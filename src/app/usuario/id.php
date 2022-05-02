<?php

header('Access-Control-Allow-Headers: access');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
header('Access-Control-Allow-Origin: *');

include_once "../utils/constants.php";
include_once '../../../vendor/autoload.php';
include_once '../utils/funcoes.php';

use App\Database\Database;
use App\Usuario;

$database = new Database();
$connection = $database->getConnection();
$usuario = new Usuario($connection);


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
  $usuario->listarPorId($id);
  if ($usuario->nome != null) {
    $resposta = array(
      "mensagem" => SUCESSO_AO_PESQUISAR,
      "dados" => array(
        "id" => $usuario->id,
        "nome" => $usuario->nome,
        "dataNascimento" => $usuario->dataNascimento,
        "cidadeNascimento" => $usuario->cidadeNascimento,
        "email" => $usuario->email,
        "telefone" => $usuario->telefone,
      )
    );
    http_response_code(HTTP_STATUS_OK);
  } else {
    http_response_code(HTTP_STATUS_NOT_FOUND);
    $resposta['mensagem'] = NADA_ENCONTRADO_NA_PESQUISA;
  }
}

echo json_encode($resposta);
