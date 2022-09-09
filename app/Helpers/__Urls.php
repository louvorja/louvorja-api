<?php

namespace App\Helpers;

class Urls
{

    public static function covers($lang)
    {
        return env("URL_FILES")."/$lang/covers";
    }
    public static function musics($lang)
    {
        return env("URL_FILES")."/$lang/musics";
    }
    public static function images($lang)
    {
        return env("URL_FILES")."/$lang/images";
    }


}
