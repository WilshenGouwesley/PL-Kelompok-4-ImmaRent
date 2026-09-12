<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FacilityFactory extends Factory
{
    public function definition(): array
    {
        $categories = ['Laboratory', 'Hall', 'Classroom', 'Equipment', 'Sport Court'];
        $locations = ['IELTS Centre', '2nd Floor', '5th Floor', 'Teacher\'s Office', 'Main Building'];

        return [
            'name' => fake()->randomElement([
                'Computer Laboratory',
                'Language Laboratory',
                'Tiranus Hall',
                'LCD Projector',
                'Black Marker',
                'Science Laboratory',
            ]) . ' ' . fake()->numberBetween(1, 9),
            'category' => fake()->randomElement($categories),
            'location' => fake()->randomElement($locations),
            'description' => fake()->sentence(12),
            'capacity' => fake()->numberBetween(1, 60),
            'status' => 'active',
            'image' => null,
        ];
    }
}
