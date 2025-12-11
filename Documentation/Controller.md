# Controller Usage Documentation

## Overview

`App\Core\Controller` acts as the base class for all HTTP controllers. Provides access to rendering views, instantiating models, and managing request-response flow. Automatically loads `Config` and `Security` during construction. Meant for handling route dispatch logic and response construction. Not intended to contain low-level data access or business rules.

---

## Base Controller Features

```php
$this->view('path/to/view', ['key' => 'value']);
$this->model('ModelName/SubPath');
$this->request->getMethod();
$this->response->json(['ok' => true]);
````

Controllers receive URL parameters and can optionally access request/response instances if injected via the router.

---

## View Rendering

```php
$this->view('templates/header', ['title' => 'Home']);
$this->view('pages/index', ['items' => $items]);
$this->view('templates/footer');
```

Calls to `view()` resolve relative to `../app/views/`, append `.php`, and include provided `$data` as scoped local variables.

---

## Model Instantiation

```php
$model = $this->model('UserModel/SubPath');
$data = $model->fetchById($id);
```

Loads model from `../app/models/`, resolves full namespaced class path, and returns new instance. All models must follow PSR-style naming.

---

## Request and Response Access

```php
$payload = $this->request->getJSON();
$this->response->withStatus(200)->json(['data' => $payload]);
```

Injected automatically into controllers extending base `Controller`. Enables full HTTP lifecycle handling inside controller actions.

---

## Route Mapping

```php
$route->Route('GET', '/item/{id}', 'ItemController::detail');
```

Controller methods can receive `$params`, optionally `$request` and `$response` if router dispatches them. Signature must match route injection.

---

## Example Controller

```php
namespace App\Controllers;

use App\Core\Controller;

class ProductController extends Controller
{
    public function show($params)
    {
        $product = $this->model('ProductModel')->find($params['id']);
        $this->view('product/show', ['product' => $product]);
    }

    public function apiCreate()
    {
        $data = $this->request->getJSON();
        $this->model('ProductModel')->create($data);
        $this->response->withStatus(201)->json(['created' => true]);
    }
}
```

Separation of concern between view-based and API-oriented actions. Both rely on base controller capabilities.

---

## Summary

Base `Controller` acts as execution entry point for route handlers.
Provides unified interface to view rendering, model access, and HTTP interaction.
Should not include persistence or domain logic—delegate to models or services.
Designed for direct use in routing layer and supports parameterized route mapping.
Built-in `Config` and `Security` auto-loaded per instance.
Response and request utilities tightly integrated for streamlined web control flow.
