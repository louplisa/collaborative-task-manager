@extends('admin.base')

@section('title', $project->exists ? "Editer un projet" : "Créer un projet")

@section('content')
    <h1>@yield('title')</h1>
    <form class="vstack gap-2"
          action="{{ route($project->exists ? 'admin.project.update' : 'admin.project.store', $project) }}"
          method="post" enctype="multipart/form-data">
        @csrf
        @method($project->exists ? 'put' : 'post')
        <div class="row">
            <div class="col vstack gap-2" style="flex: 100">
                <div class="row">
                    @include('shared.input', [
                        'class' => 'col',
                        'label' => 'Nom',
                        'name' => 'name',
                        'value' => $project->name
                    ])
                    @include('shared.input', [
                        'class' => 'col',
                        'label' => 'Propriétaire',
                        'name' => 'owner',
                        'value' => $project->exists ? $project->owner()?->name : Auth::user()->name,
                        'disabled' => true
                    ])
                    @include('shared.input', [
                        'class' => 'col',
                        'type' => 'hidden',
                        'name' => 'owner',
                        'value' => $project->exists ? $project->owner()?->id : Auth::id(),
                        'disabled' => true
                    ])
                </div>
                <div class="row">
                    @include('shared.input', [
                        'class' => 'col',
                        'type' => 'textarea',
                        'label' => 'Description',
                        'name' => 'description',
                        'value' => $project->description
                    ])
                </div>
                @include('shared.select', [
                    'class' => 'col',
                    'label' => 'Membres',
                    'name' => 'users',
                    'value' => $project->users()->pluck('users.id'),
                    'options' => \App\Models\User::where('id', '!=', $project->owner()?->id)->pluck('name', 'id'),
                    'multiple' => true
                ])
            </div>
            <div>
                <button class="btn btn-primary">
                    @if($project->exists)
                        Modifier
                    @else
                        Créer
                    @endif
                </button>
            </div>
            @include('admin.tasks.index', [$tasks = $project->tasks()->get(), $project])
        </div>
    </form>
@endsection
