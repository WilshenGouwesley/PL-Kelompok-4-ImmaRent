<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    private const TARGET_STUDENTS = 30;

    public function run(): void
    {
        // Akun demo tetap supaya mudah login saat development / presentasi.
        User::updateOrCreate(
            ['email' => 'siswa@ski.sch.id'],
            [
                'name' => 'Siswa Demo',
                'password' => Hash::make('password'),
                'role' => 'student',
                'gender' => 'male',
                'class' => 'XII TKJ 3',
                'phone_number' => '+62 812 3456 7890',
                'date_of_birth' => '2008-03-14',
            ]
        );

        // Lengkapi sampai TARGET_STUDENTS dengan data acak (aman dijalankan berulang).
        $missing = max(0, self::TARGET_STUDENTS - User::students()->count());

        if ($missing > 0) {
            User::factory()->count($missing)->create();
        }
    }
}
