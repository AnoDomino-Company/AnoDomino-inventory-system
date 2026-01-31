<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name'=>'Admin User',
            'email'=>'admin@example.com',
            'role'=>'admin',
            'password'=>bcrypt('password')
        ]);
        \App\Models\User::factory()->create([
            'name'=>'Supervisor',
            'email'=>'supervisor@example.com',
            'role'=>'supervisor',
            'password'=>bcrypt('password')
        ]);
        \App\Models\User::factory()->create([
            'name'=>'Storekeeper',
            'email'=>'store@example.com',
            'role'=>'storekeeper',
            'password'=>bcrypt('password')
        ]);
    }
}

