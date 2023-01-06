<?php

namespace App\Http\Controllers;

use App\Helpers\Data;
use App\Models\Album;
use App\Models\Music;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlbumController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {
        $model = new Album;
        $data = $model->select(
            'albums.id_album',
            'albums.name',
            'albums.id_file_image',
            DB::raw('concat(files.base_url,files.subdirectory,files.file_name) as url_image'),
            'files.version as image_version',
            'albums.id_language',
            'albums.color',
            DB::raw((isset($request["categories_slug"]) ? 'categories_albums.name' : '""') . ' as subtitle'),
            DB::raw((isset($request["categories_slug"]) ? 'categories_albums.order' : '""') . ' as `order`'),
            'albums.created_at',
            'albums.updated_at',
        )
            ->where('albums.id_language', $request->id_language)
            ->leftJoin('files', 'albums.id_file_image', 'files.id_file');

        if (isset($request["categories_slug"])) {
            $categories = explode(",", $request["categories_slug"]);
            $data = $data
                ->leftJoin('categories_albums', 'categories_albums.id_album', 'albums.id_album')
                ->leftJoin('categories', 'categories.id_category', 'categories_albums.id_category')
                ->whereIn('categories.slug', $categories);
        }

        if (isset($request["with_categories"]) && $request["with_categories"] == 1) {
            $data = $data->with('categories');
        }
        $data = $data->distinct();
        return response()->json(Data::data($data, $request, $model->getFillable()));
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
        $album = Album::select(
            'albums.id_album',
            'albums.name',
            'albums.id_file_image',
            DB::raw('concat(files.base_url,files.subdirectory,files.file_name) as url_image'),
            'files.version as image_version',
            'albums.id_language',
            'albums.color',
            'albums.created_at',
            'albums.updated_at',
        )
            ->leftJoin('files', 'albums.id_file_image', 'files.id_file')
            ->find($id);
        if ($album) {
            $album->musics = Music::where('albums_musics.id_album', $album->id_album)
                ->leftJoin('albums_musics', 'albums_musics.id_music', 'musics.id_music')
                ->leftJoin('files as files_image', 'musics.id_file_image', 'files_image.id_file')
                ->leftJoin('files as files_music', 'musics.id_file_music', 'files_music.id_file')
                ->leftJoin('files as files_instrumental_music', 'musics.id_file_instrumental_music', 'files_instrumental_music.id_file')
                ->select(
                    'musics.id_music',
                    'albums_musics.track',
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
                ->orderBy('albums_musics.track')
                ->get();
        }

        $data = (object) [];
        $data->data = $album;

        return response()->json($data);
    }

    public function edit(Album $album)
    {
        //
    }

    public function update(Request $request, Album $album)
    {
        //
    }

    public function destroy(Album $album)
    {
        //
    }
}
