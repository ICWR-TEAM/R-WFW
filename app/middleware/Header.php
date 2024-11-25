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
        // Get the current request method
        $currentMethod = strtoupper($_SERVER['REQUEST_METHOD']);

        // Get the Origin header from the request
        $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';

        // Check if the current method is in the allowed methods list
        if (in_array($currentMethod, $methods)) {

            // Check if the request's origin is allowed
            if (in_array($origin, $allowedOrigins)) {
                // Set the Access-Control-Allow-Origin header (can be a list of origins)
                header("Access-Control-Allow-Origin: $origin");
            } else {
                // If the origin is not allowed, we can either not send the CORS headers, or block it
                header("Access-Control-Allow-Origin: null"); // or handle as per your business needs
            }

            // Set the Access-Control-Allow-Methods header (can be a list of allowed methods)
            header("Access-Control-Allow-Methods: " . implode(", ", $methods));

            // Set the Access-Control-Allow-Headers header (can be a list of allowed headers)
            header("Access-Control-Allow-Headers: " . implode(", ", $allowedHeaders));

            // Allow credentials (cookies, HTTP authentication, etc.)
            header("Access-Control-Allow-Credentials: true");

            // Handle preflight request (OPTIONS)
            if ($currentMethod === 'OPTIONS') {
                // If the method is OPTIONS, return a 204 No Content response and stop further execution
                http_response_code(204);
                exit;  // Important to stop execution after OPTIONS request
            }
        }
    }
}
