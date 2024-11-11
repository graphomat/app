-- Training page configuration
INSERT INTO pages (site_id, title, slug, meta_description, meta_keywords, status) VALUES
    (1, 'Тренинг навыков DBT', 'training',
    'Программа обучения навыкам DBT. Развитие эмоциональной регуляции, осознанности и межличностной эффективности.',
    'DBT тренинг, навыки DBT, обучение DBT, групповой тренинг, эмоциональная регуляция',
    'published');

-- Menu section configuration
INSERT INTO sections (page_id, name, title, description, type, sort_order, data) VALUES
    (8, 'menu', 'Main Menu', 'Navigation menu', 'menu', 0,
     '{"logo": "/img/unitydbt-logo.png", "logo_alt": "Unity DBT", "show_search": true, "sticky": true, "mobile_breakpoint": 768, "cta_text": "ЗАПИСАТЬСЯ НА ПРИЕМ", "cta_url": "#contact"}');


-- Footer section configuration
INSERT INTO sections (page_id, name, title, description, type, sort_order, data) VALUES
    (8, 'footer', 'Footer', 'Page footer', 'footer', 100, '{}');


-- Training page sections configuration
INSERT INTO sections (page_id, name, title, description, type, sort_order, data, position) VALUES
    (8, 'training-intro', 'Программа обучения навыкам DBT', 
    'Комплексная программа развития навыков управления эмоциями и построения качественной жизни', 
    'content', 1,
    '{"content": "Наша программа обучения навыкам DBT помогает развить essential навыки для управления эмоциями, улучшения отношений и построения жизни, которой вы хотите жить. Программа основана на научно доказанных методах и проводится сертифицированными DBT специалистами."}', 0),
    
    (8, 'modules', 'Основные модули обучения', 
    'Четыре ключевых модуля программы DBT', 
    'modules', 2,
    '{
        "modules": [
            {
                "title": "Осознанность",
                "description": "Развитие навыков присутствия в настоящем моменте и безоценочного наблюдения",
                "icon": "/img/mindfulness-icon.svg",
                "duration": "8 недель",
                "skills": [
                    "Что наблюдать",
                    "Как наблюдать",
                    "Мудрый разум",
                    "Практики осознанности"
                ]
            },
            {
                "title": "Стрессоустойчивость",
                "description": "Обучение эффективным техникам управления кризисными ситуациями",
                "icon": "/img/stress-icon.svg",
                "duration": "8 недель",
                "skills": [
                    "Навыки выживания в кризисе",
                    "Принятие реальности",
                    "PLEASE навыки",
                    "Самоуспокоение"
                ]
            },
            {
                "title": "Эмоциональная регуляция",
                "description": "Освоение навыков понимания и управления эмоциями",
                "icon": "/img/emotion-icon.svg",
                "duration": "8 недель",
                "skills": [
                    "Понимание эмоций",
                    "Изменение эмоций",
                    "Снижение уязвимости",
                    "Управление сильными чувствами"
                ]
            },
            {
                "title": "Межличностная эффективность",
                "description": "Улучшение навыков общения и установления границ",
                "icon": "/img/interpersonal-icon.svg",
                "duration": "8 недель",
                "skills": [
                    "Достижение целей",
                    "Построение отношений",
                    "Самоуважение",
                    "DEAR MAN навыки"
                ]
            }
        ]
    }', 1),
    
    (8, 'format', 'Формат обучения', 
    'Как проходит обучение навыкам DBT', 
    'content', 3,
    '{"content": "Обучение проходит в малых группах (6-8 человек) под руководством сертифицированных DBT тренеров. Программа включает:
    
    - Еженедельные групповые занятия (2,5 часа)
    - Практические упражнения и ролевые игры
    - Домашние задания для закрепления навыков
    - Раздаточные материалы и рабочие тетради
    - Поддержку в применении навыков
    
    Каждый модуль длится 8 недель. Вы можете присоединиться к программе с любого модуля."}', 2),
    
    (8, 'schedule', 'Расписание групп', 
    'Текущее расписание групповых занятий', 
    'content', 4,
    '{"content": "Группы проходят в следующих форматах:
    
    Утренняя группа:
    - Вторник и четверг, 10:00 - 12:30
    
    Вечерняя группа:
    - Понедельник и среда, 19:00 - 21:30
    
    Группа выходного дня:
    - Суббота, 11:00 - 16:00 (с перерывом)
    
    Онлайн группа:
    - Вторник и четверг, 19:00 - 21:30"}', 3),
    
    (8, 'registration', 'Запись на программу', 
    'Как присоединиться к программе обучения', 
    'content', 5,
    '{"content": "Чтобы присоединиться к программе:
    
    1. Запишитесь на бесплатную консультацию
    - Знакомство с тренером
    - Обсуждение ваших целей
    - Выбор подходящей группы
    
    2. Пройдите вводное занятие
    - Знакомство с основами DBT
    - Правила группы
    - Организационные вопросы
    
    3. Присоединяйтесь к группе
    - Начните обучение
    - Получите материалы
    - Станьте частью сообщества
    
    Свяжитесь с нами для записи на консультацию."}', 4);
