<?php

namespace App;

use App\Interfaces\IEmpresa;

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

  public function cadastrar(array $empresa): bool
  {
    $query = "INSERT INTO " . $this->table . " SET nome = :nome, endereco = :endereco, cnpj = :cnpj";

    $stmt = $this->conn->prepare($query);
    // htmlspecialchars e strip_tags usado para  prevenção contra inserção de código html

    $this->nome = htmlspecialchars(strip_tags($empresa['nome']));
    $this->endereco = htmlspecialchars(strip_tags($empresa['endereco']));
    $this->cnpj = htmlspecialchars(strip_tags($empresa['cnpj']));

    $stmt->bindParam(":nome", $this->nome);
    $stmt->bindParam(":endereco", $this->endereco);
    $stmt->bindParam(":cnpj", $this->cnpj);
    if ($stmt->execute()) {
      $this->id = $this->conn->lastInsertId();
      return true;
    }
    return false;
  }

  public function deletar(int $id): bool
  {
    $query = "DELETE FROM " . $this->table . " WHERE id = :id";
    $stmt = $this->conn->prepare($query);

    $this->id = htmlspecialchars(strip_tags($id));
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
      return true;
    }
    return false;
  }
}
