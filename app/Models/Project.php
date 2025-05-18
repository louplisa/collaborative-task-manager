<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'created_at',
        'updated_at',
    ];

    public function tasks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'project_user',
            'project_id',
            'user_id'
        )->withPivot('role_id');
    }

    public function owner(): ?User
    {
        $ownerRoleId = Role::where('name', 'owner')->value('id');
        return $this->users->firstWhere('pivot.role_id', $ownerRoleId);
    }

    /**
     * @return Collection<User>
     */
    public function members(): ?Collection
    {
        $memberRoleId = Role::where('name', 'member')->value('id');
        return $this->users->filter(function ($user) use ($memberRoleId) {
            return $user->pivot->role_id == $memberRoleId;
        });
    }

    public function hasRole(User $user, string $roleName): bool
    {
        $roleId = Role::where('name', $roleName)->value('id');

        return $this->users()
            ->wherePivot('role_id', $roleId)
            ->where('users.id', $user->id)
            ->exists();
    }
}
