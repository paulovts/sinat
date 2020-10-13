<?php
/**
 * Created by PhpStorm.
 * User: websis
 * Date: 13/10/20
 * Time: 12:26
 */

namespace App\Controllers;


use Psr\Container\ContainerInterface;

class CadastroDocumentos
{

    protected $container;


    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;;
    }

    public function cadastroDocumento($request, $response, $args)
    {
        return $this->container->get('view')->render(
            $response,
            'cadastro/cadastro.twig'
        );
    }

}