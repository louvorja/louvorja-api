<?php

namespace App\Http\Controllers;

use App\Models\AlbumMusic;
use Illuminate\Http\Request;

class AlbumMusicController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {
        return response()->json(
            AlbumMusic::where('id_language', $request->id_language)->paginate($request->limit)
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
