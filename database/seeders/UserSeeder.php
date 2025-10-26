<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Administrator',
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

        // Tambahkan user lain jika perlu
        User::create([
            'name' => 'Kepala Desa',
            'email' => 'kades@sipedes.local',
            'password' => 'password123',
            'role' => 'admin',
        ]);
    }
}
