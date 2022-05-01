<?php

namespace App;

use App\Interfaces\IUsuario;

require_once '../../../vendor/autoload.php';

class Usuario extends Entidade implements IUsuario
{
  protected string $table = "usuarios";
  public string $dataNascimento;
  public string $cidadeNascimento;
  public string $email;
  public string $telefone;

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
    $this->dataNascimento = $resultado['dataNascimento'];
    $this->cidadeNascimento = $resultado['cidadeNascimento'];
    $this->email = $resultado['email'];
    $this->telefone = $resultado['telefone'];
  }

  public function cadastrar(array $usuario): bool
  {
    $query = "INSERT INTO " . $this->table . " SET nome = :nome, dataNascimento = :dataNascimento, cidadeNascimento = :cidadeNascimento, email = :email, telefone = :telefone";

    $stmt = $this->conexao->prepare($query);


    $this->nome = htmlspecialchars(strip_tags($usuario['nome']));
    $this->dataNascimento = htmlspecialchars(strip_tags($usuario['dataNascimento']));
    $this->cidadeNascimento = htmlspecialchars(strip_tags($usuario['cidadeNascimento']));
    $this->email = htmlspecialchars(strip_tags($usuario['email']));
    $this->telefone = htmlspecialchars(strip_tags($usuario['telefone']));

    $stmt->bindParam(":nome", $this->nome);
    $stmt->bindParam(":dataNascimento", $this->dataNascimento);
    $stmt->bindParam(":cidadeNascimento", $this->cidadeNascimento);
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":telefone", $this->telefone);
    if ($stmt->execute()) {
      $this->id = $this->conexao->lastInsertId();
      return true;
    }
    return false;
  }

  public function atualizar(int $id, array $usuario): bool
  {
    $query = "UPDATE " . $this->table . " ET nome = :nome, dataNascimento = :dataNascimento, cidadeNascimento = :cidadeNascimento, email = :email, telefone = :telefone WHERE id = :id";

    $stmt = $this->conexao->prepare($query);
    // htmlspecialchars e strip_tags usado para  prevenção contra inserção de código html

    $this->nome = htmlspecialchars(strip_tags($usuario['nome']));
    $this->dataNascimento = htmlspecialchars(strip_tags($usuario['dataNascimento']));
    $this->cidadeNascimento = htmlspecialchars(strip_tags($usuario['cidadeNascimento']));
    $this->email = htmlspecialchars(strip_tags($usuario['email']));
    $this->telefone = htmlspecialchars(strip_tags($usuario['telefone']));
    $this->id = htmlspecialchars(strip_tags($id));

    $stmt->bindParam(":nome", $this->nome);
    $stmt->bindParam(":endereco", $this->endereco);
    $stmt->bindParam(":cnpj", $this->cnpj);
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":telefone", $this->telefone);
    $stmt->bindParam(":id", $this->id);
    if ($stmt->execute()) {
      return true;
    }
    return false;
  }
}