@extends('admin.base')
@section('title', 'Tous les projets')
@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1>@yield('title')</h1>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('admin.project.create') }}" class="btn btn-primary">Ajouter un projet</a>
    </div>
    @livewire('project-filter')
@endsection
