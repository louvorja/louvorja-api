<?php

namespace App\Http\Controllers;

use App\Helpers\Data;
use App\Helpers\Validations;
use App\Models\Album;
use App\Models\Music;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlbumController extends Controller
{
    public function validationRules(Request $request, $id = null)
    {
        return [
            'name' => 'required|string',
            'id_language' => 'required|string|exists:languages,id_language',
        ];
    }

    private function validationMessages()
    {
        return Validations::validationMessages();
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
            ->leftJoin('files', 'albums.id_file_image', 'files.id_file');

        if ($request->id_language) {
            $data->where('albums.id_language', $request->id_language);
        }

        if (isset($request["categories_slug"])) {
            $categories = explode(",", $request["categories_slug"]);
            $data = $data
                ->join('categories_albums', 'categories_albums.id_album', 'albums.id_album')
                ->join('categories', 'categories.id_category', 'categories_albums.id_category')
                ->whereIn('categories.slug', $categories);
        }

        if (isset($request["with_categories"]) && $request["with_categories"] == 1) {
            $data = $data->with('categories');
        }
        $data = $data->distinct();
        return response()->json(Data::data($data, $request, [$model->getKeyName(), ...$model->getFillable()], 'albums'));
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->validationRules($request), $this->validationMessages());

        $album = Album::create($request->all());

        $data = (object) [];
        $data->data = $album;
        $data->message = 'Registro cadastrado com sucesso!';
        return response()->json($data, 201);
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

        if (!$album) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, $this->validationRules($request, $id), $this->validationMessages());

        $album = Album::find($id);

        $data = (object) [];
        $data->data = $album;

        if (!$album) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $album->update($request->all());

        $data->message = 'Registro alterado com sucesso!';
        return response()->json($data);
    }

    public function destroy($id)
    {
        $album = Album::find($id);

        $data = (object) [];
        $data->data = $album;

        if (!$album) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $album->delete();
        return response()->json(['message' => 'Registro excluído com sucesso!']);
    }
}
