<?php

namespace App\Controller\Admin;

use App\Utils\View;
use App\Model\Entity\User;
use App\Session\Admin\Login as SessionAdminLogin;

class Login extends Page
{
    /**
     * METODO RESPONSAVEL POR RETORNAR A RENDERIZAÇÃO DA PÁGINA DE LOGIN
     * @param Request $request
     * @return string
     */
    public static function getLogin($request, $errorMessage = null)
    {

        //STATUS
        $status = !is_null($errorMessage) ? View::render('admin/login/status', [
            'mensagem' => $errorMessage
        ]) : $errorMessage;

        //CONTEUDO DA PAGINA DE LOGIN
        $content = View::render('admin/login', [
            'status' => $status
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPage('Login > WDEV', $content);
    }

    //METODO RESPONSAVEL POR DEFINIR O LOGIN DO USUARIO
    public static function setLogin($request)
    {
        //POST VARS
        $postVars = $request->getPostVars();
        $email = $postVars['email'] ?? '';
        $senha = $postVars['senha'] ?? '';

        //BUSCA O USUARIO PELO EMAIL
        $obUser = User::getUserByEmail($email);

        if(!$obUser instanceof User) {
            return self::getLogin($request, 'E-mail ou senha inválidos');
        }

        //VERIFICA A SENHA DO USUARIO
        if(!password_verify($senha, $obUser->senha)) {
            return self::getLogin($request, 'E-mail ou senha inválidos');
        }

        //CRIA A SESSAO DE LOGIN
        SessionAdminLogin::login($obUser);

        //REDIRECIONA O USUÁRIO PARA A HOME DO ADMIN
        $request->getRouter()->redirect('/admin');

    }

    public static function setLogout($request)
    {
        //DESTROI A SESSAO DE LOGIN
        SessionAdminLogin::logout();

        //REDIRECIONA O USUÁRIO PARA A tela DO LOGIN
        $request->getRouter()->redirect('/admin/login');
    }

}
