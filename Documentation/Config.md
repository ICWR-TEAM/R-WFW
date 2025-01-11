# **Configuration Documentation**

This file contains constants for configuring your application. Below are the key settings and examples of how to define them.

---

## **General Configuration**

### `BASEURL`
- **Description**: Base URL of the application.
- **Example**:
  ```php
  define('BASEURL', 'http://localhost:8090');
  ```

---

## **Database Configuration**

### `DB_HOST`
- **Description**: Database server hostname.
- **Example**:
  ```php
  define('DB_HOST', 'incrustwerush.org');
  ```

### `DB_USER`
- **Description**: Database username.
- **Example**:
  ```php
  define('DB_USER', 'incrustwerush.org');
  ```

### `DB_PASS`
- **Description**: Database password.
- **Example**:
  ```php
  define('DB_PASS', 'incrustwerush.org');
  ```

### `DB_NAME`
- **Description**: Database name.
- **Example**:
  ```php
  define('DB_NAME', 'incrustwerush.org');
  ```

---

## **Application Settings**

### `UPDATER`
- **Description**: Enable/disable updates.
- **Example**:
  ```php
  define('UPDATER', false);
  ```

### `UPDATER_PASSWD`
- **Description**: Password for updates.
- **Example**:
  ```php
  define('UPDATER_PASSWD', 'incrustwerush.org');
  ```

### `DEV_MODE`
- **Description**: Enable/disable developer mode.
- **Example**:
  ```php
  define('DEV_MODE', true);
  ```

### `DB_USE`
- **Description**: Enable/disable database usage.
- **Example**:
  ```php
  define('DB_USE', false);
  ```

### `ALLOW_ALL_CORS`
- **Description**: Allow all CORS requests.
- **Example**:
  ```php
  define('ALLOW_ALL_CORS', false);
  ```

---

## **Security Settings**

### `ALL_SECURITY_HEADERS`
- **Description**: Enable/disable security headers.
- **Example**:
  ```php
  define('ALL_SECURITY_HEADERS', false);
  ```

### `ANTI_XSS`
- **Description**: Enable/disable XSS protection.
- **Example**:
  ```php
  define('ANTI_XSS', false);
  ```

---

## **JWT Settings**

### `SECRET_KEY_JWT`
- **Description**: Secret key for JWT.
- **Example**:
  ```php
  define('SECRET_KEY_JWT', 'incrustwerush.org');
  ```

---

## **Signature Keys**

### `SIGNATURE_PRIVATE_KEY`
- **Description**: Path to private key.
- **Example**:
  ```php
  define('SIGNATURE_PRIVATE_KEY', '../data/signature/private_key.pem');
  ```

### `SIGNATURE_PUBLIC_KEY`
- **Description**: Path to public key.
- **Example**:
  ```php
  define('SIGNATURE_PUBLIC_KEY', '../data/signature/public_key.pem');
  ```
