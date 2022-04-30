<?php

namespace App;

use Interfaces\IEmpresa as IEmpresa;

require_once '../../../vendor/autoload.php';

class Empresa implements IEmpresa
{
  private $conn;
  private $table = "empresas";

  public $id;
  public $nome;
  public $endereco;
  public $cnpj;

  public function __construct($connection)
  {
    $this->conn = $connection;
  }

  public function listarTudo()
  {
    $query = "SELECT * FROM " . $this->table . ";";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
  }

  public function listarPorId(int $id)
  {
    $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $resultado = $stmt->fetch(\PDO::FETCH_ASSOC);
    $this->id = $resultado['id'];
    $this->nome = $resultado['nome'];
    $this->endereco = $resultado['endereco'];
    $this->cnpj = $resultado['cnpj'];
  }
}
