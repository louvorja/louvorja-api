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
        $port = $request->getPort();

        $host_parts = explode(".", $host);
        $subdomain = $host_parts[0];
        if ($subdomain === 'www') {
            array_shift($host_parts);
            $subdomain = $host_parts[0];
        }

        // Verifica a requisição da url
        if ($subdomain !== 'api' && $subdomain !== 'localhost') {
            $locale = 'pt'; // Idioma padrão

            // Verifica se a URL contém um segmento de idioma (ex: /es)
            if (preg_match('/^es(\/|$)/', $path)) {
                $locale = 'es';
            }

            // Redireciona para a URL correta na API
            return redirect("https://api.louvorja.com.br/{$locale}/{$subdomain}");
        }

        return $next($request);
    }
}
