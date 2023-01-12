<?php

namespace App\Http\Controllers;

use App\Helpers\Data;
use App\Models\File;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {
        $model = new File;
        $data = $model->select();

        if (isset($request["id_album"])) {
            $data = $data
                ->whereRaw('id_file in (select id_file_image from albums where albums.id_album=' . $request["id_album"] . ')')
                ->orWhereRaw('id_file in (select id_file_image from musics inner join albums_musics on albums_musics.id_music=musics.id_music where albums_musics.id_album=' . $request["id_album"] . ')')
                ->orWhereRaw('id_file in (select id_file_music from musics inner join albums_musics on albums_musics.id_music=musics.id_music where albums_musics.id_album=' . $request["id_album"] . ')')
                ->orWhereRaw('id_file in (select id_file_instrumental_music from musics inner join albums_musics on albums_musics.id_music=musics.id_music where albums_musics.id_album=' . $request["id_album"] . ')')
                ->orWhereRaw('id_file in (select id_file_image from lyrics inner join albums_musics on albums_musics.id_music=lyrics.id_music where albums_musics.id_album=' . $request["id_album"] . ')');
        }

        return response()->json(Data::data($data, $request, $model->getFillable(), 'files'));
    }

}
