<?php
/**
 * Created by PhpStorm.
 * User: websis
 * Date: 07/10/20
 * Time: 16:01
 */

namespace App\database\models;

use PDO;

class DocumentosConvencionais extends Base
{
    public function existeFiLeName($filename)
    {
        try {
            $sql = 'SELECT txt_caminho_arquivo
					FROM catalogodesempenho.tab_catalogo_convencional
					WHERE txt_caminho_arquivo ILIKE :txt_caminho_arquivo';
            $statement = $this->getConnection()->prepare($sql);

            $statement->bindValue('txt_caminho_arquivo', $filename, PDO::PARAM_STR);
            $statement->execute();

            $retorno = $statement->fetchAll(\PDO::FETCH_COLUMN);

            if ($retorno) {
                return true;
            } else {
                return false;
            }
        } catch (\PDOException $exception) {
            return $exception->getMessage();
        }
    }

    public function save(array $params)
    {

        if (empty($params)) {
            return false;
        }
        $dados = $this->limparDadosVazios($params);

        $sql = "INSERT INTO catalogodesempenho.tab_catalogo_convencional
              (txt_cod_ficha,
               dte_data_inclusao,
               cod_tipo_solucao,
               txt_caminho_arquivo,
               cod_usuario_insercao,
               bln_ativo)
            VALUES
              ('{$dados['txt_cod_ficha']}', 
               '{$dados['dte_data_inclusao']}',
               '{$dados['cod_tipo_solucao']}',
               '{$dados['txt_caminho_arquivo']}',
               {$dados['cod_usuario_insercao']},
               '{$dados['bln_ativo']}'
               )";
        $statement = $this->getConnection()->prepare($sql);

        $statement->execute();

        $retorno = $this->getConnection()->lastInsertId();

        if ($retorno) {
            return true;
        } else {
            return false;
        }
    }

    protected function limparDadosVazios($params)
    {
        $camposNulos = array();
        foreach ($params as $campo => $valor) {
            if (
                empty($valor) &&
                !is_numeric($valor) &&
                !is_bool($valor)
            ) {
                $params[$campo] = null;
                $camposNulos[] = $campo;
            }
        }
        return $params;
    }

    public function getCatalogoConvencional()
    {
        try {
            $resultado = '';
            $sql = 'SELECT json_agg(catalogos) as txt_json
					from ( 
						 SELECT 
						  opc_sistema.txt_sistema AS sistema, 
						  opc_sistema.txt_sigla_sistema, 
						  opc_solucao.txt_solucao AS solucao,
						  opc_solucao.txt_sigla_solucao,
						  opc_tipo_solucao.txt_tipo_solucao AS tiposolucao,
						  opc_tipo_solucao.num_ordem_solucao,
						  opc_tipo_solucao.txt_descricao_tipo_solucao AS descricao,
						  tab_catalogo_convencional.cod_catalogo_convencional AS numero,    
						  tab_catalogo_convencional.txt_caminho_arquivo AS url, 
						  opc_situacao_tipo_solucao.txt_situacao_tipo_solucao AS situacao,
						  tab_catalogo_convencional.dte_data_edicao,
						  tab_catalogo_convencional.cod_catalogo_convencional,
						  tab_catalogo_convencional.num_ultima_revisao,
						  tab_catalogo_convencional.txt_cod_ficha,
						  opc_situacao_tipo_solucao.cod_situacao_tipo_solucao as codsituacao
						FROM 
						  catalogodesempenho.opc_sistema, 
						  catalogodesempenho.opc_solucao, 
						  catalogodesempenho.opc_tipo_solucao, 
						  catalogodesempenho.tab_catalogo_convencional, 
						  catalogodesempenho.opc_situacao_tipo_solucao
						WHERE 
						  opc_sistema.cod_sistema = opc_solucao.cod_sistema AND
						  opc_solucao.cod_solucao = opc_tipo_solucao.cod_solucao AND
						  tab_catalogo_convencional.cod_tipo_solucao = opc_tipo_solucao.cod_tipo_solucao AND
						  opc_situacao_tipo_solucao.cod_situacao_tipo_solucao = opc_tipo_solucao.cod_situacao_tipo_solucao and
						   tab_catalogo_convencional.bln_ativo = TRUE
						ORDER BY opc_sistema.txt_sistema, opc_solucao.txt_solucao 
						) as catalogos';

            $statement = $this->getConnection()->prepare($sql);
            $statement->execute();
            $statement->setFetchMode(PDO::FETCH_OBJ);
            while ($row = $statement->fetch()) {
                $resultado = $row->txt_json;
            }

            return $resultado;

        } catch (\PDOException $exception) {
            return $exception->getMessage();
        }
    }

    public function getFileConvencionalId($id)
    {
        try {
            $sql = 'SELECT txt_caminho_arquivo
					FROM catalogodesempenho.tab_catalogo_convencional
					WHERE cod_catalogo_convencional = :cod_catalogo_convencional';
            $statement = $this->getConnection()->prepare($sql);

            $statement->bindValue('cod_catalogo_convencional', $id, PDO::PARAM_STR);
            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_COLUMN);
        } catch (\PDOException $exception) {
            return $exception->getMessage();
        }
    }

}