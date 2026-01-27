<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // SuperAdmin
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@atmi.ac.id',
            'password' => bcrypt('password'),
            'role' => 'SuperAdmin',
        ]);

        // AdminLab - Lab Elektronika
        User::factory()->create([
            'name' => 'Admin Lab Elektronika',
            'email' => 'adminlab.elektronika@atmi.ac.id',
            'password' => bcrypt('password'),
            'role' => 'AdminLab',
            'lab_id' => 1, // sesuaikan dengan ID lab
        ]);

        // AdminLab - Lab Mekanik
        User::factory()->create([
            'name' => 'Admin Lab Mekanik',
            'email' => 'adminlab.mekanik@atmi.ac.id',
            'password' => bcrypt('password'),
            'role' => 'AdminLab',
            'lab_id' => 2,
        ]);

        // AdminUser
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'adminuser@atmi.ac.id',
            'password' => bcrypt('password'),
            'role' => 'AdminUser',
        ]);

        // Regular Users (Mahasiswa)
        User::factory()->create([
            'name' => 'Budi Santoso',
            'email' => 'budi@student.atmi.ac.id',
            'nim' => '2023010001',
            'password' => bcrypt('password'),
            'role' => 'User',
        ]);

        User::factory()->create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@student.atmi.ac.id',
            'nim' => '2023010002',
            'password' => bcrypt('password'),
            'role' => 'User',
        ]);

        // Generate additional users
        User::factory(10)->create([
            'role' => 'User',
        ]);
    }
}