<?php

namespace App\Http\Controllers;

use App\Helpers\Configs;
use Illuminate\Http\Request;

class ParamsController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get("type") ?? "json";

        $params = [];
        $params["type"] = $type;

        $pt_delphi_version = Configs::get("pt_delphi_version");
        $params["versao"] = $pt_delphi_version;
        $params["versaoPT"] = $pt_delphi_version;

        $es_delphi_version = Configs::get("es_delphi_version");
        $params["versaoES"] = $es_delphi_version;

        if ($type == "env") {
            $text = "";
            foreach ($params as $key => $param) {
                $text .= "$key=$param\r\n";
            }
            return response($text, 200)->header('Content-Type', 'text/json');
        } else {
            return $params;
        }
        dd("params");
    }
}
