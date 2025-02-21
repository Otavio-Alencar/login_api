<?php

namespace App\Services;
use App\Http\Request;
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

    public static function fetch(mixed $authorization){
        try{
            if(isset($authorization['error'])){
                return ['unauthorized' => $authorization['error']];
            }

            $userfromJWT = JWT::verify($authorization);

            if(!$userfromJWT) return ['unauthorized' => 'Não encontramos este usuário'];

            $user = User::getUserById($userfromJWT['id']);
            if(!$user) return ['error' => 'Não encontramos este usuário'];

            return $user;
        }catch(\PDOException $e){
            if($e->errorInfo[0] === 'HY000') return ['error'=>'Houve algum problema na conexão com o banco de dados.'];
            return ['error' => $e->errorInfo[0]];
        }catch (\Exception $e){
            return ['error'=> $e->getMessage()];
        }
    }

    public static function update(mixed $authorization,array $data){
        try {
            if (isset($authorization['error'])) {
                return ['unauthorized'=> $authorization['error']];
            }

            $userFromJWT = JWT::verify($authorization);

            if (!$userFromJWT) return ['unauthorized' => 'Não encontramos este usuário'];

            $fields = Validator::validateUser([
                'name' => $data['name'] ?? ''
            ]);

            $user = User::edit($fields,$userFromJWT['id']);

            if (!$user) return ['error'=> 'Desculpe, não foi possível atualizar sua conta.'];

            return "Usuário atualizado com sucesso!";
        }
        catch (PDOException $e) {
            if ($e->errorInfo[0] === '08006') return ['error' => 'Sorry, we could not connect to the database.'];
            return ['error' => $e->getMessage()];
        }
        catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public static function delete(mixed $authorization){
        try {
            if (isset($authorization['error'])) {
                return ['unauthorized'=> $authorization['error']];
            }

            $userFromJWT = JWT::verify($authorization);

            if (!$userFromJWT) return ['unauthorized' => 'Não encontramos este usuário'];



            $user = User::remove($userFromJWT['id']);

            if (!$user) return ['error'=> 'Desculpe, não foi possível remover sua conta.'];

            return "Usuário excluido com sucesso!";
        }
        catch (PDOException $e) {
            if ($e->errorInfo[0] === '08006') return ['error' => 'Sorry, we could not connect to the database.'];
            return ['error' => $e->getMessage()];
        }
        catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }


}
