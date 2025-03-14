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

        $version_software = "24.8";
        $url = 'https://api.github.com/repos/louvorja/desktop/releases/tags/v' . $version_software;

        $response = \Illuminate\Support\Facades\Http::get($url);
        $api = json_decode($response->getBody()->getContents(), true);

        dd($url, $api["body"]);

        //return redirect($url);
    }
}
