<?php

interface ICrud
{
  public function listarTudo();
  public function listarPorId(int $id);
  public function cadastrar(array $empresa);
  public function deletar(int $id);
}
