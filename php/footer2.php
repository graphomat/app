<?php
// footer.php
$currentYear = date('Y');
?>


<style>
    .footer {
        background-color: #0a1657;
        color: white;
        padding-top: 4rem;
        position: relative;
    }

    .footer::before {
        content: '';
        position: absolute;
        top: -50px;
        left: 0;
        right: 0;
        height: 50px;
        background: linear-gradient(to bottom right, transparent 49%, #0a1657 50%);
    }

    .footer-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    .footer-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 3rem;
        margin-bottom: 4rem;
    }

    .footer-column h3 {
        color: #4A90E2;
        font-size: 1.2rem;
        margin-bottom: 1.5rem;
        font-weight: 500;
    }

    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-links li {
        margin-bottom: 1rem;
    }

    .footer-links a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-block;
    }

    .footer-links a:hover {
        color: white;
        transform: translateX(5px);
    }

    .contact-info {
        margin-bottom: 1.5rem;
    }

    .contact-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
        color: rgba(255, 255, 255, 0.8);
    }

    .contact-item svg {
        width: 20px;
        height: 20px;
        fill: #4A90E2;
    }

    .social-links {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .social-link {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .social-link:hover {
        background: #4A90E2;
        transform: translateY(-3px);
    }

    .social-link svg {
        width: 20px;
        height: 20px;
        fill: white;
    }

    .footer-bottom {
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding: 2rem 0;
        text-align: center;
        color: rgba(255, 255, 255, 0.6);
    }

    .footer-bottom-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    .footer-logo {
        font-size: 1.5rem;
        font-weight: bold;
        color: white;
    }

    .footer-nav {
        display: flex;
        gap: 2rem;
    }

    .footer-nav a {
        color: rgba(255, 255, 255, 0.6);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .footer-nav a:hover {
        color: white;
    }

    @media (max-width: 968px) {
        .footer-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .footer-grid {
            grid-template-columns: 1fr;
        }

        .footer-bottom-content {
            flex-direction: column;
            gap: 1rem;
        }

        .footer-nav {
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }
    }
</style>

<footer class="footer" role="contentinfo">
    <div class="footer-container">
        <div class="footer-grid">
            <!-- About Column -->
            <div class="footer-column">
                <h2 class="footer-heading" id="about-footer">О нас</h2>
                <ul class="footer-links" role="list" aria-labelledby="about-footer">
                    <li><a href="#about" aria-label="Узнать о нашей команде">Наша команда</a></li>
                    <li><a href="#certification" aria-label="Посмотреть наши квалификации">Квалификации</a></li>
                    <li><a href="#approach" aria-label="Узнать о методе DBT">Метод DBT</a></li>
                    <li><a href="#values" aria-label="Узнать о наших ценностях">Наши ценности</a></li>
                </ul>
            </div>

            <!-- Services Column -->
            <div class="footer-column">
                <h2 class="footer-heading" id="services-footer">Услуги</h2>
                <ul class="footer-links" role="list" aria-labelledby="services-footer">
                    <li><a href="#individual" aria-label="Подробнее об индивидуальной терапии">Индивидуальная терапия</a></li>
                    <li><a href="#group" aria-label="Подробнее о групповом тренинге">Групповой тренинг</a></li>
                    <li><a href="#online" aria-label="Информация об онлайн формате">Онлайн формат</a></li>
                    <li><a href="#consultation" aria-label="Записаться на консультацию">Консультации</a></li>
                </ul>
            </div>

            <!-- Contact Column -->
            <div class="footer-column">
                <h2 class="footer-heading" id="contact-footer">Контакты</h2>
                <div class="contact-info" role="list" aria-labelledby="contact-footer">
                    <div class="contact-item" role="listitem">
                        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                            <path d="M22 6C22 4.9 21.1 4 20 4H4C2.9 4 2 4.9 2 6V18C2 19.1 2.9 20 4 20H20C21.1 20 22 19.1 22 18V6ZM20 6L12 11L4 6H20ZM20 18H4V8L12 13L20 8V18Z"/>
                        </svg>
                        <a href="mailto:info@dbt-unity.com" aria-label="Написать нам на email">info@dbt-unity.com</a>
                    </div>
                    <div class="contact-item" role="listitem">
                        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                            <path d="M6.62 10.79C8.06 13.62 10.38 15.94 13.21 17.38L15.41 15.18C15.69 14.9 16.08 14.82 16.43 14.93C17.55 15.3 18.75 15.5 20 15.5C20.55 15.5 21 15.95 21 16.5V20C21 20.55 20.55 21 20 21C10.61 21 3 13.39 3 4C3 3.45 3.45 3 4 3H7.5C8.05 3 8.5 3.45 8.5 4C8.5 5.25 8.7 6.45 9.07 7.57C9.18 7.92 9.1 8.31 8.82 8.59L6.62 10.79Z"/>
                        </svg>
                        <a href="tel:+7XXXXXXXXXX" aria-label="Позвонить нам">+7 (XXX) XXX-XX-XX</a>
                    </div>
                </div>
                <div class="social-links" role="list" aria-label="Социальные сети">
                    <a href="#" class="social-link" role="listitem" aria-label="Мы в Facebook">
                        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                            <path d="M12 2.04C6.5 2.04 2 6.53 2 12.06C2 17.06 5.66 21.21 10.44 21.96V14.96H7.9V12.06H10.44V9.85C10.44 7.34 11.93 5.96 14.22 5.96C15.31 5.96 16.45 6.15 16.45 6.15V8.62H15.19C13.95 8.62 13.56 9.39 13.56 10.18V12.06H16.34L15.89 14.96H13.56V21.96C15.9 21.59 18.04 20.37 19.6 18.57C21.16 16.76 22.03 14.46 22 12.06C22 6.53 17.5 2.04 12 2.04Z"/>
                        </svg>
                    </a>
                    <a href="#" class="social-link" role="listitem" aria-label="Мы в Instagram">
                        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                            <path d="M7.8 2H16.2C19.4 2 22 4.6 22 7.8V16.2C22 19.4 19.4 22 16.2 22H7.8C4.6 22 2 19.4 2 16.2V7.8C2 4.6 4.6 2 7.8 2ZM7.6 4C5.61 4 4 5.61 4 7.6V16.4C4 18.39 5.61 20 7.6 20H16.4C18.39 20 20 18.39 20 16.4V7.6C20 5.61 18.39 4 16.4 4H7.6ZM17.25 5.5C17.94 5.5 18.5 6.06 18.5 6.75C18.5 7.44 17.94 8 17.25 8C16.56 8 16 7.44 16 6.75C16 6.06 16.56 5.5 17.25 5.5ZM12 7C14.76 7 17 9.24 17 12C17 14.76 14.76 17 12 17C9.24 17 7 14.76 7 12C7 9.24 9.24 7 12 7ZM12 9C10.35 9 9 10.35 9 12C9 13.65 10.35 15 12 15C13.65 15 15 13.65 15 12C15 10.35 13.65 9 12 9Z"/>
                        </svg>
                    </a>
                    <a href="#" class="social-link" role="listitem" aria-label="Наш канал на YouTube">
                        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                            <path d="M22.05 1.577C21.75 1.027 21.209 0.672 20.571 0.586L20.294 0.56C18.604 0.365 13.187 0.365 13.187 0.365C13.187 0.365 7.771 0.365 6.081 0.56L5.804 0.586C5.166 0.672 4.625 1.027 4.325 1.577C4.075 2.027 3.904 2.715 3.857 3.652L3.834 4.001C3.764 5.412 3.764 9.454 3.764 9.454C3.764 9.454 3.764 13.516 3.834 14.927L3.857 15.276C3.904 16.213 4.075 16.897 4.325 17.347C4.625 17.897 5.165 18.252 5.803 18.338L6.081 18.364C7.771 18.56 13.187 18.56 13.187 18.56C13.187 18.56 18.604 18.56 20.294 18.364L20.571 18.338C21.209 18.252 21.75 17.897 22.05 17.347C22.3 16.897 22.471 16.213 22.518 15.276L22.541 14.927C22.611 13.516 22.611 9.454 22.611 9.454C22.611 9.454 22.611 5.412 22.541 4.001L22.518 3.652C22.471 2.715 22.3 2.027 22.05 1.577ZM10.824 13.391V5.517L16.982 9.454L10.824 13.391Z"/>
                        </svg>
                    </a>
                    <a href="#" class="social-link" role="listitem" aria-label="Мы в Telegram">
                        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                            <path d="M20.665 3.717L2.93497 10.557C1.72497 11.017 1.73197 11.656 2.71297 11.957L7.26497 13.443L17.797 6.792C18.295 6.453 18.75 6.638 18.376 7.012L9.84297 14.713H9.84097L9.84297 14.714L9.52697 19.417C9.98897 19.417 10.192 19.208 10.45 18.961L12.661 16.82L17.26 20.161C18.108 20.631 18.717 20.391 18.928 19.419L21.947 5.111C22.256 3.919 21.474 3.351 20.665 3.717Z"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Schedule Column -->
            <div class="footer-column">
                <h2 class="footer-heading" id="schedule-footer">Расписание</h2>
                <ul class="footer-links" role="list" aria-labelledby="schedule-footer">
                    <li><a href="#schedule" aria-label="Расписание групповых занятий">Групповые занятия</a></li>
                    <li><a href="#workshops" aria-label="Расписание мастер-классов">Мастер-классы</a></li>
                    <li><a href="#intensive" aria-label="Информация об интенсивах">Интенсивы</a></li>
                    <li><a href="#events" aria-label="Календарь мероприятий">Мероприятия</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="footer-bottom-content">
            <div class="footer-logo" aria-label="DBT Unity логотип">DBT Unity</div>
            <nav class="footer-nav" aria-label="Дополнительное меню">
                <a href="#privacy">Политика конфиденциальности</a>
                <a href="#terms">Условия использования</a>
                <a href="#sitemap">Карта сайта</a>
            </nav>
            <div class="copyright" role="contentinfo">
                © <?php echo $currentYear; ?> DBT Unity. Все права защищены.
            </div>
        </div>
    </div>
</footer>
