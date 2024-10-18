<?php

namespace App\Middleware;

class Auth
{
    private $secretKey;

    public function __construct(string $secretKey)
    {
        $this->secretKey = $secretKey;
    }

    public function generateJwt(array $payload, int $expired = 3600, string $key = ''): string
    {

        $sKey = $key ? $key : $this->secretKey;

        $exp = is_int(value: $expired) ? $expired : 3600;
        
        $header = json_encode(value: ['alg' => 'HS256', 'typ' => 'JWT']);
        $payload = json_encode(value: [
            'iat' => time(),
            'exp' => time() + $exp,
            'data' => $payload
        ]);

        $base64UrlHeader = $this->base64UrlEncode(data: $header);
        $base64UrlPayload = $this->base64UrlEncode(data: $payload);
        $signature = $this->base64UrlEncode(data: hash_hmac(algo: 'SHA256', data: "$base64UrlHeader.$base64UrlPayload", key: $sKey, binary: true));

        return "$base64UrlHeader.$base64UrlPayload.$signature";
    }

    public function verifyJwt(string $token, string $key = ''): array
    {

        $sKey = $key ? $key : $this->secretKey;

        $segments = explode(separator: '.', string: $token);
        if (count(value: $segments) !== 3) {

            header(header: "HTTP/1.1 400 Bad Request");

            return [
                "status" => "error",
                "code" => 400,
                "message" => "Token is invalid."
            ];
        }

        list($base64UrlHeader, $base64UrlPayload, $signature) = $segments;
        $payload = $this->base64UrlDecode(data: $base64UrlPayload);

        if (isset($payload['exp']) && $payload['exp'] < time()) {

            header(header: "HTTP/1.1 401 Unauthorized");

            return [
                "status" => "error",
                "code" => 401,
                "message" => "Token is expired."
            ];
        }

        $validSignature = $this->base64UrlEncode(data: hash_hmac(algo: 'SHA256', data: "$base64UrlHeader.$base64UrlPayload", key: $sKey, binary: true));
        if ($validSignature !== $signature) {

            header(header: "HTTP/1.1 400 Bad Request");

            return [
                "status" => "error",
                "code" => 400,
                "message" => "Signature is invalid."
            ];
        }

        header(header: "HTTP/1.1 200 OK");

        return [
            "status" => "success",
            "code" => 200,
            "message" => "Token is valid.",
            "data" => $payload['data']
        ];
    }

    private function base64UrlEncode(string $data): string
    {
        return rtrim(string: strtr(string: base64_encode(string: $data), from: '+/', to: '-_'), characters: '=');
    }

    private function base64UrlDecode(string $data): mixed
    {
        $padding = strlen(string: $data) % 4;
        if ($padding > 0) {
            $data .= str_repeat(string: '=', times: 4 - $padding);
        }
        return json_decode(json: base64_decode(string: strtr(string: $data, from: '-_', to: '+/')), associative: true);
    }
}
