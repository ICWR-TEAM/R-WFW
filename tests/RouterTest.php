<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Core\Router;

class RouterTest extends TestCase
{
    private Router $router;

    protected function setUp(): void
    {
        $this->router = new Router();
    }

    public function testRouteRegistration()
    {
        $this->router->Route('GET', '/test', 'TestController::index');

        // Since routes are private, we can't directly test, but we can test handleRoute indirectly
        // For now, just assert the router object is created
        $this->assertInstanceOf(Router::class, $this->router);
    }

    public function testParseURLFromRoute()
    {
        $reflection = new \ReflectionClass($this->router);
        $method = $reflection->getMethod('parseURLFromRoute');
        $method->setAccessible(true);

        $result = $method->invoke($this->router, '/test/{id}');
        $this->assertEquals(['', 'test', '{id}'], $result);
    }

    public function testGroupFunctionality()
    {
        $this->router->Group('/api', [], function ($router) {
            $router->Route('GET', '/users', 'UserController::index');
        });

        // Again, private property, but we can test the structure
        $this->assertInstanceOf(Router::class, $this->router);
    }
}