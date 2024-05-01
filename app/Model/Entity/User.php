<?php

namespace App\Model\Entity;

use WilliamCosta\DatabaseManager\Database;

class User
{
    public int $id;
    public string $nome;
    public string $email;
    public string $senha;


    /**
     * MÉTODO RESPONSÁVEL POR RETORNAR UM USUÁRIO COM BASE EM SEU E-MAIL
     * @param string $email
     * $return User
     */
    public static function getUserByEmail($email)
    {
        return (new Database('usuarios'))->select('email = "'.$email.'"')->fetchObject(self::class);
    }

}
