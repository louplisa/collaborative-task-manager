<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'label' => 'Administrateur',
            ],
            [
                'name' => 'owner',
                'label' => 'Propriétaire',
            ],
            [
                'name' => 'member',
                'label' => 'Collaborateur',
            ],
            [
                'name' => 'viewer',
                'label' => 'Lecteur',
            ]
        ];

        foreach ($roles as $role) {
            Role::factory()->create($role);
        }

        $roleOwner = Role::where('name', 'owner')->first();
        $roleMember = Role::where('name', 'member')->first();

        User::factory()->create([
            'name' => 'Aurélie Ferré',
            'email' => 'ferre.aurelie@wanadoo.fr',
            'password' => Hash::make('password'),
        ]);

        $users = User::factory(50)->create();

        foreach ($users as $user) {
            $project = Project::factory()->create();
            $project->users()->attach($user, ['role_id' => $roleOwner->id]);

            $memberUsers = $users->where('id', '!=', $user->id)->random(3);

            foreach ($memberUsers as $member) {
                $project->users()->attach($member->id, [
                    'role_id' => $roleMember->id,
                ]);
            }
        }
    }
}
