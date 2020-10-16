<?php
/**
 * Created by PhpStorm.
 * User: websis
 * Date: 09/10/20
 * Time: 09:36
 */

use App\Controllers;
use App\Middleware\AuthMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->get('/', Controllers\IndexController::class . ':home')->setName('home');
$app->get('/consultarEmail', Controllers\IndexController::class . ':emailUser');
$app->get('/documentos', Controllers\Documentos::class . ':listaDocumentos')->setName('documentos');

$app->get('/convencionais', Controllers\Convencionais::class . ':home');
$app->get('/convencionais/lista', Controllers\Convencionais::class . ':listaDocumentosConvencionais');

$app->get('/inovadores', Controllers\Inovadores::class . ':home');
$app->get('/inovadores/lista', Controllers\Inovadores::class . ':listaDocumentosInovadores');


$app->get('/sistema/lista', Controllers\Sistema::class . ':listaSistema');
$app->get('/solucao/lista', Controllers\Solucao::class . ':listaSolucao');
$app->get('/tipo/lista', Controllers\TipoSolucaoController::class . ':listaTipoSolucao');


$app->post('/auth', Controllers\AuthController::class . ':postSignIn');
$app->get('/auth/logout', Controllers\AuthController::class . ':logout');

//$app->get('/cadastro', Controllers\CadastroDocumentos::class . ':cadastroDocumento');

//Url para download pdf e excel

$app->get('/convencionais/pdf/{id}', Controllers\Convencionais::class . ':downloadPDF');
$app->get('/inovadores/arquivos/datec/pdf/{id}', Controllers\Inovadores::class . ':downloadDatecPDF');
$app->get('/inovadores/arquivos/diretriz/pdf/{id}', Controllers\Inovadores::class . ':downloadDiretrizPDF');
$app->get('/documentos/arquivos/pdf/{file}', Controllers\Documentos::class . ':downloadPDF');
$app->get('/documentos/arquivos/excel/{file}', Controllers\Documentos::class . ':downloadExcel');

$app->group('', function () use ($app) {
    $app->get('/cadastro', Controllers\CadastroDocumentos::class . ':cadastroDocumento');
    $app->get('/cadastro/inovadores', Controllers\CadastroDocumentos::class . ':cadastroInovadores');
    $app->get('/cadastro/convencional', Controllers\CadastroDocumentos::class . ':cadastroConvencional');
    $app->post('/cadastro/convencional/save', Controllers\CadastroDocumentos::class . ':saveConvencional');
    $app->post('/cadastro/inovadores/save', Controllers\CadastroDocumentos::class . ':saveInovadores');
})->add(new AuthMiddleware($container));
