<?php

namespace App\Http\Controllers;

use App\Helpers\Params;
use Illuminate\Http\Request;

class ParamsController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get("type") ?? "json";

        $params = Params::all();

        if ($type == "env") {
            $text = "";
            foreach ($params as $key => $param) {
                $text .= "$key=$param\r\n";
            }
            return response($text, 200)->header('Content-Type', 'text/json');
        } else {
            return $params;
        }
    }
}
