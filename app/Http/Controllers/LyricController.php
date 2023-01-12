<?php

namespace App\Http\Controllers;

use App\Helpers\Data;
use App\Models\Lyric;
use Illuminate\Http\Request;

class LyricController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {
        $model = new Lyric;
        $data = $model->select()->where('lyrics.id_language', $request->id_language);

        if (isset($request["id_album"])) {
            $data = $data
                ->join('albums_musics', 'albums_musics.id_music', 'lyrics.id_music')
                ->where('albums_musics.id_album', $request["id_album"]);
        }

        return response()->json(Data::data($data, $request, $model->getFillable(), 'lyrics'));
    }
}
