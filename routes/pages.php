<?php

use App\Http\Response;
use App\Controller\Pages;

//ROTA DA HOME
$obRouter->get('/', [
    function () {
        return new Response(200, Pages\Home::getHome());
    }
]);
//  ROTA DO SOBRE
$obRouter->get('/sobre', [
    function () {
        return new Response(200, Pages\About::getAbout());
    }
]);

//  ROTA DINÂMICA
$obRouter->get('/pagina/{idPagina}/{acao}', [
    function ($idPagina, $acao) {
        return new Response(200, 'Página '.$idPagina.' - '.$acao);
    }
]);
