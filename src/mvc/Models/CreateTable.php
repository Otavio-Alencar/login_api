<?php
namespace App\Model;
use App\Models\Database;
class CreateTable extends Database {
    public static function newTable(){
        $pdo = self::getConection();

        $stmt = $pdo->prepare("CREATE TABLE `login_system`.`users` (`id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(155) NOT NULL , `email` VARCHAR(255) NOT NULL , `password` VARCHAR(255) NOT NULL , PRIMARY KEY (`id`), UNIQUE (`email`)) ENGINE = InnoDB;");
        $stmt->execute();
    }
}