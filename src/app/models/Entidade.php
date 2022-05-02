<?php

namespace App;

use App\Interfaces\ICrud;

require_once '../../../vendor/autoload.php';


abstract class Entidade implements ICrud
{
  public int $id;
  public string $nome;
  protected string $table;
  protected string $chavePrimaria;
  protected string $chaveEstrangeira;
  protected string $relacionamento;
  protected $conexao;

  public function __construct($conexao)
  {
    $this->conexao = $conexao;
  }

  abstract public function listarPorId(int $id);
  abstract public function cadastrar(array $dados): bool;
  abstract public function atualizar(int $id, array $dados): bool;

  public function listarTudo()
  {
    $query = "SELECT a.*, c.nome AS nome" . $this->relacionamento . ", c.id AS " . $this->chaveEstrangeira . " FROM " . $this->table . " a JOIN empresas_usuarios b ON a.id = b." . $this->chavePrimaria . " JOIN " . $this->relacionamento . " c ON b." . $this->chaveEstrangeira . " = c.id ORDER BY a.id";
    $stmt = $this->conexao->prepare($query);
    $stmt->execute();
    return $stmt;
  }

  public function deletar(int $id): bool
  {
    $query = "DELETE FROM " . $this->table . " WHERE id = :id";
    $stmt = $this->conexao->prepare($query);

    $this->id = htmlspecialchars(strip_tags($id));
    $stmt->bindParam(':id', $id);

    if ($stmt->execute() && $stmt->rowCount()) {
      return true;
    }
    return false;
  }
}
