<?php

namespace App\Http\Middleware;

use Exception;

class Maintenance
{
    public function handle($request, $next)
    {
        //VERIFICA O STATUS DE MANUTEÇÃO DA PÁGINA
        if(getenv('MAINTENANCE') == 'true') {
            throw new Exception("Página em manutenção, tente novamente mais tarde", 200);

        }

        //EXECUTA O PRÓXIMO NIVEL DO MIDDLEWARE
        return $next($request);
    }
}
