<?php

namespace Modules\Post\Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Seeder;
use Modules\Post\App\Models\Post;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $doctorIds = Doctor::pluck('id')->toArray();
        $totalItems = 100;
        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output, $totalItems);

        // Set the bar character to green color
        $progressBar->setBarCharacter('<fg=green>=</>');
        
        for ($i = 0; $i < $totalItems; $i++) {
            Post::create([
                'body' => fake()->sentence(3),
                'doctor_id' => fake()->randomElement($doctorIds),
            ]);

            $progressBar->advance();
            sleep(1);
        }

        $progressBar->finish();
        $className = class_basename(get_class($this));
        $output->writeln("\n{$className} completed!");
    }
}
