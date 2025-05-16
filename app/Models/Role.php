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
}
