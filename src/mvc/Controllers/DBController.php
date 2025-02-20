<?php

namespace App\Controllers;
use App\Http\Request;
use App\Http\Response;
use App\Models\Database;

class DBController extends Database
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
    public function newTable(Request $request, Response $response)
    {
        try {
            $pdo = Database::getConection();

            $pdo->exec("USE login_system;");
            if (self::tableExists()) {
                 $response::json([
                    'error' => true,
                    'success' => false,
                    'message' => 'A tabela já existe.'
                ], 409);
                 return;
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

            if (self::tableExists()) {
                $response::json([
                    'error' => false,
                    'success' => true,
                    'message' => 'Tabela criada com sucesso!'
                ], 201);
                return;
            }

            $response::json([
                'error' => true,
                'success' => false,
                'message' => 'Houve um erro ao criar a tabela.'
            ], 500);
            return;
        } catch (PDOException $e) {
             $response::json([
                'error' => true,
                'success' => false,
                'message' => 'Erro no banco de dados: ' . $e->getMessage()
            ], 500);
             return;
        }
    }

    public function removeTable(Request $request, Response $response)
    {
        try {
            $pdo = Database::getConection();


            if (!self::tableExists()) {
                $response::json([
                    'error' => true,
                    'success' => false,
                    'message' => 'A tabela não existe.'
                ], 404);
                return;
            }


            $stmt = $pdo->prepare("DROP TABLE IF EXISTS `users`;");
            $stmt->execute();


            if (!self::tableExists()) {
                $response::json([
                    'error' => false,
                    'success' => true,
                    'message' => 'Tabela excluída com sucesso.'
                ], 200);
                return;
            }

            $response::json([
                'error' => true,
                'success' => false,
                'message' => 'Ocorreu um erro ao tentar excluir a tabela.'
            ], 500);
            return;
        } catch (PDOException $e) {
             $response::json([
                'error' => true,
                'success' => false,
                'message' => 'Erro no banco de dados: ' . $e->getMessage()
            ], 500);
             return;
        }
    }
}