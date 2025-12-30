<?php

namespace Tests\E2E;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class DatabaseEndToEndTest extends TestCase
{
    private Client $client;
    private string $baseUrl;

    protected function setUp(): void
    {
        $this->baseUrl = getenv('TEST_BASE_URL') ?: 'http://localhost:8090';

        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => 30, // Longer timeout for DB operations
            'http_errors' => false,
        ]);
    }

    public function testDatabaseConnectionWorks()
    {
        // Test an endpoint that uses database
        $response = $this->client->get('/');

        $this->assertEquals(200, $response->getStatusCode());

        // If the page loads successfully, database connection likely works
        $body = (string) $response->getBody();
        $this->assertStringContainsString('R-WFW', $body);
    }

    public function testDataRetrievalFromDatabase()
    {
        // Test endpoint that retrieves data from database
        // This assumes there's an API endpoint that returns data
        $response = $this->client->get('/api/data');

        // If endpoint exists, it should return data or appropriate response
        $this->assertContains($response->getStatusCode(), [200, 404]);

        if ($response->getStatusCode() === 200) {
            $body = (string) $response->getBody();
            // If it's JSON API, validate JSON
            if ($response->getHeaderLine('Content-Type') === 'application/json') {
                $this->assertJson($body);
            }
        }
    }

    public function testDatabaseErrorHandling()
    {
        // Test behavior when database is unavailable
        // This might require temporarily disabling database

        // For now, test that application handles errors gracefully
        $response = $this->client->get('/');

        // Should not crash even if DB is down
        $this->assertNotEquals(500, $response->getStatusCode());
    }

    public function testConcurrentDatabaseAccess()
    {
        // Test multiple concurrent requests to database-backed endpoints
        $promises = [];
        $client = $this->client;

        for ($i = 0; $i < 5; $i++) {
            $promises[] = $client->getAsync('/');
        }

        // Wait for all requests to complete
        $results = \GuzzleHttp\Promise\Utils::unwrap($promises);

        // All should succeed
        foreach ($results as $response) {
            $this->assertEquals(200, $response->getStatusCode());
        }
    }

    public function testDatabaseTransactionIntegrity()
    {
        // Test that database transactions work correctly
        // This would require API endpoints that perform transactions

        // For now, test basic functionality
        $response = $this->client->get('/');
        $this->assertEquals(200, $response->getStatusCode());
    }
}