<?php

namespace App\Session\Admin;

class Login
{
    private static function init()
    {
        //verifica se a sessao nao esta ativa
        if(session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    /**
     * METODO RESPONSAVEL POR CRIAR O LOGIN DO USUARIO
     * @param User $obUser
     * @return bolean
     */
    public static function login($obUser): bool
    {
        self::init();

        //cria e define a sessão do usuário
        $_SESSION['admin']['usuario'] = [
            'id'    => $obUser->id,
            'nome'  => $obUser->nome,
            'email' => $obUser->email
        ];
        //sucesso
        return true;
    }

    public static function isLogged()
    {
        self::init();

        return isset($_SESSION['admin']['usuario']['id']);
    }


    public static function logout(): bool
    {
        self::init();

        unset($_SESSION['admin']['usuario']);

        return true;
    }


}
