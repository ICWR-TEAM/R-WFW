<?php

namespace App\Middleware;

class Header
{
    private static $statusTexts = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Payload Too Large',
        414 => 'URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Range Not Satisfiable',
        417 => 'Expectation Failed',
        426 => 'Upgrade Required',
        451 => 'Unavailable For Legal Reasons',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
    ];

    public static function setStatusCode(int $statusCode): void
    {
        if (!array_key_exists(key: $statusCode, array: self::$statusTexts)) {
            $statusCode = 500;
        }
        header(header: "HTTP/1.1 $statusCode " . self::$statusTexts[$statusCode]);
    }

    public static function cors(array $methods, array $allowedOrigins, array $allowedHeaders): void
    {
        $currentMethod = strtoupper(string: $_SERVER['REQUEST_METHOD']);

        if (in_array(needle: $currentMethod, haystack: $methods)) {
            header(header: "Access-Control-Allow-Origin: " . implode(separator: ", ", array: $allowedOrigins));
            header(header: "Access-Control-Allow-Methods: " . implode(separator: ", ", array: $methods));
            header(header: "Access-Control-Allow-Headers: " . implode(separator: ", ", array: $allowedHeaders));
            header(header: "Access-Control-Allow-Credentials: true");

            if ($currentMethod === 'OPTIONS') {
                http_response_code(response_code: 204);
                exit;
            }
        }
    }

    public static function headerSet(array $headers): void
    {
        foreach($headers as $k => $v)
        {
            header(header: "$k: $v");
        }
    }
}
