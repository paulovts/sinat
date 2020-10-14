<?php
/**
 * Created by PhpStorm.
 * User: websis
 * Date: 13/10/20
 * Time: 12:26
 */

namespace App\Controllers;


use App\database\models\DocumentosConvencionais;
use App\database\models\SolucaoSistema;
use Psr\Container\ContainerInterface;

class CadastroDocumentos
{

    protected $container;
    protected $convencional;


    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->convencional = new DocumentosConvencionais();
    }

    public function cadastroDocumento($request, $response, $args)
    {
        return $this->container->get('view')->render(
            $response,
            'cadastro/cadastro.twig'
        );
    }

    public function cadastroConvencional($request, $response, $args)
    {
        return $this->container->get('view')->render(
            $response,
            'cadastro/convencional.twig'
        );
    }

    public function cadastroInovadores($request, $response, $args)
    {
        return $this->container->get('view')->render(
            $response,
            'cadastro/inovadores.twig'
        );
    }

    public function saveConvencional($request, $response, $args)
    {
        $uploadedFiles = $request->getUploadedFiles();

        $params = $request->getParsedBody();

        $solucaoModel = new SolucaoSistema();

        $idSistema = $solucaoModel->getSistemaBySolucao($params['solucao']);

        $caminho = '_catalogos/convencional/' . $uploadedFiles['fileToUpload']->getClientFilename();

        $existe = $this->convencional->existeFiLeName($caminho);
        $nomeArquivo = str_replace('.pdf', "", $uploadedFiles['fileToUpload']->getClientFilename());

        if ($existe) {
            $this->container->get('flash')->addMessage('error', 'Arquivo já cadastrado no sistema');
            return $response->withStatus(302)->withHeader('Location', '/cadastro');
        }

        $arrDados = [
            'txt_cod_ficha' => $nomeArquivo,
            'dte_data_inclusao' => $params['data-emissao'],
            'dte_data_edicao' => '',
            'cod_tipo_solucao' => $idSistema,
            'txt_caminho_arquivo' => $caminho,
            'num_ultima_revisao' => '',
            'cod_usuario_insercao' => $_SESSION['cod_usuario'],
            'bln_ativo' => true,
        ];



    }

}