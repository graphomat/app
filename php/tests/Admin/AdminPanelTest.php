<?php

namespace Tests\Admin;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class AdminPanelTest extends TestCase
{
    private $client;
    private $baseUrl;
    private $adminPath;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Load environment variables
        $envFile = dirname(dirname(__DIR__)) . '/.env';
        $envContent = file_get_contents($envFile);
        $lines = explode("\n", $envContent);
        
        foreach ($lines as $line) {
            if (strpos($line, 'APP_URL=') === 0) {
                $this->baseUrl = trim(explode('=', $line)[1]);
            }
            if (strpos($line, 'ADMIN_PATH=') === 0) {
                $this->adminPath = trim(explode('=', $line)[1]);
            }
        }

        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'http_errors' => false
        ]);
    }

    public function testLoginPageLoads()
    {
        $response = $this->client->get($this->adminPath . '/login.php');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testLoginWithInvalidCredentials()
    {
        $response = $this->client->post($this->adminPath . '/login.php', [
            'form_params' => [
                'username' => 'invalid_user',
                'password' => 'invalid_password'
            ]
        ]);
        $this->assertEquals(401, $response->getStatusCode());
    }

    public function testDashboardRequiresAuth()
    {
        $response = $this->client->get($this->adminPath . '/pages/dashboard.php');
        $this->assertNotEquals(200, $response->getStatusCode());
    }

    public function testContentPageRequiresAuth()
    {
        $response = $this->client->get($this->adminPath . '/pages/content.php');
        $this->assertNotEquals(200, $response->getStatusCode());
    }
}
