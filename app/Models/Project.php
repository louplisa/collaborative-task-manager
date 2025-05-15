<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'project_user',
            'project_id',
            'user_id'
        )->withPivot('role_id');
    }

    public function owner()
    {
        $ownerRoleId = Role::where('name', 'owner')->value('id');
        return $this->users->firstWhere('pivot.role_id', $ownerRoleId);
    }

    public function members()
    {
        $memberRoleId = Role::where('name', 'member')->value('id');
        return $this->users->filter(function ($user) use ($memberRoleId) {
            return $user->pivot->role_id == $memberRoleId;
        });
    }

}
