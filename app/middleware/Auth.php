<?php

namespace App\Middleware;

use App\Middleware\Header;

class Auth
{
    private string $secretKey;
    private string $privateKey;
    private string $publicKey;

    public function __construct(string $secretKey, string $privateKeyPath = '', string $publicKeyPath = '')
    {
        $this->secretKey = $secretKey;

        if ($privateKeyPath) {
            $this->privateKey = file_get_contents(filename: $privateKeyPath);
        }

        if ($publicKeyPath) {
            $this->publicKey = file_get_contents(filename: $publicKeyPath);
        }
    }

    private function getAuthorizationHeaders(): string
    {
        if (function_exists(function: 'getallheaders')) {
            $headers = getallheaders();
            if (isset($headers['Authorization'])) {
                return $headers['Authorization'];
            }
        }
    
        if (isset($_SERVER['Authorization'])) {
            return $_SERVER['Authorization'];
        }
    
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            return $_SERVER['HTTP_AUTHORIZATION'];
        }
    
        if (function_exists(function: 'apache_request_headers')) {
            $apacheHeaders = apache_request_headers();
            if (isset($apacheHeaders['Authorization'])) {
                return $apacheHeaders['Authorization'];
            }
        }
    
        return false;
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

    public function generateJwtHeader(array $payload, int $expired = 3600, string $key = ''): void
    {
        $sKey = $key ? $key : $this->secretKey;
        $exp = is_int(value: $expired) ? $expired : 3600;
        $jwt = $this->generateJwt(payload: $payload, expired: $exp, key: $sKey);

        Header::headerSet(headers: ["Authorization" => "Bearer " . $jwt]);
    }

    public function verifyJwt(string $token, string $key = ''): array
    {

        $sKey = $key ? $key : $this->secretKey;
        $segments = explode(separator: '.', string: $token);

        if (count(value: $segments) !== 3) {
            Header::setStatusCode(statusCode: 400);
            Header::headerSet(headers: ["Content-Type" => "application/json"]);
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
            Header::headerSet(headers: ["Content-Type" => "application/json"]);
            return [
                "status" => "error",
                "code" => 401,
                "message" => "Token is expired."
            ];
        }

        $validSignature = $this->base64UrlEncode(data: hash_hmac(algo: 'SHA256', data: "$base64UrlHeader.$base64UrlPayload", key: $sKey, binary: true));

        if ($validSignature !== $signature) {
            Header::setStatusCode(statusCode: 400);
            Header::headerSet(headers: ["Content-Type" => "application/json"]);
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

    public function verifyAuthHeader(): void
    {
        $authHeader = $this->getAuthorizationHeaders();

        if ($authHeader) {

            if (preg_match(pattern: '/Bearer\s(\S+)/', subject: $authHeader, matches: $matches)) {
                $bearerToken = $matches[1];
                $resp = $this->verifyJwt(token: $bearerToken);
                if ($resp['code'] !== 200) {
                    echo json_encode(value: $resp);
                    exit();
                }
            } else {
                Header::setStatusCode(statusCode: 400);
                Header::headerSet(headers: ["Content-Type" => "application/json"]);
                echo json_encode(value: [
                    "status" => "400",
                    "message" => "Invalid Authorization header."
                ]);
                exit();
            }
        } else {
            Header::setStatusCode(statusCode: 400);
            Header::headerSet(headers: ["Content-Type" => "application/json"]);
            echo json_encode(value: [
                "status" => "400",
                "message" => "Missing Authorization header."
            ]);
            exit();
        }
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
            Header::headerSet(headers: ["Content-Type" => "application/json"]);
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
            Header::headerSet(headers: ["Content-Type" => "application/json"]);
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
