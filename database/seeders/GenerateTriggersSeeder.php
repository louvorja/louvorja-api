<?php

namespace Database\Seeders;

use App\Helpers\GenerateTriggers;
use Illuminate\Database\Seeder;

class GenerateTriggersSeeder extends Seeder
{
    public function run()
    {
        GenerateTriggers::run();
    }
}
