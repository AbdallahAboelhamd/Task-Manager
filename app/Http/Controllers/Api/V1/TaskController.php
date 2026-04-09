<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Task::with('project');

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $tasks = $query->paginate(10);
        return response()->json([
            "Status" => true,
            "Message" => "Tasks retrieved successfully",
            "Data" => $tasks
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            "title" => "string|required",
            "description" => "nullable|string",
            "due_date" => "date|nullable",
            "status" => "nullable|in:todo,in_progress,done",
            "priority" => "nullable|in:low,medium,high",
            "project_id" => "required|exists:projects,id",
            "user_id" => "nullable|exists:users,id"
        ]);
        $task = Task::create($validation);

        return response()->json([
            "Status" => true,
            "Message" => "task created successfully",
            "Data" => $task->load('project')
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::with('project')->findOrFail($id);

        return response()->json([
            "Status" => true,
            "Message" => "task retrieved successfully",
            "Data" => $task
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validation = $request->validate([
            "title" => "string|required",
            "description" => "nullable|string",
            "due_date" => "date|nullable",
            "status" => "nullable|in:todo,in_progress,done",
            "priority" => "nullable|in:low,medium,high",
            "project_id" => "required|exists:projects,id",
            "user_id" => "nullable|exists:users,id"
        ]);
        $task = Task::findOrFail($id);
        $task->update($validation);
        return response()->json([
            "Status" => true,
            "Message" => "task Updated successfully",
            "Data" => $task->load('project')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Task::destroy($id);
        return response()->json([
            "Status" => true,
            "Message" => "Task deleted successfully",
        ]);
    }
}
