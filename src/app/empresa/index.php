<?php


use App\Database\Database;
use App\Empresa;

header('Access-Control-Allow-Headers: access');
header('Access-Control-Allow-Methods: GET, POST');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
header('Access-Control-Allow-Origin: *');


include_once "../utils/constants.php";
require_once '../../../vendor/autoload.php';

$database = new Database;
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
} elseif ($tipoRequisicao === POST) {
  $dados = json_decode(file_get_contents('php://input'));
  $novaEmpresa = array(
    "nome" => $dados->nome,
    "endereco" => $dados->endereco,
    "cnpj" => $dados->cnpj
  );

  $empresaFoiCadastrada = $empresa->cadastrar($novaEmpresa);

  if (!$empresaFoiCadastrada) {
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
    $resposta['mensagem'] = FALHA_AO_CADASTRAR;
  }
}

echo json_encode($resposta);
