@extends('admin.base')
@section('title', 'Tous les projets')
@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1>@yield('title')</h1>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('admin.project.create') }}" class="btn btn-primary">Ajouter un projet</a>
    </div>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Titre</th>
            <th>Description</th>
            <th>Propriétaire</th>
            <th>Membres</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($projects as $project)
            <tr>
                <td>{{ $project->name }}</td>
                <td>{{ $project->description }}</td>
                <td>{{ $project->owner()?->name ?? 'Aucun propriétaire' }}</td>
                <td>
                    @foreach($project->members() as $member)
                        {{ $member->name }}@if(!$loop->last), @endif
                    @endforeach
                </td>
                <td>
                    <div class="d-flex gap-2 w-100 justify-content-end">
                        <a href="{{ route('admin.project.show', $project) }}" class="btn btn-secondary">Voir</a>
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
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $projects->links() }}
@endsection
