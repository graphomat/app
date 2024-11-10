<?php
require_once __DIR__ . '/../../config/Database.php';

class UserManager {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->ensureTokenFields();
    }

    private function ensureTokenFields() {
        // Add api_token and token_expiry columns if they don't exist
        $this->db->query("
            BEGIN TRANSACTION;
            
            CREATE TABLE IF NOT EXISTS temp_users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                username TEXT NOT NULL UNIQUE,
                password_hash TEXT NOT NULL,
                api_token TEXT,
                token_expiry DATETIME,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
            
            INSERT INTO temp_users (id, username, password_hash, created_at)
            SELECT id, username, password_hash, created_at FROM users;
            
            DROP TABLE users;
            ALTER TABLE temp_users RENAME TO users;
            
            COMMIT;
        ");
    }

    public function createUser($username, $password, $generateToken = true) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $token = $generateToken ? bin2hex(random_bytes(32)) : null;
        $expiry = $generateToken ? date('Y-m-d H:i:s', strtotime('+30 days')) : null;

        try {
            $this->db->query(
                "INSERT INTO users (username, password_hash, api_token, token_expiry) 
                 VALUES (:username, :password_hash, :token, :expiry)",
                [
                    ':username' => $username,
                    ':password_hash' => $passwordHash,
                    ':token' => $token,
                    ':expiry' => $expiry
                ]
            );

            return [
                'success' => true,
                'username' => $username,
                'api_token' => $token,
                'expires' => $expiry
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public function generateToken($username) {
        $token = bin2hex(random_bytes(32));
        $expiry = date('Y-m-d H:i:s', strtotime('+30 days'));

        try {
            $this->db->query(
                "UPDATE users 
                 SET api_token = :token, token_expiry = :expiry 
                 WHERE username = :username",
                [
                    ':token' => $token,
                    ':expiry' => $expiry,
                    ':username' => $username
                ]
            );

            return [
                'success' => true,
                'username' => $username,
                'api_token' => $token,
                'expires' => $expiry
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}

// Check if script is running from command line
if (php_sapi_name() !== 'cli') {
    die('This script can only be run from the command line');
}

// Parse command line arguments
$options = getopt('', ['action:', 'username:', 'password:']);

if (!isset($options['action'])) {
    die("Usage: 
    Create user: php create_user.php --action=create --username=user --password=pass
    Generate token: php create_user.php --action=token --username=user\n");
}

$userManager = new UserManager();

switch ($options['action']) {
    case 'create':
        if (!isset($options['username']) || !isset($options['password'])) {
            die("Username and password are required for user creation\n");
        }
        $result = $userManager->createUser($options['username'], $options['password']);
        break;

    case 'token':
        if (!isset($options['username'])) {
            die("Username is required for token generation\n");
        }
        $result = $userManager->generateToken($options['username']);
        break;

    default:
        die("Invalid action. Use 'create' or 'token'\n");
}

if ($result['success']) {
    echo "Operation successful!\n";
    if (isset($result['api_token'])) {
        echo "API Token: " . $result['api_token'] . "\n";
        echo "Expires: " . $result['expires'] . "\n";
    }
} else {
    echo "Error: " . $result['error'] . "\n";
}
