<?php

namespace App\Http\Controllers;

use App\Helpers\Data;
use App\Models\AlbumMusic;
use Illuminate\Http\Request;

class AlbumMusicController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {
        $model = new AlbumMusic;
        $data = $model->select()->where('id_language', $request->id_language);
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

    public function show(AlbumMusic $album_music)
    {
        //
    }

    public function edit(AlbumMusic $album_music)
    {
        //
    }

    public function update(Request $request, AlbumMusic $album_music)
    {
        //
    }

    public function destroy(AlbumMusic $album_music)
    {
        //
    }
}
