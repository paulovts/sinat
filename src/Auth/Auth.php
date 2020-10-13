<?php
/**
 * Created by PhpStorm.
 * User: websis
 * Date: 09/10/20
 * Time: 12:17
 */

namespace App\Auth;


use App\database\models\CriptografarSenha;
use App\database\models\Usuario;

class Auth
{

    protected $usuario;

    public function __construct()
    {
        $this->usuario = new Usuario();
    }

    public function attempt($email, $senha)
    {

        $encript = new CriptografarSenha();

        $senhaencript = $encript->setCriptografarSenha($senha);

        $usuario = [];

        $retorno = $this->usuario->verificaUsuario($email, $senhaencript);

        foreach ($retorno as $user) {
            $usuario = [
                'cod_usuario' => $user['cod_usuario'],
                'txt_email' => $user['txt_email'],
                'txt_nome' => $user['txt_nome'],
                'cod_perfil_usuario' => $user['cod_perfil_usuario'],
            ];
        }

        if ($usuario) {
            $_SESSION['txt_email'] = $usuario['txt_email'];
            $_SESSION['txt_nome'] = $usuario['txt_nome'];
            $_SESSION['cod_usuario'] = $usuario['cod_usuario'];
            $_SESSION['cod_perfil_usuario'] = $usuario['cod_perfil_usuario'];
            return true;
        } else {
            return false;
        }

    }

    public function check()
    {
        return isset($_SESSION['cod_usuario']);
    }

    public function getUsuario()
    {
        return $this->usuario->getUsuarioId($_SESSION['cod_usuario']);
    }

    public function logout()
    {
        unset($_SESSION['txt_email']);
        unset($_SESSION['txt_nome']);
        unset($_SESSION['cod_usuario']);
        unset($_SESSION['cod_perfil_usuario']);

    }
}