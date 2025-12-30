# **Middleware Documentation**  

## **Overview**  

The `Auth` middleware provides authentication and security for API routes using **JWT verification** and **cryptographic signatures**. It ensures that requests are properly authenticated and prevents unauthorized access.  

---

## **1. Middleware Class: `generateSignature`**  

### **Namespace**  
```php
namespace App\Middleware;
```  

### **Function Overview**  
The `generateSignature` function generates a cryptographic signature for a given data string using a private key. This signature is added to the response header (`X-Signature`) for validation.  

### **Method: `generateSignature`**  

#### **Description**  
- Creates a SHA256 digital signature using a private key.  
- Ensures that the data remains authentic and unaltered.  
- The signature is included in the response header (`X-Signature`).  

#### **Parameters**  

| Parameter  | Type   | Description |
|------------|--------|-------------|
| `data`    | `string` | The data to be signed (typically a string) |

#### **Returns**  
- `string`: The base64 URL-encoded signature.  

#### **Example Usage in Middleware**  
```php
public function generateSignature(string $data): string
{
    openssl_sign($data, $signature, $this->privateKey, OPENSSL_ALGO_SHA256);
    $encodedSignature = $this->base64UrlEncode($signature);
    header("X-Signature: " . $encodedSignature);
    return $encodedSignature;
}
```

---

## **2. Middleware Class: `verifyAuthHeader`**  

### **Function Overview**  
The `verifyAuthHeader` function extracts and validates the **JWT token** from the `Authorization` header. It ensures that only authenticated requests are processed.  

### **Method: `verifyAuthHeader`**  

#### **Description**  
- Extracts the `Authorization` header from the request.  
- Validates the JWT token using the `verifyJwt` function.  
- If the token is invalid, it returns an error response.  
- If the `Authorization` header is missing, it returns a `400 Bad Request` response.  

#### **Example Usage in Middleware**  
```php
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
```

---

## **3. Middleware Usage in Routing**  

Middleware functions like `generateSignature` and `verifyAuthHeader` can be applied in route definitions to secure API endpoints.  

### **Example Route with `generateSignature` Middleware**  
```php
$route->Group(prefix: "/test", middlewares: [
    [
        'middleware' => 'Auth',
        'constructParams' => [SECRET_KEY_JWT, SIGNATURE_PRIVATE_KEY, SIGNATURE_PUBLIC_KEY],
        'function' => 'generateSignature',
        'params' => ["Hello World"]
    ]
], callback: function() use ($route) {
    $route->Route(method: 'get', url: '/group', handler: 'About::index');
});
```
This configuration ensures that the `generateSignature` function runs before accessing `/test/group`. The response will include an `X-Signature` header containing the cryptographic signature.  

---

### **Example Route with `verifyAuthHeader` Middleware**  
```php
$route->Route(method: 'get', url: '/example', handler: "Example::index", middlewares: [
    [
        'middleware' => 'Auth',
        'constructParams' => [SECRET_KEY_JWT],
        'function' => 'verifyAuthHeader',
        'params' => []
    ]
]);
```
This configuration ensures that the `verifyAuthHeader` function checks for a valid JWT token before allowing access to `/example`. If the token is missing or invalid, the request is denied.  

---

## **4. Conclusion**  

- `generateSignature` ensures that responses include a cryptographic signature for verification.  
- `verifyAuthHeader` enforces JWT authentication, preventing unauthorized access.  
- Middleware can be applied to secure API routes and validate requests before processing.  
- These functions provide a secure and scalable authentication system.
