<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../configs/constants.php";
require_once '../../../vendor/autoload.php';

use App\Database\Database as Database;
use App\Empresa;

$database = new Database();

$connection = $database->getConnection();

$empresa = new Empresa($connection);

$empresa->listarPorId(2);
$resposta = array();


if ($empresa->nome != null) {
  $resposta['mensagem'] = SUCESSO_AO_PESQUISAR;
  $resposta['dados'] = array(
    "id" => $empresa->id,
    "nome" => $empresa->nome,
    "cnpj" => $empresa->cnpj,
    "endereco" => $empresa->endereco,
  );
  http_response_code(HTTP_STATUS_OK);
} else {
  http_response_code(HTTP_STATUS_NOT_FOUND);
  $resposta['mensagem'] = NADA_ENCONTRADO_NA_PESQUISA;
}

echo json_encode($resposta);
