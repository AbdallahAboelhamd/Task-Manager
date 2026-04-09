<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'projects' => Project::withCount('tasks')->orderBy('created_at', 'desc')->get(),
            'tasks' => Task::with('project')->orderBy('created_at', 'desc')->get(),
        ]);
    }

    public function storeProject(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Project::create($request->only(['name', 'description']));

        return redirect()->route('dashboard')->with('success', 'Project created successfully.');
    }

    public function editProject(Project $project)
    {
        return view('edit-project', [
            'project' => $project,
        ]);
    }

    public function updateProject(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $project->update($request->only(['name', 'description']));

        return redirect()->route('dashboard')->with('success', 'Project updated successfully.');
    }

    public function destroyProject(Project $project)
    {
        $project->delete();

        return redirect()->route('dashboard')->with('success', 'Project deleted successfully.');
    }

    public function project(Project $project)
    {
        $project->load(['tasks.user']);

        return view('project', compact('project'));
    }

    public function storeTask(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:todo,in_progress,done',
            'priority' => 'required|in:high,medium,low',
            'due_date' => 'nullable|date',
            'project_id' => 'required|exists:projects,id',
        ]);

        Task::create($request->only(['title', 'description', 'status', 'priority', 'due_date', 'project_id']));

        return redirect()->route('dashboard')->with('success', 'Task created successfully.');
    }

    public function editTask(Task $task)
    {
        return view('edit-task', [
            'task' => $task,
            'projects' => Project::orderBy('name')->get(),
        ]);
    }

    public function updateTask(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:todo,in_progress,done',
            'priority' => 'required|in:high,medium,low',
            'due_date' => 'nullable|date',
            'project_id' => 'required|exists:projects,id',
        ]);

        $task->update($request->only(['title', 'description', 'status', 'priority', 'due_date', 'project_id']));

        return redirect()->route('dashboard')->with('success', 'Task updated successfully.');
    }

    public function destroyTask(Task $task)
    {
        $task->delete();

        return redirect()->route('dashboard')->with('success', 'Task deleted successfully.');
    }

    public function task(Task $task)
    {
        $task->load(['project', 'user']);

        return view('task', compact('task'));
    }

    public function projects()
    {
        $projects = Project::withCount('tasks')->orderBy('created_at', 'desc')->get();

        return view('projects', compact('projects'));
    }

    public function tasks()
    {
        $tasks = Task::with('project')->where('status', 'done')->orderBy('created_at', 'desc')->get();

        return view('tasks', compact('tasks'));
    }
}
