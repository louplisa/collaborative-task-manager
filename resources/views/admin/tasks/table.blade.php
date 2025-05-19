<thead>
<tr>
    <th colspan="6" class="text-center" style="color: #2563eb">{{ $label }}</th>
</tr>
<tr>
    <th>Titre</th>
    <th>Description</th>
    <th>Deadline</th>
    <th>Assignée à</th>
    <th class="d-flex gap-2 w-100 justify-content-center">Actions</th>
</tr>
</thead>
<tbody
    data-status="{{ $status }}"
    x-data
    x-init="
            Sortable.create($el, {
                group: 'tasks',
                animation: 150,
                onAdd: (event) => {
                    const id = event.item.dataset.id;
                    const newStatus = event.to.dataset.status;
                    @this.call('updateStatus', id, newStatus);
                }
            });
        "
>
@php
    $tasks = $tasksPerStatus[$status] ?? collect();
@endphp

@if($tasks->isEmpty())
    <tr>
        <td colspan="5">Pas de tâches</td>
    </tr>
@else
    @foreach($tasks as $task)
        <tr data-id="{{ $task->id }}">
            <td>{{ $task->title }}</td>
            <td>{{ $task->description }}</td>
            <td>{{ $task->deadline ? date('d/m/Y', strtotime($task->deadline)) : '' }}</td>
            <td>{{ $task->user->name ?? 'Non assignée' }}</td>
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
@endif
</tbody>
