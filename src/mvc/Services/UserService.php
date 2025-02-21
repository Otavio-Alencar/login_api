<?php

namespace App\Services;
use App\Utils\Validator;
use App\Models\User;
use App\Http\JWT;

class UserService
{
    public static function createUser(array $data){
        try{
            $fields = Validator::validateUser([
                'name' =>$data['name'] ?? '',
                'email' => $data['email'] ?? '',
                'password' => $data['password'] ?? '',
            ]);
            $fields['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            $user = User::post($fields);
            if(!$user) return ['error' => 'Não conseguimos cadastrar o usuário'];

            return 'Usuário cadastrado com sucesso!';
        }catch(\PDOException $e){
            if($e->errorInfo[0] === '23000') return ['error'=>'Esse email já foi cadastrado.'];
            if($e->errorInfo[0] === 'HY000') return ['error'=>'Houve algum problema na conexão com o banco de dados.'];
            return ['error' => $e->errorInfo[0]];
        }
        catch (\Exception $e){
            return ['error'=> $e->getMessage()];
        }
    }

    public static function auth(array $data){
        try{
            $fields = Validator::validateUser([
                'email' => $data['email'] ?? '',
                'password' => $data['password'] ?? '',
            ]);

            $user = User::authenticate($fields);
            if(!$user) return ['error'=> 'Houve algum erro de autenticação.'];

            return JWT::generate($user);
        }catch(\PDOException $e){
            if($e->errorInfo[0] === 'HY000') return ['error'=>'Houve algum problema na conexão com o banco de dados.'];
            return ['error' => $e->errorInfo[0]];
        }catch (\Exception $e){
            return ['error'=> $e->getMessage()];
        }

    }


}
