<?php

namespace App\Interfaces;

interface ICrud
{
  public function listarTudo();
  public function listarTudoComRelacionamento();
  public function listarPorId(int $id);
  public function cadastrar(array $dados): bool;
  public function deletar(int $id): bool;
  public function atualizar(int $id, array $empresa): bool;
}
