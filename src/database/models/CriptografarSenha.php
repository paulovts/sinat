<?php
/**
 * Created by PhpStorm.
 * User: websis
 * Date: 06/10/20
 * Time: 17:13
 */

namespace App\database\models;


class CriptografarSenha
{
    public function setCriptografarSenha($senha)
    {
        $senhaCriptografada = md5(hash('whirlpool', hash('sha256', hash('whirlpool', $senha))));
        return $senhaCriptografada;

    }
}