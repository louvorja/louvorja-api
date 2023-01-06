<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Schema;

class Config extends Model
{
    protected $primaryKey = 'id_category';
    protected $fillable = [
        'id_config',
        'key',
        'type',
        'value',
    ];

    public static function generate()
    {
        try {
            //Cria uma transação, pois em caso de erros, deve ser feito o rollback
            DB::beginTransaction();

            //Limpa tabela
            Config::query()->delete();

            //Lista de tabelas do sistema
            $list_tables = [];
            DB::connection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
            $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();
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
            }
            Config::create(['key' => 'tables', 'type' => 'json', 'value' => json_encode($list_tables)]);


            //Grava data e hora da atualização
            Config::create(['key' => 'date', 'type' => 'date', 'value' => date('Y-m-d')]);
            Config::create(['key' => 'time', 'type' => 'time', 'value' => date('H:i:s')]);
            Config::create(['key' => 'datetime', 'type' => 'datetime', 'value' => date('Y-m-d H:i:s')]);


            DB::commit();
        } catch (\Exception $e) {
            //Rollback em caso de erros
            DB::rollback();

            Config::where('key', 'error')->delete();
            Config::create(['key' => 'error', 'type' => 'string', 'value' => $e->getMessage()]);
        }
    }

}
