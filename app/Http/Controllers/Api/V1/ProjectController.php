<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::paginate(10);
        return response()->json([
            "Status" => true,
            "Message" => "Projects retrieved successfully",
            "Data" => $projects
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            "name" => "required|string",
            "description" => "nullable|string"
        ]);
        $project = Project::create($validation);

        return response()->json([
            "Status" => true,
            "Message" => "Project created successfully",
            "Data" => $project
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = Project::findOrFail($id);

        return response()->json([
            "Status" => true,
            "Message" => "Project retrieved successfully",
            "Data" => $project
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validation = $request->validate([
            "name" => "required|string",
            "description" => "nullable|string"
        ]);
        $project = Project::findOrFail($id);
        $project->update($validation);
         return response()->json([
            "Status" => true,
            "Message" => "Project Updated successfully",
            "Data" => $project
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Project::destroy($id);
        return response()->json([
         "Status" => true,
        "Message" => "Project deleted successfully",
        ]);
    }
}
