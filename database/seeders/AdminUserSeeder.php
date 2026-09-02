<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    // Membuat (atau memastikan ada) satu akun admin.
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@ski.sch.id'],
            [
                'name' => 'Admin SKI',
                'password' => Hash::make('admin1234'),
                'role' => 'admin',
            ]
        );
    }
}
