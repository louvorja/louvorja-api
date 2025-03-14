<?php

namespace App\Http\Controllers;

use App\Helpers\Params;
use Illuminate\Http\Request;


class VersionLogController extends Controller
{
    public function index(Request $request)
    {
        $id_language = strtolower($request->id_language ?? $request->query('lang') ?? "pt");

        $params = Params::all();
        $version = $request->query('version') ?? $request->query('versao') ?? $params[$id_language . "_version"];

        $version_array = explode(".", $version);
        $version_software = $version_array[0] . "." . $version_array[1];

        $url = 'https://api.github.com/repos/louvorja/desktop/releases/tags/v' . $version_software;

        $response = \Illuminate\Support\Facades\Http::get($url);
        $body = $response->getBody()->getContents();

        dd($url, $body);

        //return redirect($url);
    }
}
