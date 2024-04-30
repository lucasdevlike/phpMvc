<?php

require 'includes/app.php';

use App\Http\Router;

$obRouter = new Router(URL);

//INCLUI AS RODAS DE PÁGINAS
include __DIR__.'/routes/pages.php';

// IMPRIME O RESPONSE DA ROTA
$obRouter->run()->sendResponse();
