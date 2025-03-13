<?php

namespace App\Helpers;

use App\Helpers\Configs;
use Firebase\JWT\JWT;

class Params
{

    public static function all()
    {

        $token_ftp = JWT::encode(['exp' => time() + 180 + 18000], env('JWT_SECRET'), 'HS256');

        $params = [];

        $pt_delphi_version = Configs::get("pt_delphi_version");
        $params["versao"] = $pt_delphi_version; // remover depois -- adaptar no Delphi primeiro
        $params["versaoPT"] = $pt_delphi_version; // remover depois -- adaptar no Delphi primeiro
        $params["version"] = $pt_delphi_version;
        $params["pt_version"] = $pt_delphi_version;

        $es_delphi_version = Configs::get("es_delphi_version");
        $params["versaoES"] = $es_delphi_version; // remover depois -- adaptar no Delphi primeiro
        $params["es_version"] = $es_delphi_version;

        $params["conn_ftp"] = "https://api.louvorja.com.br/ftp?token=" . $token_ftp;


        /* A partir daqui, são todos parâmetros do Delphi */
        $params["instalador"] = "setup\Output\LouvorJA_Instalador" . $pt_delphi_version . ".exe"; // Diretório FTP de onde vai buscar o instalador
        $params["instaladorES"] = "setup\Output\LoorJA_Instalador" . $es_delphi_version . ".exe";
        $params["form"] = "https://louvorja.com.br/contato/";
        $params["formPT"] = "https://louvorja.com.br/contato/";
        $params["formES"] = "https://louvorja.com.br/es/contacto/";
        $params["coletaneas_online"] = "https://params.louvorja.com.br/baixa_coletaneas_web.php";
        $params["embed_youtube"] = "https://www.youtube.com/embed/{videoID}";
        $params["ftp"] = "https://api.louvorja.com.br/ftp"; // REMOVER DEPOIS PARA MANTER A FORMA SEGURA (COM TOKEN)
        $params["help"] = "https://louvorja.com.br/ajuda/";
        $params["helpPT"] = "https://louvorja.com.br/ajuda/";
        $params["helpES"] = "https://louvorja.com.br/es/ayuda/";
        $params["logs_versao"] = "https://params.louvorja.com.br/logs_versao.php";

        return $params;
    }
}
