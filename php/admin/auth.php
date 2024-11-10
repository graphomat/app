<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Not logged in, redirect to login page
    header('Location: /admin/login.php');
    exit();
}

// Function to check if user has required permissions
function checkPermission($permission) {
    // TODO: Implement proper permission checking
    return true; // For now, return true as we haven't implemented roles/permissions yet
}
