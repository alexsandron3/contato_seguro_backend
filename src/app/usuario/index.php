<?php

use App\Database\Database;
use App\Usuario;

header('Access-Control-Allow-Headers: access');
header('Access-Control-Allow-Methods: GET, POST');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
header('Access-Control-Allow-Origin: *');

include_once "../utils/constants.php";
include_once '../../vendor/autoload.php';

$database = new Database;
$connection = $database->getConnection();
$usuario = new Usuario($connection);

$resposta = array();
$tipoRequisicao = $_SERVER['REQUEST_METHOD'];

if ($tipoRequisicao === GET) {
  $resultadoUsuarios = $usuario->listarTudo();
  $resultado = $usuario->listarTudoComRelacionamento();
  if ($resultado->rowCount()) {
    $resposta['mensagem'] = SUCESSO_AO_PESQUISAR;
    $linha = $resultado->fetchAll(PDO::FETCH_ASSOC);
    $linhaUsuarios = $resultadoUsuarios->fetchAll(PDO::FETCH_ASSOC);
    $resposta['dados'] = $linhaUsuarios;
    $resposta['adicionais'] = $linha ;
    http_response_code(HTTP_STATUS_OK);
  } else {
    http_response_code(HTTP_STATUS_NOT_FOUND);
    $resposta['mensagem'] = NADA_ENCONTRADO_NA_PESQUISA;
  }
} elseif ($tipoRequisicao === POST) {
  $dados = json_decode(file_get_contents('php://input'));
  $novoUsuario = array(
    "nome" => $dados->nome,
    "dataNascimento" => $dados->dataNascimento,
    "cidadeNascimento" => $dados->cidadeNascimento,
    "email" => $dados->email,
    "telefone" => $dados->telefone,
    "empresas" => $dados->empresas
  );

  $usuarioFoiCadastrado = $usuario->cadastrar($novoUsuario);

  if ($usuarioFoiCadastrado) {
    http_response_code(HTTP_STATUS_CREATED);
    $resposta['mensagem'] = SUCESSO_AO_CADASTRAR;
    $resposta['dados'] = array(
      "id" => $usuario->id,
      "nome" => $usuario->nome,
      "dataNascimento" => $usuario->dataNascimento,
      "cidadeNascimento" => $usuario->cidadeNascimento,
      "email" => $usuario->email,
      "telefone" => $usuario->telefone
    );
  } else {
    http_response_code(HTTP_STATUS_BAD_REQUEST);
    $resposta['mensagem'] = FALHA_AO_CADASTRAR;
  }
}
echo json_encode($resposta);
