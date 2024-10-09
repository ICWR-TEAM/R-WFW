<?php

namespace App\Middleware;

class Auth
{
    private $secretKey;

    public function __construct($secretKey)
    {
        $this->secretKey = $secretKey;
    }

    public function generateJwt($payload, $expired = 3600): string
    {
        $exp = is_int(value: $expired) ? $expired : 3600;
        
        $header = json_encode(value: ['alg' => 'HS256', 'typ' => 'JWT']);
        $payload = json_encode(value: [
            'iat' => time(),
            'exp' => time() + $exp,
            'data' => $payload
        ]);

        $base64UrlHeader = $this->base64UrlEncode(data: $header);
        $base64UrlPayload = $this->base64UrlEncode(data: $payload);
        $signature = $this->base64UrlEncode(data: hash_hmac(algo: 'SHA256', data: "$base64UrlHeader.$base64UrlPayload", key: $this->secretKey, binary: true));

        return "$base64UrlHeader.$base64UrlPayload.$signature";
    }

    public function verifyJwt($token): array
    {
        $segments = explode(separator: '.', string: $token);
        if (count(value: $segments) !== 3) {
            return [
                "status" => "error",
                "code" => 400,
                "message" => "Token is valid."
            ];
        }

        list($base64UrlHeader, $base64UrlPayload, $signature) = $segments;
        $payload = $this->base64UrlDecode(data: $base64UrlPayload);

        if (isset($payload['exp']) && $payload['exp'] < time()) {
            return [
                "status" => "error",
                "code" => 401,
                "message" => "Token is expired."
            ];
        }

        $validSignature = $this->base64UrlEncode(data: hash_hmac(algo: 'SHA256', data: "$base64UrlHeader.$base64UrlPayload", key: $this->secretKey, binary: true));
        if ($validSignature !== $signature) {
            return [
                "status" => "error",
                "code" => 400,
                "message" => "Signature is valid."
            ];
        }

        return [
            "status" => "success",
            "code" => 200,
            "message" => "Token is valid.",
            "data" => $payload['data']
        ];
    }

    private function base64UrlEncode($data): string
    {
        return rtrim(string: strtr(string: base64_encode(string: $data), from: '+/', to: '-_'), characters: '=');
    }

    private function base64UrlDecode($data): mixed
    {
        $padding = strlen(string: $data) % 4;
        if ($padding > 0) {
            $data .= str_repeat(string: '=', times: 4 - $padding);
        }
        return json_decode(json: base64_decode(string: strtr(string: $data, from: '-_', to: '+/')), associative: true);
    }
}
