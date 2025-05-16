@extends('admin.base')
@section('title', 'Project ' . $project->name )
@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1>@yield('title')</h1>
        </div>
        <div class="row">
            <div class="col-4">
                <p>{{ $project->description }}</p>
            </div>
            <div class="row ml-3">
                <div class="col-4">
                    <p><strong>Propriétaire du projet : </strong> {{ $project->owner()->name }}</p>
                    <ul class="list-group ml-5">
                        <span><strong>Membres du projet : </strong></span>
                        @foreach($project->members() as $member)
                            <li class="list-group-item">{{ $member->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-4">
                <div class="d-flex gap-2 w-100 justify-content-end">
                    @can('update', $project)
                        <a href="{{ route('admin.project.edit', $project) }}" class="btn btn-primary">Editer</a>
                    @endcan
                    @can('delete', $project)
                        <form action="{{ route('admin.project.destroy', $project) }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger">Supprimer</button>
                        </form>
                    @endcan
                    <a href="{{ route('admin.project.index', $project) }}" class="btn btn-primary">Retour aux projets</a>
                </div>
            </div>
        </div>

    </div>

@endsection
