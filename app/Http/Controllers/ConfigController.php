<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {
        //Verifica se já foi feita atualização no dia, e faz em caso de negativa
        $datetime = Config::select()->where('key', 'date')->where('value', date('Y-m-d'))->first();
        if (!$datetime) {
            Config::generate();
        }

        $config = Config::select()->get();

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

        return response()->json($data);
    }

    public function create(Request $request)
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(CategoryAlbum $category_album)
    {
        //
    }

    public function edit(CategoryAlbum $category_album)
    {
        //
    }

    public function update(Request $request, CategoryAlbum $category_album)
    {
        //
    }

    public function destroy(CategoryAlbum $category_album)
    {
        //
    }
}
