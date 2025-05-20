<?php

namespace App\Livewire;

use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectFilter extends Component
{
    use WithPagination;

    public string $search = '';
    public int $searchOwner = 0;
    public int $searchMember = 0;

    public Collection $users;

    public function mount()
    {
        $this->users = User::pluck('name', 'id');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $projects = Project::with('users')
            ->when($this->search, fn(Builder $query) => $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            )
            ->when($this->searchOwner, fn(Builder $query) =>
            $query->whereHas('users', fn(Builder $query) =>
            $query->where('project_user.role_id', Role::id(Role::OWNER))
                ->where('users.id', $this->searchOwner)
            ))
            ->when($this->searchMember, fn(Builder $query) =>
            $query->whereHas('users', fn(Builder $query) =>
            $query->where('project_user.role_id', Role::id(Role::MEMBER))
                ->where('users.id', $this->searchMember)
            ))
            ->paginate(10);

        return view('livewire.project-filter', [
            'projects' => $projects,
        ]);
    }
}
