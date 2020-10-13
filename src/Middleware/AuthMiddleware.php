<?php
/**
 * Created by PhpStorm.
 * User: websis
 * Date: 09/10/20
 * Time: 10:51
 */

namespace App\Middleware;


use Slim\Psr7\Request    ;
use Slim\Psr7\Response;

class AuthMiddleware extends Middleware
{

    public function __invoke($resquest, $response)
    {
        if (!$this->container->get('auth')->check()) {
            $this->container->get('flash')->addMessage('error', 'Usuário não autorizado!!');

            return $response;
        }
    }
}