<?php

namespace app\controller;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use app\model\LivroDAO;
use app\classes\Livro;
use app\model\ClienteDAO;
use app\classes\Cliente;
use app\model\AluguelDAO;
use app\classes\Aluguel;
use app\classes\BadHttpRequest;

class Controller
{

    //LIVRO
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

    public function getLivro ( Request $request, Response $response, array $args )
    {
        $status = 200;

        try {
            if (!( isset( $args["idLivro"]) )) {
                throw new BadHttpRequest();
            }

            $dao = new LivroDAO();
            $livro = $dao->getLivro( $args["idLivro"] );

            $status = ( !is_null( $livro ) ) ? 200 : 204;

            $corpoResp =  json_encode( $livro );
            $response = $response->withHeader('Content-type', 'application/json')
                                 ->write( $corpoResp );
        } catch (BadHttpRequest $e) {
            $status = 400;
            $response->write('Exceção capturada: '.  $e->getMessage(). '\n');
        } catch ( \PDOException $e ) {
            $status = 500;
            $response->write('Exceção capturada: '.  $e->getMessage(). '\n');
        } 
        return $response->withStatus($status);
    }

    public function cadastraLivro ( Request $request, Response $response, array $args )
    {
        $status = 201;
        try {
            $objEntrada = $request->getParsedBody();

            if (!( isset( $objEntrada["nome"] ) &&
            isset( $objEntrada["autor"] ) &&
            isset( $objEntrada["genero"])))
                throw new BadHttpRequest();

            if ( is_null($objEntrada) )
                throw new BadHttpRequest();

            $arrayLivro = array( "nome"=>$objEntrada["nome"],
                                "autor"=>$objEntrada["autor"],
                                "genero"=>$objEntrada["genero"]);

            $livro = new Livro($arrayLivro);
            $dao = new LivroDAO();
            $dao->cadastraLivro( $livro );
        } catch (BadHttpRequest $e) {
            $status = 400;
            $response->write('Exceção capturada: '.  $e->errorMessage(). '\n');
        } catch (\PDOException $e) {
            $status = 500;
            $response->write('Exceção capturada: '.  $e->getMessage(). '\n');
        }

        return $response->withStatus($status);
    }

    public function deletaLivro ( Request $request, Response $response, array $args )
    {
        $status = 200;

        try {
            if ( isset( $args["idLivro"]) ) {
                if ( !is_numeric( $args["idLivro"] ) )
                    throw new BadHttpRequest();
            } else { 
                throw new BadHttpRequest();
            }

            $dao = new LivroDAO();
            $sucesso = $dao->deleteLivro( $args["idLivro"] );
            $status = ( $sucesso ) ? 200 : 204;
        } catch (BadHttpRequest $e) {
            $status = 400;
            $response->write('Exceção capturada: '.  $e->getMessage(). '\n');
        } catch ( \PDOException $e ) {
            $status = 500;
            $response->write('Exceção capturada: '.  $e->getMessage(). '\n');
        } 
        return $response->withStatus($status);
    }

    public function updateLivro ( Request $request, Response $response, array $args )
    {
        $status = 200;

        try {

            if ( isset( $args["idLivro"]) ) {
                if ( !is_numeric( $args["idLivro"] ) )
                    throw new BadHttpRequest();
            } else { 
                throw new BadHttpRequest();
            }

            $objEntrada = $request->getParsedBody();            

            if ( is_null($objEntrada) )
                throw new BadHttpRequest();

            if (!( isset( $objEntrada["nome"] ) &&
            isset( $objEntrada["autor"] ) &&
            isset( $objEntrada["genero"])))
                throw new BadHttpRequest();

            $arrayLivro = array( "nome"=>$objEntrada["nome"],
                                "autor"=>$objEntrada["autor"],
                                "genero"=>$objEntrada["genero"]);

            $livro = new Livro($arrayLivro);
            $dao = new LivroDAO();
            $sucesso = $dao->updateLivro( $args["idLivro"]  , $livro );
            $status = ( $sucesso ) ? 200 : 204;

        } catch (BadHttpRequest $e) {
            $status = 400;
            $response->write('Exceção capturada: '.  $e->getMessage(). '\n');
        } catch (\PDOException $e) {
            $status = 500;
            $response->write('Exceção capturada: '.  $e->getMessage(). '\n');
        }

        return $response->withStatus($status);
    }




