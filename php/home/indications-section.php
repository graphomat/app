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

<style>
    .indications-section {
        background-color: #0a1657;
        color: white;
        padding: 5rem 0;
    }

    .indications-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    .section-header {
        text-align: center;
        margin-bottom: 4rem;
    }

    .section-header h2 {
        font-size: 2.5rem;
        margin-bottom: 1.5rem;
        font-weight: 500;
    }

    .indications-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 2rem;
    }

    .indication-card {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        padding: 2rem;
        transition: transform 0.3s ease, background-color 0.3s ease;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .indication-card::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 2px;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.5), transparent);
        transform: translateX(-100%);
        transition: transform 0.5s ease;
    }

    .indication-card:hover {
        transform: translateY(-5px);
        background: rgba(255, 255, 255, 0.15);
    }

    .indication-card:hover::after {
        transform: translateX(100%);
    }

    .indication-title {
        font-size: 1.2rem;
        margin-bottom: 1rem;
        font-weight: 500;
    }

    .indication-description {
        font-size: 1rem;
        line-height: 1.6;
        opacity: 0.9;
    }

    @media (max-width: 768px) {
        .indications-grid {
            grid-template-columns: 1fr;
        }

        .section-header h2 {
            font-size: 2rem;
        }
    }
</style>

<section class="indications-section">
    <div class="indications-container">
        <div class="section-header">
            <h2>Кому показана комплексная ДБТ программа</h2>
        </div>

        <div class="indications-grid">
            <?php foreach($dbtIndications as $indication): ?>
                <div class="indication-card">
                    <h3 class="indication-title"><?php echo htmlspecialchars($indication['title']); ?></h3>
                    <p class="indication-description"><?php echo htmlspecialchars($indication['description']); ?></p>
                </div>
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
        });
    });
</script>