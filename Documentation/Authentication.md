# **Authentication Usage Documentation**

### **1. Using JWT Authentication**

**1.1. Generating a JWT Token**

To generate a JWT token, you simply call the `generateJwt` method with the appropriate payload. 

**Example Usage in Model:**

```php
namespace App\Models;

class LoginModel
{
    public function index(array $parameters): string
    {
        // Validate username and password
        if (!isset($parameters['username']) || !isset($parameters['password'])) {
            return json_encode([
                "status" => "error",
                "code" => 400,
                "message" => "Username and password are required."
            ]);
        }

        // Payload data to be stored in the token
        $payload = [
            'username' => $parameters['username'],
            'role' => 'user',
            'last_login' => time(),
        ];

        // Generate JWT token
        $output = $this->authentication->generateJwt(payload: $payload);

        return json_encode([
            "status" => "success",
            "code" => 200,
            "message" => "JWT token generated successfully.",
            "data" => $output
        ]);
    }
}
```

In this example, `LoginModel::index()` validates the `username` and `password` parameters, then generates a JWT token based on the provided payload.

**1.2. Verifying a JWT Token**

To verify the validity of a JWT token, you can simply call the `verifyJwt` method.

**Example Usage in Middleware:**

```php
namespace App\Middleware;

class AuthMiddleware
{
    public function handle()
    {
        // Verify the JWT token from the Authorization header
        $authResponse = $this->authentication->verifyAuthHeader();

        if ($authResponse['status'] !== 'success') {
            // If token is invalid
            echo json_encode($authResponse);
            exit();
        }
    }
}
```

Here, `AuthMiddleware::handle()` calls `verifyAuthHeader()`, which verifies whether the JWT token in the header is valid.

---

### **2. Using Signature-Based Authentication**

In addition to JWT, the `Authentication` class also supports signature-based authentication. This is useful to ensure the integrity of the data received.

**2.1. Generating a Signature**

To generate a signature for some data, you simply call the `generateSignature()` method.

**Example Usage:**

```php
namespace App\Models;

class SignatureModel
{
    public function generateSignedData(string $data): string
    {
        // Generate the signature for the data
        $signature = $this->authentication->generateSignature(data: $data);

        return json_encode([
            "status" => "success",
            "code" => 200,
            "message" => "Data signature generated successfully.",
            "signature" => $signature
        ]);
    }
}
```

In this example, `SignatureModel::generateSignedData()` generates a cryptographic signature for the given data and returns it.

**2.2. Verifying the Signature**

To verify the integrity of the data using a signature, you simply call the `verifySignature()` method.

**Example Usage in Middleware:**

```php
namespace App\Middleware;

use App\Core\Header;

class SignatureMiddleware
{
    public function handle()
    {
        // Verify the signature in the X-Signature header
        $this->authentication->verifySignatureHeader();
    }
}
```

Here, `SignatureMiddleware::handle()` verifies the signature in the `X-Signature` header. If the signature is invalid, the request is rejected.

---

### **3. Combining JWT and Signature Authentication**

You can combine both JWT and signature-based authentication to secure your API. For instance, you might use JWT for authenticating the user and signatures to verify the integrity of the request data.

**Example Usage in Model:**

```php
namespace App\Models;

class SecureDataModel
{
    public function processSecureRequest(array $parameters): string
    {
        // First, verify the JWT token
        $this->authentication->verifyAuthHeader(); // Verifies JWT token

        // Then, verify the signature from the request
        $this->authentication->verifySignatureHeader(); // Verifies X-Signature header

        // If both verifications succeed, process the data
        return json_encode([
            "status" => "success",
            "code" => 200,
            "message" => "Request processed securely."
        ]);
    }
}
```

In this example, `SecureDataModel::processSecureRequest()` first verifies the JWT token to ensure the user is authenticated, then verifies the signature to ensure the data hasn't been tampered with.

---

### **4. Conclusion**

#### **Key Methods of the Authentication Class:**
- **`generateJwt(array $payload, int $expired = 3600, string $key = '')`**: Generates a JWT token with the provided payload.
- **`verifyJwt(string $token, string $key = '')`**: Verifies the JWT token's validity and signature.
- **`generateSignature(string $data)`**: Generates a cryptographic signature for the provided data.
- **`verifySignature(string $data, string $signature)`**: Verifies the integrity of data using the cryptographic signature.
- **`verifyAuthHeader()`**: Verifies the JWT token from the `Authorization` header.
- **`verifySignatureHeader()`**: Verifies the signature from the `X-Signature` header.

By utilizing these methods, you can secure your API with both token-based authentication (JWT) and data integrity verification (Signature).
