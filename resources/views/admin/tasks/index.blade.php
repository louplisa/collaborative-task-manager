<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center">
        <h3>Les tâches</h3>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('admin.projects.task.create', $project) }}" class="btn btn-primary">Ajouter une tâche</a>
    </div>
    @livewire('board-tasks', ['project' => $project])
</div>
