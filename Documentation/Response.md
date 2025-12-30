# Response Documentation

## Overview

`App\Core\Response` provides HTTP response construction via fluent interface. Handles status codes, headers, and output formatting. Designed for routing and controllers. Avoid usage in models to preserve separation of concerns.

---

## Available Methods

```php
$response->withStatus(200);
$response->withHeader('X-Key', 'value');
$response->json(['message' => 'ok']);
$response->raw('<html>done</html>');
````

`withStatus()` sets the HTTP status code. `withHeader()` adds or overrides response headers. `json()` encodes array as JSON and outputs with `Content-Type: application/json`. `raw()` outputs plain text or HTML string.

---

## Usage in Routing

```php
$router->Route('POST', '/api/send', function ($request, $response, $params) {
    $json = $request->getJSON();

    if (empty($json['payload'])) {
        $response->withStatus(422)->json(['error' => 'Missing payload']);
        return;
    }

    $response->withStatus(201)->json(['status' => 'accepted']);
});
```

Used inside closure-based route handlers. Combined with `Request` to construct API endpoints.

---

## Usage in Controllers

```php
namespace App\Controllers;

use App\Core\Controller;

class ApiController extends Controller
{
    public function index()
    {
        $this->response->withStatus(200)->json(['status' => 'ok']);
    }
}
```

Available directly through base `Controller`. No need for manual instantiation.

---

## Behavior

`json()` always sets `Content-Type: application/json`.
`raw()` outputs as-is unless headers are explicitly set.
Header and status are sent before any body content.
Calling `json()` or `raw()` completes the response lifecycle.

---

## Summary

`Response` is strictly for use in route handlers and controllers.
Models must remain agnostic of HTTP transport.
Combines status, headers, and body output in a single fluent contract.
Supports both JSON APIs and raw outputs like HTML or plain text.
Integrates cleanly with `Request` for complete HTTP lifecycle orchestration.

