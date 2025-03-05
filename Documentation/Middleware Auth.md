### **Authentication Documentation**

Below are examples of how each of the key functions (`generateJwt`, `verifyJwt`, `verifyAuthHeader`, `generateSignature`, `verifySignature`, and `verifySignatureHeader`) can be used as middleware in your routing configuration. These methods provide various security features for JWT and cryptographic signature handling in your routes.

### **1. Using `generateJwt` in a Route Middleware**

The `generateJwt` method can be used to generate a JWT token, which is typically sent as a response after a successful authentication attempt. It can be added as middleware to ensure that a JWT is generated before returning the response to the client.

```php
$route->Group(prefix: "/auth", middlewares: [
    [
        'middleware' => 'Auth',
        'constructParams' => [SECRET_KEY_JWT],
        'function' => 'generateJwt',
        'params' => [['user_id' => 123, 'role' => 'admin'], 3600]
    ]
], callback: function() use ($route) {
    // After the middleware runs, this route will generate a JWT
    $route->Route(method: 'post', url: '/login', handler: 'AuthController::login');
});
```

- **`'middleware'`**: Specifies that the `Auth` middleware is used.
- **`'function'`**: Calls the `generateJwt` method.
- **`'params'`**: Passes the payload and expiration time as parameters for generating the JWT.

### **2. Using `verifyJwt` in a Route Middleware**

The `verifyJwt` method verifies the validity of a JWT. This is typically used in routes that require authentication. It checks if the JWT in the `Authorization` header is valid, and if not, returns an error.

```php
$route->Group(prefix: "/secure", middlewares: [
    [
        'middleware' => 'Auth',
        'constructParams' => [SECRET_KEY_JWT],
        'function' => 'verifyJwt',
        'params' => [$jwtToken]  // Example of passing the token
    ]
], callback: function() use ($route) {
    // This route requires a valid JWT to access
    $route->Route(method: 'get', url: '/profile', handler: 'UserController::profile');
});
```

- **`'middleware'`**: Specifies that the `Auth` middleware is used.
- **`'function'`**: Calls the `verifyJwt` method to verify the JWT.
- **`'params'`**: Passes the token (typically from the `Authorization` header) for verification.

### **3. Using `verifyAuthHeader` in a Route Middleware**

The `verifyAuthHeader` method checks the `Authorization` header for a Bearer token and verifies its validity. This middleware is used to secure routes that need to authenticate requests based on the `Authorization` header.

```php
$route->Group(prefix: "/user", middlewares: [
    [
        'middleware' => 'Auth',
        'constructParams' => [SECRET_KEY_JWT],
        'function' => 'verifyAuthHeader',
        'params' => []  // No parameters, as the token is fetched from the header
    ]
], callback: function() use ($route) {
    // This route requires the Authorization header to be valid
    $route->Route(method: 'get', url: '/details', handler: 'UserController::details');
});
```

- **`'middleware'`**: Specifies the `Auth` middleware.
- **`'function'`**: Calls the `verifyAuthHeader` method to verify the token from the `Authorization` header.

### **4. Using `generateSignature` in a Route Middleware**

The `generateSignature` method generates a cryptographic signature for the data and attaches it to the response header (`X-Signature`). This is typically used to sign responses before sending them to the client for data integrity and verification.

```php
$route->Group(prefix: "/data", middlewares: [
    [
        'middleware' => 'Auth',
        'constructParams' => [SECRET_KEY_JWT, SIGNATURE_PRIVATE_KEY],
        'function' => 'generateSignature',
        'params' => ['Sensitive data to sign']
    ]
], callback: function() use ($route) {
    // This route will include an X-Signature header for integrity checking
    $route->Route(method: 'get', url: '/export', handler: 'DataController::export');
});
```

- **`'middleware'`**: Specifies the `Auth` middleware.
- **`'function'`**: Calls the `generateSignature` method to sign the data.
- **`'params'`**: Passes the data that needs to be signed as a parameter.

### **5. Using `verifySignature` in a Route Middleware**

The `verifySignature` method verifies that the data's signature matches the expected signature. This middleware ensures that the signature in the request matches the data sent in the request body.

```php
$route->Group(prefix: "/verify", middlewares: [
    [
        'middleware' => 'Auth',
        'constructParams' => [SECRET_KEY_JWT, SIGNATURE_PUBLIC_KEY],
        'function' => 'verifySignature',
        'params' => ['Sensitive data', 'signature-from-request']
    ]
], callback: function() use ($route) {
    // This route ensures that the signature is valid before proceeding
    $route->Route(method: 'post', url: '/check', handler: 'VerifyController::checkSignature');
});
```

- **`'middleware'`**: Specifies the `Auth` middleware.
- **`'function'`**: Calls the `verifySignature` method to verify the signature.
- **`'params'`**: Passes the data and the signature to be verified.

### **6. Using `verifySignatureHeader` in a Route Middleware**

The `verifySignatureHeader` method checks the `X-Signature` header to ensure that the signature is valid. This method is typically used when you want to ensure that the incoming request body has not been tampered with by validating the signature.

```php
$route->Group(prefix: "/secure-data", middlewares: [
    [
        'middleware' => 'Auth',
        'constructParams' => [SECRET_KEY_JWT, SIGNATURE_PUBLIC_KEY],
        'function' => 'verifySignatureHeader',
        'params' => []  // No parameters needed, signature is retrieved from the header
    ]
], callback: function() use ($route) {
    // This route requires a valid X-Signature header to access the sensitive data
    $route->Route(method: 'get', url: '/fetch', handler: 'SecureDataController::fetch');
});
```

- **`'middleware'`**: Specifies the `Auth` middleware.
- **`'function'`**: Calls the `verifySignatureHeader` method to validate the signature from the header.

---

### **Summary of Middleware Usage in Routes**

- **JWT-related methods (`generateJwt`, `verifyJwt`, `verifyAuthHeader`)**: These methods are used for generating and verifying JWT tokens, which can be utilized for securing routes based on token-based authentication.
- **Signature-related methods (`generateSignature`, `verifySignature`, `verifySignatureHeader`)**: These methods ensure the integrity of the data in transit by generating and verifying cryptographic signatures in request and response headers.

In each case, the `Auth` middleware is added to the route, and the relevant method is specified to handle the task, either for signing, verifying, or generating security tokens or signatures.
