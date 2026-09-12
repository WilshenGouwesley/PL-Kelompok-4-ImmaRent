<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    public function run(): void
    {
        $facilities = [
            [
                'name' => 'Computer Laboratory',
                'category' => 'Laboratory',
                'location' => 'IELTS Centre',
                'description' => 'Fully equipped computer lab with 30 workstations, ideal for practical sessions and exams.',
                'capacity' => 30,
                'status' => 'active',
            ],
            [
                'name' => 'Language Laboratory',
                'category' => 'Laboratory',
                'location' => 'IELTS Centre',
                'description' => 'Sound-isolated language lab with individual headsets for listening practice.',
                'capacity' => 25,
                'status' => 'active',
            ],
            [
                'name' => 'Tiranus Hall 2',
                'category' => 'Hall',
                'location' => '2nd Floor',
                'description' => 'Mid-size multipurpose hall, commonly used for rehearsals and small events.',
                'capacity' => 80,
                'status' => 'active',
            ],
            [
                'name' => 'Tiranus Hall 6',
                'category' => 'Hall',
                'location' => '5th Floor',
                'description' => 'Large hall with stage setup, suitable for worship rehearsals and assemblies.',
                'capacity' => 150,
                'status' => 'active',
            ],
            [
                'name' => 'LCD Projector',
                'category' => 'Equipment',
                'location' => 'Teacher\'s Office',
                'description' => 'Portable LCD projector unit that can be borrowed for classroom presentations.',
                'capacity' => null,
                'status' => 'active',
            ],
            [
                'name' => 'Black Marker Set',
                'category' => 'Equipment',
                'location' => 'Teacher\'s Office',
                'description' => 'A set of whiteboard markers available for short-term loan.',
                'capacity' => null,
                'status' => 'active',
            ],
            [
                'name' => 'Science Laboratory',
                'category' => 'Laboratory',
                'location' => '3rd Floor',
                'description' => 'General-purpose science lab with basic chemistry and biology equipment.',
                'capacity' => 32,
                'status' => 'active',
            ],
            [
                'name' => 'Basketball Court',
                'category' => 'Sport Court',
                'location' => 'Main Building',
                'description' => 'Outdoor basketball court available for sport activities and events.',
                'capacity' => null,
                'status' => 'active',
            ],
        ];

        foreach ($facilities as $facility) {
            Facility::updateOrCreate(
                ['name' => $facility['name'], 'location' => $facility['location']],
                $facility
            );
        }
    }
}
