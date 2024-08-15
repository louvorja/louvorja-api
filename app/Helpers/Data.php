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
            $we = Data::whereExplode($value);

            if ($we['sep'] == "or") {
                $data->orWhere($field, $we['op'], $we['value']);
            } else {
                $data->where($field, $we['op'], $we['value']);
            }
        }
        //echo PHP_EOL . $data->toSql();
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

    public static function whereExplode($text)
    {
        $type = '=';
        $value = $text;
        $sep = 'and';

        $term = explode(":", $text);
        if (!isset($term[1])) {
            $value = Data::value($value);
        } else {
            $op = $term[0];
            if ($op == "like" || $op == "orlike") {
                $type = "like";
                if ($op == "orlike") {
                    $sep = 'or';
                }
                unset($term[0]);
                $value = implode(":", $term);
                $value = str_replace("*", "%", $value);
                $value = Data::value($value);
            } elseif ($op == "or") {
                $sep = 'or';
                unset($term[0]);
                $value = implode(":", $term);
                $value = Data::value($value);
            } else {
                $value = Data::value($value);
            }
        }

        return ['op' => $type, 'value' => $value, 'sep' => $sep];
    }
}
