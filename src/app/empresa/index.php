<?php

use App\Database\Database as DatabaseDatabase;
use App\Empresa;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../configs/constants.php";
require_once '../../../vendor/autoload.php';
$database = new DatabaseDatabase;

$connection = $database->getConnection();

$empresa = new Empresa($connection);

$resultado = $empresa->listarTudo();
$resposta = array();

if ($resultado->rowCount()) {
  $resposta['mensagem'] = SUCESSO_AO_PESQUISAR;
  $linha = $resultado->fetchAll(PDO::FETCH_ASSOC);
  $resposta['dados'] = $linha;
  http_response_code(HTTP_STATUS_OK);
} else {
  http_response_code(HTTP_STATUS_NOT_FOUND);
  $resposta['mensagem'] = NADA_ENCONTRADO_NA_PESQUISA;
}

echo json_encode($resposta);
