<?php

namespace App\Http\Middleware;

use App\Models\Language;
use Cache;
use Closure;

class ApiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        list($lang) = explode("/", $request->path());

        $cache = env('APP_CACHE', true);
        $debug = env('APP_DEBUG', false);
        //error_log("APP_CACHE=".$cache);

        if (!$debug) {
            if (!$request->header('Api-Token')) {
                return response()->json(['error' => "Token de API não informado!"], 401);
            }
            if ($request->header('Api-Token') != env('API_TOKEN')) {
                return response()->json(['error' => "Token de API inválido!"], 401);
            }
        }

        if ($lang != "" && $lang != "tasks" && $lang != "auth") {
            if (!$cache || Cache::store('file')->get("lang_{$lang}") != true) {
                //error_log("*** Localiza idioma ***");
                if (!Language::find($lang)) {
                    return response()->json(['error' => "Idioma '$lang' não encontrado."], 401);
                }

                if ($cache) {
                    // Armazena a verificação em cache, por 24 horas
                    // para não precisar repetir consulta no BD
                    //error_log("*** Armazena em cache (lang_{$lang}) ***");
                    Cache::store('file')->put("lang_{$lang}", true, 60 * 60 * 24);
                }
            }
        }

        $request->limit = ($request->limit ? (int) $request->limit : 100);
        if ($request->limit <= 0) {
            $request->limit = 999999;
        }
        $request->id_language = $lang;

        $key = preg_replace('/[^0-9a-zA-Z_]/', '', "req_" . $request->getPathInfo() . '_' . json_encode($request->all()));

        if (!$cache || !Cache::store('file')->get("{$key}")) {
            $response = $next($request);

            if ($cache) {
                // Armazena o resultado da requisição por 1 hora
                // para não precisar repetir consulta no BD
                //error_log("*** Armazena em cache ({$key}) ***");
                Cache::store('file')->put("{$key}", $response, 60 * 60 * 1);
            }

            return $response;
        } else {
            //error_log("*** Obter do cache ({$key}) ***");
            return Cache::store('file')->get("{$key}");
        }
    }
}
