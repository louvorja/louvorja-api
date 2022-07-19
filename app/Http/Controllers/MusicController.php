<?php

namespace App\Http\Controllers;

use App\Models\Music;
use Illuminate\Http\Request;

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
