<?php
/**
 * Created by PhpStorm.
 * User: websis
 * Date: 09/10/20
 * Time: 10:51
 */

namespace App\Middleware;


use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use Slim\Routing\RouteContext;

class AuthMiddleware extends Middleware
{


    public function __invoke(Request $request, RequestHandler $handler)
    {
        $arrRoutes = [
            '/',
            '/convencionais',
            '/inovadores',
            '/documentos',
            '/convencionais/lista',
            '/sistema/lista',
            '/solucao/lista',
            '/documentos/arquivos/pdf/Desempenho_Documento_1',
            '/documentos/arquivos/pdf/Desempenho_Documento_2',
            '/documentos/arquivos/excel/Desempenho_Documento_2_Anexo_3',
            '/documentos/arquivos/pdf/Desempenho_Documento_3',
            '/documentos/arquivos/pdf/Desempenho_Documento_4',
        ];

        if (in_array($request->getUri()->getPath(), $arrRoutes)) {
            return $handler->handle($request);
        } else {

            if (!$this->container->get('auth')->check()) {

                $this->container
                    ->get('flash')
                    ->addMessage('error', 'Usuário não autorizado!!');

                return (new Response)
                    ->withHeader('Location', '/')
                    ->withStatus(302);

            } else {
                $response = $handler->handle($request);
            }
            return $response;
        }

    }

}