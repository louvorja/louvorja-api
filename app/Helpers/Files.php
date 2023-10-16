<?php

namespace App\Helpers;

use App\Models\File;

class Files
{

    public static function refresh_size()
    {
        $log = [];
        //$files = Files::all();
        //$files = Files::take(3)->get();
        $files = File::where('size', '<=', 0)->get();
        foreach ($files as $file) {
            $url = $file["base_url"] . $file["subdirectory"] . $file["file_name"];
            $dir = $file["base_dir"] . $file["subdirectory"] . $file["file_name"];

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
}
