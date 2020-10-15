<?php
/**
 * Created by PhpStorm.
 * User: websis
 * Date: 08/10/20
 * Time: 10:54
 */

namespace App\database\models;

use PDO;

class SolucaoSistema extends Base
{

    public function getSistemaBySolucao($solucao)
    {
        try {
            $sql = 'SELECT cod_sistema
                    FROM catalogodesempenho.opc_solucao
                    WHERE  txt_solucao ILIKE :txtSistema
                    ';
            $statement = $this->getConnection()->prepare($sql) OR die(implode('', $this->getConnection()->errorInfo()));
            $statement->bindValue('txtSistema', $solucao, PDO::PARAM_STR);
            $statement->execute();

            return $statement->fetch(PDO::FETCH_COLUMN);

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

            $statement = $this->getConnection()->prepare($sql) OR die(implode('', $this->connection->errorInfo()));
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
            $statement = $this->getConnection()->prepare($sql) OR die(implode('', $this->connection->errorInfo()));

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