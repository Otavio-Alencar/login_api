<?php

namespace App\Controllers;
use App\Http\Request;
use App\Http\Response;
class NotFoundController
{
    public static function index(Request $request, Response $response){
        $response::json([
            'erro' => true,
            'success' => false,
            'message' => 'Desculpe, Rota não encontrada.'
        ],404);

        return;
    }
}