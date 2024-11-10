<?php
// indications-section.php

$dbtIndications = [
    [
        'title' => 'Трудности с регуляцией эмоционального состояния',
        'description' => 'Помощь в управлении эмоциями и развитии навыков эмоциональной регуляции.'
    ],
    [
        'title' => 'Пограничное расстройство личности',
        'description' => 'Эффективная терапия для людей с ПРЛ, помогающая стабилизировать эмоции и улучшить межличностные отношения.'
    ],
    [
        'title' => 'Биполярное аффективное расстройство (БАР)',
        'description' => 'Поддержка в управлении симптомами БАР и предотвращении рецидивов.'
    ],
    [
        'title' => 'Расстройства пищевого поведения',
        'description' => 'Работа над нормализацией пищевого поведения и связанных с ним эмоциональных трудностей.'
    ],
    [
        'title' => 'Синдром дефицита внимания с гиперактивностью (СДВГ)',
        'description' => 'Развитие навыков концентрации и управления импульсивностью.'
    ],
    [
        'title' => 'Посттравматическое стрессовое расстройство',
        'description' => 'Помощь в преодолении последствий травмы и развитии устойчивости.'
    ],
    [
        'title' => 'Химические и нехимические зависимости',
        'description' => 'Работа с зависимым поведением и развитие здоровых копинг-стратегий.'
    ]
];
?>

<section class="indications-section" aria-labelledby="indications-heading">
    <div class="indications-container">
        <header class="section-header">
            <h2 id="indications-heading">Кому показана комплексная ДБТ программа</h2>
        </header>

        <div class="indications-grid" role="list">
            <?php foreach($dbtIndications as $indication): ?>
                <article class="indication-card" role="listitem">
                    <h3 class="indication-title"><?php echo htmlspecialchars($indication['title']); ?></h3>
                    <p class="indication-description"><?php echo htmlspecialchars($indication['description']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.indication-card');
        
        // Add animation when cards come into view
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    // Add ARIA live region announcement for screen readers
                    entry.target.setAttribute('aria-live', 'polite');
                }
            });
        }, {
            threshold: 0.1
        });

        cards.forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            observer.observe(card);
            
            // Add keyboard interaction
            card.setAttribute('tabindex', '0');
            card.addEventListener('keypress', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    this.click();
                }
            });
        });
    });
</script>
