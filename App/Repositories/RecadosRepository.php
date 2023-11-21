<?php 

namespace App\Repositories;

use App\Connections\ConnectionFactory;
use PDO;

class RecadosRepository {

    public $connection;

    public function __construct()
    {
        $factory = new ConnectionFactory();
        $this->connection = $factory->getConnection();
    }

    public function obterTodos($inicio = ''){
        $sql = "SELECT * FROM tb_recados WHERE data > '$inicio' ORDER BY data asc";

        $table = $this->connection->query($sql); 
        $resultados = $table->fetchAll(PDO::FETCH_ASSOC);

        return $resultados;
    }

    public function cadastrar($recado){

        $sql = "INSERT INTO tb_recados (`data`, `autor`, `frase`) VALUES(:data, :autor, :frase)";

        $statement = $this->connection->prepare($sql);

        $statement->bindParam(':data', $recado['data']);
        $statement->bindParam(':autor', $recado['autor']);
        $statement->bindParam(':frase', $recado['frase']);

        $statement->execute();

        $recado['id'] = $this->connection->lastInsertId();

        return $recado;
    }

    public function remover($id){

        $sql = "DELETE FROM tb_recados WHERE id = :id";

        $statement = $this->connection->prepare($sql);

        $statement->bindParam(':id', $id, PDO::PARAM_INT);

        $statement->execute();

        return $id;
    }

    public function obterAutor($autor = ''){
        $sql = "SELECT * FROM tb_recados WHERE autor = '$autor' ";

        $table = $this->connection->query($sql);
        $resultados = $table->fetchAll(PDO::FETCH_ASSOC);

        return $resultados;
    }

}