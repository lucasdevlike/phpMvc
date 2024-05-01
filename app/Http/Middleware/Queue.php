<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Http\Request;
use App\Http\Response;

class Queue
{
    private static $map = [];

    //MAPEAMENTO DE MIDDLEWARES QUE SERAO CARREGADOS EM TODAS AS ROTAS
    private static $default = [];


    //FILA DE MIDDLEWARES A SEREM EXECUTADAS
    private array $middlewares = [];

    //FUNÇÃO DE EXECUÇÃO DO CONTROLADOR
    private $controller;

    //ARGUMENTOS DA FUNÇÃO DO CONTROLADOR
    private array $controllerArgs = [];

    public function __construct(array $middlewares, Closure $controller, array $controllerArgs)
    {
        $this->middlewares = array_merge(self::$default, $middlewares);
        $this->controller = $controller;
        $this->controllerArgs = $controllerArgs;
    }

    /**
     * MÉTODO RESPONSÁVEL POR DEFINIR O MAPEAMENTO DE MIDDLEWARES
     * @param array $map
     */
    public static function setMap($map)
    {
        self::$map = $map;
    }

    /**
     * MÉTODO RESPONSÁVEL POR DEFINIR O MAPEAMENTO DE MIDDLEWARES PADROES
     * @param array $map
     */
    public static function setDefault($default)
    {
        self::$default = $default;
    }

    public function next(Request $request)
    {
        //VERIFICA SE A FILA ESTA VAZIA
        if(empty($this->middlewares)) {
            return call_user_func_array($this->controller, $this->controllerArgs);
        }

        //MIDDLEWARE
        $middleware = array_shift($this->middlewares);

        //VERIFICA O MAPEAMENTO
        if(!isset(self::$map[$middleware])) {
            throw new Exception("Problemas ao processar o middleware da requisição", 500);
        }

        //NEXT
        $queue = $this;
        $next = function ($request) use ($queue) {
            return $queue->next($request);
        };
        //EXECUTA O MIDDLEWARE
        return (new self::$map[$middleware]())->handle($request, $next);
    }
}
