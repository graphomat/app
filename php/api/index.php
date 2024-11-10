<?php
require_once __DIR__ . '/../config/env.php';
require_once __DIR__ . '/Api.php';

header('Content-Type: application/json');

// Get the requested endpoint from the URL
$requestUri = $_SERVER['REQUEST_URI'];
$baseUri = dirname($_SERVER['SCRIPT_NAME']);
$endpoint = str_replace($baseUri, '', $requestUri);
$endpoint = trim($endpoint, '/');

// Parse endpoint parts
$parts = explode('/', $endpoint);
$resource = $parts[0] ?? '';

// Define allowed fields for each resource
$allowedFields = [
    'users' => ['username', 'email', 'is_admin', 'created_at'],
    'content' => ['title', 'content', 'slug', 'created_at', 'updated_at'],
    'media' => ['filename', 'type', 'path', 'created_at'],
    'settings' => ['key', 'value', 'created_at', 'updated_at']
];

try {
    if (empty($resource)) {
        throw new Exception('No resource specified');
    }

    if (!isset($allowedFields[$resource])) {
        throw new Exception('Invalid resource');
    }

    // Create API instance for the requested resource
    $api = new Api($resource, $allowedFields[$resource]);
    
    // Handle the request
    $api->handleRequest();

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
