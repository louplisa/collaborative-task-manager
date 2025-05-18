<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TaskStatus;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    use \Illuminate\Foundation\Auth\Access\AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project)
    {
        $task = new Task;
        return view('admin.tasks.form', compact('project', 'task'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $validated = $request->validate([
            'title' => 'required|string|max:255|min:3',
            'description' => 'nullable|string|min:3|max:255',
            'status' => [Rule::enum(TaskStatus::class)],
            'deadline' => 'nullable|date',
            'assignee_id' => 'nullable|exists:users,id',
            'project_id' => 'required|exists:projects,id'
        ]);

        Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'],
            'deadline' => $validated['deadline'] ?? null,
            'assignee_id' => $validated['assignee_id'] ?? null,
            'project_id' => $project->id,
        ]);

        return redirect()->route('admin.project.edit', $project)->with('success', 'Tâche créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project, Task $task)
    {
        return view('admin.tasks.show', compact('project', 'task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project, Task $task)
    {
        $this->authorize('update', $project);
        return view('admin.tasks.form', [
            'task' => $task,
            'project' => $project,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Project $project, Task $task)
    {
        $this->authorize('update', $project);

        $validated = $request->validate([
            'title' => 'required|string|max:255|min:3',
            'description' => 'nullable|string|min:3|max:255',
            'status' => [Rule::enum(TaskStatus::class)],
            'deadline' => 'nullable|date',
            'assignee_id' => 'nullable|exists:users,id',
            'project_id' => 'required|exists:projects,id'
        ]);

        $task->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'],
            'deadline' => $validated['deadline'] ?? null,
            'assignee_id' => $validated['assignee_id'] ?? null,
            'project_id' => $project->id,
        ]);

        return redirect()->route('admin.project.edit', $project)->with('success', 'Tâche modifiée avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, Task $task)
    {
        $this->authorize('delete', $project);
        $task->delete();
        return redirect()->route('admin.project.edit', $project)->with('success', 'Tâche supprimée avec succès');
    }
}
