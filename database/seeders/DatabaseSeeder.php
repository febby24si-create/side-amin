<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data
        User::query()->delete();

        // Create Users dengan struktur yang benar
        User::create([
            'name' => 'Administrator Sistem',
            'email' => 'admin@sipedes.local',
            'password' => 'password123', // Akan di-hash otomatis
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Operator Desa',
            'email' => 'operator@sipedes.local',
            'password' => 'password123',
            'role' => 'operator',
        ]);

        $this->command->info('Users created successfully!');
    }
}
