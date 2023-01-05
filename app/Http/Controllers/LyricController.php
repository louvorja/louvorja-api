<?php

namespace App\Http\Controllers;

use App\Helpers\Data;
use App\Models\Lyric;
use Illuminate\Http\Request;

class LyricController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {
        $model = new Lyric;
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

    public function show(Lyric $lyric)
    {
        //
    }

    public function edit(Lyric $lyric)
    {
        //
    }

    public function update(Request $request, Lyric $lyric)
    {
        //
    }

    public function destroy(Lyric $lyric)
    {
        //
    }
}
