<?php

namespace App\Http;

class JWT
{
    private static string $secret = "secret_key";
    public static function generate(array $data = []){
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload = json_encode($data);

        $headerbase64 = self::base64url_encode($header);
        $payloadbase64 = self::base64url_encode($payload);
        $signature = self::signature($headerbase64, $payloadbase64);

        $jwt = $headerbase64 . '.' . $payloadbase64 . '.' . $signature;
        return $jwt;
    }
    public static function verify(string $jwt){
        $auth = explode('.', $jwt);
        if(count($auth) != 3) return false;
        [$header, $payload, $signature] = $auth;
        if($signature !== self::signature($header, $payload)) return false;
        return self::base64url_decode($payload);

    }
    public static function signature(string $header, string $payload){
        $signature = hash_hmac('sha256', $payload. '.'. $header,self::$secret, true);
        return self::base64url_encode($signature);
    }
    public static function base64url_encode($data) {

        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');

    }

    public static function base64url_decode($data)
    {
        $padding = strlen($data) % 4;

        $padding !== 0 && $data .= str_repeat('=', 4 -  $padding);

        $data = strtr($data, '-_', '+/');

        return json_decode(base64_decode($data), true);
    }
}