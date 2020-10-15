<?php
/**
 * Created by PhpStorm.
 * User: websis
 * Date: 08/10/20
 * Time: 10:53
 */

namespace App\Controllers;


use App\database\models\SolucaoSistema;
use Psr\Container\ContainerInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class Solucao
{
    protected $container;
    protected $solucao;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->solucao = new SolucaoSistema();
    }

    public function listaSolucao(Request $request, Response $response, $args)
    {
        $data = $request->getQueryParams();

        if (empty($data)) {
            $solucao = $this->solucao->getSolucaoAll();
        } else {
            $solucao = $this->solucao->getSolucaoBySistema($data);
        }

        $response->getBody()->write("$solucao");

        return $response;
    }

}