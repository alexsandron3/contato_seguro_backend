<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Methods: GET, DELETE, UPDATE');

include_once "../utils/constants.php";
include_once '../../../vendor/autoload.php';
include_once '../utils/funcoes.php';

use App\Database\Database;
use App\Empresa;

$database = new Database();
$connection = $database->getConnection();
$empresa = new Empresa($connection);


$resposta = array();
$tipoRequisicao = $_SERVER['REQUEST_METHOD'];
$id = pegarIdDaRequisicao($_SERVER['REQUEST_URI']);

if (!$id) {
  $resposta = array(
    "mensagem" => ID_NAO_INFORMADO,
    "dados" => array(),
  );
  http_response_code(HTTP_STATUS_BAD_REQUEST);
  return print_r(json_encode($resposta));
}

if ($tipoRequisicao === GET) {
  $empresa->listarPorId($id);
  if ($empresa->nome != null) {
    $resposta = array(
      "mensagem" => SUCESSO_AO_PESQUISAR,
      "dados" => array(
        "id" => $empresa->id,
        "nome" => $empresa->nome,
        "cnpj" => $empresa->cnpj,
        "endereco" => $empresa->endereco,
      )
    );
    http_response_code(HTTP_STATUS_OK);
  } else {
    http_response_code(HTTP_STATUS_NOT_FOUND);
    $resposta['mensagem'] = NADA_ENCONTRADO_NA_PESQUISA;
  }
} else if ($tipoRequisicao === DELETE) {
  $empresaFoiDeletada = $empresa->deletar($id);
  if ($empresaFoiDeletada) {
    http_response_code(HTTP_STATUS_OK);
    $resposta = array(
      "mensagem" => SUCESSO_AO_DELETAR,
      "dados" => array(),
    );
  }
} else if ($tipoRequisicao === PUT) {
  $dados = json_decode(file_get_contents('php://input'));
  $empresaAtualizada = array(
    "nome" => $dados->nome,
    "endereco" => $dados->endereco,
    "cnpj" => $dados->cnpj
  );
  $empresaFoiAtualizada = $empresa->atualizar($id, $empresaAtualizada);
  if ($empresaFoiAtualizada) {
    $resposta = array(
      "mensagem" => SUCESSO_AO_ATUALIZAR,
      "dados" => $empresaAtualizada
    );
  }
} else {
  $resposta['mensagem'] = METODO_NAO_PERMITIDO;
  http_response_code(HTTP_STATUS_METHOD_NOT_ALLOWED);
}
echo json_encode($resposta);
