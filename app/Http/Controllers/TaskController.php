<?php

namespace App\Http\Controllers;

use App\Helpers\Configs;
use App\Helpers\Files;
use App\Helpers\DataBase;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct()
    {
        ini_set('memory_limit', '-1');
        set_time_limit(60 * 60);
    }

    public function refresh_files_size()
    {
        $ret = Files::refresh_size();
        return response()->json($ret);
    }

    public function refresh_configs()
    {
        $ret = Configs::refresh();
        $data = Configs::get();
        $ret["data"] = $data;

        return response()->json($ret);
    }

    public function export_database()
    {
        Configs::refresh();
        $ret = DataBase::export();

        return response()->json($ret);
    }

    public function import_slides()
    {
        $dir = app()->basePath('public') . DIRECTORY_SEPARATOR . 'import' . DIRECTORY_SEPARATOR;

        $files = Files::list_files($dir);

        if (isset($files["error"])) {
            return response()->json($files);
        }

        $log = [];
        foreach ($files as $file) {
            $ret = DataBase::import_file($file["path"]);
            $log[] = ['file' => $file['name'], 'status' => $ret];
        }

        return response()->json($log);
    }

    public function index(Request $request)
    {
        Configs::refresh();

        $version = Configs::get("version");
        $last_version = Configs::get("last_version");
        $force = ($request->force ?? 0);
        $logs = [];

        if ($force == 1 || $last_version <> $version) {

            //Teve alterações no banco de dados. Gera os dados novamente

            //Ajusta tamanho dos arquivos, caso tenham novos arquivos
            $logs["refresh_files_size"] = Files::refresh_size();

            //Exporta o banco de dados
            $logs["export_database"] = DataBase::export();


            //Atualiza a versão anterior para ficar igual a atual
            $logs["new_version"] = Configs::set("last_version", $version);
        }

        $data = Configs::get();
        return response()->json(["logs" => $logs, "data" => $data]);
    }
}
