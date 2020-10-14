<?php
/**
 * Created by PhpStorm.
 * User: websis
 * Date: 06/10/20
 * Time: 15:31
 */

namespace App\database\models;

use App\database\Connection;
use PDO;

class Usuario extends Base
{
    protected $table = 'catalogodesempenho.tab_usuario';

    public function consultaEmailUsuario($email)
    {

        $sql = 'SELECT txt_nome
					FROM catalogodesempenho.tab_usuario
					WHERE txt_email LIKE :email';

        $statement = $this->connection()->prepare($sql);;

        $statement->bindValue('email', $email, PDO::PARAM_STR);

        return $statement->rowCount();

    }

    public function buscarUsuario($email)
    {

        try {
            $sql = 'SELECT cod_usuario, txt_nome, txt_email, txt_cpf_usuario
					FROM catalogodesempenho.tab_usuario
					WHERE txt_email LIKE :email';
            $statement = $this->getConnection()->prepare($sql);

            $statement->bindValue('email', $email, PDO::PARAM_STR);
            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_OBJ);
        } catch (\PDOException $exception) {
            return $exception->getMessage();
        }


    }

    public function getUsuarioId($id)
    {

        try {
            $sql = 'SELECT cod_usuario, txt_nome, txt_email, txt_cpf_usuario
					FROM catalogodesempenho.tab_usuario
					WHERE cod_usuario = :cod_usuario';
            $statement = $this->getConnection()->prepare($sql);

            $statement->bindValue('cod_usuario', $id, PDO::PARAM_STR);
            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_OBJ);
        } catch (\PDOException $exception) {
            return $exception->getMessage();
        }


    }


    public function verificaUsuario($email, $senha)
    {
        try {
            $usuario = '';

            $sql = "SELECT cod_usuario, 
                           txt_email, 
                           txt_nome, 
                           txt_senha,
                           cod_perfil_usuario
  	                FROM catalogodesempenho.tab_usuario
	                WHERE txt_email ILIKE '" . $email . "' AND txt_senha ILIKE '" . $senha . "' LIMIT 1";
            $statement = $this->getConnection()->prepare($sql);
            $statement->execute();
            $usuario = $statement->fetchAll(PDO::FETCH_ASSOC);

            return $usuario;

        } catch (\PDOException $exception) {
            return $exception->getMessage();
        }

    }
}