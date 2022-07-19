<?php

namespace App\Http\Controllers;

use App\Models\Music;
use App\Models\Lyric;
use Illuminate\Http\Request;
use App\Helpers\Urls;

class MusicController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {
        return response()->json(
            Music::where('id_language', $request->id_language)->paginate($request->limit)
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

    public function show($id,Request $request)
    {
        $music = Music::find($id);
        if ($music){
            $music->url_music = Urls::musics($request->id_language);
            $music->url_images = Urls::images($request->id_language);
            $music->lyric = Lyric::where('id_music',$music->id_music)->orderBy('order')->get();
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
