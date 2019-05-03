<?php

use \PDO;

class DAO {
	private $nomeServer;
	private $usuario;
	private $senha;
	private $dataBase;
    private $charset;
    public 	$con;

	function __construct() {
		$this->nomeServer = "172.18.0.3";
		$this->usuario = "root";
		$this->senha = "";
        $this->dataBase = "livraria";
        $this->charset = 'utf8mb4';
        $dsn = "mysql:host=$this->nomeServer;dbname=$this->dataBase;charset=$this->charset";

        $this->con = new PDO($dsn, $this->usuario, $this->senha);
	}
}

//$conn = new DAO();

echo "DEU CERTO";