<?php
// program-section.php

$programComponents = [
    [
        'title' => 'Индивидуальные сессии',
        'description' => 'с личным терапевтом в течение 24-48 недель',
        'icon' => '<svg class="w-12 h-12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M20 7L12 3L4 7M20 7L12 11M20 7V17L12 21M12 11L4 7M12 11V21M4 7V17L12 21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>'
    ],
    [
        'title' => 'Кризисное консультирование',
        'description' => '24/7 по телефону во время кризиса',
        'icon' => '<svg class="w-12 h-12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M3 5C3 3.89543 3.89543 3 5 3H8.27924C8.70967 3 9.09181 3.27543 9.22792 3.68377L10.7257 8.17721C10.8831 8.64932 10.6694 9.16531 10.2243 9.38787L7.96701 10.5165C9.06925 12.9612 11.0388 14.9308 13.4835 16.033L14.6121 13.7757C14.8347 13.3306 15.3507 13.1169 15.8228 13.2743L20.3162 14.7721C20.7246 14.9082 21 15.2903 21 15.7208V19C21 20.1046 20.1046 21 19 21H18C9.71573 21 3 14.2843 3 6V5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>'
    ],
    [
        'title' => 'Тренинг навыков',
        'description' => '24-48 недель',
        'icon' => '<svg class="w-12 h-12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 6.25278V19.2528M12 6.25278C10.8321 5.47686 9.24649 5 7.5 5C5.75351 5 4.16789 5.47686 3 6.25278V19.2528C4.16789 18.4769 5.75351 18 7.5 18C9.24649 18 10.8321 18.4769 12 19.2528M12 6.25278C13.1679 5.47686 14.7535 5 16.5 5C18.2465 5 19.8321 5.47686 21 6.25278V19.2528C19.8321 18.4769 18.2465 18 16.5 18C14.7535 18 13.1679 18.4769 12 19.2528" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>'
    ]
];
?>

<style>
    .program-section {
        padding: 5rem 0;
        background-color: #fff;
    }

    .program-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    .program-header {
        text-align: center;
        margin-bottom: 4rem;
    }

    .program-header h2 {
        font-size: 2.5rem;
        color: #0a1657;
        margin-bottom: 1.5rem;
    }

    .program-components {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 3rem;
    }

    .component-card {
        text-align: center;
        padding: 2rem;
        border-radius: 15px;
        background: #f8f9fa;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .component-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .icon-wrapper {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #0a1657;
        color: white;
        border-radius: 50%;
    }

    .component-title {
        font-size: 1.25rem;
        color: #0a1657;
        margin-bottom: 1rem;
        font-weight: 600;
    }

    .component-description {
        color: #666;
        line-height: 1.6;
    }

    .cta-button {
        display: inline-block;
        margin-top: 3rem;
        padding: 1rem 2rem;
        background-color: #0a1657;
        color: white;
        border-radius: 30px;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .cta-button:hover {
        background-color: #162276;
    }

    .footer {
        background-color: #0a1657;
        color: white;
        padding: 4rem 0 2rem;
    }

    .footer-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 3rem;
    }

    .footer-column h3 {
        font-size: 1.2rem;
        margin-bottom: 1.5rem;
        font-weight: 500;
    }

    .footer-links {
        list-style: none;
        padding: 0;
    }

    .footer-links li {
        margin-bottom: 0.75rem;
    }

    .footer-links a {
        color: rgba(255,255,255,0.8);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .footer-links a:hover {
        color: white;
    }

    .footer-bottom {
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 1px solid rgba(255,255,255,0.1);
        text-align: center;
        color: rgba(255,255,255,0.6);
    }

    @media (max-width: 768px) {
        .program-components {
            grid-template-columns: 1fr;
        }

        .footer-container {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 480px) {
        .footer-container {
            grid-template-columns: 1fr;
        }
    }
</style>

<section class="program-section">
    <div class="program-container">
        <div class="program-header">
            <h2>Что включает в себя комплексная ДБТ программа</h2>
        </div>

        <div class="program-components">
            <?php foreach($programComponents as $component): ?>
                <div class="component-card">
                    <div class="icon-wrapper">
                        <?php echo $component['icon']; ?>
                    </div>
                    <h3 class="component-title"><?php echo htmlspecialchars($component['title']); ?></h3>
                    <p class="component-description"><?php echo htmlspecialchars($component['description']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <div style="text-align: center;">
            <a href="#contact" class="cta-button">ЗАПИСАТЬСЯ НА ПРИЕМ СПЕЦИАЛИСТА</a>
        </div>
    </div>
</section>
