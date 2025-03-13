<?php

namespace App\Http\Controllers;

use App\Helpers\Params;
use App\Models\DownloadLog;
use Illuminate\Http\Request;


class DownloadController extends Controller
{
    public function index(Request $request)
    {
        $id_language = strtolower($request->id_language ?? $request->query('lang') ?? "pt");
        $params = Params::all();

        $version = $params[$id_language . "_version"];

        $version_array = explode(".", $version);
        $version_software = $version_array[0] . "." . $version_array[1];

        $name = "";
        if ($id_language == "pt") {
            $name = "LouvorJA_Instalador" . $version . ".exe";
        } elseif ($id_language == "es") {
            $name = "LoorJA_Instalador" . $version . ".exe";
        }

        $url = "https://github.com/louvorja/desktop/releases/download/v" . $version_software . "/" . $name;

        DownloadLog::create(['version' => $version, 'id_language' => $id_language]);

        return redirect($url);
    }
}
