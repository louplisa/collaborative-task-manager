<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center">
        <h3>Les tâches</h3>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('admin.projects.task.create', $project) }}" class="btn btn-primary">Ajouter une tâche</a>
    </div>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Titre</th>
            <th>Description</th>
            <th>Statut</th>
            <th>Deadline</th>
            <th>Assignée à</th>
            <th class="d-flex gap-2 w-100 justify-content-center">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($tasks as $task)
            <tr>
                <td>{{ $task->title }}</td>
                <td>{{ $task->description }}</td>
                <td>{{ \App\Enums\TaskStatus::labels()[$task->status->value] }}</td>
                <td>{{ $task->deadline }}</td>
                <td>{{ $task->user?->name ?? 'Tâche non assignée' }}</td>
                <td>
                    <div class="d-flex gap-2 w-100 justify-content-end">
                        <a href="{{ route('admin.projects.task.show', [$project, $task]) }}"
                           class="btn btn-secondary">Voir</a>
                        @can('update', $project)
                            <a href="{{ route('admin.projects.task.edit', [$project, $task]) }}"
                               class="btn btn-primary">Editer</a>
                        @endcan
                        @can('delete', $project)
                            <form action="{{ route('admin.projects.task.destroy', [$project, $task]) }}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger">Supprimer</button>
                            </form>
                        @endcan
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
