<?php

namespace App\Http\Controllers;

use App\Helpers\Params;
use App\Models\DownloadLog;
use Illuminate\Http\Request;


class VersionLogController extends Controller
{
    public function index(Request $request)
    {
        dd("EM BREVE", $request->all());

        return redirect($url);
    }
}
