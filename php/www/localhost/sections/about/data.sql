-- About sections configuration
INSERT OR IGNORE INTO sections (page_id, name, title, description, type, sort_order, data) VALUES
    (1, 'about', 'About Unity DBT', 'Discover our approach to Dialectical Behavior Therapy', 'about', 2,
    '{"content": "Unity DBT provides comprehensive dialectical behavior therapy programs designed to help individuals develop effective coping skills and improve their quality of life.", "image": "/img/about-unity.jpg"}'),
    
    (2, 'about-intro', 'О Unity DBT', 'Наш подход к диалектической поведенческой терапии', 'content', 1,
    '{"content": "Unity DBT - это команда сертифицированных специалистов, предоставляющих комплексную программу диалектической поведенческой терапии.", "image": "/img/about-team.jpg"}'),

    (5, 'dbt-intro', 'Что такое ДБТ?', 'Основы диалектической поведенческой терапии', 'content', 1,
    '{"content": "Диалектическая поведенческая терапия (ДБТ) - это научно доказанный метод психотерапии, разработанный Маршей Линехан."}'),

    (5, 'dbt-principles', 'Принципы ДБТ', 'Основные принципы терапии', 'principles', 2,
    '{"principles": [
        {"title": "Диалектика", "description": "Баланс между принятием и изменением"},
        {"title": "Осознанность", "description": "Развитие навыков присутствия в настоящем моменте"},
        {"title": "Валидация", "description": "Признание и подтверждение опыта клиента"},
        {"title": "Поведенческий анализ", "description": "Изучение и изменение проблемного поведения"}
    ]}');

-- Site configuration
INSERT INTO config (name, value, type, description) VALUES
    ('site_name', 'Unity DBT', 'text', 'Website name');
