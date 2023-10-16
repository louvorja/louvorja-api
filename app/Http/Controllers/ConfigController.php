<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Helpers\Configs;
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
            Configs::refresh();
        }
        return $this->configs();

    }
    public function refresh()
    {
        Configs::refresh();
        return $this->configs();
    }

    public function configs()
    {
        $data = Configs::get();
        return response()->json(["data" => $data]);
    }
}
