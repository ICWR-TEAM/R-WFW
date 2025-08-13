# **Security Configuration Documentation**

## **Overview**

The **Security Configuration** defines various settings that govern the security aspects of the application. It covers features like JWT authentication, signature verification, XSS protection, and CORS settings, allowing developers to enable or disable certain security features easily by modifying the configuration file.

---

## **Security Configuration Class: `Config`**

### **Namespace**
```php
namespace App\Config\Config;
```

### **Function Overview**

The `Config` class defines security-related settings through constant values. These settings can be adjusted to enhance the security of the application, such as enabling JWT authentication, using private/public keys for signature verification, and preventing XSS attacks.

---

### **Configuration Constants for Security**

#### **1. `SECRET_KEY_JWT`**

##### **Description**

Defines the secret key used for signing JWT tokens. Changing this key ensures that JWT tokens cannot be easily forged. It's important to keep this key secure and confidential.

##### **Example Configuration:**

```php
define('SECRET_KEY_JWT', 'incrustwerush.org');  // Change to a secure, private key
```

##### **Usage:**

The secret key will be used by the JWT middleware for encoding and decoding JWT tokens.

---

#### **2. `SIGNATURE_PRIVATE_KEY` and `SIGNATURE_PUBLIC_KEY`**

##### **Description**

Defines the file paths for the private and public keys used for signing and verifying cryptographic signatures. These keys are used to ensure data integrity and authenticate requests.

- **`SIGNATURE_PRIVATE_KEY`**: The path to the private key for signing data.
- **`SIGNATURE_PUBLIC_KEY`**: The path to the public key for verifying signatures.

##### **Example Configuration:**

```php
define('SIGNATURE_PRIVATE_KEY', '../data/signature/private_key.pem');  // Path to private key
define('SIGNATURE_PUBLIC_KEY', '../data/signature/public_key.pem');    // Path to public key
```

##### **Usage:**

- The **private key** is used to generate signatures.
- The **public key** is used to verify the authenticity of the signatures.

---

#### **3. `ANTI_XSS`**

##### **Description**

Enables protection against Cross-Site Scripting (XSS) attacks by sanitizing user inputs and preventing malicious scripts from being executed in the browser.

##### **Example Configuration:**

```php
define('ANTI_XSS', true);  // Enable anti-XSS protection
```

##### **Usage:**

When enabled, the application will sanitize inputs that could potentially contain malicious scripts.

---

#### **4. `ALL_SECURITY_HEADERS`**

##### **Description**

This setting enables or disables the inclusion of security-related headers in the HTTP response. These headers can include **Content-Security-Policy**, **Strict-Transport-Security**, **X-Content-Type-Options**, etc., which help prevent various types of attacks like clickjacking, content injection, etc.

##### **Example Configuration:**

```php
define('ALL_SECURITY_HEADERS', true);  // Enable all security headers
```

##### **Usage:**

When enabled, the server will include these headers in every response to improve security.

---

#### **5. `ALLOW_ALL_CORS`**

##### **Description**

Enables or disables **Cross-Origin Resource Sharing (CORS)** for requests coming from any domain. This setting is useful for APIs that need to be accessed from multiple origins.

##### **Example Configuration:**

```php
define('ALLOW_ALL_CORS', true);  // Allow all CORS requests
```

##### **Usage:**

When enabled, CORS requests will be allowed from all domains. Be cautious in production environments, as it may open your API to cross-origin attacks.

---

## **Usage in Application**

To enable or configure security features, the constants defined in the configuration file should be set as per the requirements of your application.

For example, to enable JWT authentication and signature verification:

```php
define('SECRET_KEY_JWT', 'my_secure_secret_key');  // Set a secure JWT secret
define('SIGNATURE_PRIVATE_KEY', '/path/to/private/key.pem');  // Set path to private key
define('SIGNATURE_PUBLIC_KEY', '/path/to/public/key.pem');    // Set path to public key
```

To enable **XSS protection** and **security headers**:

```php
define('ANTI_XSS', true);  // Enable anti-XSS protection
define('ALL_SECURITY_HEADERS', true);  // Enable security headers
```

You can also control **CORS**:

```php
define('ALLOW_ALL_CORS', true);  // Enable CORS for all domains (for public APIs)
```

---

## **Conclusion**

This configuration file allows you to easily manage the security features of your application. By adjusting the constants, you can enable or disable critical security features such as JWT authentication, cryptographic signature validation, XSS protection, security headers, and CORS management. Always ensure that sensitive values like JWT secrets and key paths are configured securely in production environments.
