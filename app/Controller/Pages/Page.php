<?php

namespace App\Controller\Pages;

use App\Utils\View;

class Page
{
    /**
     * MÉTODO RESPONSAVEL POR RENDERIZAR O TOPO DA PÁGINA
     * @return string
     */
    private static function getHeader(): string
    {
        return View::render('pages/header');
    }

    /**
     * MÉTODO RESPONSAVEL POR RENDERIZAR O Rodapé DA PÁGINA
     * @return string
     */
    private static function getFooter(): string
    {
        return View::render('pages/footer');
    }

    /**
     * Método responsavel por retornar o conteúdo (view) da nossa Pagina generica
     *
     * @return string
     */
    public static function getPage(string $title, $content): string
    {
        return View::render('pages/page', [
            'title' => $title,
            'header' => self::getHeader(),
            'content' => $content,
            'footer' => self::getFooter()
        ]);
    }

}
