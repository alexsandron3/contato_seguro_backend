<?php
function pegarIdDaRequisicao(string $url): int
{
  $rota = explode('/', $url);
  $id = intval(end($rota));
  return $id;
}
