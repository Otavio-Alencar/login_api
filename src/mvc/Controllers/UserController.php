<?php

namespace App\Controllers;
use App\Http\Request;
use App\Http\Response;
use App\Models\Database;
use App\Models\User;
use App\Services\UserService;
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
    public static function store(Request $request, Response $response){
        $body = $request::body();
        $user = UserService::createUser($body);
        if(isset($user['error'])){
            $response::json([
                "error" => true,
                "success" => false,
                "menssage" => $user,
            ],400);
            return;
        }

        $response::json([
            "error" => false,
            "success" => true,
            "data" => $user
        ],201);
        return;


    }
    public static function login(Request $request, Response $response){
        $body = $request::body();
        $userservice =  UserService::auth($body);
        if(isset($user['error'])){
            $response::json([
                "error" => true,
                "success" => false,
                "menssage" => $user,
            ],400);
            return;
        }

        $response::json([
            "error" => false,
            "success" => true,
            "jwt" => $userservice
        ],200);
        return;

    }
    public static function edit(){
        
    }
    public static function remove(){
        
    }




}