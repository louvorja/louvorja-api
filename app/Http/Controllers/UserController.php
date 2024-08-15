<?php

namespace App\Http\Controllers;

use App\Helpers\Data;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct() {}

    public function index(Request $request)
    {
        $model = new User;
        $data = $model->select();
        return response()->json(Data::data($data, $request, $model->getFillable()));
    }
}
