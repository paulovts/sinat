<?php
/**
 * Created by PhpStorm.
 * User: websis
 * Date: 08/10/20
 * Time: 09:17
 */

namespace App\Controllers;


use App\database\models\Sistemas;
use Psr\Container\ContainerInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class Sistema
{
    protected $container;
    protected $sistema;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->sistema = new Sistemas();
    }

    public function listaSistema(Request $request, Response $response, $args)
    {
        $sistema = $this->sistema->getSistemas();

        $response->getBody()->write("$sistema");

        return $response;
    }


}