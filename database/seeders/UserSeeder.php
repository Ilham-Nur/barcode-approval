<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil ID Role
        $adminRole = Role::where('name', 'admin')->first();
        $karyawanRole = Role::where('name', 'karyawan')->first();
        $atasanRole = Role::where('name', 'atasan')->first();

        // Tambah user admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
        ]);

        // Tambah user karyawan
        User::create([
            'name' => 'Karyawan User',
            'email' => 'karyawan@example.com',
            'password' => Hash::make('password'),
            'role_id' => $karyawanRole->id,
        ]);

        // Tambah user atasan
        User::create([
            'name' => 'Atasan User',
            'email' => 'atasan@example.com',
            'password' => Hash::make('password'),
            'role_id' => $atasanRole->id,
        ]);
    }
}

