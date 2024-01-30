<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class GenerateTriggers
{

    protected $signature = 'generate:triggers';
    protected $description = 'Generate triggers for all tables in the database';

    public static function run()
    {
        $tables = self::getTables();

        foreach ($tables as $table) {
            //if ($table != 'logs') {
                self::generateTrigger($table);
            //}
        }
    }

    private static function getTables()
    {
        $tables = [];

        $result = DB::select("SHOW TABLES");

        foreach ($result as $table) {
            $tables[] = reset($table);
        }

        return $tables;
    }

    private static function generateTrigger($table)
    {
        $triggerName = 'trigger_' . $table . '_update';

        DB::unprepared("DROP TRIGGER IF EXISTS $triggerName");

        $columns = self::getColumns($table);

        $previousData = [];
        $newData = [];

        foreach ($columns as $column) {
            $previousData[] = sprintf("'%s', OLD.%s", $column, $column);
            $newData[] = sprintf("'%s', NEW.%s", $column, $column);
        }

        $previousData = implode(', ', $previousData);
        $newData = implode(', ', $newData);

        $triggerSql = sprintf("
            CREATE TRIGGER %s
            AFTER UPDATE ON %s
            FOR EACH ROW
            BEGIN
                INSERT INTO `logs` (`table`, `operation_type`, `user`, `previous_data`, `current_data`, `created_at`, `updated_at`)
                VALUES ('%s', 'UPDATE', USER(), JSON_OBJECT(%s), JSON_OBJECT(%s), NOW(), NOW());
            END
        ", $triggerName, $table, $table, $previousData, $newData);

        //echo $triggerSql;
        DB::unprepared($triggerSql);
    }


    private static function getColumns($table)
    {
        $columns = [];

        $result = DB::select("DESCRIBE $table");

        foreach ($result as $column) {
            $columns[] = $column->Field;
        }

        return $columns;
    }
}
