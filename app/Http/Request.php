<?php

namespace App\Http;

class Request
{
    //MÉTODO HTTP DA REQUISIÇÃO
    private $httpMethod;

    private $uri;

    //PARANETROS DA URL ($_GET)
    private $queryParams = [];

    //VARIAVEIS RECEBIDAS DO POST DA PÁGINA
    private $postVars = [];

    //CABEÇALHO DA PÁGINA
    private $headers = [];

    public function __construct()
    {
        $this->queryParams = $_GET ?? [];
        $this->postVars    = $_POST ?? [];
        $this->headers     = getallheaders();
        $this->httpMethod  = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->uri         = $_SERVER['REQUEST_URI'] ?? '';
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
