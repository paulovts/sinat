<?php
/**
 * Created by PhpStorm.
 * User: websis
 * Date: 06/10/20
 * Time: 15:38
 */

namespace App\database\models;

use App\database\Connection;
use PDO;

abstract class Base
{

    protected static $connection;

    protected function getConnection()
    {

        if (!self::$connection) {
            self::$connection = Connection::connection();
        }

        return self::$connection;
    }
}