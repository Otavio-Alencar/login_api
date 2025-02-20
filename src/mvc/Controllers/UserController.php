<?php

namespace App\Controllers;
use App\Http\Request;
use App\Http\Response;
use App\Models\Database;

class UserController
{
    public function index(Request $request,Response $response)
    {
        $response::json([
            "error" => false,
            "success" => true,
            "menssage" => "testando..."
        ],200);
        return;
    }
    public function fetch(Request $request, Response $response)
    {
        $response::json([
            "error" => false,
            "success" => true,
            "menssage" => "aqui estão seus usuarios..."
        ],200);
        return;
    }
    public static function create(){
        
    }
    public static function edit(){
        
    }
    public static function remove(){
        
    }




}