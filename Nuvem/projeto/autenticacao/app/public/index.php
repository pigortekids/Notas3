<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once 'config.php';

mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');

$app = new \Slim\App;

#tira o tratamento de exceção automatico do Slim
$c = $app->getContainer();
unset($c['phpErrorHandler']);

$app->group('/v1',function ( ) {
	$this->get('/livro', function (Request $request, Response $response, array $args) {
		$url = 'http://172.18.0.2/public/index.php/v1/livro';
		$contents = file_get_contents($url);
		if($contents !== false){
			return $response->write($contents)->withStatus(200);
		}else{
			return $response->write("PROBLEMA")->withStatus(404);
		}
    });
});

#erro 404
$c['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        return $response->withStatus(404);
    };
};

$app->run();