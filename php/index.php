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

<?php include 'menu-section.php'; ?>


<!-- Hero Section -->
<main>


    <!-- About Section -->
    <!-- Copy content from about-section.php -->
    <?php //include 'includes/header.php'; ?>
    <?php include 'home/header-section.php'; ?>
    <?php include 'home/about-section.php'; ?>

    <!-- Indications Section -->
    <!-- Copy content from indications-section.php -->
    <?php include 'home/indications-section.php'; ?>

    <!-- Program Section -->
    <!-- Copy content from program-section.php -->
    <?php include 'home/program-section.php'; ?>
</main>

<!-- Footer -->
<?php include 'footer.php'; ?>

</body>
</html>