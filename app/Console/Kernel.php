<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;
use App\Http\Controllers\TaskController;
use App\Helpers\Configs;
use App\Services\TelegramService;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $controller = new TaskController();
            $controller->refresh_configs();

            Configs::set('schedule:refresh_configs', date('Y-m-d H:i:s'), 'datetime');

            $telegramService = new TelegramService();
            $telegramService->sendMessage("✅ As configurações do Banco de Dados foram atualizadas!");
        })->dailyAt('00:00');

        $schedule->call(function () {
            $controller = new TaskController();
            $controller->refresh_files_size();

            Configs::set('schedule:refresh_files_size', date('Y-m-d H:i:s'), 'datetime');

            $telegramService = new TelegramService();
            $telegramService->sendMessage("✅ Os tamanhos dos arquivos foram atualizados no Banco de Dados!");
        })->dailyAt('01:00');

        //})->everyMinute();
    }
}
