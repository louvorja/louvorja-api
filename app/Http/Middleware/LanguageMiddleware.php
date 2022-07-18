<?php

namespace App\Http\Middleware;

use Closure;
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

        if (!Language::find($lang)){
            return response()->json(['error'=>"Idioma '$lang' não encontrado."],401);
        }

        return $next($request);
    }
}
