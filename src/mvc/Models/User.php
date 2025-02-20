<?php

namespace App\Models;
use App\Models\Database;
class User extends Database{
    public static function post(array $data){
        $pdo = self::getConection();
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");

        $stmt->execute([$data['name'], $data['email'], $data['password']]);

        return $pdo->lastInsertId() > 0 ? true : false;
    }
}