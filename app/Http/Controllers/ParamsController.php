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

        $params["instalador"] = "setup\Output\LouvorJA_Instalador24.7.17233.35503.exe";
        $params["instaladorES"] = "setup\Output\LoorJA_Instalador21.0.20.1.exe";
        $params["form"] = "https://louvorja.com.br/contato/";
        $params["formPT"] = "https://louvorja.com.br/contato/";
        $params["formES"] = "https://louvorja.com.br/es/contacto/";
        $params["coletaneas_online"] = "https://params.louvorja.com.br/baixa_coletaneas_web.php";
        $params["embed_youtube"] = "https://www.youtube.com/embed/{videoID}";
        $params["ftp"] = "https://params.louvorja.com.br/ftp.php";
        $params["help"] = "https://louvorja.com.br/ajuda/";
        $params["helpPT"] = "https://louvorja.com.br/ajuda/";
        $params["helpES"] = "https://louvorja.com.br/es/ayuda/";
        $params["logs_versao"] = "https://params.louvorja.com.br/logs_versao.php";

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
