<?php

namespace app\controller;


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use app\model\LivroDAO;
use app\classes\Livro;
use app\classes\BadHttpRequest;


class Controller
{

    public function getLivros( Request $request, Response $response, array $args )
    {
        $status = 200;

        try {
            $dao = new LivroDAO();
            $livrosArray = $dao->getLivros();

            $corpoResp =  json_encode( $livrosArray );
            $response = $response->withHeader('Content-type', 'application/json')
                                 ->write( $corpoResp );
        } catch ( \PDOException $e ) {
            $status = 500;
            $response->write('Exceção capturada: '.  $e->getMessage(). '\n');
        }
        return $response->withStatus($status);
    }

}