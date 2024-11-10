<?php
require_once __DIR__ . '/../../config/env.php';
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../auth.php';

// Auth check will exit with 401 if not authenticated
requireAuth();

// Only get user after auth check
$user = getCurrentUser();
if (!$user) {
    http_response_code(401);
    exit('Unauthorized');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="admin-container">
        <header>
            <h1>Admin Dashboard</h1>
            <div class="user-info">
                Welcome, <?php echo htmlspecialchars($user['username']); ?>
                <a href="../logout.php">Logout</a>
            </div>
        </header>
        <nav>
            <a href="dashboard.php" class="active">Dashboard</a>
            <a href="content.php">Content</a>
            <a href="menu.php">Menu</a>
            <a href="seo.php">SEO</a>
            <a href="media.php">Media</a>
        </nav>
        <main>
            <h2>Dashboard Overview</h2>
            <!-- Dashboard content here -->
        </main>
    </div>
</body>
</html>
