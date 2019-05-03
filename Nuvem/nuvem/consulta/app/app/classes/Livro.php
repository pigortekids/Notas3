<?php

namespace app\classes;

class Livro{

    private $id_livro;
    private $nome;
    private $autor;
    private $genero;

    public function __construct($args = null){
        if ( !is_null($args) ) {
            $this->id_livro = (isset($args["id_livro"])) ? $args["id_livro"] : null;
            $this->nome = $args["nome"];
            $this->autor = $args["autor"];
            $this->genero = $args["genero"];
        }
    }

    public function getIdLivro(){
        return $this->id_livro;
    }
    public function setIdLivro($id_livro){
        $this->id_livro = $id_livro;
    }

    public function getNome(){
        return $this->nome;
    }
    public function setNome($nome){
        $this->nome = $nome;
    }

    public function getAutor(){
        return $this->autor;
    }
    public function setAutor($autor){
        $this->autor = $autor;
    }

    public function getGenero(){
        return $this->genero;
    }
    public function setGenero($genero){
        $this->genero = $genero;
    }

    public function getLivro()
    {
        return array( 'id_livro' => $this->id_livro,
                        'nome' => $this->nome,
                        'autor' => $this->autor,
                        'genero' => $this->genero);
    }

}