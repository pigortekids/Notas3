<?php

namespace app\classes;

class Aluguel{

    private $id_cliente;
    private $id_livro;
    private $dia_aluguel;
    private $dia_devolucao;

    public function __construct($args = null){
        if ( !is_null($args) ) {
            $this->id_cliente = $args["id_cliente"];
            $this->id_livro = $args["id_livro"];
            $this->dia_aluguel = $args["dia_aluguel"];
            $this->dia_devolucao = $args["dia_devolucao"];
        }
    }

    public function getIdCliente(){
        return $this->id_cliente;
    }
    public function setIdCliente($id_cliente){
        $this->id_cliente = $id_cliente;
    }

    public function getIdLivro(){
        return $this->id_livro;
    }
    public function setIdLivro($id_livro){
        $this->id_livro = $id_livro;
    }

    public function getDiaAluguel(){
        return $this->dia_aluguel;
    }
    public function setDiaAlguel($dia_aluguel){
        $this->dia_aluguel = $dia_aluguel;
    }

    public function getDiaDevolucao(){
        return $this->dia_devolucao;
    }
    public function setDiaDevolucao($dia_devolucao){
        $this->dia_devolucao = $dia_devolucao;
    }

    public function getAluguel()
    {
        return array( 'id_cliente' => $this->id_cliente,
                        'id_livro' => $this->id_livro,
                        'dia_aluguel' => $this->dia_aluguel,
                        'dia_devolucao' => $this->dia_devolucao);
    }

}