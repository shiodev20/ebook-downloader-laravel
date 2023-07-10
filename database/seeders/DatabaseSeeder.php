<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $seedData = Storage::disk('local')->get('seed/data.json');
        $seedDataDecode = json_decode($seedData);

        $roles = $seedDataDecode->roles;
        foreach ($roles as $role) {
            Role::create([
                'id' => $role->id,
                'name' => $role->name
            ]);
        }

        $users = $seedDataDecode->users;
        foreach ($users as $user) {
            User::create([
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'password' => $user->password,
                'status' => $user->status,
                'role_id' => $user->role_id,
                'created_at' => $user->createdAt,
                'created_at' => $user->createdAt,
            ]);
        }
    }
}
