<?php
/**
 * Created by PhpStorm.
 * User: websis
 * Date: 09/10/20
 * Time: 11:47
 */

namespace App\Controllers;


use App\Auth\Auth;
use App\database\models\CriptografarSenha;
use App\database\models\Usuario;
use Psr\Container\ContainerInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class AuthController
{
    protected $user;
    protected $container;
    protected $auth;


    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->auth = new Auth();

    }

    public function postSignIn(Request $request, Response $response)
    {
        $data = $request->getParsedBody();

        $retorno = $this->auth->attempt($data['username'], $data['password']);

        if ($retorno) {
            return $response->withStatus(302)->withHeader('Location', '/sinat/cadastro');
        } else {
            $this->container->get('flash')->addMessage('error', 'Usuário ou senhas inválidos');
            return $response->withStatus(302)->withHeader('Location', '/');
        }
    }

    public function logout(Request $request, Response $response)
    {
        $this->auth->logout();
        return $response->withStatus(302)->withHeader('Location', '/');
    }
}