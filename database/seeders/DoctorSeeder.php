<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $totalItems = 100;
        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output, $totalItems);

        // Set the bar character to green color
        $progressBar->setBarCharacter('<fg=green>=</>');
        
        for ($i = 0; $i < $totalItems; $i++) {
            Doctor::create([
                'name'=>fake()->name(),
                'email'=>fake()->safeEmail(),
                'password'=>Hash::make('123456'),
            ]);

            $progressBar->advance();
            sleep(1);
        }

        $progressBar->finish();
        $className = class_basename(get_class($this));
        $output->writeln("\n{$className} completed!");
    }
}
