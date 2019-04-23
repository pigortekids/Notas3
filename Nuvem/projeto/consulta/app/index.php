<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use controller\Controller;

require_once 'config.php';

mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');

$app = new \Slim\App;

#tira o tratamento de exceção automatico do Slim
$c = $app->getContainer();
unset($c['phpErrorHandler']);

$app->group('/v1',function ( ) {

    //LIVRO
    $this->get('/livro/{sessao}', function (Request $request, Response $response, array $args) {
        $controlador = new Controller();
        return $controlador->getLivros($request, $response, $args);
    });

});

#erro 404
$c['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        return $response->withStatus(404);
    };
};

$app->run();