<?php

namespace App\Utils;



class Validator
{
    public static function validateUser(array $fields){
        foreach($fields as $field => $value ){
            if(empty(trim($value))){
                throw new \Exception("É necessário preencher o campo $field");
            }
        }

        return $fields;
    }

}
