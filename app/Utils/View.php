<?php

namespace App\Utils;

class View
{
    private static $vars = [];

    /**
     * MÉTODO RESPONSÁVEL POR DEFINIR OS DADOS INICIAIS DA CLASSE
     * @param array $vars
     */
    public static function init(array $vars = [])
    {
        self::$vars = $vars;
    }

    /**
    * Método responsavel por retornar o conteúdo de uma view
    * @param string view
    * @return string
    */
    private static function getContentView(string $view): string
    {

        $file = __DIR__.'/../../resources/view/'.$view.'.html';
        return file_exists($file) ? file_get_contents($file) : '';

    }

    /**
     * Método responsavel por retornar o conteúdo renderizado de uma view
     * @param string $view
     * @param array $vars (strings/numerics)
     * @return string
     */
    public static function render(string $view, array $vars = []): string
    {

        //Conteudo da view
        $contentView = self::getContentView($view);

        //UNIR AS VARIAVEIS DA VIEW
        $vars = array_merge(self::$vars, $vars);

        //CHAVES DO ARRAY DE VARIAVEIS
        $keys = array_keys($vars);
        $keys = array_map(function ($item) {
            return '{{'.$item.'}}';
        }, $keys);

        //retorna o conteudo renderizado
        return str_replace($keys, array_values($vars), $contentView);

    }

}
