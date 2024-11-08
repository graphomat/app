<?php
// about-section.php

$teamMembers = [
    'Daria Dymont',
    'Ekaterina Khisamieva',
    'Anastasia Nikolaeva',
    'Alsou Fazullina',
    'Olga Sapietta',
    'Liudmila Grishanova'
];

$certificationDetails = [
    'institution' => 'Behavioral Tech Institute',
    'program' => 'DBT Intensive Training',
    'dates' => [
        'part1' => 'March 1-3, 2024 & April 5-7, 2024',
        'part2' => 'September 20-22, 2024 & October 11-13, 2024'
    ],
    'instructors' => [
        'André Ivanoff, PhD',
        'Dmitry Pushkarev, MD, PhD'
    ]
];
?>

<style>
    .about-section {
        max-width: 1200px;
        margin: 4rem auto;
        padding: 0 2rem;
    }

    .about-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: start;
    }

    .about-content {
        color: #333;
    }

    .about-content h2 {
        font-size: 2.5rem;
        color: #0a1657;
        margin-bottom: 1.5rem;
    }

    .about-content p {
        font-size: 1.1rem;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }

    .certification-card {
        background: #fff;
        border-radius: 10px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }

    .certification-logo {
        width: 200px;
        margin-bottom: 1.5rem;
    }

    .certification-details {
        margin-top: 1.5rem;
    }

    .certification-details h3 {
        color: #0a1657;
        font-size: 1.2rem;
        margin-bottom: 1rem;
    }

    .team-list {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin-top: 1rem;
    }

    .team-member {
        background: #f8f9fa;
        padding: 0.75rem 1rem;
        border-radius: 5px;
        font-size: 0.9rem;
    }

    .highlight-text {
        color: #0a1657;
        font-weight: bold;
    }

    @media (max-width: 768px) {
        .about-grid {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .team-list {
            grid-template-columns: 1fr;
        }
    }
</style>

<section class="about-section">
    <div class="about-grid">
        <div class="about-content">
            <h2>O НАС</h2>
            <p>В 2024 году наша команда прошла обучение диалектической поведенческой терапии от Behavioral Tech под руководством преподавателей: André Ivanoff и Дмитрия Пушкарева.</p>

            <div class="certification-details">
                <h3>Наша команда сертифицированных специалистов:</h3>
                <div class="team-list">
                    <?php foreach($teamMembers as $member): ?>
                        <div class="team-member"><?php echo htmlspecialchars($member); ?></div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="certification-card">
            <img src="/assets/behavioral-tech-logo.svg" alt="Behavioral Tech Institute" class="certification-logo">

            <div class="certification-details">
                <h3>DBT Intensive Training</h3>
                <p><span class="highlight-text">Часть 1:</span> <?php echo htmlspecialchars($certificationDetails['dates']['part1']); ?></p>
                <p><span class="highlight-text">Часть 2:</span> <?php echo htmlspecialchars($certificationDetails['dates']['part2']); ?></p>

                <h3>Преподаватели:</h3>
                <?php foreach($certificationDetails['instructors'] as $instructor): ?>
                    <p><?php echo htmlspecialchars($instructor); ?></p>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>