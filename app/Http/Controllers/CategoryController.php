<?php

namespace App\Http\Controllers;

use App\Helpers\Data;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {
        $model = new Category;
        $data = $model->select()->where('id_language', $request->id_language);
        return response()->json(Data::data($data, $request, $model->getFillable()));
    }
}
