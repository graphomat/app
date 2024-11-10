<?php
session_start();

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-box">
            <h1>DBT Unity Admin</h1>
            <form id="loginForm" class="login-form">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <button type="submit">Login</button>
                </div>
                <div id="error-message" class="error-message"></div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const errorMessage = document.getElementById('error-message');
            
            try {
                const response = await fetch('../api/auth', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ username, password })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    window.location.href = 'index.php';
                } else {
                    errorMessage.textContent = data.error || 'Login failed';
                }
            } catch (error) {
                errorMessage.textContent = 'An error occurred. Please try again.';
            }
        });
    </script>
</body>
</html>
