-- Home page configuration
INSERT OR IGNORE INTO pages (site_id, title, slug, meta_description, meta_keywords, status)
VALUES
    (1, 'Unity DBT - Диалектическая поведенческая терапия', 'home', 'Эффективная помощь при эмоциональной нестабильности от сертифицированных DBT специалистов', 'DBT, диалектическая поведенческая терапия, эмоциональная нестабильность, психотерапия', 'published');

-- Home page sections configuration
INSERT OR IGNORE INTO sections (page_id, name, title, description, type, sort_order, data, position)
VALUES
    (1, 'about', 'О нас', 'Узнайте больше о Unity DBT', 'content', 2, '{"content": "Unity DBT - это команда сертифицированных специалистов по диалектической поведенческой терапии. Мы помогаем людям развить навыки управления эмоциями и улучшить качество жизни."}', 1), (1, 'program', 'Наша программа', 'Основные компоненты DBT терапии', 'program', 3, '{"components": ["individual","group","phone","consultation"]}', 2), (1, 'indications', 'Показания', 'Кому подходит DBT терапия', 'indications', 4, '{"items": ["emotional","interpersonal","behavioral","cognitive"]}', 3), (1, 'team', 'Наша команда', 'Познакомьтесь с нашими специалистами', 'team', 5, '{}', 4);


-- Certification section configuration
INSERT OR IGNORE INTO sections (page_id, name, title, description, type, sort_order, data)
VALUES
    (1, 'certification', 'Сертификация', 'Наши профессиональные достижения', 'certification', 1, '{}');


-- Team sections configuration
INSERT OR IGNORE INTO sections (page_id, name, title, description, type, sort_order, data)
VALUES
    (1, 'team', 'Наша команда', 'Познакомьтесь с нашими специалистами', 'team', 2, '{}');


-- Indications section configuration
INSERT OR IGNORE INTO sections (page_id, name, title, description, type, sort_order, data)
VALUES
    (1, 'indications', 'Who Can Benefit', 'DBT can help with various challenges', 'indications', 3, '{"items": [
        {"title": "Emotion Regulation", "icon": "emotion-icon.svg", "description": "Learn to understand and manage emotions effectively"},
        {"title": "Mindfulness", "icon": "mindfulness-icon.svg", "description": "Develop present-moment awareness and focus"},
        {"title": "Interpersonal Skills", "icon": "interpersonal-icon.svg", "description": "Improve relationships and communication"},
        {"title": "Stress Tolerance", "icon": "stress-icon.svg", "description": "Build resilience and cope with difficult situations"}
    ]}');
