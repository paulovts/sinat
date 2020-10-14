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
//        $sql = "INSERT INTO seguranca.estatistica
//              (mnuid,usucpf,esttempoexec,estsession,sisid,estmemusa)
//            VALUES
//              ('{$mnuid}', '{$_SESSION['usucpforigem']}', {$tFim},'{$sessionId}', {$sisid}, '{$memoryUsage}')";
    }
}