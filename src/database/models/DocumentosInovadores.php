<?php
/**
 * Created by PhpStorm.
 * User: websis
 * Date: 08/10/20
 * Time: 17:04
 */

namespace App\database\models;

use PDO;


class DocumentosInovadores extends Base
{
    public function getFileInovadoreslDatecId($id)
    {
        try {
            $sql = 'SELECT txt_caminho_arquivo
					FROM catalogodesempenho.tab_catalogo_datec
					WHERE cod_catalogo_datec = :cod_catalogo_datec';
            $statement = $this->getConnection()->prepare($sql);

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
            $statement = $this->getConnection()->prepare($sql);

            $statement->bindValue('cod_diretriz', $id, PDO::PARAM_STR);
            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_COLUMN);
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
            $statement = $this->getConnection()->prepare($sql);
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

    public function existeFiLeNameDiretriz($filename)
    {
        try {
            $sql = 'SELECT txt_caminho_arquivo
					FROM catalogodesempenho.tab_diretriz
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

    public function existeFiLeNameDatec($filename)
    {
        try {
            $sql = 'SELECT txt_caminho_arquivo
					FROM catalogodesempenho.tab_catalogo_datec
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

    public function saveDiretriz(array $params)
    {

        if (empty($params)) {
            return false;
        }
        $dados = $this->limparDadosVazios($params);
        $numDiretriz = $this->countDiretriz();

        $sql = "INSERT INTO catalogodesempenho.tab_diretriz
              (txt_descricao_diretriz,
               num_ultima_revisao,
               txt_caminho_arquivo,
               dte_data_insercao,
               dte_data_pulicacao_diretriz,
               num_numero_diretriz)
            VALUES
              ('{$dados['txt_descricao_diretriz']}', 
               '{$dados['num_ultima_revisao']}',
               '{$dados['txt_caminho_arquivo']}',
               'now()',
               {$dados['dte_data_pulicacao_diretriz']},
               {$numDiretriz},
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

    public function saveDatec(array $params)
    {

        if (empty($params)) {
            return false;
        }
        $dados = $this->limparDadosVazios($params);

        $sql = "INSERT INTO catalogodesempenho.tab_catalogo_datec
              (txt_descricao_datec,
               bln_vencido,
               bln_suspenso,
               dte_data_emissao,
               dte_data_validade,
               dte_data_insercao,
               txt_caminho_arquivo,
               cnpj_proponente,
               cod_situacao_datec,
               cod_diretriz,
               txt_ultima_versao,
               num_ordem_ficha,
               cod_usuario_insercao,
               )
            VALUES
              (
               '{$dados['txt_descricao_datec']}', 
               '{$dados['bln_vencido']}',
               '{$dados['bln_suspenso']}',
               '{$dados['dte_data_emissao']}',
               '{$dados['dte_data_validade']}',
               '{$dados['dte_data_insercao']}',
               '{$dados['txt_caminho_arquivo']}',
               '{$dados['cnpj_proponente']}',
               '{$dados['cod_situacao_datec']}',
               '{$dados['cod_diretriz']}',
               '{$dados['txt_ultima_versao']}',
               '{$dados['num_ordem_ficha']}',
               '{$dados['cod_usuario_insercao']}'
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

    public function countDiretriz()
    {
        try {
            $sql = 'SELECT count(*) as quantidade
					FROM catalogodesempenho.tab_diretriz';
            $statement = $this->getConnection()->prepare($sql);
            $statement->execute();

            return $statement->fetch(\PDO::FETCH_COLUMN);
        } catch (\PDOException $exception) {
            return $exception->getMessage();
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

    public function getListDiretriz()
    {
        try {
            $resultado = '';
            $sql = 'SELECT json_agg(diretriz) as txt_json
                    from (
                       SELECT
                         cod_diretriz,txt_descricao_diretriz
                       FROM
                         catalogodesempenho.tab_diretriz
                       ORDER BY tab_diretriz.cod_diretriz
                          ) as diretriz';
            $statement = $this->getConnection()->prepare($sql) OR die(implode('', $this->getConnection()->errorInfo()));

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