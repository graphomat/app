<?php
// Start the session
session_start();

// Include configuration
require_once 'config/database.php';

// Include header
require_once 'includes/header.php';

// Include sections
require_once 'includes/about-section.php';
require_once 'includes/indications-section.php';
require_once 'includes/program-section.php';

// Include footer
require_once 'includes/footer.php';
?>
