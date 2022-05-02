<?php

namespace App;

use App\Interfaces\IEmpresa;

require_once '../../../vendor/autoload.php';

class Empresa extends Entidade implements IEmpresa
{
  protected string $table = "empresas";
  protected string $chavePrimaria = "idEmpresa";
  protected string $chaveEstrangeira = "idUsuario";
  protected string $relacionamento = "usuarios";
  public string $endereco;
  public string $cnpj;

  public function __construct($conexao)
  {
    Entidade::__construct($conexao);
  }


  public function listarPorId(int $id)
  {
    $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
    $stmt = $this->conexao->prepare($query);
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

    $stmt = $this->conexao->prepare($query);


    $this->nome = htmlspecialchars(strip_tags($empresa['nome']));
    $this->endereco = htmlspecialchars(strip_tags($empresa['endereco']));
    $this->cnpj = htmlspecialchars(strip_tags($empresa['cnpj']));

    $stmt->bindParam(":nome", $this->nome);
    $stmt->bindParam(":endereco", $this->endereco);
    $stmt->bindParam(":cnpj", $this->cnpj);
    if ($stmt->execute()) {
      $this->id = $this->conexao->lastInsertId();
      return true;
    }
    return false;
  }


  public function atualizar(int $id, array $empresa): bool
  {
    $query = "UPDATE " . $this->table . " SET nome = :nome, endereco = :endereco, cnpj = :cnpj WHERE id = :id";

    $stmt = $this->conexao->prepare($query);
    // htmlspecialchars e strip_tags usado para  prevenção contra inserção de código html

    $this->nome = htmlspecialchars(strip_tags($empresa['nome']));
    $this->endereco = htmlspecialchars(strip_tags($empresa['endereco']));
    $this->cnpj = htmlspecialchars(strip_tags($empresa['cnpj']));
    $this->id = htmlspecialchars(strip_tags($id));

    $stmt->bindParam(":nome", $this->nome);
    $stmt->bindParam(":endereco", $this->endereco);
    $stmt->bindParam(":cnpj", $this->cnpj);
    $stmt->bindParam(":id", $this->id);
    if ($stmt->execute()) {
      return true;
    }
    return false;
  }
}
