# Requests Documentation

## Overview

`App\Core\Request` abstracts all inbound HTTP input. Encapsulates method, URI, query parameters, form data, headers, raw body, and JSON payload. Stateless and initialized per request lifecycle. Intended for routing and controllers only—should not be accessed from models.

---

## Available Methods

```php
$request->getMethod();
$request->getUri();
$request->getQuery();
$request->getPost();
$request->getBody();
$request->getJSON();
$request->getHeader('Header-Name');
````

Each accessor reads from PHP superglobals (`$_GET`, `$_POST`, `$_SERVER`) or input streams. `getJSON()` decodes `php://input` with fallback to empty array on invalid payload.

---

## Usage in Routing

```php
$router->Route('POST', '/api/submit', function ($request, $response, $params) {
    $data = $request->getJSON();
    $auth = $request->getHeader('Authorization');

    if (!$auth || empty($data['payload'])) {
        $response->withStatus(400)->json(['error' => 'Invalid input']);
        return;
    }

    $response->json(['received' => $data['payload']]);
});
```

Request is passed automatically into closure routes alongside `Response` and URL `params`.

---

## Usage in Controllers

```php
namespace App\Controllers;

use App\Core\Controller;

class UserController extends Controller
{
    public function show($params)
    {
        $id = $params['id'];
        $ua = $this->request->getHeader('User-Agent');
    }

    public function store()
    {
        $data = $this->request->getJSON();
        $method = $this->request->getMethod();
    }
}
```

Accessed directly via `$this->request` from base `Controller`. Requires no injection.

---

## Behavior

* `getMethod()` falls back to `GET` if unset
* `getUri()` extracts raw `REQUEST_URI` without query string
* `getHeader()` returns null if header not found
* `getBody()` reads full raw payload from input stream
* `getJSON()` returns associative array or empty array on failure

---

## Summary

`Request` provides uniform read-only access to HTTP input.
Strictly scoped to routing and controller layers.
Not suitable for use inside models or repositories.
Works with RESTful APIs, form submissions, and raw input transport.
Complements `Response` in closure routes and controller actions.
