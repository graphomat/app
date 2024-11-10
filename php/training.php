<?php
// training.php
session_start();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тренинг навыков ДБТ | DBT Unity</title>
    <style>
        :root {
            --primary-color: #0a1657;
            --secondary-color: #ffffff;
            --accent-color: #4A90E2;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        /* Header styles from main page */
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
        }

        /* Training section specific styles */
        .training-section {
            max-width: 1200px;
            margin: 3rem auto;
            padding: 0 2rem;
        }

        .training-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            margin: 2rem 0;
        }

        .training-content {
            padding-right: 2rem;
        }

        .training-content h1 {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .training-details {
            margin: 2rem 0;
        }

        .training-details p {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 1rem;
            color: #333;
        }

        .training-image {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .training-image img {
            width: 100%;
            height: auto;
            display: block;
        }

        .cta-button {
            display: inline-block;
            padding: 1.2rem 2.5rem;
            background-color: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 2rem;
            transition: background-color 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .cta-button:hover {
            background-color: #162276;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
            margin-top: 4rem;
        }

        .feature-card {
            background: #f8f9fa;
            padding: 2rem;
            border-radius: 15px;
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .feature-card h3 {
            color: var(--primary-color);
            margin-bottom: 1rem;
            font-size: 1.2rem;
        }

        .feature-card p {
            color: #666;
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            .training-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .training-content {
                padding-right: 0;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .training-content h1 {
                font-size: 2rem;
            }
        }
    </style>
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

<!-- Add this section after the features-grid in the previous code -->
<style>
    .schedule-section {
        padding: 5rem 0;
        background-color: #f8f9fa;
        margin-top: 4rem;
    }

    .schedule-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    .schedule-header {
        text-align: center;
        margin-bottom: 4rem;
    }

    .schedule-header h2 {
        font-size: 2.5rem;
        color: var(--primary-color);
        text-transform: uppercase;
        margin-bottom: 1.5rem;
    }

    .schedule-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 3rem;
        margin-bottom: 3rem;
    }

    .group-card {
        background-color: var(--primary-color);
        color: white;
        padding: 2.5rem;
        border-radius: 15px;
        position: relative;
        overflow: hidden;
    }

    .group-card h3 {
        font-size: 2rem;
        margin-bottom: 2rem;
        font-weight: 500;
        border-bottom: 2px solid rgba(255, 255, 255, 0.2);
        padding-bottom: 1rem;
    }

    .group-time {
        font-size: 1.25rem;
        margin-bottom: 1.5rem;
    }

    .group-leaders {
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }

    .group-price {
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }

    .group-status {
        font-style: italic;
        color: rgba(255, 255, 255, 0.8);
    }

    .schedule-cta {
        text-align: center;
        margin-top: 3rem;
    }

    .available {
        color: #4CAF50;
    }

    .waitlist {
        color: #FFC107;
    }

    @media (max-width: 768px) {
        .schedule-grid {
            grid-template-columns: 1fr;
        }

        .schedule-header h2 {
            font-size: 2rem;
        }

        .group-card {
            padding: 2rem;
        }
    }
</style>

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



<!-- Add this section after the schedule section -->
<style>
    .modules-section {
        padding: 5rem 0;
        background-color: white;
    }

    .modules-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    .modules-header {
        text-align: center;
        margin-bottom: 4rem;
    }

    .modules-header h2 {
        font-size: 2.5rem;
        color: var(--primary-color);
        text-transform: uppercase;
        margin-bottom: 1.5rem;
    }

    .modules-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 2rem;
    }

    .module-card {
        text-align: center;
        padding: 2rem;
        border-radius: 15px;
        background: white;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .module-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .module-icon {
        width: 120px;
        height: 120px;
        margin: 0 auto 1.5rem;
    }

    .module-icon img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .module-title {
        color: var(--primary-color);
        font-size: 1.1rem;
        font-weight: bold;
        margin-bottom: 1rem;
        min-height: 2.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        text-transform: uppercase;
    }

    .module-description {
        font-size: 0.9rem;
        line-height: 1.6;
        color: #666;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .module-card {
        animation: fadeInUp 0.5s ease forwards;
        opacity: 0;
    }

    .module-card:nth-child(1) { animation-delay: 0.1s; }
    .module-card:nth-child(2) { animation-delay: 0.2s; }
    .module-card:nth-child(3) { animation-delay: 0.3s; }
    .module-card:nth-child(4) { animation-delay: 0.4s; }

    @media (max-width: 1024px) {
        .modules-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 640px) {
        .modules-grid {
            grid-template-columns: 1fr;
        }

        .modules-header h2 {
            font-size: 2rem;
        }

        .module-title {
            min-height: auto;
        }
    }
</style>

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



<!-- Add this section after the modules section -->
<style>
    .indications-section {
        padding: 5rem 0;
        background: var(--primary-color);
        color: white;
    }

    .indications-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 4rem;
        align-items: start;
    }

    .indications-title {
        position: sticky;
        top: 2rem;
    }

    .indications-title h2 {
        font-size: 3rem;
        line-height: 1.2;
        margin-bottom: 2rem;
    }

    .indications-list {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .indication-item {
        padding: 2rem;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        backdrop-filter: blur(10px);
        transition: transform 0.3s ease, background-color 0.3s ease;
    }

    .indication-item:hover {
        transform: translateX(10px);
        background: rgba(255, 255, 255, 0.15);
    }

    .indication-item p {
        font-size: 1.1rem;
        line-height: 1.6;
    }

    .divider {
        height: 2px;
        background: rgba(255, 255, 255, 0.1);
        margin: 1rem 0;
        width: 100%;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .indication-item {
        animation: slideIn 0.5s ease forwards;
        opacity: 0;
    }

    .indication-item:nth-child(1) { animation-delay: 0.1s; }
    .indication-item:nth-child(2) { animation-delay: 0.2s; }
    .indication-item:nth-child(3) { animation-delay: 0.3s; }
    .indication-item:nth-child(4) { animation-delay: 0.4s; }
    .indication-item:nth-child(5) { animation-delay: 0.5s; }
    .indication-item:nth-child(6) { animation-delay: 0.6s; }

    @media (max-width: 968px) {
        .indications-container {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .indications-title {
            position: static;
            text-align: center;
        }

        .indications-title h2 {
            font-size: 2rem;
        }

        .indication-item:hover {
            transform: translateY(-5px);
        }
    }
</style>

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