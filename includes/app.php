<?php

require __DIR__.'/../vendor/autoload.php';

use App\Utils\View;
use WilliamCosta\DatabaseManager\Database;
use WilliamCosta\DotEnv\Environment;
use App\Http\Middleware\Queue as MiddlewareQueue;

//CARREGA O ARQUIVO .ENV COM AS VARIAVEIS DE AMBIENTE
Environment::load(__DIR__.'/../');

//DEFINE AS CONFIGURAÇÕES DE BANCO DE DADOS
Database::config(
    getenv('DB_HOST'),
    getenv('DB_NAME'),
    getenv('DB_USER'),
    getenv('DB_PASS'),
    getenv('DB_PORT')
);

define('URL', getenv('URL'));

//DEFINE O VALOR PADRÃO DAS VARIAVEIS
View::init([
    'URL' => URL
]);

//DEFINE O MAPEAMENTO DE MIDDLEWARES
MiddlewareQueue::setMap([
    'maintenance' => \App\Http\Middleware\Maintenance::class
]);


//DEFINE O MAPEAMENTO DE MIDDLEWARES PADRÕES (PARA TODO O SITE)
MiddlewareQueue::setDefault([
    'maintenance'
]);
