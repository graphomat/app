<?php
session_start();

// Check if already installed
if (file_exists('.env') && !isset($_GET['force'])) {
    die('Application is already installed. To reinstall, add ?force=1 to the URL.');
}

$error = '';
$success = '';

function generateRandomKey($length = 32) {
    return bin2hex(random_bytes($length));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate inputs
        $required_fields = ['app_name', 'admin_username', 'admin_password', 'admin_password_confirm'];
        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("All fields are required");
            }
        }

        if ($_POST['admin_password'] !== $_POST['admin_password_confirm']) {
            throw new Exception("Passwords do not match");
        }

        if (strlen($_POST['admin_password']) < 8) {
            throw new Exception("Password must be at least 8 characters long");
        }

        // Create .env file
        $env_content = "# Application\n";
        $env_content .= "APP_NAME=" . $_POST['app_name'] . "\n";
        $env_content .= "APP_ENV=production\n";
        $env_content .= "APP_DEBUG=false\n";
        $env_content .= "APP_URL=" . (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . "\n";
        $env_content .= "APP_KEY=" . generateRandomKey() . "\n\n";

        $env_content .= "# Database\n";
        $env_content .= "DB_CONNECTION=sqlite\n";
        $env_content .= "DB_DATABASE=/var/www/html/data/database.sqlite\n\n";

        $env_content .= "# Paths\n";
        $env_content .= "UPLOAD_PATH=/var/www/html/uploads\n";
        $env_content .= "DOCUMENTS_PATH=/var/www/html/uploads/documents\n";
        $env_content .= "IMAGES_PATH=/var/www/html/uploads/images\n";
        $env_content .= "OTHER_PATH=/var/www/html/uploads/other\n\n";

        $env_content .= "# Admin Configuration\n";
        $env_content .= "ADMIN_PATH=/admin\n";
        $env_content .= "ADMIN_SESSION_LIFETIME=120\n\n";

        $env_content .= "# Security\n";
        $env_content .= "SESSION_DRIVER=file\n";
        $env_content .= "SESSION_LIFETIME=120\n";
        $env_content .= "COOKIE_LIFETIME=120\n";

        // Create directories
        $directories = ['data', 'uploads/documents', 'uploads/images', 'uploads/other'];
        foreach ($directories as $dir) {
            if (!file_exists($dir)) {
                mkdir($dir, 0755, true);
            }
        }

        // Write .env file
        file_put_contents('.env', $env_content);

        // Initialize database
        if (file_exists('../schema.sql')) {
            $db = new SQLite3('data/database.sqlite');
            $db->exec(file_get_contents('../schema.sql'));

            // Create admin user
            $password_hash = password_hash($_POST['admin_password'], PASSWORD_DEFAULT);
            $db->exec("INSERT INTO users (username, password_hash, is_admin, created_at) 
                      VALUES ('" . SQLite3::escapeString($_POST['admin_username']) . "', 
                             '" . SQLite3::escapeString($password_hash) . "', 
                             1, 
                             datetime('now'))");
            $db->close();
        } else {
            throw new Exception("Database schema file not found");
        }

        $success = "Installation completed successfully!";
        
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Install Application</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #45a049;
        }
        .error {
            color: #ff0000;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ff0000;
            border-radius: 4px;
            background-color: #fff5f5;
        }
        .success {
            color: #4CAF50;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #4CAF50;
            border-radius: 4px;
            background-color: #f5fff5;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Application Installation</h1>
        
        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="success">
                <?php echo htmlspecialchars($success); ?>
                <p>You can now:</p>
                <ul>
                    <li>Access the main site: <a href="index.php">Click here</a></li>
                    <li>Login to admin panel: <a href="admin/login.php">Click here</a></li>
                </ul>
            </div>
        <?php else: ?>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="app_name">Application Name:</label>
                    <input type="text" id="app_name" name="app_name" required>
                </div>

                <div class="form-group">
                    <label for="admin_username">Admin Username:</label>
                    <input type="text" id="admin_username" name="admin_username" required>
                </div>

                <div class="form-group">
                    <label for="admin_password">Admin Password:</label>
                    <input type="password" id="admin_password" name="admin_password" required>
                </div>

                <div class="form-group">
                    <label for="admin_password_confirm">Confirm Password:</label>
                    <input type="password" id="admin_password_confirm" name="admin_password_confirm" required>
                </div>

                <button type="submit">Install Application</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
