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



}