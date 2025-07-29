<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HealthcareProfessional;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HealthcareProfessionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run()
    {
        $professionals = [
            ['name' => 'Dr. Abhishek Patel', 'specialty' => 'Cardiologist'],
            ['name' => 'Dr. Ankit Patel', 'specialty' => 'Dermatologist'],
            ['name' => 'Dr. Harsh Duby', 'specialty' => 'Pediatrician'],
            ['name' => 'Dr. Omar Ali', 'specialty' => 'Orthopedic Surgeon'],
            ['name' => 'Dr. Vinayak Naydu', 'specialty' => 'General Physician'],
            ['name' => 'Dr. Malav Shah', 'specialty' => 'Neurologist'],
            ['name' => 'Dr. Ravi Rawat', 'specialty' => 'Psychiatrist'],
        ];

        foreach ($professionals as $professional) {
            HealthcareProfessional::create($professional);
        }
    }
}
