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
        $authorization = $request::authorization();
        $userService  = UserService::fetch($authorization);

        if (isset($userService['unauthorized'])) {
            $response::json([
                'error'   => true,
                'success' => false,
                'message' => $userService['unauthorized']
            ], 401);
            return;
        }
        if(isset($userService['error'])){
            $response::json([
                "error" => true,
                "success" => false,
                "menssage" => $userService['error'],
            ],400);
            return;
        }
        $response::json([
            "data" => $userService,
            "success" => true,
            "error" => false,
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
        if(isset($userservice['error'])){
            $response::json([
                "error" => true,
                "success" => false,
                "menssage" => $userservice['error'],
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
    public static function update(Request $request, Response $response){
        $body = $request::body();
        $authorization = $request::authorization();
        $userService = UserService::update($authorization,$body);

        if (isset($userService['unauthorized'])) {
            $response::json([
                'error'   => true,
                'success' => false,
                'message' => $userService['unauthorized']
            ], 401);
            return;
        }
        if(isset($userService['error'])){
            $response::json([
                "error" => true,
                "success" => false,
                "menssage" => $userService['error'],
            ],400);
            return;
        }
        $response::json([
            "menssage" => $userService,
            "success" => true,
            "error" => false,
        ],200);
        return;
    }
    public static function remove(){
        
    }




}