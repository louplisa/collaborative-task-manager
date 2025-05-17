<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /** @use HasFactory<\Database\Factories\RoleFactory> */
    use HasFactory;

    public const OWNER = 'owner';
    public const MEMBER = 'member';
    public const ADMIN = 'admin';
    public const VIEWER = 'viewer';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'label'
    ];

    public static function id(string $roleName): ?int
    {
        return static::where('name', $roleName)->value('id');
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_role', 'role_id', 'user_id');
    }
}
