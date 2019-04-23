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
        session_start();
        $resposta = "NÃO";
		if(isset($_SESSION["id"])){
            $url = "" + $_SESSION["id"]; // COLOCAR AQUI A URL DA CONSULTA
            $resposta = file_get_contents($url);
		}else{
            $_SESSION["id"] = "Nome";
        }
        return $response->write($resposta)->withStatus(201);
    });

});

#erro 404
$c['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        return $response->withStatus(404);
    };
};

$app->run();