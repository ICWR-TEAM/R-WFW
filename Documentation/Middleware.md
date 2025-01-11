# **Middleware Documentation**

## **Overview**

The `Auth` middleware is used to generate and verify signatures for request validation. The middleware ensures that requests are authenticated via a cryptographic signature, ensuring data integrity and security.

---

## **Auth Middleware Class: `generateSignature`**

### **Namespace**
```php
namespace App\Middleware;
```

### **Function Overview**

The `generateSignature` function generates a cryptographic signature for the provided data using a private key. This is typically used to ensure the authenticity of the data being sent to the server.

---

### **Method: `generateSignature`**

#### **Description**

Generates a signature for the provided data using a private key. The signature is then included in the response header (`X-Signature`) for validation on the receiving end.

#### **Parameters:**
- **`data`** (`string`): The data that needs to be signed (typically a string).

#### **Returns:**
- **`string`**: The base64-encoded signature.

#### **Example Code:**

```php
public function generateSignature(string $data): string
{
    openssl_sign($data, $signature, $this->privateKey, OPENSSL_ALGO_SHA256);
    $encodedSignature = $this->base64UrlEncode($signature);
    header("X-Signature: " . $encodedSignature);
    return $encodedSignature;
}
```

#### **Explanation:**
1. **`openssl_sign`**: Signs the provided data with the private key using the SHA256 algorithm.
2. **`base64UrlEncode`**: Encodes the generated signature to a base64 URL-safe format.
3. **`header("X-Signature: ...")`**: Sets the `X-Signature` header in the HTTP response to the encoded signature.
4. **Returns** the encoded signature as a string.

---

### **Usage in Routing**

In the routing configuration, the `generateSignature` function is typically used as a middleware to ensure that the request is signed properly before proceeding to the route handler.

#### **Example Usage:**

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
    $route->Route(method: 'get', url: '/group/parameter/{1}/parameter/{2}/', handler: "TestParameter::index");
});
```

- **`'middleware'`**: Specifies the middleware class (`Auth`).
- **`'constructParams'`**: Passes the required parameters to the middleware constructor (e.g., secret keys).
- **`'function'`**: Specifies the function to execute within the middleware (`generateSignature`).
- **`'params'`**: Passes parameters to the `generateSignature` function (`["Hello World"]`).

---

## **Conclusion**

The `generateSignature` method in the `Auth` middleware generates a signature for provided data and sends it as an `X-Signature` header in the response. This is used to ensure the authenticity and integrity of the data, making it a key part of securing routes that require signature-based validation.
