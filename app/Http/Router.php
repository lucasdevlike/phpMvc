<?php

namespace App\Http;

use Closure;
use Exception;
use ReflectionFunction;

class Router
{
    private string $url = '';
    private string $prefix = '';
    private array $routes = [];
    private Request $request;

    public function __construct(string $url)
    {
        $this->request = new Request($this);
        $this->url = $url;
        $this->setPrefix();
    }

    private function setPrefix()
    {
        //INFORMAÇÕES DA URL ATUAL
        $parseUrl = parse_url($this->url);

        //DEFINE O PREFIXO
        $this->prefix = $parseUrl['path'] ?? '';
    }

    //METODO RESPONSAVEL POR ADICIONAR UMA ROTA NA CLASSE
    private function addRoute(string $method, string $route, array $params = [])
    {
        //VALIDAÇÃO DOS PARAMETROSD
        foreach($params as $key => $value) {
            if($value instanceof Closure) {
                $params['controller'] = $value;
                unset($params[$key]);
                continue;
            }
        }

        //VARIAVEIS DA ROTA
        $params['variables'] = [];

        //PADRÃO DE VALIDAÇÃO DAS VARIAVEIS DAS ROTAS
        $patternVariable = '/{(.*?)}/';

        if(preg_match_all($patternVariable, $route, $matches)) {
            $route = preg_replace($patternVariable, '(.*?)', $route);
            $params['variables'] = $matches[1];
        }

        //PADRÃO DE VALIDAÇÃO DA URL
        $patternRoute = '/^'.str_replace('/', '\/', $route).'$/';

        //ADICIONA A ROTA DENTRO DA CLASSE
        $this->routes[$patternRoute][$method] = $params;

    }

    /**
     * METODO RESPONSAVEL POR DEFINIR UMA ROTA DE GET
     * @param string $route
     * @param array $params
     */
    public function get(string $route, array $params = [])
    {
        return $this->addRoute('GET', $route, $params);
    }

    /**
     * METODO RESPONSAVEL POR DEFINIR UMA ROTA DE POST
     * @param string $route
     * @param array $params
     */
    public function post(string $route, array $params = [])
    {
        return $this->addRoute('POST', $route, $params);
    }

    /**
     * METODO RESPONSAVEL POR DEFINIR UMA ROTA DE PUT
     * @param string $route
     * @param array $params
     */
    public function put(string $route, array $params = [])
    {
        return $this->addRoute('PUT', $route, $params);
    }

    /**
     * METODO RESPONSAVEL POR DEFINIR UMA ROTA DE DELETE
     * @param string $route
     * @param array $params
     */
    public function delete(string $route, array $params = [])
    {
        return $this->addRoute('DELETE', $route, $params);
    }

    /**
     * MÉTODO RESPONSÁVEL POR RETORNAR A URI DESCONSIDERANDO O PREFIXO
     * @return string
     */
    private function getUri(): string
    {
        $uri = $this->request->getUri();

        //FATIA A URI COM O PREFIXO
        $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];

        //RETORNA A URI SEM O PREFIXO
        return end($xUri);
    }

    /**
     * MÉTODO RESPONSÁVEL POR RETORNAR OS DADOS DA ROTA ATUAL
     * @return array
     */
    private function getRoute(): array
    {
        //URI
        $uri = $this->getUri();
        $httpMethod = $this->request->getHttpMethod();

        //VALIDA AS ROTAS
        foreach ($this->routes as $patternRoute => $methods) {
            //VERIFICA SE A URI BATE COM O PADRÃO
            if(preg_match($patternRoute, $uri, $matches)) {

                //VERIFICA O MÉTODO
                if(isset($methods[$httpMethod])) {
                    //REMOVE A PRIMEIRA POSIÇÃO DO ARRAY POIS ELA MOSTRA COMPLETO
                    unset($matches[0]);

                    //VARIAVEIS PROCESSADAS
                    $keys = $methods[$httpMethod]['variables'];
                    $methods[$httpMethod]['variables'] = array_combine($keys, $matches);

                    $methods[$httpMethod]['variables']['request'] = $this->request;

                    //RETORNA OS PARÂMETROS DA TOYA
                    return$methods[$httpMethod];
                }

                throw new Exception("Método não permitido", 405);

            }
        }
        //URL NÃO ENCONTRADA
        throw new Exception("URL não encontrada", 404);

    }

    /**
     * MÉTODO RESPONSAVEL POR EXECUTAR A ROTA ATUAL
     * @return Response
     */
    public function run(): Response
    {
        try {
            //OBTEM A ROTA ATUAL
            $route = $this->getRoute();


            //VERIFICA O CONTROLADOR
            if(!isset($route['controller'])) {
                throw new Exception("A URL não pode ser processada", 500);
            }

            //ARGUMENTOS DA FUNÇÃO
            $args = [];

            //REFLECTION
            $reflection = new ReflectionFunction($route['controller']);
            foreach($reflection->getParameters() as $parameter) {
                $name = $parameter->getName();
                $args[$name] = $route['variables'][$name] ?? '';
            }


            //RETORNA A FUNÇÃO
            return call_user_func_array($route['controller'], $args);

        } catch (Exception $e) {
            return new Response($e->getCode(), $e->getMessage());
        }
    }

    /**
     * MÉTODO RESPONSÁVEL POR RETORNAR A URL ATUAL
     */
    public function getCurrentUrl(): string
    {
        return $this->url.$this->getUri();
    }

}
