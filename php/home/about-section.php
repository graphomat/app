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

<section class="about-section" aria-labelledby="about-heading">
    <div class="about-grid">
        <div class="about-content">
            <h2 id="about-heading">O НАС</h2>
            <p>В 2024 году наша команда прошла обучение диалектической поведенческой терапии от Behavioral Tech под
                руководством преподавателей: André Ivanoff и Дмитрия Пушкарева.</p>

            <div class="certification-details" aria-labelledby="team-heading">
                <h3 id="team-heading">Наша команда сертифицированных специалистов:</h3>
                <div class="team-list" role="list">
                    <?php foreach ($teamMembers as $member): ?>
                        <div class="team-member" role="listitem"><?php echo htmlspecialchars($member); ?></div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="certification-card" aria-labelledby="cert-heading">
            <a href="Cert_Unity_241108_073542.pdf" aria-label="Посмотреть сертификат Behavioral Tech Institute">
                <img src="img/unitydbt-cert.png" 
                     alt="Сертификат DBT Intensive Training от Behavioral Tech Institute" 
                     class="certification-logo"
                     height="350">
            </a>

            <div class="certification-details">
                <h3 id="cert-heading">DBT Intensive Training</h3>
                <p>
                    <span class="highlight-text">Часть 1:</span> <?php echo htmlspecialchars($certificationDetails['dates']['part1']); ?>
                </p>
                <p>
                    <span class="highlight-text">Часть 2:</span> <?php echo htmlspecialchars($certificationDetails['dates']['part2']); ?>
                </p>

                <h3 id="instructors-heading">Преподаватели:</h3>
                <div role="list" aria-labelledby="instructors-heading">
                    <?php foreach ($certificationDetails['instructors'] as $instructor): ?>
                        <p role="listitem"><?php echo htmlspecialchars($instructor); ?></p>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
