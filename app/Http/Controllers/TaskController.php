<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use App\Models\Config;

class TaskController extends Controller
{
    public function __construct()
    {
        ini_set('memory_limit', '-1');
        set_time_limit(60 * 60);
    }

    public function export_database(Request $request)
    {

        Config::generate();

        $database = env('DB_SQLITE_DATABASE');
        $url_database = url('/') . '/' . $database;

        if (File::exists($database)) {
            unlink($database);
        }


        $dir_database = dirname($database);
        if ($dir_database <> "") {
            if (!file_exists($dir_database)) {
                mkdir($dir_database, 0755, true);
            }
        }

        touch($database);

        Artisan::call('migrate', [
            '--database' => 'sqlite',
            '--path' => 'database/migrations',
        ]);


        DB::connection('sqlite')->getPdo()->exec("ATTACH DATABASE '{$database}' AS sqlite_db");

        $mysqlConnection = DB::connection('mysql');
        $tables = $mysqlConnection->getDoctrineSchemaManager()->listTableNames();


        $log = [];
        foreach ($tables as $table) {
            try {
                $log[$table]["table_name"] = $table;

                DB::connection('sqlite')->table($table)->truncate();
                $data = json_decode(json_encode(DB::connection('mysql')->table($table)->get()->toArray()), true);
                $log[$table]["count"] = count($data);

                $chunks = array_chunk($data, 50);
                $log[$table]["parts"] = count($chunks);
                foreach ($chunks as $chunk) {
                    DB::connection('sqlite')->table($table)->insert($chunk);
                    $log[$table]["status"] = "success";
                }
            } catch (\Exception $e) {
                $log[$table]["error"] = $e->getMessage();
                $log[$table]["status"] = "error";
            }
        }
        return response()->json(["url" => $url_database, "logs" => $log]);
    }
}
