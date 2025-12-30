## **Header Middleware Usage**

### **1. Using `setStatusCode` in a Route**

Sets the HTTP status code for a route.

```php
$route->Group(prefix: "/error-page", middlewares: [
    [
        'middleware' => 'Header',
        'constructParams' => [],
        'function' => 'setStatusCode',
        'params' => [404]  // Set status code to 404
    ]
], callback: function() use ($route) {
    $route->Route(method: 'get', url: '/not-found', handler: 'ErrorController::notFound');
});
```

### **2. Using `cors` in a Route**

Sets CORS headers for cross-origin requests.

```php
$route->Group(prefix: "/api", middlewares: [
    [
        'middleware' => 'Header',
        'constructParams' => [],
        'function' => 'cors',
        'params' => [
            ['GET', 'POST'],  // Allowed HTTP methods
            ['https://example.com', 'https://anotherdomain.com'],  // Allowed origins
            ['Content-Type', 'Authorization']  // Allowed headers
        ]
    ]
], callback: function() use ($route) {
    $route->Route(method: 'get', url: '/data', handler: 'ApiController::getData');
});
```

### **3. Combining `setStatusCode` and `cors` in a Route**

Combines setting the status code and handling CORS headers for a route.

```php
$route->Group(prefix: "/secure-api", middlewares: [
    [
        'middleware' => 'Header',
        'constructParams' => [],
        'function' => 'setStatusCode',
        'params' => [200]  // Set status code to 200 (OK)
    ],
    [
        'middleware' => 'Header',
        'constructParams' => [],
        'function' => 'cors',
        'params' => [
            ['GET', 'POST'],  // Allowed HTTP methods
            ['https://trusted.com'],  // Allowed origins
            ['Content-Type', 'Authorization']  // Allowed headers
        ]
    ]
], callback: function() use ($route) {
    $route->Route(method: 'get', url: '/protected', handler: 'SecureController::protectedData');
});
```
