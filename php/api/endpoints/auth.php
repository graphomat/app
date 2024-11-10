<?php
require_once __DIR__ . '/../../config/env.php';
require_once __DIR__ . '/../../config/Database.php';

class Auth {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function login($username, $password) {
        try {
            $query = "SELECT id, username, password_hash FROM users WHERE username = :username";
            $result = $this->db->query($query, [':username' => $username]);
            
            if ($result) {
                $user = $result->fetchArray(SQLITE3_ASSOC);
                if ($user && password_verify($password, $user['password_hash'])) {
                    // Start session and set user data
                    session_start();
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    return ['success' => true, 'message' => 'Login successful'];
                }
            }
            
            return ['success' => false, 'message' => 'Invalid credentials'];
        } catch (Exception $e) {
            error_log('Login error: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Login failed'];
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        return ['success' => true, 'message' => 'Logout successful'];
    }

    public function isAuthenticated() {
        session_start();
        return isset($_SESSION['user_id']);
    }

    public function getCurrentUser() {
        if (!$this->isAuthenticated()) {
            return null;
        }

        try {
            $query = "SELECT id, username, created_at FROM users WHERE id = :id";
            $result = $this->db->query($query, [':id' => $_SESSION['user_id']]);
            
            if ($result) {
                return $result->fetchArray(SQLITE3_ASSOC);
            }
            
            return null;
        } catch (Exception $e) {
            error_log('Get current user error: ' . $e->getMessage());
            return null;
        }
    }
}

// Handle API requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth = new Auth();
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'login':
                if (isset($data['username']) && isset($data['password'])) {
                    $result = $auth->login($data['username'], $data['password']);
                    echo json_encode($result);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Missing credentials']);
                }
                break;
                
            case 'logout':
                $result = $auth->logout();
                echo json_encode($result);
                break;
                
            default:
                echo json_encode(['success' => false, 'message' => 'Invalid action']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No action specified']);
    }
}
