<?php

namespace App\Controller\Pages;

use App\Model\Entity\Organization;
use App\Utils\View;

class About extends Page
{
    /**
     * Método responsavel por retornar o conteúdo (view) da nossa Home
     * @return string
     */
    public static function getAbout(): string
    {
        $obOrganization = new Organization();
        $content = View::render('pages/about', [
            'name' => $obOrganization->name,
            'description' => $obOrganization->description,
            'site' => '<a href="'.$obOrganization->site.'" target="blank">Canal WDEV</a>'
        ]);

        //RETORNA A VIEW DA PÁGINA
        return self::getPage('SOBRE > CANAL WDEV', $content);
    }

}
