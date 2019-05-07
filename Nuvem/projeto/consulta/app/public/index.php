<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \PDO;

class DAO {
	private $nomeServer;
	private $usuario;
	private $senha;
	private $dataBase;
    private $charset;
    public 	$con;

	function __construct() {
		$this->nomeServer = "172.18.0.5";
		$this->usuario = "root";
		$this->senha = "";
        $this->dataBase = "livraria";
        $this->charset = 'utf8mb4';
        $dsn = "mysql:host=$this->nomeServer;dbname=$this->dataBase;charset=$this->charset";

        $this->con = new PDO($dsn, $this->usuario, $this->senha);
	}
}

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

class Controller
{

    //LIVRO
    public function getLivros( Request $request, Response $response, array $args )
    {
        $status = 200;
        try {
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
            
            $corpoResp =  json_encode( $arrayLivros );
            $response = $response->withHeader('Content-type', 'application/json')->write( $corpoResp );
                                    
        } catch ( \PDOException $e ) {
            $status = 500;
            $response->write('Exceção capturada: '.  $e->getMessage(). '\n');
        }
        return $response->withStatus($status);
    }

}

require_once 'config.php';

mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');

$app = new \Slim\App;

$c = $app->getContainer();
unset($c['phpErrorHandler']);

$app->group('/v1',function ( ) {
	$this->get('/livro', function (Request $request, Response $response, array $args) {
        $controlador = new Controller();
        return $controlador->getLivros($request, $response, $args);
    });
	$this->get('/teste', function (Request $request, Response $response, array $args) {
        return $response->write("CONSEGUIU")->withStatus(200);
    });
});

#erro 404
$c['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        return $response->withStatus(404);
    };
};

$app->run();