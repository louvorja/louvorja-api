<?php

namespace App\Http\Controllers;

use App\Models\Music;
use Illuminate\Http\Request;

class HymnalController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {
        return response()->json(
            Music::where('musics.id_language', $request->id_language)
                ->select('musics.*','albums_musics.track')
                ->join('albums_musics', 'albums_musics.id_music', '=', 'musics.id_music')
                ->join('categories_albums', 'categories_albums.id_album', '=', 'albums_musics.id_album')
                ->join('categories', 'categories.id_category', '=', 'categories_albums.id_category')
                ->where('categories.slug', 'hymnal')
                ->orderBy('albums_musics.track')
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

    public function show(Music $music)
    {
        //
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
