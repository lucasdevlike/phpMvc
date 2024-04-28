<?php

namespace App\Http;

class Response
{
    /**
     * CÓDIGO DO STATUS HTTP
     */
    private $httpCode = '200';

    /**
     * CABEÇALHO DO RESPONSE
     */
    private $headers = [];

    /**
     * TIPO DE CONTEÚDO QUE ESTÁ SENDO RETORNADO
     */
    private $contentType = 'text/html';

    /**
     * CONTEÚDO DO RESPONSE
     */
    private $content;

    public function __construct(int $httpCode, mixed $content, string $contentType = 'text/html')
    {
        $this->httpCode = $httpCode;
        $this->content  = $content;
        $this->setContentType($contentType);
    }

    public function setContentType(string $contentType)
    {
        $this->contentType = $contentType;
        $this->addHeader('Content-Type', $contentType);
    }

    /**
     * MÉTODO RESPONSÁVEL POR ADICIONAR UM REGISTRO NO CABEÇALHO DE RESPONSE
     * @param string $key
     * @param string $value
     */
    public function addHeader(string $key, string $value)
    {
        $this->headers[$key] = $value;
    }

    private function sendHeaders()
    {
        //STATUS
        http_response_code($this->httpCode);

        //ENVIA OS HEADERS
        foreach($this->headers as $key => $value) {
            header($key.': '.$value);
        }
    }

    /**
     * MÉTODO RESPONSAVEL POR ENVIAR A RESPOSTA PARA O USUARIO
     */
    public function sendResponse()
    {
        //ENVIA OS HEADERS
        $this->sendHeaders();

        //IMPRIME O CONTEÚDO
        switch ($this->contentType) {
            case 'text/html':
                echo $this->content;
                exit;
        }
    }


}
