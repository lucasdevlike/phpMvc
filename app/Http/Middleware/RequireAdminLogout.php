<?php

namespace App\Http\Middleware;

use App\Session\Admin\Login as SessionAdminLogin;

class RequireAdminLogout
{
    public function handle($request, $next)
    {
        //VERIFICA SE O USUARIO ESTA LOGADO
        if(SessionAdminLogin::isLogged()) {
            $request->getRouter()->redirect('/admin');
        }

        //Continua a execução
        return $next($request);
    }

}
