<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use app\controller\Controller;

require_once 'config.php';

mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');

$app = new \Slim\App;

#tira o tratamento de exceção automatico do Slim
$c = $app->getContainer();
unset($c['phpErrorHandler']);

$app->group('/v1',function ( ) {

    //LIVRO
    $this->get('/livro', function (Request $request, Response $response, array $args) {
        $controlador = new Controller();
        return $controlador->getLivros($request, $response, $args);
    });

    $this->get('/livro/{idLivro}', function (Request $request, Response $response, array $args) {
        $controlador = new Controller();
        return $controlador->getLivro($request, $response, $args);
    });

    $this->post('/livro', function (Request $request, Response $response, array $args) {
        $controlador = new Controller();
        return $controlador->cadastraLivro($request, $response, $args);
    });

    $this->delete('/livro/{idLivro}', function (Request $request, Response $response, array $args) {
        $controlador = new Controller();
        return $controlador->deletaLivro($request, $response, $args);
    });

    $this->put('/livro/{idLivro}', function (Request $request, Response $response, array $args) {
        $controlador = new Controller();
        return $controlador->updateLivro($request, $response, $args);
    });




    //CLIENTE
    $this->get('/cliente', function (Request $request, Response $response, array $args) {
        $controlador = new Controller();
        return $controlador->getClientes($request, $response, $args);
    });

    $this->get('/cliente/{idCliente}', function (Request $request, Response $response, array $args) {
        $controlador = new Controller();
        return $controlador->getCliente($request, $response, $args);
    });

    $this->post('/cliente', function (Request $request, Response $response, array $args) {
        $controlador = new Controller();
        return $controlador->cadastraCliente($request, $response, $args);
    });

    $this->delete('/cliente/{idCliente}', function (Request $request, Response $response, array $args) {
        $controlador = new Controller();
        return $controlador->deletaCliente($request, $response, $args);
    });

    $this->put('/cliente/{idCliente}', function (Request $request, Response $response, array $args) {
        $controlador = new Controller();
        return $controlador->updateCliente($request, $response, $args);
    });




    //ALUGUEL
    $this->get('/aluguel', function (Request $request, Response $response, array $args) {
        $controlador = new Controller();
        return $controlador->getAlugueis($request, $response, $args);
    });

    $this->get('/aluguel/{idCliente}', function (Request $request, Response $response, array $args) {
        $controlador = new Controller();
        return $controlador->getAlugueis_porCliente($request, $response, $args);
    });

    $this->post('/aluguel', function (Request $request, Response $response, array $args) {
        $controlador = new Controller();
        return $controlador->cadastraAluguel($request, $response, $args);
    });

    $this->delete('/aluguel', function (Request $request, Response $response, array $args) {
        $controlador = new Controller();
        return $controlador->deletaAluguel($request, $response, $args);
    });

    $this->put('/aluguel', function (Request $request, Response $response, array $args) {
        $controlador = new Controller();
        return $controlador->updateAluguel($request, $response, $args);
    });

});

#erro 404
$c['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        return $response->withStatus(404);
    };
};

$app->run();