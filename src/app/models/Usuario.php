<?php

namespace App;

use App\Interfaces\IUsuario;
use Error;

require_once '../../../vendor/autoload.php';

class Usuario extends Entidade implements IUsuario
{
  protected string $table = "usuarios";
  protected string $chavePrimaria = "idUsuario";
  protected string $chaveEstrangeira = "idEmpresa";
  protected string $relacionamento = "empresas";
  public string $dataNascimento;
  public string $cidadeNascimento;
  public string $email;
  public string $telefone;
  public array $empresas;

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
    $data = (is_null($usuario['dataNascimento']) || empty($usuario['dataNascimento'])) ? null : $this->dataNascimento;
    $this->cidadeNascimento = htmlspecialchars(strip_tags($usuario['cidadeNascimento']));
    $this->email = htmlspecialchars(strip_tags($usuario['email']));
    $this->telefone = htmlspecialchars(strip_tags($usuario['telefone']));
    $this->empresas = $usuario['empresas'];

    $stmt->bindParam(":nome", $this->nome);
    $stmt->bindParam(":dataNascimento", $data);
    $stmt->bindParam(":cidadeNascimento", $this->cidadeNascimento);
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":telefone", $this->telefone);

    $this->conexao->beginTransaction();
    if ($stmt->execute()) {
      $this->id = $this->conexao->lastInsertId();

      try {
        if (count($this->empresas)) {
          foreach ($this->empresas as $key => $empresa) {
            $empresa_usuario = new Empresa_Usuario($this->conexao);
            $relacionamentoRealizado = $empresa_usuario->novoRelacionamento($this->id, $empresa);
            if (!$relacionamentoRealizado) {
              throw new Error;
            }
          }
        }
        $this->conexao->commit();
        return true;
      } catch (\Throwable $th) {
        $this->conexao->rollBack();
        return false;
      }
      return true;
    }
  }

  public function atualizar(int $id, array $usuario): bool
  {
    $query = "UPDATE " . $this->table . " SET nome = :nome, dataNascimento = :dataNascimento, cidadeNascimento = :cidadeNascimento, email = :email, telefone = :telefone WHERE id = :id";

    // print_r($usuario);

    $stmt = $this->conexao->prepare($query);
    // htmlspecialchars e strip_tags usado para  prevenção contra inserção de código html

    $this->nome = htmlspecialchars(strip_tags($usuario['nome']));
    $this->dataNascimento = htmlspecialchars(strip_tags($usuario['dataNascimento']));
    $data = (is_null($usuario['dataNascimento']) || empty($usuario['dataNascimento'])) ? null : $this->dataNascimento;

    $this->cidadeNascimento = htmlspecialchars(strip_tags($usuario['cidadeNascimento']));
    $this->email = htmlspecialchars(strip_tags($usuario['email']));
    $this->telefone = htmlspecialchars(strip_tags($usuario['telefone']));
    $this->id = htmlspecialchars(strip_tags($id));

    $stmt->bindParam(":nome", $this->nome);
    $stmt->bindParam(":dataNascimento", $data);
    $stmt->bindParam(":cidadeNascimento", $this->cidadeNascimento);
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":telefone", $this->telefone);
    $stmt->bindParam(":id", $this->id);
    if ($stmt->execute()) {
      return true;
    }
    // print_r($stmt->errorInfo());
    return false;
  }
}
