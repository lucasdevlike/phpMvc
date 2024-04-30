<?php

namespace App\Http;

class Request
{
    //INSTÂNCIA DO ROUTER
    private $router;

    //MÉTODO HTTP DA REQUISIÇÃO
    private $httpMethod;

    private $uri;

    //PARANETROS DA URL ($_GET)
    private $queryParams = [];

    //VARIAVEIS RECEBIDAS DO POST DA PÁGINA
    private $postVars = [];

    //CABEÇALHO DA PÁGINA
    private $headers = [];

    public function __construct($router)
    {
        $this->router      = $router;
        $this->queryParams = $_GET ?? [];
        $this->postVars    = $_POST ?? [];
        $this->headers     = getallheaders();
        $this->httpMethod  = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->setUri();
    }

    /**
     * METEODO RESPONSAVEL POR DEFINIR A URI
     *
    */
    private function setUri()
    {
        //URI COMPLETA COM GETS
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';

        //REMOVE OS GETS DA URI
        $xUri = explode('?', $this->uri);

        $this->uri = $xUri[0];
    }

    /**
     * MÉTODO RESPONSÁVEL POR RETORNAR A INSTÂNCIA DE ROUTER
     * @return Router
     */
    public function getRouter(): Router
    {
        return $this->router;
    }

    /**
     * MÉTODO RESPONSÁVEL POR RETORNAR O MÉTODO HTTP
     * @return string
     */
    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    /**
     * MÉTODO RESPONSÁVEL POR RETORNAR A URI DA REQUISIÇÃO
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * MÉTODO RESPONSÁVEL POR RETORNAR Os HEADERS HTTP
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * MÉTODO RESPONSÁVEL POR RETORNAR OS PARAMETROS DA URL
     * @return array
     */
    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    /**
     * MÉTODO RESPONSÁVEL POR RETORNAR AS VARIÁVEIS POST DA REQUISIÇÃO
     * @return array
     */
    public function getPostVars(): array
    {
        return $this->postVars;
    }

}
