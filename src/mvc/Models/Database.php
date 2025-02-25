<?php

namespace App\Models;
use PDO;
use App\Http\Response;
class Database
{
    public static function tableExists()
    {
        try {
            $pdo = Database::getConection();
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = 'login_system' AND table_name = 'users'");
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function createTable(){
        $pdo = Database::getConection();

        $pdo->exec("USE login_system;");
        if (self::tableExists()) {
            return ['error' => 'A tabela já existe'];
        }


        $stmt = $pdo->prepare("CREATE TABLE IF NOT EXISTS `users` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `name` VARCHAR(155) NOT NULL,
                `email` VARCHAR(255) NOT NULL,
                `password` VARCHAR(255) NOT NULL,
                PRIMARY KEY (`id`),
                UNIQUE (`email`)
            ) ENGINE=InnoDB;");
        $stmt->execute();
    }
    public static function getConection(){
        $pdo = new PDO("mysql:dbname=login_system;host=db","user","root");
        return $pdo;
    }

    public static function deleteTable(){
        $pdo = self::getConection();


        if (!self::tableExists()) return ['error'=> 'A tabela não existe'];

        $stmt = $pdo->prepare("DROP TABLE IF EXISTS `users`;");
        $stmt->execute();
    }
}