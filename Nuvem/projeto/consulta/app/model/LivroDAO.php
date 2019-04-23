<?php

namespace app\model;

use app\classes\Livro;
use app\model\DAO;

class LivroDAO
{

    public function getLivros( $sessao )
    {
        $conn = new DAO();
        $stmt = $connDB->con->prepare("SELECT * FROM tbl_livro WHERE sessao = :SESSSAO");
        $stmt->bindParam(":SESSSAO", $sessao);
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

        return $arrayLivros;
    }
    
}