<?php
require_once __DIR__ . '/../config/Database.php';

class UserManager {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function createUser($username, $password, $generateToken = true) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $token = $generateToken ? bin2hex(random_bytes(32)) : null;
        $expiry = $generateToken ? date('Y-m-d H:i:s', strtotime('+30 days')) : null;

        try {
            $stmt = $this->db->prepare(
                "INSERT INTO users (username, password_hash, api_token, token_expiry) 
                 VALUES (:username, :password_hash, :token, :expiry)"
            );
            
            $stmt->bindValue(':username', $username, SQLITE3_TEXT);
            $stmt->bindValue(':password_hash', $passwordHash, SQLITE3_TEXT);
            $stmt->bindValue(':token', $token, SQLITE3_TEXT);
            $stmt->bindValue(':expiry', $expiry, SQLITE3_TEXT);
            
            $result = $stmt->execute();

            if ($result && $this->db->changes() > 0) {
                return [
                    'success' => true,
                    'username' => $username,
                    'api_token' => $token,
                    'expires' => $expiry
                ];
            } else {
                throw new Exception("Failed to create user");
            }
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
            $stmt = $this->db->prepare(
                "UPDATE users 
                 SET api_token = :token, token_expiry = :expiry 
                 WHERE username = :username"
            );
            
            $stmt->bindValue(':token', $token, SQLITE3_TEXT);
            $stmt->bindValue(':expiry', $expiry, SQLITE3_TEXT);
            $stmt->bindValue(':username', $username, SQLITE3_TEXT);
            
            $result = $stmt->execute();

            if ($result && $this->db->changes() > 0) {
                return [
                    'success' => true,
                    'username' => $username,
                    'api_token' => $token,
                    'expires' => $expiry
                ];
            } else {
                throw new Exception("User not found or token not updated");
            }
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
