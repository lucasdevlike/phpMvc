<?php

namespace App\Controller\Pages;

use App\Model\Entity\Organization;
use App\Utils\View;

class Home extends Page
{
    /**
     * Método responsavel por retornar o conteúdo (view) da nossa Home
     * @return string
     */
    public static function getHome(): string
    {
        $obOrganization = new Organization();

        //VIEW DA HOME
        $content = View::render('pages/home', [
            'name' => $obOrganization->name,
        ]);

        //RETORNA A VIEW DA PÁGINA
        return self::getPage('HOME > Canal WDEV', $content);
    }

}
