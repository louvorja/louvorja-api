<?php

namespace App\Http\Controllers;

use App\Helpers\Data;
use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function __construct() {}

    public function index(Request $request)
    {
        $model = new Language;
        $data = $model->select();

        $data = $data->distinct();
        return response()->json(Data::data($data, $request, [$model->getKeyName(), ...$model->getFillable()]));
    }
}
