<?php

namespace app\classes;

class Cliente{

    private $id_cliente;
    private $nome;
    private $idade;
    private $cpf;

    public function __construct( $args = null ){
        if ( !is_null($args) ) {
            $this->id_cliente = (isset($args["id_cliente"])) ? $args["id_cliente"] : null ;
            $this->nome = $args["nome"];
            $this->idade = $args["idade"];
            $this->cpf = $args["cpf"];
        }
    }

    public function getID(){
        return $this->id_cliente;
    }
    public function setID($id_cliente){
        $this->id_cliente = $id_cliente;
    }

    public function getNome(){
        return $this->nome;
    }
    public function setNome($nome){
        $this->nome = $nome;
    }

    public function getIdade(){
        return $this->idade;
    }
    public function setIdade($idade){
        $this->idade = $idade;
    }

    public function getCPF(){
        return $this->cpf;
    }
    public function setCPF($cpf){
        $this->cpf = $cpf;
    }

    public function getCliente()
    {
        return array( 'id_cliente' => $this->id_cliente,
                        'nome' => $this->nome,
                        'idade' => $this->idade,
                        'cpf' => $this->cpf);
    }

}