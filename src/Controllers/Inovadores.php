<?php
/**
 * Created by PhpStorm.
 * User: websis
 * Date: 08/10/20
 * Time: 17:03
 */

namespace App\Controllers;


use App\database\models\DocumentosInovadores;
use Psr\Container\ContainerInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class Inovadores
{
    protected $container;
    protected $inovadores;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->inovadores = new DocumentosInovadores();
    }

    public function home($request, $response, $args)
    {
        return
            $this->container->get('view')->render(
                $response,
                'inovadores/inovadores.twig',
                [
                    'title' => 'Documentos Inovadores'
                ]
            );
    }

    public function listaDocumentosInovadores(Request $request, Response $response, $args)
    {

        $retorno = $this->inovadores->getCatalogoInovadores();

        $response->getBody()->write("$retorno");

        return $response;
    }




    public function downloadDatecPDF(Request $request, Response $response, $args)
    {
        $retorno = $this->inovadores->getFileInovadoreslDatecId($args['id']);

        $fh = fopen('../' . $retorno[0], 'r');
        if ($fh) {
            $stream = new \Slim\Psr7\Stream($fh);
            return $response->withHeader('Content-Type', 'application/pdf')
                ->withHeader('Content-Disposition', 'attachment; filename="' . basename($retorno[0]) . '"')
                ->withBody($stream);
        } else {
            return false;
        }

    }

    public function downloadDiretrizPDF(Request $request, Response $response, $args)
    {
        $retorno = $this->inovadores->getFileInovadoreslDiretrizId($args['id']);

        $fh = fopen('../' . $retorno[0], 'r');
        if ($fh) {
            $stream = new \Slim\Psr7\Stream($fh);
            return $response->withHeader('Content-Type', 'application/pdf')
                ->withHeader('Content-Disposition', 'attachment; filename="' . basename($retorno[0]) . '"')
                ->withBody($stream);
        } else {
            return false;
        }

    }

}