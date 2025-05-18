<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    use \Illuminate\Foundation\Auth\Access\AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all();
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $project = new Project;
        $users = User::all();
        return view('admin.projects.form', compact('project', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $validated = $request->validated();

        $project = Project::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        $memberRoleId = Role::id(Role::MEMBER);
        $ownerRoleId = Role::id(Role::OWNER);
        $members = collect($validated['users'] ?? [])
            ->filter(fn ($id) => $id != $validated['owner'])
            ->mapWithKeys(fn ($id) => [$id => ['role_id' => $memberRoleId]]);


        $members[$validated['owner']] = ['role_id' => $ownerRoleId];

        $project->users()->attach($members->toArray());

        return redirect()->route('admin.project.index')->with('success', 'Projet créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $this->authorize('update', $project);
        $users = User::all();
        return view('admin.projects.form', compact('project', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $validated = $request->validate([
            'name' => 'required|string|max:255|min:3',
            'description' => 'nullable|string|min:3|max:255',
            'users' => 'nullable|array',
            'users.*' => 'exists:users,id',
        ]);

        $project->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        $memberRoleId = Role::id(Role::MEMBER);
        $newMemberIds = collect($validated['users'] ?? []);
        $syncData = $newMemberIds->mapWithKeys(fn ($id) => [
            $id => ['role_id' => $memberRoleId]
        ])->toArray();

        $currentMembers = $project->users()
            ->wherePivot('role_id', $memberRoleId)
            ->pluck('users.id')
            ->toArray();

        $toDetach = array_diff($currentMembers, $newMemberIds->toArray());
        if (!empty($toDetach)) {
            $project->users()->detach($toDetach);
        }

        $project->users()->syncWithoutDetaching($syncData);

        return redirect()->route('admin.project.index')->with('success', 'Projet mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        $project->delete();
        return redirect()->route('admin.project.index')->with('success', 'Projet supprimé avec succès');
    }
}
