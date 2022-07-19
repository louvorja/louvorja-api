<?php

namespace App\Http\Middleware;

use Closure;
use Cache;
use App\Models\Language;

class LanguageMiddleware
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
        list($lang) = explode("/",$request->path());

        if (Cache::store('file')->get("lang_{$lang}") != true){
            error_log("*** Verifica parâmetro {lang = $lang} ***");
            if (!Language::find($lang)){
                return response()->json(['error'=>"Idioma '$lang' não encontrado."],401);
            }
        }

        // Armazena a verificação em cache, por 24 horas
        // para não precisar repetir consulta no BD
        Cache::store('file')->put("lang_{$lang}", true, 60 * 60 * 24);

        return $next($request);
    }
}
