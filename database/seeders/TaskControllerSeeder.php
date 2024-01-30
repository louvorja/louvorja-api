<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Http\Controllers\TaskController;

class TaskControllerSeeder extends Seeder
{
    public function run()
    {
        (new TaskController())->export_database();
        $this->command->info('Database export completed.');
    }
}
