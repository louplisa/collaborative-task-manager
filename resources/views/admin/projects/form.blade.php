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
                    <label for="name">Nom</label>
                    <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name"
                           value="{{ $project->name }}">
                    <label for="description">Description</label>
                    <input class="form-control @error('description') is-invalid @enderror" type="text"
                           name="description" id="description" value="{{ $project->description }}">
                    <label for="owner">Propriétaire</label>
                    <input type="text" class="form-control" value="{{ $project->exists ? $project->owner()?->name : Auth::user()->name }}" disabled>
                    <input type="hidden" name="owner" value="{{ $project->exists ? $project->owner()?->id : Auth::id() }}" id="owner">
                    <label for="users">Membres</label>
                    @php
                        $memberRoleId = \App\Models\Role::id(\App\Models\Role::MEMBER);
                        $memberIds = $project->users
                            ->filter(fn($u) => $u->pivot->role_id == $memberRoleId)
                            ->pluck('id')
                            ->toArray();
                    @endphp
                    <select name="users[]" id="users" class="form-control" multiple>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ in_array($user->id, $memberIds) ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button class="btn btn-primary">
                        @if('project->exists')
                            Modifier
                        @else
                            Créer
                        @endif
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection
