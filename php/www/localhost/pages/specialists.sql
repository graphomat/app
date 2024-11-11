-- Menu section configuration
INSERT OR IGNORE INTO sections (page_id, name, title, description, type, sort_order, data) VALUES
(4, 'menu', 'Main Menu', 'Navigation menu', 'menu', 0,
    '{"logo": "/img/unitydbt-logo.png", "logo_alt": "Unity DBT", "show_search": true, "sticky": true, "mobile_breakpoint": 768, "cta_text": "ЗАПИСАТЬСЯ НА ПРИЕМ", "cta_url": "#contact"}');

-- Footer section configuration
INSERT OR IGNORE INTO sections (page_id, name, title, description, type, sort_order, data) VALUES
(4, 'footer', 'Footer', 'Page footer', 'footer', 100, '{}');

-- Specialists page sections configuration
INSERT OR IGNORE INTO sections (page_id, name, title, description, type, sort_order, data, position) VALUES
    (4, 'specialists-intro', 'Специалист Unity DBT', 'Информация о специалисте', 'content', 1,
    '{"content": "Каждый специалист Unity DBT имеет обширный опыт работы и международную сертификацию в области диалектической поведенческой терапии. Мы постоянно совершенствуем свои навыки и применяем современные научно обоснованные методы терапии."}', 0),
    
    (4, 'specialist-profile', 'Профиль специалиста', 'Детальная информация о специалисте', 'specialist-profile', 2, '{}', 1),
    
    (4, 'expertise', 'Области экспертизы', 'Специализация и опыт работы', 'content', 3,
    '{"content": "Основные направления работы:
    - Индивидуальная психотерапия
    - Групповой тренинг навыков DBT
    - Работа с эмоциональной дисрегуляцией
    - Кризисное консультирование
    - Работа с травматическим опытом
    - Межличностная эффективность
    - Развитие осознанности
    - Управление стрессом"}', 2),
    
    (4, 'education', 'Образование и сертификация', 'Квалификация и обучение', 'content', 4,
    '{"content": "Профессиональная подготовка включает:
    - Базовое психологическое/медицинское образование
    - Интенсивный тренинг по DBT
    - Международная сертификация DBT-LBC
    - Регулярные супервизии и повышение квалификации
    - Участие в профессиональных конференциях
    - Постоянное изучение новых исследований в области DBT"}', 3),
    
    (4, 'consultation', 'Запись на консультацию', 'Как записаться на прием', 'content', 5,
    '{"content": "Чтобы записаться на консультацию:
    1. Используйте форму записи на сайте
    2. Позвоните по телефону
    3. Напишите на email
    
    На первой встрече мы обсудим ваш запрос и определим наиболее эффективный план работы."}', 4);
