<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /** Kelas contoh, mengikuti yang muncul di wireframe. */
    private const CLASSES = [
        'X TKJ 1', 'X TKJ 2', 'XI TKJ 1', 'XI TKJ 3', 'XII TKJ 1', 'XII TKJ 3',
        'X AKL', 'XI AKL', 'XII AKL', 'X BiD', 'XI BiD', 'XII BiD',
    ];

    /** Password default semua user hasil factory: "password". */
    protected static ?string $password;

    public function definition(): array
    {
        $faker = fake('id_ID'); // nama & nomor telepon khas Indonesia

        $gender = $faker->randomElement(['male', 'female']);
        $firstName = $faker->firstName($gender);

        return [
            'name' => $firstName.' '.$faker->lastName(),
            // pola email sekolah seperti pada form register: nama.123@ski.sch.id
            'email' => Str::slug($firstName).'.'.fake()->unique()->numerify('####').'@ski.sch.id',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => 'student',
            'gender' => $gender,
            'class' => $faker->randomElement(self::CLASSES),
            'phone_number' => '+62 8'.$faker->numerify('## #### ####'),
            'date_of_birth' => $faker->dateTimeBetween('-19 years', '-15 years')->format('Y-m-d'),
            'avatar' => null,
        ];
    }

    public function admin(): static
    {
        return $this->state(fn () => [
            'role' => 'admin',
            'class' => null,
        ]);
    }

    public function unverified(): static
    {
        return $this->state(fn () => [
            'email_verified_at' => null,
        ]);
    }
}
