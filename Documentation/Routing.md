# **Routing Documentation**

---

## **Setting Up Routes**

In R-WFW, the routing system allows you to map URL patterns to controller actions. You can define simple routes, grouped routes, and apply middleware to routes.

### Example Routing Setup:

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

// Define another individual route
$route->Route(method: 'get', url: '/test/parameter/{1}/parameter/{2}/', handler: "TestParameter::index");
```

### Route Breakdown:

- **Simple Routes**:  
  The `Route()` method is used to define individual routes. It takes the HTTP method (`get`, `post`, etc.), the URL pattern, and the handler (which consists of the controller and method to be executed).

  Example:
  ```php
  $route->Route(method: 'get', url: '/', handler: "Home::index");
  ```
  This maps the URL `/` to the `index()` method of the `Home` controller.

- **Named Routes**:  
  The `RoutesName()` method allows you to define named routes, which can be used for easier URL generation.

  Example:
  ```php
  $route->RoutesName(name: 'test/get', context: ['route' => $route]);
  ```

- **Route Groups with Middleware**:  
  The `Group()` method defines routes with a common prefix. It also allows you to apply middleware to the routes in that group. Middleware is a way to filter or modify requests before they reach the controller action.

  Example:
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

  This creates a route group with the prefix `/test`. The `Auth` middleware is applied to all routes in this group.

- **Handling Dynamic Parameters in URLs**:  
  You can include dynamic segments in your route URL by using curly braces (`{}`). These segments will be passed to the controller method as parameters.

  Example:
  ```php
  $route->Route(method: 'get', url: '/test/parameter/{1}/parameter/{2}/', handler: "TestParameter::index");
  ```
  This route has two dynamic parameters (`{1}` and `{2}`) that will be passed to the `TestParameter::index` method.

---

## **Middleware**

Middleware can be applied globally or to specific routes or route groups. It is used to handle tasks like authentication, logging, or other request filtering before reaching the controller.

Example:
```php
$route->Middleware(middleware: 'Auth', constructParams: [SECRET_KEY_JWT, SIGNATURE_PRIVATE_KEY, SIGNATURE_PUBLIC_KEY], function: 'generateJwt', params: [['id' => 1, 'name' => 'John Doe'], 3600, SECRET_KEY_JWT]);
```

This would apply the `Auth` middleware to the route and pass parameters to it.

---

## **Conclusion**

- **Simple Routes**: Use `$route->Route()` to map URLs to controller actions.
- **Named Routes**: Use `$route->RoutesName()` for easier URL generation.
- **Route Groups**: Use `$route->Group()` to define routes with common prefixes and apply middleware.
- **Dynamic Parameters**: Use curly braces (`{}`) in the URL pattern for dynamic segments that are passed to the controller method.
- **Middleware**: Apply middleware globally or to specific routes to handle request filtering and processing.
