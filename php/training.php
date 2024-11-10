<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тренинг навыков ДБТ | DBT Unity</title>

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

<?php include 'menu-section.php'; ?>

<!-- Training Section -->
<section class="training-section">
    <div class="training-grid">
        <div class="training-content">
            <h1>Тренинг<br>навыков ДБТ</h1>
            <div class="training-details">
                <p>Онлайн тренинг навыков DBT для взрослых (18+)</p>
                <p>Встречи: 1 раз в неделю по 2.5 часа.</p>
                <p>Количество встреч: 24 встречи.</p>
                <p>Предварительное собеседование.</p>
                <p>Стоимость: По запросу</p>
            </div>
            <button class="cta-button">
                ЗАПИСАТЬСЯ НА БЕСПЛАТНОЕ СОБЕСЕДОВАНИЕ
            </button>
        </div>
        <div class="training-image">
            <img src="img/training.png"
                 alt="DBT Skills Training Session"
                 width="600"
                 height="400">
        </div>
    </div>

    <div class="features-grid">
        <div class="feature-card">
            <h3>Mindfulness</h3>
            <p>Развитие осознанности и способности быть в настоящем моменте.</p>
        </div>
        <div class="feature-card">
            <h3>Distress Tolerance</h3>
            <p>Навыки преодоления кризисных ситуаций и сильных эмоций.</p>
        </div>
        <div class="feature-card">
            <h3>Emotion Regulation</h3>
            <p>Управление эмоциями и развитие эмоциональной устойчивости.</p>
        </div>
        <div class="feature-card">
            <h3>Interpersonal Effectiveness</h3>
            <p>Улучшение навыков межличностного общения и построения отношений.</p>
        </div>
    </div>
</section>

<section class="schedule-section">
    <div class="schedule-container">
        <div class="schedule-header">
            <h2>Расписание групп тренинга навыков ДБТ</h2>
        </div>

        <div class="schedule-grid">
            <!-- Tuesday Group -->
            <div class="group-card">
                <h3>Группа по вторникам</h3>
                <div class="group-time">18.00-20.30</div>
                <div class="group-leaders">
                    <strong>Ведущие:</strong> Ольга Саплетта, Екатерина Хисамиева
                </div>
                <div class="group-price">
                    Стоимость 1250 за занятие, оплата блоками по 4 занятия.
                </div>
                <div class="group-status waitlist">
                    Набор закрыт, запись в лист ожидания.
                </div>
            </div>

            <!-- Wednesday Group -->
            <div class="group-card">
                <h3>Группа по средам</h3>
                <div class="group-time">18.00-20.30</div>
                <div class="group-leaders">
                    <strong>Ведущие:</strong> Ольга Саплетта, Алсу Физулина
                </div>
                <div class="group-price">
                    Стоимость 1250 за занятие, оплата блоками по 4 занятия.
                </div>
                <div class="group-status available">
                    Есть свободные места, вход 27.11.24
                </div>
            </div>
        </div>

        <div class="schedule-cta">
            <button class="cta-button">
                ЗАПИСАТЬСЯ НА БЕСПЛАТНОЕ СОБЕСЕДОВАНИЕ
            </button>
        </div>
    </div>
</section>

<section class="modules-section">
    <div class="modules-container">
        <div class="modules-header">
            <h2>Основные модули тренинга навыков ДБТ:</h2>
        </div>

        <div class="modules-grid">
            <!-- Module 1 -->
            <div class="module-card">
                <div class="module-icon">
                    <img src="img/mindfulness-icon.svg" alt="Навыки осознанности">
                </div>
                <div class="module-title">
                    Навыки осознанности
                </div>
                <div class="module-description">
                    Развитие способности фокусироваться на настоящем моменте без осуждения, что помогает лучше понимать и принимать свои эмоции.
                </div>
            </div>

            <!-- Module 2 -->
            <div class="module-card">
                <div class="module-icon">
                    <img src="img/emotion-icon.svg" alt="Навыки эмоциональной регуляции">
                </div>
                <div class="module-title">
                    Навыки эмоциональной регуляции
                </div>
                <div class="module-description">
                    Навыки управления и снижения интенсивности негативных эмоций, таких как гнев или тревога.
                </div>
            </div>

            <!-- Module 3 -->
            <div class="module-card">
                <div class="module-icon">
                    <img src="img/stress-icon.svg" alt="Навыки стрессоустойчивости">
                </div>
                <div class="module-title">
                    Навыки стрессоустойчивости
                </div>
                <div class="module-description">
                    Навыки, помогающие справляться с кризисами и болью, не прибегая к импульсивным действиям.
                </div>
            </div>

            <!-- Module 4 -->
            <div class="module-card">
                <div class="module-icon">
                    <img src="img/interpersonal-icon.svg" alt="Навыки межличностной эффективности">
                </div>
                <div class="module-title">
                    Навыки межличностной эффективности
                </div>
                <div class="module-description">
                    Улучшение навыков общения, обучение выражать потребности, устанавливать границы и справляться с конфликтами.
                </div>
            </div>
        </div>
    </div>
</section>

<section class="indications-section">
    <div class="indications-container">
        <div class="indications-title">
            <h2>Показания к тренингу навыков ДБТ</h2>
        </div>

        <div class="indications-list">
            <!-- Emotional Instability -->
            <div class="indication-item">
                <p>Эмоциональная нестабильность: частые и интенсивные эмоциональные перепады, трудности в контроле гнева.</p>
            </div>

            <!-- Impulsive Behavior -->
            <div class="indication-item">
                <p>Импульсивное поведение: саморазрушительные действия, рискованные поступки.</p>
            </div>

            <!-- Mood Disorders -->
            <div class="indication-item">
                <p>Расстройства настроения: особенно расстройства, связанные с сильной тревогой, депрессией, суицидальными мыслями.</p>
            </div>

            <!-- Borderline Personality Disorder -->
            <div class="indication-item">
                <p>Пограничное расстройство личности (ПРЛ): как основное показание к ДБТ, так и связанные с ним проблемы, такие как трудности в отношениях.</p>
            </div>

            <!-- Adaptation Problems -->
            <div class="indication-item">
                <p>Проблемы с адаптацией и стрессом: трудности в принятии реальности и стрессоустойчивости.</p>
            </div>

            <!-- Interpersonal Difficulties -->
            <div class="indication-item">
                <p>Сложности в межличностных отношениях: конфликты, эмоциональные зависимости, чрезмерное желание одобрения.</p>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<?php include 'footer2.php'; ?>

</body>
</html>
