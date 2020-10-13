<?php
/**
 * Created by PhpStorm.
 * User: websis
 * Date: 07/10/20
 * Time: 10:55
 */

namespace App\Controllers;


use Psr\Container\ContainerInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class Documentos
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function listaDocumentos(Request $request, Response $response, $args)
    {

        return $this->container->get('view')->render(
            $response,
            'documentos/documentos.twig',
            [
                'title' => 'Documentos'
            ]
        );
    }

    public function downloadPDF(Request $request, Response $response, $args)
    {
        $file = '../_catalogos/documentos/' . $args['file'] . '.pdf';

        $fh = fopen($file, 'r');

        $stream = new \Slim\Psr7\Stream($fh); // create a stream instance for the response body

        return $response->withHeader('Content-Type', 'application/pdf')
            ->withHeader('Content-Disposition', 'attachment; filename="' . basename($file) . '"')
            ->withBody($stream);

    }

    public function downloadExcel(Request $request, Response $response, $args)
    {
        $file = '../_catalogos/documentos/' . $args['file'] . '.xlsx';

        $fh = fopen($file, 'r');

        $stream = new \Slim\Psr7\Stream($fh); // create a stream instance for the response body

        return $response->withHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            ->withHeader('Content-Disposition', 'attachment; filename="' . basename($file) . '"')
            ->withBody($stream);

    }
}