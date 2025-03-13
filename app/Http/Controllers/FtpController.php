<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ftp;
use App\Models\FtpLog;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class FtpController extends Controller
{
    public function index(Request $request)
    {
        $id_language = strtolower($request->id_language ?? $request->query('lang') ?? "pt");

        //REMOVER DEPOIS -- RETROCOMPATIBILIDADE
        if (!$request->get("token")) {

            $ftp = Ftp::where('id_language', $id_language)->inRandomOrder()->first();

            $data = $ftp->data;
            $data["lang"] = $id_language;

            // RETROCOMPATIBILIDADE
            $data["ftp_url"] = $data["host"];
            $data["ftp_dir"] = $data["root"];
            $data["ftp_porta"] = $data["port"];
            $data["ftp_usuario"] = $data["username"];
            $data["ftp_senha"] = $data["password"];
            // -------------------

            self::save_log($request, $ftp->id_ftp);

            $text = "";
            foreach ($data as $key => $param) {
                $text .= "$key=$param\r\n";
            }
            return response(base64_encode($text), 200)->header('Content-Type', 'text/plain');
        }
        //----------REMOVER ATÉ AQUI--------------------------


        $key = env('JWT_SECRET');
        $jwt = $request->get("token");

        try {
            JWT::decode($jwt, new Key($key, 'HS256'));

            $ftp = Ftp::where('id_language', $id_language)->inRandomOrder()->first();
            self::save_log($request, $ftp->id_ftp);

            $data = $ftp->data;
            $data["lang"] = $id_language;

            $text = "";
            foreach ($data as $key => $param) {
                $text .= "$key=$param\r\n";
            }
            return response(base64_encode($text), 200)->header('Content-Type', 'text/plain');
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Token inválido',
            ], 401);
        }
    }

    public function save_log(Request $request, $id_ftp)
    {
        $ftp = Ftp::find($id_ftp);

        $request->request->remove('limit');

        FtpLog::create([
            'id_language' => $ftp->id_language,
            'request' => $request->toArray(),
        ]);
        //dd($id_ftp, $request->toArray());
    }
}
