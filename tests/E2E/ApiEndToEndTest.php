<?php

namespace Tests\E2E;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ApiEndToEndTest extends TestCase
{
    private Client $client;
    private string $baseUrl;

    protected function setUp(): void
    {
        // Configure test server URL
        $this->baseUrl = getenv('TEST_BASE_URL') ?: 'http://localhost:8090';

        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => 10,
            'http_errors' => false, // Don't throw exceptions for HTTP errors
        ]);
    }

    public function testApplicationIsRunning()
    {
        try {
            $response = $this->client->get('/');
            $this->assertGreaterThanOrEqual(200, $response->getStatusCode());
            $this->assertLessThan(500, $response->getStatusCode());
        } catch (RequestException $e) {
            $this->fail('Application is not running or accessible: ' . $e->getMessage());
        }
    }

    public function testHomePageLoads()
    {
        $response = $this->client->get('/');

        $this->assertEquals(200, $response->getStatusCode());
        $body = (string) $response->getBody();

        // Check for expected content
        $this->assertStringContainsString('R-WFW', $body);
        $this->assertStringContainsString('Web FrameWork', $body);
    }

    public function testAboutPageLoads()
    {
        $response = $this->client->get('/test/about');

        $this->assertEquals(200, $response->getStatusCode());
        $body = (string) $response->getBody();

        // Should contain some content (exact content depends on controller)
        $this->assertNotEmpty($body);
    }

    public function testRouteWithParameters()
    {
        $response = $this->client->get('/test/closure/test-value');

        $this->assertEquals(200, $response->getStatusCode());
        $body = (string) $response->getBody();

        // Parse JSON response
        $data = json_decode($body, true);
        $this->assertIsArray($data);
        $this->assertArrayHasKey('status', $data);
        $this->assertArrayHasKey('parameters', $data);
        $this->assertEquals(['param_value' => 'test-value'], $data['parameters']);
    }

    public function testNonExistentRouteReturns404()
    {
        $response = $this->client->get('/non-existent-route');

        $this->assertEquals(404, $response->getStatusCode());
        $body = (string) $response->getBody();
        $this->assertStringContainsString('Not Found', $body);
    }

    public function testMethodNotAllowed()
    {
        $response = $this->client->post('/test/about'); // POST on GET route

        $this->assertEquals(405, $response->getStatusCode());
        $body = (string) $response->getBody();
        $this->assertStringContainsString('Method Not Allowed', $body);
    }

    public function testCorsHeaders()
    {
        $response = $this->client->options('/test/about', [
            'headers' => [
                'Origin' => 'http://example.com',
                'Access-Control-Request-Method' => 'GET',
            ]
        ]);

        $this->assertEquals(204, $response->getStatusCode());

        // Check CORS headers if enabled
        $headers = $response->getHeaders();
        if (isset($headers['Access-Control-Allow-Origin'])) {
            $this->assertContains('*', $headers['Access-Control-Allow-Origin']);
        }
    }

    public function testJsonContentType()
    {
        $response = $this->client->get('/test/closure/test');

        $contentType = $response->getHeaderLine('Content-Type');
        // Should be JSON for API responses
        if (strpos($contentType, 'application/json') !== false) {
            $body = (string) $response->getBody();
            $this->assertJson($body);
        }
    }

    public function testResponseTime()
    {
        $start = microtime(true);
        $response = $this->client->get('/');
        $end = microtime(true);

        $responseTime = ($end - $start) * 1000; // Convert to milliseconds

        // Response should be reasonably fast (< 500ms for simple page)
        $this->assertLessThan(500, $responseTime, 'Response time should be less than 500ms');
    }

    public function testServerHeaders()
    {
        $response = $this->client->get('/');

        // Check for basic server headers
        $this->assertNotEmpty($response->getHeaderLine('Server'));
        $this->assertNotEmpty($response->getHeaderLine('Date'));
    }
}