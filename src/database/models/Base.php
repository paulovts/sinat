<?php
/**
 * Created by PhpStorm.
 * User: websis
 * Date: 06/10/20
 * Time: 15:38
 */

namespace App\database\models;

use App\database\Connection;
use PDO;

abstract class Base
{

    private $connection;

    public function __construct()
    {
        $this->connection = Connection::connection();
    }

    public function getFileConvencionalId($id)
    {
        try {
            $sql = 'SELECT txt_caminho_arquivo
					FROM catalogodesempenho.tab_catalogo_convencional
					WHERE cod_catalogo_convencional = :cod_catalogo_convencional';
            $statement = $this->connection->prepare($sql);

            $statement->bindValue('cod_catalogo_convencional', $id, PDO::PARAM_STR);
            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_COLUMN);
        } catch (\PDOException $exception) {
            return $exception->getMessage();
        }
    }

    public function getFileInovadoreslDatecId($id)
    {
        try {
            $sql = 'SELECT txt_caminho_arquivo
					FROM catalogodesempenho.tab_catalogo_datec
					WHERE cod_catalogo_datec = :cod_catalogo_datec';
            $statement = $this->connection->prepare($sql);

            $statement->bindValue('cod_catalogo_datec', $id, PDO::PARAM_STR);
            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_COLUMN);
        } catch (\PDOException $exception) {
            return $exception->getMessage();
        }
    }

    public function getFileInovadoreslDiretrizId($id)
    {
        try {
            $sql = 'SELECT txt_caminho_arquivo
					FROM catalogodesempenho.tab_diretriz
					WHERE cod_diretriz = :cod_diretriz';
            $statement = $this->connection->prepare($sql);

            $statement->bindValue('cod_diretriz', $id, PDO::PARAM_STR);
            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_COLUMN);
        } catch (\PDOException $exception) {
            return $exception->getMessage();
        }
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

            $statement = $this->connection->prepare($sql);
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

    public function getCatalogoInovadores()
    {

        try {
            $resultado = '';
            $sql = 'select json_agg(catalogos)
					from ( 
						SELECT tab_diretriz.cod_diretriz,
						    tab_diretriz.num_numero_diretriz,
							tab_diretriz.txt_descricao_diretriz, 
							tab_diretriz.num_ultima_revisao, 
							tab_diretriz.txt_caminho_arquivo,
							tab_diretriz.dte_data_pulicacao_diretriz,
							tab_diretriz.dte_data_edicao,
							json_agg(catalogodesempenho.tab_catalogo_datec.*) as jsonDatec	
						  FROM catalogodesempenho.tab_diretriz
						  LEFT JOIN catalogodesempenho.tab_catalogo_datec
						  ON tab_catalogo_datec.cod_diretriz = tab_diretriz.cod_diretriz 
						  GROUP BY tab_diretriz.cod_diretriz, tab_diretriz.txt_descricao_diretriz, tab_diretriz.num_ultima_revisao, 		tab_diretriz.txt_caminho_arquivo
						) as catalogos';
            $statement = $this->connection->prepare($sql);
            $statement->execute();
            $statement->setFetchMode(PDO::FETCH_OBJ);
            while ($row = $statement->fetch()) {
                $resultado = $row->json_agg;
            }
            return $resultado;

        } catch (\PDOException $exception) {
            return $exception->getMessage();
        }

    }

    public function getSistemas()
    {
        try {
            $resultado = '';
            $sql = 'SELECT json_agg(sistema) as txt_json
                    from (
                       SELECT
                         cod_sistema, txt_sistema, txt_sigla_sistema
                       FROM
                         catalogodesempenho.opc_sistema
                       ORDER BY opc_sistema.txt_sistema
                          ) as sistema';
            $statement = $this->connection->prepare($sql) OR die(implode('', $this->connection->errorInfo()));

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

    public function getSolucaoAll()
    {
        try {
            $resultado = '';
            $sql = 'SELECT json_agg(solucao) as txt_json
                    FROM (SELECT 
                             cod_solucao,
                             txt_solucao,
                             txt_sigla_solucao
                              FROM 
                              catalogodesempenho.opc_solucao
	                    ) AS solucao';
            $statement = $this->connection->prepare($sql) OR die(implode('', $this->connection->errorInfo()));

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

    public function getSolucaoBySistema($sistema)
    {
        try {
            $resultado = '';

            $sql = 'SELECT json_agg(solucao) as txt_json
                   FROM (SELECT
                   catalogodesempenho.opc_sistema.txt_sistema,
                   catalogodesempenho.opc_solucao.txt_solucao
                  FROM
                    catalogodesempenho.opc_sistema
                     LEFT JOIN catalogodesempenho.opc_solucao
                     ON opc_sistema.cod_sistema = opc_solucao.cod_sistema
                  GROUP BY
                    opc_sistema.txt_sistema, opc_solucao.txt_solucao
                  HAVING opc_sistema.txt_sistema ILIKE :txtSistema) AS solucao';

            $statement = $this->connection->prepare($sql) OR die(implode('', $this->connection->errorInfo()));
            $statement->bindValue('txtSistema', $sistema['sistema'], PDO::PARAM_STR);
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
}