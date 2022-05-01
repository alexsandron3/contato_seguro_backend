<?php

namespace App;

class Empresa_Usuario
{
  protected string $table = "empresas_usuarios";
  public int $idUsuario;
  public int $idEmpresa;
  protected $conexao;
  public function __construct($conexao)
  {
    $this->conexao = $conexao;
  }
  public function novoRelacionamento(int $idUsuario, int $idEmpresa): bool
  {
    $query = "INSERT INTO " . $this->table . " SET idEmpresa = :idEmpresa, idUsuario = :idUsuario";
    $stmt = $this->conexao->prepare($query);
    $this->idUsuario = htmlspecialchars(strip_tags($idUsuario));
    $this->idEmpresa = htmlspecialchars(strip_tags($idEmpresa));

    $stmt->bindParam(":idUsuario", $this->idUsuario);
    $stmt->bindParam(":idEmpresa", $this->idEmpresa);
    if ($stmt->execute()) {
      $this->id = $this->conexao->lastInsertId();
      return true;
    }
    return false;
  }
}
