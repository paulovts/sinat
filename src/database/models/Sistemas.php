<?php
/**
 * Created by PhpStorm.
 * User: websis
 * Date: 08/10/20
 * Time: 09:30
 */

namespace App\database\models;
use PDO;


class Sistemas extends Base
{
    protected $table = 'catalogodesempenho.opc_sistema';

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