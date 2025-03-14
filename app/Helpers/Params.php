<?php

namespace App\Helpers;

use App\Helpers\Configs;
use Firebase\JWT\JWT;
use App\Models\Language;

class Params
{

    public static function all()
    {

        $file_name = [
            "pt" => "LouvorJA_Instalador",
            "es" => "LoorJA_Instalador"
        ];

        $params = [];

        $langs = Language::all();
        foreach ($langs as $lang) {
            $id_language = $lang->id_language;

            $version = Configs::get($id_language . "_delphi_version");
            if ($lang->id_language == "pt") {
                $params["versao"] = $version; // remover depois -- adaptar no Delphi primeiro
                $params["instalador"] = "setup\Output\LouvorJA_Instalador" . $version . ".exe"; // remover depois -- adaptar no Delphi primeiro
            }
            $params["versao" . strtoupper($id_language)] = $version; // remover depois -- adaptar no Delphi primeiro
            $params["instalador" . strtoupper($id_language)] = "setup\Output\\" . $file_name[$id_language] . $version . ".exe"; // remover depois -- adaptar no Delphi primeiro

            $params[$id_language . "_version"] = $version;

            $version_array = explode(".", $version);
            $version_software = $version_array[0] . "." . $version_array[1];
            $params[$id_language . "_version_software"] = $version_software;

            $params[$id_language . "_download"] = "https://github.com/louvorja/desktop/releases/download/v" . $version_software . "/" . $file_name[$id_language] . $version . ".exe";
        }

        $token_ftp = JWT::encode(['exp' => time() + 60], env('JWT_SECRET'), 'HS256');
        $params["conn_ftp"] = "https://api.louvorja.com.br/ftp?token=" . $token_ftp;
        $params["version_log"] = "https://api.louvorja.com.br/version_log";
        $params["help"] = "https://louvorja.com.br/ajuda/";

        /* A partir daqui, são todos parâmetros do Delphi */
        $params["coletaneas_online"] = "https://params.louvorja.com.br/baixa_coletaneas_web.php";
        $params["embed_youtube"] = "https://www.youtube.com/embed/{videoID}";
        $params["ftp"] = "https://api.louvorja.com.br/ftp"; // REMOVER DEPOIS PARA MANTER A FORMA SEGURA (COM TOKEN)
        $params["helpPT"] = $params["help"];
        $params["helpES"] = $params["help"] . "?lang=es";
        $params["logs_versao"] = $params["version_log"];

        return $params;
    }
}
