<?php

namespace App\Controllers;

use App\database\models\Usuario;
use Psr\Container\ContainerInterface;
use Slim\Flash\Messages as Messages;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use \Slim\Views\Twig as View;

class IndexController
{
    protected $container;
    protected $flash;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->usuario = new Usuario();
        $this->mail = new Mail();
    }

    public function home($request, $response, $args)
    {
        return $this->container->get('view')->render(
            $response,
            'index.twig',
            [
                'title' => 'SINAT-API'
            ]
        );
    }

    public function emailUser(Request $request, Response $response, $args)
    {

        $data = $request->getQueryParams();

        $dados = $this->usuario->buscarUsuario($data['email']);

        if (!empty($dados)) {
            $retorno = $this->mail->enviarEmailAlteracao($dados);
            if ($retorno) {
                $valid = count($dados);
                $response->getBody()->write("$valid");
                return $response;
            }
        } else {
            $invalid = count($dados);
            $response->getBody()->write("$invalid");
            return $response;
        }
    }

}