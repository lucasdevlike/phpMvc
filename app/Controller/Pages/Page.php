<?php

namespace App\Controller\Pages;

use App\Http\Request;
use App\Utils\View;
use WilliamCosta\DatabaseManager\Pagination;

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
     * MÉTODO RESPONSÁVEL POR RENDERIZAR O LAYOUT DE PAGINAÇÃO
     * @param Request $request
     * @param Pagination $pobPagination
     * @return string
     */
    public static function getPagination(Request $request, Pagination $obPagination): string
    {
        //PAGINAS
        $pages = $obPagination->getPages();

        //VERIFICA A QUANTIDADE DE PAGINAS
        if(count($pages) <= 1) {
            return '';
        }

        //LINKS
        $links = '';

        //URL ATUAL
        $url = $request->getRouter()->getCurrentUrl();

        //GET
        $queryParams = $request->getQueryParams();

        //RENDERIZA OS LINKS
        foreach($pages as $page) {
            //ALTERA A PAGINA
            $queryParams['page'] = $page['page'];

            //LINK DA PAGINA
            $link = $url . '?' . http_build_query($queryParams);

            //VIEW RENDERIZADA
            $links .= View::render('pages/pagination/link', [
                'page' => $page['page'],
                'link' => $link,
                'active' => $page['current'] ? 'active' : ''
            ]);
        }
        return View::render('pages/pagination/box', [
            'links' => $links
        ]);
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
