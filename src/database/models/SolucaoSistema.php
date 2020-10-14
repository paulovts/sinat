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
}