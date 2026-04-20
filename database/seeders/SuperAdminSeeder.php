<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat Super Admin
        User::create([
            'name' => 'Super Administrator',
            'nim' => null,
            'jurusan' => null,
            'no_hp' => '081234567890',
            'email' => 'superadmin@atmi.ac.id',
            'password' => Hash::make('superadmin123'),
            'role' => 'super_admin',
            'created_by' => null,
        ]);

        // Buat User Admin
        User::create([
            'name' => 'User Administrator',
            'nim' => null,
            'jurusan' => null,
            'no_hp' => '081234567891',
            'email' => 'useradmin@atmi.ac.id',
            'password' => Hash::make('useradmin123'),
            'role' => 'user_admin',
            'created_by' => 1, // Dibuat oleh Super Admin
        ]);

        // Buat Admin Lab
        User::create([
            'name' => 'Admin Laboratorium',
            'nim' => null,
            'jurusan' => null,
            'no_hp' => '081234567892',
            'email' => 'admin@atmi.ac.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'created_by' => 1, // Dibuat oleh Super Admin
        ]);


        // Buat User Biasa (contoh)
        User::create([
            'name' => 'Muhammad Aziz',
            'nim' => '2200018322',
            'jurusan' => 'Teknik Informatika',
            'no_hp' => '081234567893',
            'email' => 'aziz@student.atmi.ac.id',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'created_by' => 2, // Dibuat oleh User Admin
        ]);
    }
}