    //CLIENTE
    public function getClientes ( Request $request, Response $response, array $args )
    {
        $status = 200;

        try {
            $dao = new ClienteDAO();
            $clientesArray = $dao->getClientes();

            $corpoResp =  json_encode( $clientesArray );
            $response = $response->withHeader('Content-type', 'application/json')
                                 ->write( $corpoResp );
        } catch ( \PDOException $e ) {
            $status = 500;
            $response->write('Exceção capturada: '.  $e->getMessage(). '\n');
        } 
        return $response->withStatus($status);
    }

    public function getCliente ( Request $request, Response $response, array $args )
    {
        $status = 200;

        try {
            if (!( isset( $args["idCliente"]) )) {
                throw new BadHttpRequest();
            }

            $dao = new ClienteDAO();
            $cliente = $dao->getCliente( $args["idCliente"] );

            $status = ( !is_null( $cliente ) ) ? 200 : 204;

            $corpoResp =  json_encode( $cliente );
            $response = $response->withHeader('Content-type', 'application/json')
                                 ->write( $corpoResp );
        } catch (BadHttpRequest $e) {
            $status = 400;
            $response->write('Exceção capturada: '.  $e->getMessage(). '\n');
        } catch ( \PDOException $e ) {
            $status = 500;
            $response->write('Exceção capturada: '.  $e->getMessage(). '\n');
        } 
        return $response->withStatus($status);
    }

    public function cadastraCliente( Request $request, Response $response, array $args )
    {
        $status = 201;
        try {
            $objEntrada = $request->getParsedBody();

            if (!( isset( $objEntrada["nome"] ) &&
            isset( $objEntrada["idade"] ) &&
            isset( $objEntrada["cpf"])))
                throw new BadHttpRequest();

            if ( is_null($objEntrada) )
                throw new BadHttpRequest();

            $arrayCliente = array( "nome"=>$objEntrada["nome"],
                                "idade"=>$objEntrada["idade"],
                                "cpf"=>$objEntrada["cpf"]);

            $cliente = new Cliente($arrayCliente);
            $dao = new ClienteDAO();
            $dao->createCliente( $cliente );
        } catch (BadHttpRequest $e) {
            $status = 400;
            $response->write('Exceção capturada: '.  $e->errorMessage(). '\n');
        } catch (\PDOException $e) {
            $status = 500;
            $response->write('Exceção capturada: '.  $e->getMessage(). '\n');
        }

        return $response->withStatus($status);
    }

    public function deletaCliente ( Request $request, Response $response, array $args )
    {
        $status = 200;

        try {
            if ( isset( $args["idCliente"]) ) {
                if ( !is_numeric( $args["idCliente"] ) )
                    throw new BadHttpRequest();
            } else { 
                throw new BadHttpRequest();
            }

            $dao = new ClienteDAO();
            $sucesso = $dao->deleteCliente( $args["idCliente"] );
            $status = ( $sucesso ) ? 200 : 204;
        } catch (BadHttpRequest $e) {
            $status = 400;
            $response->write('Exceção capturada: '.  $e->getMessage(). '\n');
        } catch ( \PDOException $e ) {
            $status = 500;
            $response->write('Exceção capturada: '.  $e->getMessage(). '\n');
        } 
        return $response->withStatus($status);
    }

    public function updateCliente ( Request $request, Response $response, array $args )
    {
        $status = 200;

        try {

            if ( isset( $args["idCliente"]) ) {
                if ( !is_numeric( $args["idCliente"] ) )
                    throw new BadHttpRequest();
            } else { 
                throw new BadHttpRequest();
            }

            $objEntrada = $request->getParsedBody();            

            if ( is_null($objEntrada) )
                throw new BadHttpRequest();

            if (!( isset( $objEntrada["nome"] ) &&
            isset( $objEntrada["idade"] ) &&
            isset( $objEntrada["cpf"])))
                throw new BadHttpRequest();

            $arrayCliente = array( "nome"=>$objEntrada["nome"],
                                "idade"=>$objEntrada["idade"],
                                "cpf"=>$objEntrada["cpf"]);

            $cliente = new Cliente($arrayCliente);
            $dao = new ClienteDAO();
            $sucesso = $dao->updateCliente( $args["idCliente"]  , $cliente );
            $status = ( $sucesso ) ? 200 : 204;

        } catch (BadHttpRequest $e) {
            $status = 400;
            $response->write('Exceção capturada: '.  $e->getMessage(). '\n');
        } catch (\PDOException $e) {
            $status = 500;
            $response->write('Exceção capturada: '.  $e->getMessage(). '\n');
        }

        return $response->withStatus($status);
    }




