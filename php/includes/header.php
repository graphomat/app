
<?php
// header.php
session_start();

// Navigation items array - can be managed from backend
$navigation = [
    'about' => 'O NAS',
    'training' => 'TRENING',
    'specialists' => 'SPECJALIŚCI',
    'services' => 'USŁUGI',
    'contact' => 'KONTAKT'
];
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centrum Terapii</title>
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
</head>
<body>
<header class="header">
    <nav class="nav-container">
        <div class="logo">
            <!-- Logo can be managed from backend -->
            <img src="logo.svg" alt="Logo" height="40">
        </div>
        <ul class="nav-menu">
            <?php foreach($navigation as $key => $item): ?>
                <li><a href="<?php echo $key; ?>.php"><?php echo htmlspecialchars($item); ?></a></li>
            <?php endforeach; ?>
        </ul>
    </nav>
</header>

<main>
    <section class="hero-section">
        <div class="hero-content">
            <h1>Kompleksowa<br>Terapia</h1>
            <p>"Tworzenie życia wartego przeżycia"</p>
            <button class="cta-button">Umów wizytę</button>
        </div>
        <div class="hero-image">
            <!-- SVG icon can be managed from backend -->
            <svg viewBox="0 0 200 200" width="200" height="200">
                <circle cx="100" cy="100" r="90" fill="#0a1657"/>
                <path d="M100 40 C60 40 40 90 40 130 C40 150 60 160 100 160 C140 160 160 150 160 130 C160 90 140 40 100 40" fill="#fff"/>
            </svg>
        </div>
    </section>
</main>
</body>
</html>