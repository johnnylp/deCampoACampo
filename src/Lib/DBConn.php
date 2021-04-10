<?php

namespace App\Lib;

use PDO;
use Slim\App;

class DBConn
{
    public static function StartUp()
    {
        require '../src/Config/env.php';

        $pdo = new PDO("mysql:host={$DB_HOST};dbname={$DB_NAME};", $DB_USER, $DB_PASS);


        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

        return $pdo;
    }
}