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

        $url = $params[$id_language . "_download"];

        DownloadLog::create(['version' => $params[$id_language . "_version"], 'id_language' => $id_language]);

        return redirect($url);
    }
}
