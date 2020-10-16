<?php
/**
 * Created by PhpStorm.
 * User: websis
 * Date: 15/10/20
 * Time: 18:09
 */

namespace App\database\models;
use PDO;

class TipoSolucao extends Base
{

    public function getTipoSolucaoById($params)
    {
        try {
            $resultado = '';

            $sql = 'SELECT json_agg(tiposolucao) as txt_json
                   FROM (SELECT
                   catalogodesempenho.opc_tipo_solucao.cod_tipo_solucao,
                   catalogodesempenho.opc_tipo_solucao.txt_tipo_solucao,
                   catalogodesempenho.opc_tipo_solucao.txt_descricao_tipo_solucao
                  FROM
                    catalogodesempenho.opc_tipo_solucao
                  GROUP BY
                    opc_tipo_solucao.cod_tipo_solucao, opc_tipo_solucao.txt_tipo_solucao, opc_tipo_solucao.txt_descricao_tipo_solucao
                  HAVING opc_tipo_solucao.cod_solucao = :cod_solucao) AS tiposolucao';

            $statement = $this->getConnection()->prepare($sql) OR die(implode('', $this->getConnection()->errorInfo()));
            $statement->bindValue('cod_solucao', $params['id'], PDO::PARAM_STR);
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