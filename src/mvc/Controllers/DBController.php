<?php

namespace App\Controllers;
use App\Http\Request;
use App\Http\Response;
use App\Models\Database;

class DBController extends Database
{

    public function newTable(Request $request, Response $response)
    {
        try {
            $table = self::createTable();
            if(isset($table['error'])){
                $response::json([
                    'error' => 'true',
                    'success' => false,
                    'message' => self::createTable()['error']
                ]);
                return;
            }

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
            $table = self::deleteTable();

            if(isset($table['error'])){
                $response::json([
                    'error' => 'true',
                    'success' => false,
                    'message' => self::deleteTable()['error']
                ]);
                return;
            }

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