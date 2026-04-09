import os
import re
from pathlib import Path

root = Path('.').resolve()


def is_text_bytes(data):
    if b'\x00' in data:
        return False
    return True


def strip_c_comments(text):
    out = []
    i = 0
    n = len(text)
    state = None
    quote = None
    escaped = False
    while i < n:
        ch = text[i]
        nxt = text[i + 1] if i + 1 < n else ''
        if state == 'string':
            out.append(ch)
            if escaped:
                escaped = False
            elif ch == '\\':
                escaped = True
            elif ch == quote:
                state = None
            i += 1
            continue
        if state == 'line_comment':
            if ch == '\n':
                out.append(ch)
                state = None
            i += 1
            continue
        if state == 'block_comment':
            if ch == '*' and nxt == '/':
                state = None
                i += 2
                continue
            i += 1
            continue
        if ch in ('"', "'"):
            state = 'string'
            quote = ch
            out.append(ch)
            i += 1
            continue
        if ch == '/' and nxt == '*':
            state = 'block_comment'
            i += 2
            continue
        if ch == '/' and nxt == '/':
            state = 'line_comment'
            i += 2
            continue
        out.append(ch)
        i += 1
    return ''.join(out)


def strip_hash_comments(text):
    out = []
    i = 0
    n = len(text)
    state = None
    quote = None
    escaped = False
    while i < n:
        ch = text[i]
        if state == 'string':
            out.append(ch)
            if escaped:
                escaped = False
            elif ch == '\\':
                escaped = True
            elif ch == quote:
                state = None
            i += 1
            continue
        if state == 'hash_comment':
            if ch == '\n':
                out.append(ch)
                state = None
            i += 1
            continue
        if ch in ('"', "'"):
            state = 'string'
            quote = ch
            out.append(ch)
            i += 1
            continue
        if ch == '#':
            state = 'hash_comment'
            i += 1
            continue
        out.append(ch)
        i += 1
    return ''.join(out)


def strip_dash_comments(text):
    out = []
    i = 0
    n = len(text)
    state = None
    quote = None
    escaped = False
    while i < n:
        ch = text[i]
        nxt = text[i + 1] if i + 1 < n else ''
        if state == 'string':
            out.append(ch)
            if escaped:
                escaped = False
            elif ch == '\\':
                escaped = True
            elif ch == quote:
                state = None
            i += 1
            continue
        if state == 'dash_comment':
            if ch == '\n':
                out.append(ch)
                state = None
            i += 1
            continue
        if ch in ('"', "'"):
            state = 'string'
            quote = ch
            out.append(ch)
            i += 1
            continue
        if ch == '-' and nxt == '-' and (i == 0 or text[i - 1] in ' \t\r\n'):
            state = 'dash_comment'
            i += 2
            continue
        out.append(ch)
        i += 1
    return ''.join(out)


def remove_comments(text):
    text = re.sub(r'', '', text, flags=re.S)
    text = strip_c_comments(text)
    text = strip_hash_comments(text)
    text = strip_dash_comments(text)
    return text


if __name__ == '__main__':
    changed = 0
    processed = 0
    for path in root.rglob('*'):
        if path.is_file():
            try:
                data = path.read_bytes()
            except Exception:
                continue
            if not is_text_bytes(data):
                continue
            decoded = None
            encoding = None
            for enc in ('utf-8', 'utf-16', 'latin-1'):
                try:
                    decoded = data.decode(enc)
                    encoding = enc
                    break
                except Exception:
                    continue
            if decoded is None:
                continue
            new_text = remove_comments(decoded)
            if new_text != decoded:
                try:
                    path.write_text(new_text, encoding=encoding)
                    changed += 1
                except Exception:
                    continue
            processed += 1
    print(f'Processed {processed} text files, modified {changed} files.')
