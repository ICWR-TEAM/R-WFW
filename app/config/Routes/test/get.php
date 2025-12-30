<?php

// GET

$route->Middleware(
    middleware: 'Logger',
    constructParams: ['../tmp/' . date(format: "Y-m-d") . '.log', 2097152, ['info', 'error']],
    function: 'write',
    params: ['Incoming request', 'info', [200, 512]]
);

$route->Route(method: 'get', url: '/', handler: "Home::index");
$route->Route(method: 'get', url: '/test/about', handler: "About::index");
$route->Route(method: 'get', url: '/test/closure/{param_value}', handler: function ($request, $response, $parameters): mixed {
    $body = $request->getBody();
    return $response->json([
        'status' => true,
        'parameters' => $parameters,
        'body' => $body
    ]);
});
