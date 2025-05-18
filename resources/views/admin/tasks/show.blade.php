@extends('admin.base')
@section('title', 'Tâche ' . $task->title )
@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1>@yield('title')</h1>
        </div>
        <div class="row">
            <div class="col-4">
                <p>{{ $task->description }}</p>
            </div>
            <div class="row ml-3">
                <div class="col-4">
                    <p><strong>Statut : </strong> {{ \App\Enums\TaskStatus::labels()[$task->status->value] }}</p>
                    <p><strong>Deadline :</strong> {{ $task->deadline }}</p>
                    <p><strong>Assignée à :</strong> {{ $task->user?->name ?? 'Tâche non assignée' }}</p>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-4">
                <div class="d-flex gap-2 w-100 justify-content-end">
                    @can('update', $project)
                        <a href="{{ route('admin.projects.task.edit', [$project, $task]) }}" class="btn btn-primary">Editer</a>
                    @endcan
                    @can('delete', $project)
                        <form action="{{ route('admin.projects.task.destroy', [$project, $task]) }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger">Supprimer</button>
                        </form>
                    @endcan
                    <a href="{{ route('admin.project.edit', $project) }}" class="btn btn-primary">Retour au projet</a>
                </div>
            </div>
        </div>

    </div>

@endsection
