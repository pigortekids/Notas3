<?php

namespace app\model;

use app\classes\Aluguel;
use app\model\DAO;

class AluguelDAO
{
    
    public function getAlugueis ()
    {
        $conn = new DAO();
        $stmt = $conn->con->prepare("SELECT tbl_cliente.nome AS cliente, tbl_livro.nome AS livro, tbl_aluguel.* FROM tbl_aluguel, tbl_cliente, tbl_livro WHERE (tbl_aluguel.id_cliente = tbl_cliente.id_cliente AND tbl_aluguel.id_livro = tbl_livro.id_livro)");
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $arrayAluguel = null;
        if ( $stmt->rowCount() > 0 ) {
            $arrayAluguel = array();
            foreach ($result as $row) {
                $aluguelTemp = new Aluguel( $row );
                $arrayFinal = $aluguelTemp->getAluguel();
                $arrayFinal["cliente"] = $row["cliente"];
                $arrayFinal["livro"] = $row["livro"];
                array_push($arrayAluguel, $arrayFinal);
            }            
        }

        return $arrayAluguel;
    }

    public function getAlugueis_porCliente( $idCliente )
    {
        $conn = new DAO();
        $stmt = $conn->con->prepare("SELECT tbl_cliente.nome AS cliente, tbl_livro.nome AS livro, tbl_aluguel.* FROM tbl_aluguel, tbl_cliente, tbl_livro WHERE (tbl_cliente.id_cliente = :ID AND tbl_aluguel.id_cliente = tbl_cliente.id_cliente AND tbl_aluguel.id_livro = tbl_livro.id_livro)");
        $stmt->bindParam(":ID", $idCliente);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $arrayAluguel = null;
        if ( $stmt->rowCount() > 0 ) {
            $arrayAluguel = array();
            foreach ($result as $row) {
                $aluguelTemp = new Aluguel( $row );
                $arrayFinal = $aluguelTemp->getAluguel();
                $arrayFinal["cliente"] = $row["cliente"];
                $arrayFinal["livro"] = $row["livro"];
                array_push($arrayAluguel, $arrayFinal);
            }            
        }

        return $arrayAluguel;
    }

    public function cadastraAluguel( $id_cliente, $id_livro )
    {
        $conn = new DAO();
        $stmt = $conn->con->prepare("INSERT INTO tbl_aluguel SELECT tbl_cliente.id_cliente, :IDLIVRO, :ALUGUEL, :DEVOLUCAO FROM tbl_cliente WHERE tbl_cliente.id_cliente = :IDCLIENTE");

        $stmt->bindParam(":IDLIVRO", $id_livro);
        $data_aluguel = date("Y-m-d");
        $data_devolucao = date('Y-m-d', strtotime($data_aluguel. ' + 1 week'));
        $stmt->bindParam(":ALUGUEL", $data_aluguel);
        $stmt->bindParam(":DEVOLUCAO", $data_devolucao);
        $stmt->bindParam(":IDCLIENTE", $id_cliente);

        $stmt->execute();
    }

    public function deleteAluguel( $idCliente, $idLivro ):bool
    {
        $conn = new DAO();
        $stmt = $conn->con->prepare("DELETE FROM tbl_aluguel WHERE id_cliente = :IDCLIENTE AND id_livro = :IDLIVRO");
        $stmt->bindParam(":IDCLIENTE", $idCliente);
        $stmt->bindParam(":IDLIVRO", $idLivro);

        $stmt->execute();
        return ( $stmt->rowCount() >= 1 );
    }

    public function updateAluguel( Aluguel $aluguel ):bool
    {
        $conn = new DAO();
        $stmt = $conn->con->prepare("UPDATE tbl_aluguel SET dia_aluguel = :DIAALUGUEL, dia_devolucao = :DIADEVOLUCAO WHERE id_cliente = :IDCLIENTE AND id_livro = :IDLIVRO");

        $stmt->bindParam(":DIAALUGUEL", $dia_aluguel);
        $stmt->bindParam(":DIADEVOLUCAO", $dia_devolucao);
        $stmt->bindParam(":IDCLIENTE", $id_cliente);
        $stmt->bindParam(":IDLIVRO", $id_livro);

        $dia_aluguel = $aluguel->getDiaAluguel();
        $dia_devolucao = $aluguel->getDiaDevolucao();
        $id_cliente = $aluguel->getIdCliente();
        $id_livro = $aluguel->getIdLivro();

        $stmt->execute();
        return ( $stmt->rowCount() >= 1 );        
    }

}