<?php

namespace app\model;

use app\classes\Livro;
use app\model\DAO;

class LivroDAO
{

    public function getLivros()
    {
        $conn = new DAO();
        $stmt = $conn->con->prepare("SELECT * FROM tbl_livro");
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $arrayLivros = null;
        if ( $stmt->rowCount() > 0 ) {
            $arrayLivros = array();
            foreach ($result as $row) {
                $livroTemp = new Livro( $row );
                array_push($arrayLivros, $livroTemp->getLivro());
            }            
        }

        //print_r($arrayLivros);
        return $arrayLivros;
    }

    public function getLivro( $idLivro )
    {
        $connDB = new DAO();
        $stmt = $connDB->con->prepare("SELECT * FROM tbl_livro where id_livro = :ID");
        $stmt->bindParam(":ID", $idLivro);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $arrayLivros = null;
        if ( $stmt->rowCount() > 0 ) {
            $arrayLivros = array();
            $livroTemp = new Livro( $result[0] );
            array_push($arrayLivros, $livroTemp->getLivro());
        };

        return $arrayLivros;
    }

    public function cadastraLivro ( Livro $livro )
    {
        $conn = new DAO();
        $stmt = $conn->con->prepare("INSERT INTO tbl_livro (nome, autor, genero) VALUES (:NOME, :AUTOR, :GENERO)");

        $stmt->bindParam(":NOME", $nome);
        $stmt->bindParam(":AUTOR", $autor);
        $stmt->bindParam(":GENERO", $genero);

        $nome = $livro->getNome();
        $autor = $livro->getAutor();
        $genero = $livro->getGenero();

        $stmt->execute();
    }

    public function deleteLivro( $idLivro ):bool
    {
        $conn = new DAO();
        $stmt = $conn->con->prepare("DELETE FROM tbl_livro where id_Livro = :ID");
        $stmt->bindParam(":ID", $idLivro);

        # TRUE: sucesso
        # FALSE: Não existe registro com tal id_livro
        $stmt->execute();
        return ( $stmt->rowCount() >= 1 );

    }

    public function updateLivro( $idLivro, Livro $livro ):bool
    {
        $conn = new DAO();
        $stmt = $conn->con->prepare("UPDATE tbl_livro SET nome = :NOME, autor = :AUTOR, genero = :GENERO WHERE id_livro = :ID");

        $stmt->bindParam(":NOME", $nome);
        $stmt->bindParam(":AUTOR", $autor);
        $stmt->bindParam(":GENERO", $genero);
        $stmt->bindParam(":ID", $idLivro);

        $nome = $livro->getNome();
        $autor = $livro->getAutor();
        $genero = $livro->getGenero();

        $stmt->execute();
        return ( $stmt->rowCount() >= 1 );        
    }
    
}