<div>
    <div class="d-flex mb-3 gap-2">
        <input wire:model.live.debounce.250ms="search"
               type="text" class="form-control"
               placeholder="Chercher un titre de projet..."/>
        <input wire:model.live.debounce.250ms="search"
               type="text" class="form-control"
               placeholder="Chercher une description de projet..."/>
        <select wire:model.live="searchOwner" class="form-select">
            <option value="0">Choisissez un propriétaire</option>
            @foreach($users as $id => $owner)
                <option value="{{ $id }}"> {{ $owner }} </option>
            @endforeach
        </select>
        <select wire:model.live="searchMember" class="form-select">
            <option value="0">Choisissez un membre</option>
            @foreach($users as $id => $member)
                <option value="{{ $id }}"> {{ $member }} </option>
            @endforeach
        </select>
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
                        {{ $member->name }}@if(!$loop->last)
                            ,
                        @endif
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
</div>
