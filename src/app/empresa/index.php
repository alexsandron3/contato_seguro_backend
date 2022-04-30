<?php

use App\Database\Database as DatabaseDatabase;
use App\Empresa;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Methods: GET, POST');


include_once "../utils/constants.php";
require_once '../../../vendor/autoload.php';

$database = new DatabaseDatabase;
$connection = $database->getConnection();
$empresa = new Empresa($connection);


$resposta = array();
$tipoRequisicao = $_SERVER['REQUEST_METHOD'];


if ($tipoRequisicao === GET) {
  $resultado = $empresa->listarTudo();
  if ($resultado->rowCount()) {
    $resposta['mensagem'] = SUCESSO_AO_PESQUISAR;
    $linha = $resultado->fetchAll(PDO::FETCH_ASSOC);
    $resposta['dados'] = $linha;
    http_response_code(HTTP_STATUS_OK);
  } else {
    http_response_code(HTTP_STATUS_NOT_FOUND);
    $resposta['mensagem'] = NADA_ENCONTRADO_NA_PESQUISA;
  }
} else if ($tipoRequisicao === POST) {
  $dados = json_decode(file_get_contents('php://input'));
  $novaEmpresa = array(
    "nome" => $dados->nome,
    "endereco" => $dados->endereco,
    "cnpj" => $dados->cnpj
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
} else {
  $resposta['mensagem'] = METODO_NAO_PERMITIDO;
  http_response_code(HTTP_STATUS_METHOD_NOT_ALLOWED);
}

echo json_encode($resposta);
