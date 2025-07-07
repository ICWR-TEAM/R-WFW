<?php

namespace App\Core;

use App\Middleware\Header;

class Authentication
{

    private string $secretKey;
    private string $privateKey;
    private string $publicKey;

    public function __construct(string $secretKey = SECRET_KEY_JWT, string $privateKeyPath = SIGNATURE_PRIVATE_KEY, string $publicKeyPath = SIGNATURE_PUBLIC_KEY)
    {
        $this->secretKey = $secretKey;

        if ($privateKeyPath) {
            $this->privateKey = file_get_contents(filename: $privateKeyPath);
        }

        if ($publicKeyPath) {
            $this->publicKey = file_get_contents(filename: $publicKeyPath);
        }
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
            Header::setStatusCode(statusCode: 400);
            return [
                "status" => "error",
                "code" => 400,
                "message" => "Token is invalid."
            ];
        }

        list($base64UrlHeader, $base64UrlPayload, $signature) = $segments;
        $payload = $this->base64UrlDecodeJson(data: $base64UrlPayload);

        if (isset($payload['exp']) && $payload['exp'] < time()) {
            Header::setStatusCode(statusCode: 401);
            return [
                "status" => "error",
                "code" => 401,
                "message" => "Token is expired."
            ];
        }

        $validSignature = $this->base64UrlEncode(data: hash_hmac(algo: 'SHA256', data: "$base64UrlHeader.$base64UrlPayload", key: $sKey, binary: true));

        if ($validSignature !== $signature) {
            Header::setStatusCode(statusCode: 400);
            return [
                "status" => "error",
                "code" => 400,
                "message" => "Signature is invalid."
            ];
        }

        Header::setStatusCode(statusCode: 200);
        return [
            "status" => "success",
            "code" => 200,
            "message" => "Token is valid.",
            "data" => $payload['data']
        ];
    }

    public function getCurrentUser(): mixed
    {
        if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
            return null;
        }
    
        if (!preg_match(pattern: '/Bearer\s(\S+)/', subject: $_SERVER['HTTP_AUTHORIZATION'], matches: $matches)) {
            return null;
        }
    
        $token = $matches[1];
        $result = $this->verifyJwt($token);
    
        if ($result['status'] === 'success' && isset($result['data'])) {
            return $result['data'];
        }
    
        return null;
    }

    public function verifyAuthHeader(): array
    {
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $authHeader = $_SERVER['HTTP_AUTHORIZATION'];

            if (preg_match(pattern: '/Bearer\s(\S+)/', subject: $authHeader, matches: $matches)) {
                $bearerToken = $matches[1];
                return $this->verifyJwt(token: $bearerToken);
            }
        }

        return [
            "status" => "500",
            "message" => "error"
        ];
    }

    public function generateSignature(string $data): string
    {
        openssl_sign(data: $data, signature: $signature, private_key: $this->privateKey, algorithm: OPENSSL_ALGO_SHA256);
        $encodedSignature = $this->base64UrlEncode(data: $signature);
        header(header: "X-Signature: " . $encodedSignature);
        return $encodedSignature;
    }


    public function verifySignature(string $data, string $signature): bool
    {
        $decodedSignature = $this->base64UrlDecode(data: $signature);
    
        if (!$decodedSignature) {
            return false;
        }

        $result = openssl_verify(data: $data, signature: $decodedSignature, public_key: $this->publicKey, algorithm: OPENSSL_ALGO_SHA256);
        
        return $result === 1;
    }

    public function verifySignatureHeader(): void
    {
        $receivedSignature = $_SERVER['HTTP_X_SIGNATURE'] ?? '';
        $requestBody = file_get_contents(filename: 'php://input');

        if (!$receivedSignature) {
            Header::setStatusCode(statusCode: 400);
            echo json_encode(value: [
                "status" => "error",
                "code" => 400,
                "message" => "Missing X-Signature header."
            ]);
            exit();
        }

        $isValid = $this->verifySignature(data: $requestBody, signature: $receivedSignature);

        if (!$isValid) {
            Header::setStatusCode(statusCode: 403);
            echo json_encode(value: [
                "status" => "error",
                "code" => 403,
                "message" => "Invalid Signature."
            ]);
            exit();
        }
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

        return base64_decode(string: strtr(string: $data, from: '-_', to: '+/'));
    }

    private function base64UrlDecodeJson(string $data): mixed
    {
        $padding = strlen(string: $data) % 4;

        if ($padding > 0) {
            $data .= str_repeat(string: '=', times: 4 - $padding);
        }

        return json_decode(json: base64_decode(string: strtr(string: $data, from: '-_', to: '+/')), associative: true);
    }
}
