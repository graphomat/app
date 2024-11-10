<?php

namespace Tests\Admin;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class AdminPanelTest extends TestCase
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

    public function testLoginPageLoads()
    {
        $response = $this->client->get('/admin/login.php');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testLoginWithInvalidCredentials()
    {
        $response = $this->client->post('/admin/login.php', [
            'form_params' => [
                'username' => 'invalid_user',
                'password' => 'invalid_password'
            ]
        ]);
        $this->assertEquals(401, $response->getStatusCode());
    }

    public function testDashboardRequiresAuth()
    {
        $response = $this->client->get('/admin/pages/dashboard.php');
        $this->assertNotEquals(200, $response->getStatusCode());
    }

    public function testContentPageRequiresAuth()
    {
        $response = $this->client->get('/admin/pages/content.php');
        $this->assertNotEquals(200, $response->getStatusCode());
    }
}
