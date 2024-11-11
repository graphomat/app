-- Team page configuration
INSERT INTO pages (site_id, title, slug, meta_description, meta_keywords, status) VALUES
    (1, 'Специалисты Unity DBT', 'team',
    'Познакомьтесь с нашей командой сертифицированных специалистов по диалектической поведенческой терапии. Опытные психологи и психотерапевты с международной сертификацией.',
    'DBT специалисты, психологи, психотерапевты, DBT терапевты, сертифицированные специалисты, команда Unity DBT',
    'published');

-- Menu section configuration
INSERT INTO sections (page_id, name, title, description, type, sort_order, data) VALUES
    (4, 'menu', 'Main Menu', 'Navigation menu', 'menu', 0,
     '{"logo": "/img/unitydbt-logo.png", "logo_alt": "Unity DBT", "show_search": true, "sticky": true, "mobile_breakpoint": 768, "cta_text": "ЗАПИСАТЬСЯ НА ПРИЕМ", "cta_url": "#contact"}');


-- Footer section configuration
INSERT INTO sections (page_id, name, title, description, type, sort_order, data) VALUES
    (4, 'footer', 'Footer', 'Page footer', 'footer', 100, '{}');


-- Team page sections configuration
INSERT INTO sections (page_id, name, title, description, type, sort_order, data, position) VALUES
    (4, 'specialists-intro', 'Наши специалисты', 'Команда Unity DBT', 'content', 1,
    '{"content": "Все специалисты Unity DBT прошли полный курс обучения и сертификации по диалектической поведенческой терапии (DBT). Мы регулярно участвуем в супервизиях и повышаем квалификацию, чтобы обеспечивать высокое качество помощи нашим клиентам."}', 0),
    
    (4, 'team-full', 'Познакомьтесь с нашей командой', 'Подробная информация о специалистах', 'team-full', 2, '{}', 1),
    
    (4, 'certifications', 'Сертификация и обучение', 'Наши квалификации и стандарты', 'content', 3,
    '{"content": "Сертификация DBT-LBC (Linehan Board Certified) является международным стандартом качества в области диалектической поведенческой терапии. Все наши специалисты постоянно поддерживают и повышают свою квалификацию через:
    - Регулярные супервизии с сертифицированными супервизорами
    - Участие в профессиональных конференциях и семинарах
    - Непрерывное профессиональное образование
    - Следование современным исследованиям и практикам в области DBT"}', 2),
    
    (4, 'specializations', 'Специализации', 'Направления работы наших специалистов', 'content', 4,
    '{"content": "Наши специалисты имеют опыт работы с различными запросами:
    - Эмоциональная нестабильность
    - Трудности в отношениях
    - Управление гневом
    - Тревожные расстройства
    - Депрессивные состояния
    - Травматический опыт
    - Проблемы самооценки
    - Кризисные состояния"}', 3),
    
    (4, 'appointment', 'Записаться на консультацию', 'Как записаться к специалисту', 'content', 5,
    '{"content": "Чтобы записаться на консультацию к конкретному специалисту, вы можете:
    1. Позвонить по телефону и сообщить администратору имя выбранного специалиста
    2. Заполнить форму на сайте, указав предпочитаемого специалиста
    3. Написать на email с пометкой имени специалиста
    
    Мы поможем подобрать удобное время для первичной консультации."}', 4);



-- Team sections configuration
INSERT INTO sections (page_id, name, title, description, type, sort_order, data) VALUES
    (4, 'specialists-intro', 'Наши специалисты', 'Команда сертифицированных DBT терапевтов', 'content', 1,
    '{"content": "Все наши специалисты прошли сертификацию по программе DBT Intensive Training и имеют многолетний опыт работы."}'),
    (4, 'team-full', 'Команда Unity DBT', 'Подробная информация о специалистах', 'team-full', 2, '{}');
