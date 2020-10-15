<?php
/**
 * Created by PhpStorm.
 * User: websis
 * Date: 07/10/20
 * Time: 15:39
 */

namespace App\Controllers;

use App\database\models\DocumentosConvencionais;
use Psr\Container\ContainerInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class Convencionais
{
    protected $container;
    protected $convencionais;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->convencionais = new DocumentosConvencionais();
    }

    public function listaDocumentosConvencionais(Request $request, Response $response, $args)
    {
        $dados = $this->convencionais->getCatalogoConvencional();
        $response->getBody()->write("$dados");

        return $response;
    }

    public function home($request, $response, $args)
    {
        return
            $this->container->get('view')->render(
                $response,
                'convencionais/convencionais.twig',
                [
                    'title' => 'Documentos Convencionais'
                ]
            );
    }

    public function downloadPDF(Request $request, Response $response, $args)
    {
        $retorno = $this->convencionais->getFileConvencionalId($args['id']);

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