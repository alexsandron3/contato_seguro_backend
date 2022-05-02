<?php

// RESPOSTAS DO SERVIDOR
const SUCESSO_AO_PESQUISAR = 'Pesquisa realizada com sucesso!';
const SUCESSO_AO_CADASTRAR = 'Cadastro realizado com sucesso!';
const SUCESSO_AO_DELETAR = 'Registro apagado com sucesso!';
const SUCESSO_AO_ATUALIZAR = 'Registro atualizado com sucesso!';
const FALHA_AO_CADASTRAR = 'Falha ao tentar cadastrar registro!';
const FALHA_AO_DELETAR = 'Falha ao tentar deletar registro!';
const FALHA_AO_ATUALIZAR = 'Falha ao tentar atualizar este registro!';
const NADA_ENCONTRADO_NA_PESQUISA = 'Nenhum registro foi encontrado!';
const METODO_NAO_PERMITIDO = "Método não permitido!";
const ID_NAO_INFORMADO = "ID não encontrado na requisição!";

// STATUS HTTP
const HTTP_STATUS_OK = 200;
const HTTP_STATUS_CREATED = 201;
const HTTP_STATUS_NO_CONTENT = 204;
const HTTP_STATUS_BAD_REQUEST = 400;
const HTTP_STATUS_NOT_FOUND = 404;
const HTTP_STATUS_METHOD_NOT_ALLOWED = 405;

// TIPOS DE REQUISIÇÃO

const DELETE = "DELETE";
const GET = "GET";
const POST = "POST";
const PUT = "PUT";
