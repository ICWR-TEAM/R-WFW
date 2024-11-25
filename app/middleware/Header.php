<?php

namespace App\Middleware;

class Header
{
    /**
     * Adds CORS headers based on the incoming request.
     * 
     * @param array $methods List of allowed HTTP methods (e.g., GET, POST, PUT).
     * @param array $allowedOrigins List of allowed origins (e.g., ['https://example.com', 'https://another-domain.com']).
     * @param array $allowedHeaders List of allowed headers (e.g., ['Content-Type', 'Authorization', 'X-Requested-With']).
     * @return void
     */
    public function cors(array $methods, array $allowedOrigins, array $allowedHeaders): void
    {
        $currentMethod = strtoupper(string: $_SERVER['REQUEST_METHOD']);
        $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';


        if (in_array(needle: $currentMethod, haystack: $methods)) {

            if (in_array(needle: $origin, haystack: $allowedOrigins)) {
                header(header: "Access-Control-Allow-Origin: $origin");
            } else {
                header(header: "Access-Control-Allow-Origin: null");
            }
            header(header: "Access-Control-Allow-Methods: " . implode(separator: ", ", array: $methods));
            header(header: "Access-Control-Allow-Headers: " . implode(separator: ", ", array: $allowedHeaders));
            header(header: "Access-Control-Allow-Credentials: true");

            if ($currentMethod === 'OPTIONS') {
                http_response_code(response_code: 204);
                exit;
            }
        }
    }
}
