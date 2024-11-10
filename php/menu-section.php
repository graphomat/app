<?php
// header.php
session_start();

// Navigation items array - can be managed from backend
$navigation = [
    'index' => 'О НАС',
    'training' => 'ТРЕНИНГ НАВЫКОВ',
    'specialists' => 'СПЕЦИАЛИСТЫ',
    'about-dbt' => 'ЧТО ТАКОЕ ДБТ',
//    'services' => 'ЧТО ТАКОЕ ДБТ',
    'contact' => 'КОНТАКТЫ'
];
?>

<?php
/*
// Navigation items array - can be managed from backend
$navigation = [
    'about' => 'O NAS',
    'training' => 'TRENING',
    'specialists' => 'SPECJALIŚCI',
    'services' => 'USŁUGI',
    'contact' => 'KONTAKT'
];*/
?>


<style>
    :root {
        --primary-color: #0a1657;
        --secondary-color: #ffffff;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }

    .header {
        background-color: var(--primary-color);
        padding: 1rem 0;
        width: 100%;
    }

    .nav-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 2rem;
    }

    .nav-menu {
        display: flex;
        gap: 2rem;
        list-style: none;
    }

    .nav-menu a {
        color: var(--secondary-color);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        transition: opacity 0.3s;
    }

    .nav-menu a:hover {
        opacity: 0.8;
    }

    .hero-section {
        padding: 4rem 2rem;
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .hero-content {
        flex: 1;
        padding-right: 2rem;
    }

    .hero-content h1 {
        color: var(--primary-color);
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }

    .hero-content p {
        color: #666;
        margin-bottom: 2rem;
    }

    .cta-button {
        background-color: var(--primary-color);
        color: var(--secondary-color);
        padding: 1rem 2rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-transform: uppercase;
        font-weight: bold;
        transition: background-color 0.3s;
    }

    .cta-button:hover {
        background-color: #162276;
    }

    .hero-image {
        flex: 1;
        text-align: right;
    }

    @media (max-width: 768px) {
        .nav-menu {
            display: none;
        }

        .hero-section {
            flex-direction: column;
            text-align: center;
        }

        .hero-content {
            padding-right: 0;
            margin-bottom: 2rem;
        }
    }
</style>

<header class="header">
    <nav class="nav-container">
        <div class="logo">
            <!-- Logo can be managed from backend -->
<!--            <img src="logo.svg" alt="Logo" height="40">-->
            <a href="/" style="color: white; text-decoration: none; font-weight: bold; font-size: 1.5rem;">
                DBT Unity
            </a>

        </div>
        <ul class="nav-menu">
            <?php foreach ($navigation as $key => $item): ?>
                <li><a href="<?php echo $key; ?>.php"><?php echo htmlspecialchars($item); ?></a></li>
            <?php endforeach; ?>
        </ul>
    </nav>
</header>



