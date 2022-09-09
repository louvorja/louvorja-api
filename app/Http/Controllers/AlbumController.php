<?php

namespace App\Http\Controllers;

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
        return response()->json(
            Album::where('id_language', $request->id_language)
                ->leftJoin('files', 'albums.id_file_image', 'files.id_file')
                ->select(
                    'albums.id_album',
                    'albums.name',
                    'albums.id_file_image',
                    DB::raw('concat(files.base_url,files.subdirectory,files.file_name) as url_image'),
                    'files.version as image_version',
                    'albums.id_language',
                    'albums.created_at',
                    'albums.updated_at',
                )
                ->paginate($request->limit)
        );
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
