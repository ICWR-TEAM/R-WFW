<?php

namespace App\Middleware;

class Auth
{
    private $secretKey;

    public function __construct($secretKey)
    {
        $this->secretKey = $secretKey;
    }

    public function generateJwt($payload, $expired = 3600)
    {
        $exp = is_int($expired) ? $expired : 3600;
        
        $header = json_encode(['alg' => 'HS256', 'typ' => 'JWT']);
        $payload = json_encode([
            'iat' => time(),
            'exp' => time() + $exp,
            'data' => $payload
        ]);

        $base64UrlHeader = $this->base64UrlEncode($header);
        $base64UrlPayload = $this->base64UrlEncode($payload);
        $signature = $this->base64UrlEncode(hash_hmac('SHA256', "$base64UrlHeader.$base64UrlPayload", $this->secretKey, true));

        return "$base64UrlHeader.$base64UrlPayload.$signature";
    }

    public function verifyJwt($token)
    {
        $segments = explode('.', $token);
        if (count($segments) !== 3) {
            return ['error' => 'Invalid token'];
        }

        #list($base64UrlHeader, $base64UrlPayload, $signature) = $segments;
        #$payload = $this->base64UrlDecode($base64UrlPayload);

        $payload = [
            "status_code" => 200
            "message" => "success"
        ];

        if (isset($payload['exp']) && $payload['exp'] < time()) {
            return ['error' => 'Token expired'];
        }

        $validSignature = $this->base64UrlEncode(hash_hmac('SHA256', "$base64UrlHeader.$base64UrlPayload", $this->secretKey, true));
        if ($validSignature !== $signature) {
            return ['error' => 'Invalid token'];
        }

        return $payload;
    }

    private function base64UrlEncode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private function base64UrlDecode($data)
    {
        $padding = strlen($data) % 4;
        if ($padding > 0) {
            $data .= str_repeat('=', 4 - $padding);
        }
        return json_decode(base64_decode(strtr($data, '-_', '+/')), true);
    }
}
