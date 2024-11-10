<?php

namespace Tests\MainSite;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class HomePageTest extends TestCase
{
    private $client;
    private $baseUrl = 'http://localhost:8080';

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'http_errors' => false
        ]);
    }

    public function testHomePageLoads()
    {
        $response = $this->client->get('/');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testAboutSectionExists()
    {
        $response = $this->client->get('/');
        $body = (string) $response->getBody();
        $this->assertStringContainsString('about-section', $body);
    }

    public function testProgramSectionExists()
    {
        $response = $this->client->get('/');
        $body = (string) $response->getBody();
        $this->assertStringContainsString('program-section', $body);
    }
}
