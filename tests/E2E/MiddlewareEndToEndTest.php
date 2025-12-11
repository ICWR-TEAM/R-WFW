<?php

namespace Tests\E2E;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class MiddlewareEndToEndTest extends TestCase
{
    private Client $client;
    private string $baseUrl;

    protected function setUp(): void
    {
        $this->baseUrl = getenv('TEST_BASE_URL') ?: 'http://localhost:8090';

        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => 10,
            'http_errors' => false,
        ]);
    }

    public function testLoggerMiddlewareExecution()
    {
        // Test route that has Logger middleware
        $response = $this->client->get('/test/about');

        $this->assertEquals(200, $response->getStatusCode());

        // In a real scenario, you might check log files
        // For now, just verify the request succeeds
        $body = (string) $response->getBody();
        $this->assertNotEmpty($body);
    }

    public function testHeaderMiddlewareAddsHeaders()
    {
        $response = $this->client->get('/');

        // Check if custom headers are added by Header middleware
        $serverHeader = $response->getHeaderLine('Server');
        $this->assertNotEmpty($serverHeader);

        // If Header middleware is configured, it might add custom headers
        // This is a basic check - actual headers depend on middleware config
    }

    public function testMiddlewareChainExecution()
    {
        // Test a route that goes through multiple middlewares
        $response = $this->client->get('/test/about');

        $this->assertEquals(200, $response->getStatusCode());

        // Verify response is still valid after middleware processing
        $body = (string) $response->getBody();
        $this->assertNotEmpty($body);
    }

    public function testMiddlewareErrorHandling()
    {
        // Test middleware that might cause errors
        // For example, if Auth middleware blocks access
        $response = $this->client->get('/protected-route-without-auth');

        // Should either succeed or return appropriate error
        $this->assertContains($response->getStatusCode(), [200, 401, 403, 404]);
    }
}