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
            static::$pdo = new PDO('pgsql:host=192.168.10.113;port=5432;dbname=sinat', 'postgres', 'pg01', [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            ]);
            return static::$pdo;
        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }
}