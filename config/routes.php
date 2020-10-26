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
$app->get('/sinat/consultarEmail', Controllers\IndexController::class . ':emailUser');
$app->get('/sinat/documentos', Controllers\Documentos::class . ':listaDocumentos')->setName('documentos');

$app->get('/sinat/convencionais', Controllers\Convencionais::class . ':home');
$app->get('/sinat/convencionais/lista', Controllers\Convencionais::class . ':listaDocumentosConvencionais');

$app->get('/sinat/inovadores', Controllers\Inovadores::class . ':home');
$app->get('/sinat/inovadores/lista', Controllers\Inovadores::class . ':listaDocumentosInovadores');


$app->get('/sinat/sistema/lista', Controllers\Sistema::class . ':listaSistema');
$app->get('/sinat/solucao/lista', Controllers\Solucao::class . ':listaSolucao');
$app->get('/sinat/tipo/lista', Controllers\TipoSolucaoController::class . ':listaTipoSolucao');


$app->post('/sinat/auth', Controllers\AuthController::class . ':postSignIn');
$app->get('/sinat/auth/logout', Controllers\AuthController::class . ':logout');

//$app->get('/cadastro', Controllers\CadastroDocumentos::class . ':cadastroDocumento');

//Url para download pdf e excel

$app->get('/sinat/convencionais/pdf/{id}', Controllers\Convencionais::class . ':downloadPDF');
$app->get('/sinat/inovadores/arquivos/datec/pdf/{id}', Controllers\Inovadores::class . ':downloadDatecPDF');
$app->get('/sinat/inovadores/arquivos/diretriz/pdf/{id}', Controllers\Inovadores::class . ':downloadDiretrizPDF');
$app->get('/sinat/documentos/arquivos/pdf/{file}', Controllers\Documentos::class . ':downloadPDF');
$app->get('/sinat/documentos/arquivos/excel/{file}', Controllers\Documentos::class . ':downloadExcel');

$app->group('', function () use ($app) {
    $app->get('/sinat/cadastro', Controllers\CadastroDocumentos::class . ':cadastroDocumento');
    $app->get('/sinat/cadastro/inovadores', Controllers\CadastroDocumentos::class . ':cadastroInovadores');
    $app->get('/sinat/cadastro/convencional', Controllers\CadastroDocumentos::class . ':cadastroConvencional');
    $app->get('/sinat/diretriz/list', Controllers\CadastroDocumentos::class . ':getListDiretriz');
    $app->post('/sinat/save/convencional', Controllers\CadastroDocumentos::class . ':saveConvencional');
    $app->post('/sinat/save/diretriz', Controllers\CadastroDocumentos::class . ':saveInovadoresDiretriz');
    $app->post('/sinat/save/datec', Controllers\CadastroDocumentos::class . ':saveInovadoresDatec');
})->add(new AuthMiddleware($container));
