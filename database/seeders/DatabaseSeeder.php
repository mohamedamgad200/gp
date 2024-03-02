<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Post\Database\Seeders\PostSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            DoctorPermissionsSeeder::class,
            PatientPermissionSeeder::class,
            DoctorSeeder::class,
            PatientSeeder::class,
            PostSeeder::class,
        ]);
    }
}
