<?php

namespace App\Helpers;

use App\Models\Config;
use Illuminate\Support\Facades\DB;

class Configs
{

    public static function get($key = "")
    {
        if ($key <> "") {
            $config = Config::select()->where("key", $key)->get();
        } else {
            $config = Config::select()->get();
        }

        $data = [];
        foreach ($config as $c) {
            if ($c["type"] == "json") {
                $data[$c["key"]] = json_decode($c["value"]);
            } elseif ($c["type"] == "number") {
                $data[$c["key"]] = +$c["value"];
            } else {
                $data[$c["key"]] = $c["value"];
            }
        }

        if ($key <> "") {
            $data = $data[$key] ?? null;
        }
        return $data;
    }

    public static function set($key, $value = "", $type = "", $details = null)
    {
        if ($type == "") {
            if (is_numeric($value)) {
                $type = "number";
            } else {
                $type = "string";
            }
        }
        Config::where('key', $key)->delete();
        Config::create(['key' => $key, 'type' => $type, 'value' => $value, 'details' => $details]);

        $config = Configs::get($key);
        return [$key => $config];
    }

    public static function refresh()
    {
        Config::where('key', 'error')->delete();

        try {
            //Cria uma transação, pois em caso de erros, deve ser feito o rollback
            DB::beginTransaction();

            $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();

            /*
            //Limpa tabela
            Config::query()->delete();

            //Lista de tabelas do sistema
            $list_tables = [];
            DB::connection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
            
            foreach ($tables as $table) {
                if ($table == 'migrations') {
                    continue;
                }
                $list_tables[$table] = [];

                $columns = Schema::getColumnListing($table);
                $list_tables[$table]["columns"] = [];
                foreach ($columns as $column) {
                    $list_tables[$table]["columns"][$column] = [
                        "type" => DB::connection()->getDoctrineColumn($table, $column)->getType()->getName(),
                        "length" => DB::connection()->getDoctrineColumn($table, $column)->getLength(),
                    ];
                }
                $list_tables[$table]["primary"] = Schema::getConnection()->getDoctrineSchemaManager()->listTableIndexes($table)['primary']->getColumns();
            }
            Config::create(['key' => 'tables', 'type' => 'json', 'value' => json_encode($list_tables)]);

            // Forma de transferência de dados
            $data_transfer = [];
            $data_transfer["full"] = ["languages", "categories"]; // Tabelas em que todos os dados devem ser transferidos
            $data_transfer["album"] = ["albums", "albums_musics", "categories_albums", "musics", "lyrics", "files"]; // Tabelas em que devem ser respeitados o filtro de albuns escolhido pelo usuário
            Config::create(['key' => 'data_transfer', 'type' => 'json', 'value' => json_encode($data_transfer)]);
            */

            //Obter a data e hora da alteração mais recente
            $exclude = ["migrations", "configs"]; // Não checar essas tabelas
            $latestUpdatedAt = null;
            foreach ($tables as $table) {
                if (in_array($table, $exclude)) {
                    continue;
                }

                try {
                    $maxUpdatedAtInTable = DB::table($table)
                        ->orderBy('updated_at', 'desc')
                        ->value('updated_at');

                    if ($maxUpdatedAtInTable > $latestUpdatedAt) {
                        $latestUpdatedAt = $maxUpdatedAtInTable;
                    }
                } catch (\Exception $e) {
                    //
                }
            }

            $version = self::get("version");
            if ($version == strtotime($latestUpdatedAt)) {
                $status = "";
                $message = null;
            } else {

                Config::where('key', 'latest_updated')->delete();
                Config::create(['key' => 'latest_updated', 'type' => 'datetime', 'value' => $latestUpdatedAt]);

                Config::where('key', 'version')->delete();
                Config::create(['key' => 'version', 'type' => 'number', 'value' => strtotime($latestUpdatedAt)]);


                //Grava data e hora da atualização
                Config::where('key', 'date')->delete();
                Config::create(['key' => 'date', 'type' => 'date', 'value' => date('Y-m-d')]);
                Config::where('key', 'time')->delete();
                Config::create(['key' => 'time', 'type' => 'time', 'value' => date('H:i:s')]);
                Config::where('key', 'datetime')->delete();
                Config::create(['key' => 'datetime', 'type' => 'datetime', 'value' => date('Y-m-d H:i:s')]);

                DB::commit();

                $status = "success";
                $message = null;
            }
        } catch (\Exception $e) {
            //Rollback em caso de erros
            DB::rollback();

            Config::where('key', 'error')->delete();
            Config::create(['key' => 'error', 'type' => 'string', 'value' => $e->getMessage()]);

            $status = "error";
            $message = $e->getMessage();
        }

        return ["status" => $status, "message" => $message];
    }
}
