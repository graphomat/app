<?php
// index.php
session_start();

// Basic configuration
$config = [
    'site_name' => 'DBT Unity',
    'site_description' => 'Комплексная ДБТ терапия',
    'contact_email' => 'info@dbt-unity.com',
    'contact_phone' => '+1 (234) 567-890'
];

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $config['site_name']; ?></title>
    <style>
        /* Copy all CSS from previous artifacts here */
        /* Header styles */
        /* About section styles */
        /* Indications section styles */
        /* Program section styles */
        /* Footer styles */
    </style>
</head>
<body>
<!-- Header Section -->
<header class="header">
    <nav class="nav-container">
        <div class="logo">
            <span style="color: white; font-size: 1.5rem;">DBT Unity</span>
        </div>
        <ul class="nav-menu">
            <li><a href="#about">О НАС</a></li>
            <li><a href="#training">ТРЕНИНГ НАВЫКОВ</a></li>
            <li><a href="#specialists">СПЕЦИАЛИСТЫ</a></li>
            <li><a href="#about-dbt">ЧТО ТАКОЕ ДБТ</a></li>
            <li><a href="#contacts">КОНТАКТЫ</a></li>
        </ul>
    </nav>
</header>

<?php //include 'includes/menu-section.php'; ?>


<!-- Hero Section -->
<main>


    <!-- About Section -->
    <!-- Copy content from about-section.php -->
<!--    --><?php //include 'includes/header.php'; ?>
    <?php include 'includes/header-section.php'; ?>
    <?php include 'includes/about-section.php'; ?>

    <!-- Indications Section -->
    <!-- Copy content from indications-section.php -->
    <?php include 'includes/indications-section.php'; ?>

    <!-- Program Section -->
    <!-- Copy content from program-section.php -->
    <?php include 'includes/program-section.php'; ?>
</main>

<!-- Footer -->
<footer class="footer">
    <!-- Copy content from footer section -->
</footer>
</body>
</html>