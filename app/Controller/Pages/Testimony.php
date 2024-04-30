<?php

namespace App\Controller\Pages;

use App\Http\Request;
use App\Model\Entity\Organization;
use App\Utils\View;
use App\Model\Entity\Testimony as EntityTestimony;
use WilliamCosta\DatabaseManager\Pagination;

class Testimony extends Page
{
    /**
     * MÉTODO RESPONSAVEL POR OBTER A RENDERIZAÇÃO DOS ITENS DE DEPOIMENTO PARA A PÁGINA
     * @param Request $request
     * @param Pagination $obPagination
     * @return string
     */
    private static function getTestimonyItems($request, &$obPagination): string
    {
        //DEPOIMENTOS
        $itens = '';

        //QUANTIDADE TOTAL DE REGISTROS
        $quantidadetotal = EntityTestimony::getTestimonies(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        //PÁGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        //INSTÂNCIA DE PAGINAÇÃO
        $obPagination = new Pagination($quantidadetotal, $paginaAtual, 4);

        //RESULTADOS DA PÁGINA
        $results = EntityTestimony::getTestimonies(null, 'id DESC', $obPagination->getLimit());

        //RENDERIZA O ITEM
        while($obTestimony = $results->fetchObject(EntityTestimony::class)) {
            $itens .= View::render('pages/testimony/item', [
               'nome'     => $obTestimony->nome,
               'mensagem' => $obTestimony->mensagem,
               'data'     => date('d/m/Y H:i:s', strtotime($obTestimony->data))
            ]);
        }

        //RETORNA OS DEPOIMENTOS
        return $itens;
    }

    /**
     * Método responsavel por retornar o conteúdo (view) da nossa Home
     * @return string
     */
    public static function getTestimonies($request): string
    {
        //VIEW DDE DEPOIMENTOS
        $content = View::render('pages/testimonies', [
            'itens' => self::getTestimonyItems($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination)
        ]);

        //RETORNA A VIEW DA PÁGINA
        return self::getPage('HOME > Canal WDEV', $content);
    }

    public static function insertTestimony(Request $request): string
    {
        //DADOS DO POST
        $postVars = $request->getPostVars();

        //NOVA INSTÂNCIA DE DEPOIMENTO
        $obTestimony = new EntityTestimony();
        $obTestimony->nome = $postVars['nome'];
        $obTestimony->mensagem = $postVars['mensagem'];
        $obTestimony->cadastrar();

        return self::getTestimonies($request);
    }

}
