<?php

namespace App\Interfaces;

interface ICrud
{
  public function listarTudo();
  public function listarPorId(int $id);
  public function cadastrar(array $empresa): bool;
  // public function deletar(int $id);
}
