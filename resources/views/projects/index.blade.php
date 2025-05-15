@extends('base')
@section('title', 'Tous les projets')
@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1>@yield('title')</h1>
    </div>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>Titre</th>
            <th>Description</th>
            <th>Propriétaire</th>
            <th>Membres</th>
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
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
