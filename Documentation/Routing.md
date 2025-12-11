# **Routing Documentation**

## **Overview**

R-WFW routing supports controller-based handlers (`"Controller::method"`) and closures (`function($request, $response, $params)`). Supports simple routes,
grouped routes with shared prefix and middleware, and dynamic URL parameters.

## **Defining Routes**

### **Basic Route**

```php
$route->Route(method: 'get', url: '/', handler: 'Home::index');
```

### **Closure Route**

```php
$route->Route(method: 'get', url: '/test/closure/{param_value}', handler: function ($request, $response, $parameters): mixed {
    $body = $request->getBody();
    return $response->json([
        'status' => true,
        'parameters' => $parameters,
        'body' => $body
    ]);
});
```

### **Dynamic Parameters**

```php
$route->Route(method: 'get', url: '/user/{id}/profile/{section}', handler: 'UserProfile::view');
```

Request to `/user/42/profile/settings` results in:

```php
$params = ['id' => '42', 'section' => 'settings'];
```

## **Named Routes**

```php
$route->RoutesName(name: 'test/get', context: ['route' => $route]);
```

Loads route file from `../app/config/Routes/test/get.php`.

## **Route Groups**

Example:

```php
$route->Group(
    prefix: '/secure',
    middlewares: [
        [
            'middleware' => 'Signature',
            'constructParams' => [SIGNATURE_PRIVATE_KEY, SIGNATURE_PUBLIC_KEY],
            'function' => 'verify',
            'params' => ['signed-message']
        ]
    ],
    callback: function () use ($route) {
        $route->Route(method: 'get', url: '/verify', handler: 'Security::check');
        $route->Route(method: 'post', url: '/data', handler: 'Data::submit');
    }
);
```

All routes inside the group inherit `/secure` prefix and `Signature` middleware.

## **Global Middleware**

```php
$route->Middleware(
    middleware: 'Logger',
    constructParams: ['../tmp/' . date(format: "Y-m-d") . '.log', 2097152, ['info', 'error']],
    function: 'write',
    params: ['Incoming request', 'info', [200, 512]]
);
```

Executed before all registered routes.

## **Controller Handler Format**

```php
$route->Route(method: 'get', url: '/home', handler: 'HomeController::index');
```

Loads `../app/controllers/HomeController.php`, instantiates `App\Controllers\HomeController`, invokes `index()`.

## **Closure Handler Format**

Closures must accept:

```php
function (Request $request, Response $response, array $params)
```

Request body is auto-parsed. Response object supports structured output like `json()`.

## **Middleware Structure**

Middleware must exist in `App\Middleware`. Middleware is defined via:

* `constructParams`: passed to constructor
* `function`: method invoked
* `params`: arguments passed to method
  Example:

```php
$route->Middleware(
    middleware: 'Signature',
    constructParams: [SIGNATURE_PRIVATE_KEY, SIGNATURE_PUBLIC_KEY],
    function: 'verify',
    params: ['signed-payload']
);
```

Loads class `App\Middleware\Signature`, instantiates with keys, executes `verify()` method with parameters.

## **Summary**

Use `Route()` to define endpoint routes. Use `RoutesName()` to load external route config files. Use `Group()` to wrap routes with common prefix and
middleware stack. Handlers may be controller strings or closures. URL parameters use `{name}` and are passed to the handler via `$params`. Middleware is
class-based, configured with constructor arguments and dynamic method invocation. Signature middleware ensures request integrity through cryptographic
verification.
