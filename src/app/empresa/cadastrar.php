<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

use App\Database\Database;
use App\Empresa;

include_once "../utils/constants.php";
require_once '../../../vendor/autoload.php';

$database = new Database();
$conexao = $database->getConnection();
$empresa = new Empresa($conexao);
$resposta = array();
$novaEmpresa = array(
  "nome" => "Empresa criada pela API",
  "endereco" => "Lugar nenhum",
  "cnpj" => "0000000"
);

$empresaFoiCadastrada = $empresa->cadastrar($novaEmpresa);

if ($empresaFoiCadastrada) {
  http_response_code(HTTP_STATUS_CREATED);
  $resposta['mensagem'] = SUCESSO_AO_CADASTRAR;
  $resposta['empresa'] = array(
    "id" => $empresa->id,
    "nome" => $empresa->nome,
    "endereco" => $empresa->endereco,
    "cnpj" => $empresa->cnpj,
  );
} else {
  http_response_code(HTTP_STATUS_BAD_REQUEST);
  $resposta['mensagem'] = SUCESSO_AO_CADASTRAR;
}

echo json_encode($resposta);
