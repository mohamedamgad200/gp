<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        $totalItems = 100;
        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output, $totalItems);

        // Set the bar character to green color
        $progressBar->setBarCharacter('<fg=green>=</>');
        
        for ($i = 0; $i < $totalItems; $i++) {
            Patient::create([
                'name'=>fake()->name(),
                'email'=>fake()->safeEmail(),
                'password'=>Hash::make('123456'),
                'result'=>fake()->boolean(),
            ]);

            $progressBar->advance();
            sleep(1);
        }

        $progressBar->finish();
        $className = class_basename(get_class($this));
        $output->writeln("\n{$className} completed!");
    }
}
