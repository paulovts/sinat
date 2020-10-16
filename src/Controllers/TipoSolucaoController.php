<?php
/**
 * Created by PhpStorm.
 * User: websis
 * Date: 15/10/20
 * Time: 18:08
 */

namespace App\Controllers;


use App\database\models\TipoSolucao;
use Psr\Container\ContainerInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class TipoSolucaoController
{
    protected $container;
    protected $tipoSolucao;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->tipoSolucao = new TipoSolucao();
    }


    public function listaTipoSolucao(Request $request, Response $response, $args)
    {
        $params = $request->getQueryParams();
        $tipoSolucao = $this->tipoSolucao->getTipoSolucaoById($params);

        $response->getBody()->write("$tipoSolucao");

        return $response;
    }


}