    //ALUGUEL
    public function getAlugueis ( Request $request, Response $response, array $args )
    {
        $status = 200;

        try {
            $dao = new AluguelDAO();
            $alugueisArray = $dao->getAlugueis();

            $corpoResp =  json_encode( $alugueisArray );
            $response = $response->withHeader('Content-type', 'application/json')
                                 ->write( $corpoResp );
        } catch ( \PDOException $e ) {
            $status = 500;
            $response->write('Exceção capturada: '.  $e->getMessage(). '\n');
        } 
        return $response->withStatus($status);
    }

    public function getAlugueis_porCliente( Request $request, Response $response, array $args )
    {
        $status = 200;

        try {
            if (!( isset( $args["idCliente"]) )) {
                throw new BadHttpRequest();
            }

            $dao = new AluguelDAO();
            $alugueisArray = $dao->getAlugueis_porCliente( $args["idCliente"] );

            $corpoResp =  json_encode( $alugueisArray );
            $response = $response->withHeader('Content-type', 'application/json')
                                 ->write( $corpoResp );
        } catch ( \PDOException $e ) {
            $status = 500;
            $response->write('Exceção capturada: '.  $e->getMessage(). '\n');
        } 
        return $response->withStatus($status);
    }

    public function cadastraAluguel( Request $request, Response $response, array $args )
    {
        $status = 201;
        try {
            $objEntrada = $request->getParsedBody();

            if (!( isset( $objEntrada["id_livro"] ) &&
            isset( $objEntrada["id_cliente"]))){
                throw new BadHttpRequest();
            }

            if ( is_null($objEntrada) ){
                throw new BadHttpRequest();
            }

            $dao = new AluguelDAO();
            $dao->cadastraAluguel( $objEntrada["id_cliente"], $objEntrada["id_livro"] );
        } catch (BadHttpRequest $e) {
            $status = 400;
            $response->write('Exceção capturada: '.  $e->errorMessage(). '\n');
        } catch (\PDOException $e) {
            $status = 500;
            $response->write('Exceção capturada: '.  $e->getMessage(). '\n');
        }

        return $response->withStatus($status);
    }

    public function deletaAluguel ( Request $request, Response $response, array $args )
    {
        $status = 200;

        try {
            $objEntrada = $request->getParsedBody();

            if ( isset( $objEntrada["id_cliente"]) ) {
                if ( !is_numeric( $objEntrada["id_cliente"] ) ) {
                    if ( isset( $objEntrada["id_livro"]) ) {
                        if ( !is_numeric( $objEntrada["id_livro"] ) )
                            throw new BadHttpRequest();
                    }
                }
            } else { 
                throw new BadHttpRequest();
            }

            $dao = new AluguelDAO();
            $sucesso = $dao->deleteAluguel( $objEntrada["id_cliente"], $objEntrada["id_livro"] );
            $status = ( $sucesso ) ? 200 : 204;
        } catch (BadHttpRequest $e) {
            $status = 400;
            $response->write('Exceção capturada: '.  $e->getMessage(). '\n');
        } catch ( \PDOException $e ) {
            $status = 500;
            $response->write('Exceção capturada: '.  $e->getMessage(). '\n');
        } 
        return $response->withStatus($status);
    }

    public function updateAluguel ( Request $request, Response $response, array $args )
    {
        $status = 200;

        try {

            $objEntrada = $request->getParsedBody();            

            if ( is_null($objEntrada) )
                throw new BadHttpRequest();

            if (!( isset( $objEntrada["id_cliente"] ) &&
            isset( $objEntrada["id_livro"] ) &&
            isset( $objEntrada["dia_aluguel"] ) &&
            isset( $objEntrada["dia_devolucao"])))
                throw new BadHttpRequest();

            $arrayAluguel = array( "id_cliente"=>$objEntrada["id_cliente"],
                                "id_livro"=>$objEntrada["id_livro"],
                                "dia_aluguel"=>$objEntrada["dia_aluguel"],
                                "dia_devolucao"=>$objEntrada["dia_devolucao"]);

            $aluguel = new Aluguel($arrayAluguel);
            $dao = new AluguelDAO();
            $sucesso = $dao->updateAluguel( $aluguel );
            $status = ( $sucesso ) ? 200 : 204;

        } catch (BadHttpRequest $e) {
            $status = 400;
            $response->write('Exceção capturada: '.  $e->getMessage(). '\n');
        } catch (\PDOException $e) {
            $status = 500;
            $response->write('Exceção capturada: '.  $e->getMessage(). '\n');
        }

        return $response->withStatus($status);
    }

}