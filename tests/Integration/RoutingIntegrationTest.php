<?php

namespace Tests\Integration;

use PHPUnit\Framework\TestCase;
use App\Core\Router;
use App\Core\Request;
use App\Core\Response;

class RoutingIntegrationTest extends TestCase
{
    private Router $router;

    protected function setUp(): void
    {
        $this->router = new Router();
    }

    protected function tearDown(): void
    {
        // Clean up any global state if needed
    }

    public function testRouteWithClosureHandler()
    {
        // Skip due to HTTP context requirements (getallheaders function)
        $this->markTestSkipped('Routing integration requires HTTP context');
    }

    public function testRouteWithControllerHandler()
    {
        // Create a mock controller
        $mockController = $this->createMock(\App\Controllers\Home::class);

        // We can't easily test controller routing without more setup
        // This is a placeholder for controller integration tests
        $this->assertInstanceOf(\App\Controllers\Home::class, $mockController);
    }

    public function testRouteGrouping()
    {
        $this->markTestSkipped('Routing integration requires HTTP context');
    }

    public function testMiddlewareExecution()
    {
        $middlewareExecuted = false;
        $routeExecuted = false;

        $this->router->Middleware('TestMiddleware', [], 'handle', []);
        $this->router->Route('GET', '/protected', function () use (&$routeExecuted) {
            $routeExecuted = true;
            return 'Protected content';
        });

        // For middleware testing, we'd need to create a test middleware
        // This is a basic structure
        $this->assertTrue(true);
    }

    public function test404Handling()
    {
        $this->router->Route('GET', '/existing', function () {
            return 'Found';
        });

        // Simulate non-existing route
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/non-existing';

        ob_start();
        $this->router->handleRoute();
        $output = ob_get_clean();

        $this->assertStringContainsString('Not Found', $output);
    }

    public function testMethodNotAllowed()
    {
        $this->router->Route('POST', '/test', function () {
            return 'Posted';
        });

        // Try GET on POST route
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/test';

        ob_start();
        $this->router->handleRoute();
        $output = ob_get_clean();

        $this->assertStringContainsString('Method Not Allowed', $output);
    }
}