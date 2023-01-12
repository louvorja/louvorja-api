<?php

namespace App\Helpers;

class Data
{

    public static function data($data, $request, $fillable, $table = '')
    {
        if ($request->limit && $request->limit <= 0) {
            $request->limit = 9999;
        }
        if ($request->sort_by) {
            $items = explode(",", $request->sort_by);
            foreach ($items as $item) {
                $f = explode(".", $item);
                $f[1] = (@$f[1] ? $f[1] : "asc");
                $data->orderBy($f[0], $f[1]);
            }
        }
        $fields = Data::arrayFilter($request->all(), $fillable);
        foreach ($fields as $field => $value) {
            $field = ($table != '' ? $table . '.' : '') . $field;
            $term = explode(":", $value);
            if (!isset($term[1])) {
                $data->where($field, Data::value($value));
            } else {
                $type = $term[0];
                unset($term[0]);
                $value = implode(":", $term);
                if ($type == "like") {
                    $value = str_replace("*", "%", $value);
                    $data->where($field, $type, Data::value($value));
                }
            }
        }
        return $data->paginate($request->limit);
    }

    public static function arrayFilter($all, $get)
    {
        return array_filter($all, function ($item) use ($get) {
            return array_search($item, $get) !== false;
        }, ARRAY_FILTER_USE_KEY);
    }

    public static function value($value)
    {
        if ($value == "true") {
            $value = true;
        } elseif ($value == "false") {
            $value = false;
        }
        return $value;
    }

}
