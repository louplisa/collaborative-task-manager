@extends('admin.base')

@section('title', $task->exists ? "Editer une tâche" : "Créer une tâche")

@section('content')
    <h1>@yield('title')</h1>
    <form class="vstack gap-2"
          action="{{ $task->exists ? route('admin.projects.task.update', [$project, $task]) : route('admin.projects.task.store', $project) }}"
          method="post" enctype="multipart/form-data">
        @csrf
        @method($task->exists ? 'put' : 'post' )
        <div class="row">
            <div class="col vstack gap-2" style="flex: 100">
                <div class="row">
                    @include('shared.input', [
                        'class' => 'col',
                        'label' => 'Titre',
                        'name' => 'title',
                        'value' => $task->title
                    ])

                    @include('shared.select', [
                        'class' => 'col',
                        'label' => 'Statut',
                        'name' => 'status',
                        'value' => $task->status?->value ?? 'todo',
                        'options' => \App\Enums\TaskStatus::labels(),
                        'multiple' => false
                    ])
                </div>
                <div class="row">
                    @include('shared.input', [
                        'class' => 'col',
                        'type' => 'date',
                        'name' => 'deadline',
                        'value' => $task->deadline,
                    ])

                    @include('shared.select', [
                        'class' => 'col',
                        'label' => 'Assignée à',
                        'name' => 'assignee_id',
                        'value' => $task->user?->id ?? '',
                        'options' => $project->members()->pluck('name', 'id'),
                        'multiple' => false,
                    ])
                </div>
                <div class="row">
                    @include('shared.input', [
                        'class' => 'col',
                        'type' => 'textarea',
                        'label' => 'Description',
                        'name' => 'description',
                        'value' => $task->description
                    ])
                    @include('shared.input', [
                        'class' => 'col',
                        'type' => 'hidden',
                        'name' => 'project_id',
                        'value' => $project->id,
                    ])
                </div>
            </div>
        </div>

        <div>
            <button class="btn btn-primary">
                @if($task->exists)
                    Modifier
                @else
                    Créer
                @endif
            </button>
        </div>
    </form>
@endsection
