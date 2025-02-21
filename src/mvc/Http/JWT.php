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
    public static function signature(string $header, string $payload){
        $signature = hash_hmac('sha256', $payload. '.'. $header,self::$secret, true);
        return self::base64url_encode($signature);
    }
    public static function base64url_encode($data) {

        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');

    }

    public static function base64url_decode($data) {

        return json_decode(base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT)));

    }
}