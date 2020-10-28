<?php
/**
 * Created by PhpStorm.
 * User: websis
 * Date: 06/10/20
 * Time: 15:23
 */

namespace App\database;

use PDO;
use PDOException;


abstract class Connection
{

    public static $pdo;

    public static function connection()
    {

        if (static::$pdo) {
            return static::$pdo;
        }
        try {
            // Capturando a configuração do banco
            $settings = require(__DIR__ . '/../../config/database.php');

            static::$pdo = new PDO(
                $settings[APP_ENV]['db']['dsn'],
                $settings[APP_ENV]['db']['username'],
                $settings[APP_ENV]['db']['password'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                ]
            );
            return static::$pdo;
        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }
}