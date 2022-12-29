<?php

namespace App\Http\Controllers;

use App\Helpers\Data;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlbumController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {
        $data = Album::where('albums.id_language', $request->id_language)
            ->leftJoin('files', 'albums.id_file_image', 'files.id_file')
            ->select(
                'albums.id_album',
                'albums.name',
                'albums.id_file_image',
                DB::raw('concat(files.base_url,files.subdirectory,files.file_name) as url_image'),
                'files.version as image_version',
                'albums.id_language',
                'albums.color',
                DB::raw((isset($request["categories_slug"]) ? 'categories_albums.name' : '""').' as subtitle'),
                DB::raw((isset($request["categories_slug"]) ? 'categories_albums.order' : '""').' as `order`'),
                'albums.created_at',
                'albums.updated_at',
            );

        if (isset($request["categories_slug"])) {
            $data = $data
                ->leftJoin('categories_albums', 'categories_albums.id_album', 'albums.id_album')
                ->leftJoin('categories', 'categories.id_category', 'categories_albums.id_category')
                ->where('categories.slug', $request["categories_slug"]);
        }

        if (isset($request["with_categories"]) && $request["with_categories"] == 1) {
            $data = $data->with('categories');
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

    public function show(Album $album)
    {
        //
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
