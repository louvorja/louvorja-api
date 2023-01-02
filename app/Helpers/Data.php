<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class Data
{

    public static function data($data, $request)
    {
        if ($request->sort_by) {
            $items = explode(",", $request->sort_by);
            foreach ($items as $item) {
                $f = explode(".", $item);
                $f[1] = (@$f[1] ? $f[1] : "asc");
                $data->orderBy($f[0], $f[1]);
            }
        }
        return $data->paginate($request->limit);
    }

    public static function structure($table_name)
    {
        $columns = DB::select("SHOW COLUMNS FROM $table_name");
        return ["columns" => $columns];
    }

}
