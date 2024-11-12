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
            $ret = $controller->refresh_configs();

            echo "Tarefa: refresh_configs" . PHP_EOL;
            if ($ret) {
                echo "Executado!" . PHP_EOL;
                Configs::set('schedule:refresh_configs', date('Y-m-d H:i:s'), 'datetime', $ret);
                $telegramService = new TelegramService();
                $telegramService->sendMessage("⏰ Rotina executada: Atualização de configurações!");
                $telegramService->sendMessage("<pre>" . json_encode($ret, JSON_PRETTY_PRINT) . "</pre>");
            }
        })->dailyAt('00:00');

        $schedule->call(function () {
            $controller = new TaskController();
            $ret = $controller->refresh_files_size();

            echo "Tarefa: refresh_files_size" . PHP_EOL;
            if ($ret) {
                echo "Executado!" . PHP_EOL;
                Configs::set('schedule:refresh_files_size', date('Y-m-d H:i:s'), 'datetime', $ret);
                $telegramService = new TelegramService();
                $telegramService->sendMessage("⏰ Rotina executada: Atualização de tamanho de arquivos no Banco de Dados!");
                $telegramService->sendMessage("<pre>" . json_encode($ret, JSON_PRETTY_PRINT) . "</pre>");
            }
        })->dailyAt('01:00');

        $schedule->call(function () {
            $controller = new TaskController();
            $ret = $controller->export_database();

            echo "Tarefa: export_database" . PHP_EOL;
            if ($ret) {
                echo "Executado!" . PHP_EOL;
                Configs::set('schedule:export_database', date('Y-m-d H:i:s'), 'datetime', $ret);
                $telegramService = new TelegramService();
                $telegramService->sendMessage("⏰ Rotina executada: Exportação de Banco de Dados!");
                $telegramService->sendMessage("<pre>" . json_encode($ret, JSON_PRETTY_PRINT) . "</pre>");
            }
        })->dailyAt('02:00');

        $schedule->call(function () {
            $controller = new TaskController();
            $ret = $controller->export_database_json();

            echo "Tarefa: export_database_json" . PHP_EOL;
            if ($ret) {
                echo "Executado!" . PHP_EOL;
                Configs::set('schedule:export_database_json', date('Y-m-d H:i:s'), 'datetime', $ret);
                //$telegramService = new TelegramService();
                //$telegramService->sendMessage("⏰ Rotina executada: Exportação de Banco de Dados em JSON!");
                //$telegramService->sendMessage("<pre>" . json_encode($ret, JSON_PRETTY_PRINT) . "</pre>");
            }
        })->everyMinute(); //->dailyAt('02:00');

        //})->everyMinute();
    }
}
