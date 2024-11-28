<?php

namespace App\Helpers;

use App\Models\File as FileModel;
use Illuminate\Support\Facades\File;
use zipArchive;
use getID3;

class Files
{

    public static function refresh_size()
    {
        $log = [];
        //$files = Files::all();
        //$files = Files::take(3)->get();
        $files = FileModel::where('size', '<=', 0)->get();
        foreach ($files as $file) {
            $url = env("FILES_URL") . $file["dir"] . "/" . $file["file_name"];
            $dir = env("FILES_DIR") . $file["dir"] . "/" . $file["file_name"];

            $log[$file->id_file]["url"] = $url;
            $log[$file->id_file]["dir"] = $dir;

            if (file_exists($dir)) {
                $contentLength = filesize($dir);
                $file->size = $contentLength;
                $file->save();

                $log[$file->id_file]["status"] = "success";
                $log[$file->id_file]["size"] = $contentLength;
            } else {
                $log[$file->id_file]["status"] = "error";
            }
        }
        return ["logs" => $log];
    }

    public static function refresh_duration()
    {
        $getID3 = new getID3;

        $log = [];
        $files = FileModel::whereNull('duration')->where('type', 'music')->get();
        foreach ($files as $file) {
            $url = env("FILES_URL") . $file["dir"] . "/" .  $file["file_name"];
            $dir = env("FILES_DIR") . $file["dir"] . "/" . $file["file_name"];

            $log[$file->id_file]["url"] = $url;
            $log[$file->id_file]["dir"] = $dir;

            if (file_exists($dir)) {
                $fileInfo = $getID3->analyze($dir);
                $duration = gmdate("H:i:s", $fileInfo['playtime_seconds']);
                $file->duration = $duration;
                $file->save();

                $log[$file->id_file]["status"] = "success";
                $log[$file->id_file]["duration"] = $duration;
            } else {
                $log[$file->id_file]["status"] = "error";
            }
        }
        return ["logs" => $log];
    }

    public static function list_files($directoryPath)
    {
        if (!File::exists($directoryPath)) {
            return ['error' => 'Diretório não encontrado.'];
        }

        $allFilesAndDirs = File::files($directoryPath);

        $files = array_filter($allFilesAndDirs, function ($file) {
            return $file->isFile();
        });

        $fileNames = array_map(function ($file) use ($directoryPath) {
            return [
                'name' => $file->getFilename(),
                'path' => $directoryPath . $file->getFilename(),
                'mime' => mime_content_type($directoryPath . $file->getFilename()),
            ];
        }, $files);

        return $fileNames;
    }

    public static function zip_filenames(\ZipArchive $zipArchive)
    {
        $filenames = array();
        $fileCount = $zipArchive->numFiles;

        for ($i = 0; $i < $fileCount; $i++) {
            $filename = $zipArchive->getNameIndex($i);

            if ($filename !== false) {
                $filenames[] = $filename;
            }
        }

        return $filenames;
    }

    public static function unzip($file, $output = '')
    {
        if (!File::exists($file)) {
            return ['error' => 'Arquivo não encontrado.'];
        }

        $info = pathinfo($file);

        if ($output == '') {
            $output = dirname($file);
            $output = rtrim($output, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $info['filename'];
        }

        $zipArchive = new ZipArchive;
        $zipArchive->open($file);
        $filenames  = self::zip_filenames($zipArchive);

        $zipArchive->extractTo($output, $filenames);

        $zipArchive->close();

        return ['files' => $filenames, 'output' => $output];
    }
}
