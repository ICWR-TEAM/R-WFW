# Header Documentation

## Overview

The `Header` class in the `App\Middleware` namespace provides utilities to manage HTTP headers, including:

- Setting HTTP status codes.
- Configuring CORS (Cross-Origin Resource Sharing) headers.
- Setting custom headers.

---

## Class: `Header`

### Namespace
```php
namespace App\Middleware;
```

---

## Properties

### `$statusTexts`
An **associative array** mapping HTTP status codes to their corresponding textual descriptions.  
This array covers standard HTTP status codes from `100` to `505`.

Example:
```php
[
    200 => 'OK',
    404 => 'Not Found',
    500 => 'Internal Server Error',
]
```

---

## Methods

### 1. `setStatusCode(int $statusCode): void`

#### Description
Sets the HTTP response status code. If the provided status code is not recognized (not in `$statusTexts`), it defaults to **500 Internal Server Error**.

#### Parameters
| Parameter   | Type  | Description                        |
|-------------|-------|------------------------------------|
| `$statusCode` | `int` | The HTTP status code to set. |

#### Example
```php
Header::setStatusCode(200);
```

---

### 2. `cors(array $methods, array $allowedOrigins, array $allowedHeaders): void`

#### Description
Sets CORS headers to allow cross-origin requests.  
Automatically handles `OPTIONS` preflight requests by returning a `204 No Content` response.

#### Parameters
| Parameter       | Type   | Description                                               |
|------------------|--------|-----------------------------------------------------------|
| `$methods`        | `array` | Allowed HTTP methods (e.g., `['GET', 'POST', 'OPTIONS']`). |
| `$allowedOrigins` | `array` | Allowed origins (e.g., `['*']`).                         |
| `$allowedHeaders` | `array` | Allowed headers (e.g., `['Content-Type', 'Authorization']`). |

#### Example
```php
Header::cors(
    ['GET', 'POST', 'OPTIONS'],
    ['https://example.com', 'https://another-site.com'],
    ['Content-Type', 'Authorization']
);
```

---

### 3. `headerSet(array $headers): void`

#### Description
Sets custom headers provided in an associative array.

#### Parameters
| Parameter   | Type   | Description                                   |
|-------------|--------|-----------------------------------------------|
| `$headers`    | `array` | Associative array of headers (`key => value`). |

#### Example
```php
Header::headerSet([
    'X-Custom-Header' => 'CustomValue',
    'Content-Type' => 'application/json'
]);
```

---

## Usage Example

Here is an example of how the `Header` class might be used inside a model class.

```php
<?php

namespace App\Models;

use App\Core\Model;
use App\Middleware\Header;

class HomeModel extends Model
{
    public function description(): string
    {
        // Set 200 OK status
        Header::setStatusCode(200);

        // Set some custom headers
        Header::headerSet([
            'Content-Type' => 'application/json'
        ]);

        return json_encode(["msg" => "test"]);
    }
}
```

---

## Summary

| Method                  | Purpose                                                  |
|-------------------------|----------------------------------------------------------|
| `setStatusCode()`       | Sets the HTTP response status code.                     |
| `cors()`                 | Configures CORS headers and handles preflight requests. |
| `headerSet()`            | Sets custom headers.                                   |

This class simplifies setting common HTTP headers and handling CORS in PHP applications.

---

Let me know if you want a version with example responses or extended documentation!
