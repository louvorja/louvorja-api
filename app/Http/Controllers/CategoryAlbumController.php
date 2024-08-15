<?php

namespace App\Http\Controllers;

use App\Helpers\Data;
use App\Models\CategoryAlbum;
use Illuminate\Http\Request;

class CategoryAlbumController extends Controller
{
    public function __construct() {}

    public function index(Request $request)
    {
        $model = new CategoryAlbum;
        $data = $model->select()->where('id_language', $request->id_language);
        return response()->json(Data::data($data, $request, [$model->getKeyName(), ...$model->getFillable()]));
    }
}
