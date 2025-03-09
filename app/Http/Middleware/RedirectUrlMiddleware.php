<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectUrlMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $host = $request->getHost();
        $path = $request->path();

        // Verifica se a requisição veio de download.louvorja.com.br
        if ($host === 'download.louvorja.com.br') {
            $locale = 'pt'; // Idioma padrão

            // Verifica se a URL contém um segmento de idioma (ex: /es)
            if (preg_match('/^es(\/|$)/', $path)) {
                $locale = 'es';
            }

            // Redireciona para a URL correta na API
            return redirect("https://api.louvorja.com.br/{$locale}/download");
        }

        return $next($request);
    }
}
