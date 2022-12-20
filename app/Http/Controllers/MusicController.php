<?php

namespace App\Http\Controllers;

use App\Helpers\Data;
use App\Models\Lyric;
use App\Models\Music;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MusicController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {
        $data = Music::where('id_language', $request->id_language)
            ->leftJoin('files as files_image', 'musics.id_file_image', 'files_image.id_file')
            ->leftJoin('files as files_music', 'musics.id_file_music', 'files_music.id_file')
            ->leftJoin('files as files_instrumental_music', 'musics.id_file_instrumental_music', 'files_instrumental_music.id_file')
            ->select(
                'musics.id_music',
                'musics.name',
                'musics.id_file_image',
                DB::raw('concat(files_image.base_url,files_image.subdirectory,files_image.file_name) as url_image'),
                'files_image.version as image_version',
                'musics.id_file_music',
                DB::raw('concat(files_music.base_url,files_music.subdirectory,files_music.file_name) as url_music'),
                'files_music.version as music_version',
                'musics.id_file_instrumental_music',
                DB::raw('concat(files_instrumental_music.base_url,files_instrumental_music.subdirectory,files_instrumental_music.file_name) as url_instrumental_music'),
                'files_instrumental_music.version as instrumental_music_version',
                'musics.id_language',
                'musics.created_at',
                'musics.updated_at',
            );
        if (isset($request["with_albums"]) && $request["with_albums"] == 1) {
            $data = $data->with('albums');
        }
        return response()->json(Data::data($data, $request));
    }

    public function create(Request $request)
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id, Request $request)
    {
        $music = Music::select(
            'musics.id_music',
            'musics.name',
            'musics.id_file_image',
            DB::raw('concat(files_image.base_url,files_image.subdirectory,files_image.file_name) as url_image'),
            'files_image.version as image_version',
            'musics.id_file_music',
            DB::raw('concat(files_music.base_url,files_music.subdirectory,files_music.file_name) as url_music'),
            'files_music.version as music_version',
            'musics.id_file_instrumental_music',
            DB::raw('concat(files_instrumental_music.base_url,files_instrumental_music.subdirectory,files_instrumental_music.file_name) as url_instrumental_music'),
            'files_instrumental_music.version as instrumental_music_version',
            'musics.id_language',
            'musics.created_at',
            'musics.updated_at',
        )
            ->leftJoin('files as files_image', 'musics.id_file_image', 'files_image.id_file')
            ->leftJoin('files as files_music', 'musics.id_file_music', 'files_music.id_file')
            ->leftJoin('files as files_instrumental_music', 'musics.id_file_instrumental_music', 'files_instrumental_music.id_file')
            ->find($id);
        if ($music) {
            $music->lyric = Lyric::where('id_music', $music->id_music)
                ->leftJoin('files as files_image', 'lyrics.id_file_image', 'files_image.id_file')
                ->select(
                    'lyrics.id_lyric',
                    'lyrics.id_music',
                    'lyrics.lyric',
                    DB::raw('ifnull(lyrics.id_file_image,0' . $music->id_file_image . ') id_file_image'),
                    DB::raw('ifnull(concat(files_image.base_url,files_image.subdirectory,files_image.file_name),"' . $music->url_image . '") as url_image'),
                    DB::raw('ifnull(files_image.version,0' . $music->image_version . ') as image_version'),
                    'lyrics.time',
                    'lyrics.instrumental_time',
                    'lyrics.show_slide',
                    'lyrics.order',
                    'lyrics.id_language',
                    'lyrics.created_at',
                    'lyrics.updated_at',
                )
                ->orderBy('order')->get();
        }

        $data = (object) [];
        $data->data = $music;

        return response()->json($data);
    }

    public function edit(Music $music)
    {
        //
    }

    public function update(Request $request, Music $music)
    {
        //
    }

    public function destroy(Music $music)
    {
        //
    }
}
