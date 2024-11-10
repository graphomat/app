<?php
// index.php
session_start();

// Basic configuration
$config = [
    'site_name' => 'DBT Unity - Диалектическая поведенческая терапия',
    'site_description' => 'Комплексная ДБТ терапия в России. Профессиональная помощь в управлении эмоциями, работа с ПРЛ, БАР и другими расстройствами.',
    'contact_email' => 'info@dbt-unity.com',
    'contact_phone' => '+1 (234) 567-890',
    'keywords' => 'ДБТ, диалектическая поведенческая терапия, ПРЛ, пограничное расстройство личности, БАР, управление эмоциями, психотерапия',
    'author' => 'DBT Unity Team'
];

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $config['site_name']; ?></title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="<?php echo $config['site_description']; ?>">
    <meta name="keywords" content="<?php echo $config['keywords']; ?>">
    <meta name="author" content="<?php echo $config['author']; ?>">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?php echo $config['site_name']; ?>">
    <meta property="og:description" content="<?php echo $config['site_description']; ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://dbt-unity.com">
    <meta property="og:image" content="https://dbt-unity.com/img/unitydbt-logo.png">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo $config['site_name']; ?>">
    <meta name="twitter:description" content="<?php echo $config['site_description']; ?>">
    <meta name="twitter:image" content="https://dbt-unity.com/img/unitydbt-logo.png">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="https://dbt-unity.com">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="img/favicon.png">
    
    <!-- Stylesheet -->
    <link rel="stylesheet" href="styles.css">

    <!-- Schema.org markup -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "MedicalOrganization",
        "name": "<?php echo $config['site_name']; ?>",
        "description": "<?php echo $config['site_description']; ?>",
        "url": "https://dbt-unity.com",
        "logo": "https://dbt-unity.com/img/unitydbt-logo.png",
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "<?php echo $config['contact_phone']; ?>",
            "email": "<?php echo $config['contact_email']; ?>",
            "contactType": "customer service"
        },
        "medicalSpecialty": ["Психотерапия", "Диалектическая поведенческая терапия"],
        "availableService": [
            {
                "@type": "MedicalTherapy",
                "name": "Индивидуальная терапия",
                "description": "Индивидуальные сессии с личным терапевтом"
            },
            {
                "@type": "MedicalTherapy",
                "name": "Групповой тренинг",
                "description": "Групповые занятия по развитию навыков"
            }
        ]
    }
    </script>
</head>
<body>
    <!-- Header with navigation -->
    <?php include 'menu-section.php'; ?>

    <!-- Main content -->
    <main>
        <!-- Hero Section -->
        <?php include 'home/header-section.php'; ?>

        <!-- About Section -->
        <?php include 'home/about-section.php'; ?>

        <!-- Indications Section -->
        <?php include 'home/indications-section.php'; ?>

        <!-- Program Section -->
        <?php include 'home/program-section.php'; ?>
    </main>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <!-- Structured data for breadcrumbs -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [{
            "@type": "ListItem",
            "position": 1,
            "name": "Главная",
            "item": "https://dbt-unity.com"
        }]
    }
    </script>
</body>
</html>
