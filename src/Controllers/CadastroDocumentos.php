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
use Slim\Psr7\Response;
use Slim\Psr7\UploadedFile;

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
        $directory = '../_catalogos/convencional';

        $uploadedFiles = $request->getUploadedFiles();

        $params = $request->getParsedBody();

        $solucaoModel = new SolucaoSistema();

        $caminho = '_catalogos/convencional/' . $uploadedFiles['fileToUpload']->getClientFilename();

        $existe = $this->convencional->existeFiLeName($caminho);


        if ($existe) {
            $this->container->get('flash')->addMessage('error', 'Arquivo já cadastrado no sistema');
            return (new Response())
                ->withHeader('Location', '/cadastro')
                ->withStatus(302);
        }

        $nomeArquivo = str_replace('.pdf', "", $uploadedFiles['fileToUpload']->getClientFilename());

        $idSistema = $solucaoModel->getSistemaBySolucao($params['solucao']);

        $arrDados = [
            'txt_cod_ficha' => $nomeArquivo,
            'dte_data_inclusao' => $params['data-emissao'],
            'dte_data_edicao' => null,
            'cod_tipo_solucao' => $idSistema,
            'txt_caminho_arquivo' => $caminho,
            'cod_usuario_insercao' => $_SESSION['cod_usuario'],
            'bln_ativo' => true,
        ];
        $modelConvencional = new DocumentosConvencionais();

        $retorno = $modelConvencional->save($arrDados);

        if ($retorno) {

            $uploadedFile = $uploadedFiles['fileToUpload'];

            if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
                $this->moveUploadedFile($directory, $uploadedFile);
            }

            $this->container->get('flash')->addMessage('info', 'Arquivo cadastro com Successo!');
            return (new Response())
                ->withHeader('Location', '/cadastro')
                ->withStatus(302);

        } else {
            $this->container->get('flash')->addMessage('error', 'Não foi Possível salvar o Arquivo!');
            return (new Response())
                ->withHeader('Location', '/cadastro')
                ->withStatus(302);
        }
    }

    public function moveUploadedFile($directory, UploadedFile $uploadedFile)
    {
//        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
//        $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
//        $filename = sprintf('%s.%0.8s', $basename, $extension);
        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $uploadedFile->getClientFilename());
    }

}