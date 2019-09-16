<?php

namespace app\model;

use app\classes\Cliente;
use app\model\DAO;

class ClienteDAO
{

    public function getClientes ()
    {
        $conn = new DAO();
        $stmt = $conn->con->prepare("SELECT * FROM tbl_cliente");
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $arrayCliente = null;
        if ( $stmt->rowCount() > 0 ) {
            $arrayCliente = array();
            foreach ($result as $row) {
                $clienteTemp = new Cliente( $row );
                array_push($arrayCliente, $clienteTemp->getCliente());
            }            
        }

        return $arrayCliente;
    }
    
    public function getCliente( $idCliente )
    {
        $connDB = new DAO();
        $stmt = $connDB->con->prepare("SELECT * FROM tbl_cliente where id_cliente = :ID");
        $stmt->bindParam(":ID", $idCliente);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $arrayCliente = null;
        if ( $stmt->rowCount() > 0 ) {
            $arrayCliente = array();
            $clienteTemp = new Cliente( $result[0] );
            array_push($arrayCliente, $clienteTemp->getCliente());
        };

        return $arrayCliente;
    }
    
    public function createCliente( Cliente $cliente )
    {
        # Pode lançar erro
        $connDB = new DAO();
        $stmt = $connDB->con->prepare("INSERT INTO tbl_cliente (nome, idade, cpf) VALUES (:NOME, :IDADE, :CPF)");

        $stmt->bindParam(":NOME", $nome);
        $stmt->bindParam(":IDADE", $idade);
        $stmt->bindParam(":CPF", $cpf);

        $nome = $cliente->getNome();
        $idade = $cliente->getIdade();
        $cpf = $cliente->getCPF();
        $stmt->execute();
    }

    public function deleteCliente( $idCliente ):bool
    {
        $conn = new DAO();
        $stmt = $conn->con->prepare("DELETE FROM tbl_cliente where id_cliente = :ID");
        $stmt->bindParam(":ID", $idCliente);

        $stmt->execute();
        return ( $stmt->rowCount() >= 1 );
    }

    public function updateCliente( $idCliente, Cliente $cliente ):bool
    {
        $conn = new DAO();
        $stmt = $conn->con->prepare("UPDATE tbl_cliente SET nome = :NOME, idade = :IDADE, cpf = :CPF WHERE id_cliente = :ID");

        $stmt->bindParam(":NOME", $nome);
        $stmt->bindParam(":IDADE", $idade);
        $stmt->bindParam(":CPF", $cpf);
        $stmt->bindParam(":ID", $idCliente);

        $nome = $cliente->getNome();
        $idade = $cliente->getIdade();
        $cpf = $cliente->getCPF();

        $stmt->execute();
        return ( $stmt->rowCount() >= 1 );        
    }

}