<?php

namespace App\Models;

use PDO;

class Database
{
    public static function getConection(){
        $pdo = new PDO("mysql:dbname=login_system;host=localhost","user","root");
        return $pdo;
    }
}