<?php
// program-section.php

$programComponents = [
    [
        'title' => 'Индивидуальные сессии',
        'description' => 'с личным терапевтом в течение 24-48 недель',
        'icon' => '<svg class="w-12 h-12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
            <path d="M20 7L12 3L4 7M20 7L12 11M20 7V17L12 21M12 11L4 7M12 11V21M4 7V17L12 21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>'
    ],
    [
        'title' => 'Кризисное консультирование',
        'description' => '24/7 по телефону во время кризиса',
        'icon' => '<svg class="w-12 h-12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
            <path d="M3 5C3 3.89543 3.89543 3 5 3H8.27924C8.70967 3 9.09181 3.27543 9.22792 3.68377L10.7257 8.17721C10.8831 8.64932 10.6694 9.16531 10.2243 9.38787L7.96701 10.5165C9.06925 12.9612 11.0388 14.9308 13.4835 16.033L14.6121 13.7757C14.8347 13.3306 15.3507 13.1169 15.8228 13.2743L20.3162 14.7721C20.7246 14.9082 21 15.2903 21 15.7208V19C21 20.1046 20.1046 21 19 21H18C9.71573 21 3 14.2843 3 6V5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>'
    ],
    [
        'title' => 'Тренинг навыков',
        'description' => '24-48 недель',
        'icon' => '<svg class="w-12 h-12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
            <path d="M12 6.25278V19.2528M12 6.25278C10.8321 5.47686 9.24649 5 7.5 5C5.75351 5 4.16789 5.47686 3 6.25278V19.2528C4.16789 18.4769 5.75351 18 7.5 18C9.24649 18 10.8321 18.4769 12 19.2528M12 6.25278C13.1679 5.47686 14.7535 5 16.5 5C18.2465 5 19.8321 5.47686 21 6.25278V19.2528C19.8321 18.4769 18.2465 18 16.5 18C14.7535 18 13.1679 18.4769 12 19.2528" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>'
    ]
];
?>

<section class="program-section" aria-labelledby="program-heading">
    <div class="program-container">
        <header class="program-header">
            <h2 id="program-heading">Что включает в себя комплексная ДБТ программа</h2>
        </header>

        <div class="program-components" role="list">
            <?php foreach($programComponents as $component): ?>
                <article class="component-card" role="listitem">
                    <div class="icon-wrapper" aria-hidden="true">
                        <?php echo $component['icon']; ?>
                    </div>
                    <h3 class="component-title"><?php echo htmlspecialchars($component['title']); ?></h3>
                    <p class="component-description"><?php echo htmlspecialchars($component['description']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>

        <div class="text-center">
            <a href="#contact" 
               class="cta-button" 
               role="button"
               aria-label="Записаться на прием к специалисту">
                ЗАПИСАТЬСЯ НА ПРИЕМ СПЕЦИАЛИСТА
            </a>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.component-card');
    
    // Add keyboard interaction for cards
    cards.forEach(card => {
        card.setAttribute('tabindex', '0');
        
        card.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                this.click();
            }
        });

        // Add hover effect announcement for screen readers
        card.addEventListener('mouseenter', function() {
            this.setAttribute('aria-expanded', 'true');
        });
        
        card.addEventListener('mouseleave', function() {
            this.setAttribute('aria-expanded', 'false');
        });
    });
});
</script>
