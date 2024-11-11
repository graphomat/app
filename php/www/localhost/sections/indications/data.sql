-- DBT indications
INSERT OR IGNORE INTO dbt_indications (title, description, sort_order) VALUES
('Трудности с регуляцией эмоционального состояния', 'Помощь в управлении эмоциями и развитии навыков эмоциональной регуляции.', 1),
('Пограничное расстройство личности', 'Эффективная терапия для людей с ПРЛ, помогающая стабилизировать эмоции и улучшить межличностные отношения.', 2),
('Биполярное аффективное расстройство (БАР)', 'Поддержка в управлении симптомами БАР и предотвращении рецидивов.', 3),
('Расстройства пищевого поведения', 'Работа над нормализацией пищевого поведения и связанных с ним эмоциональных трудностей.', 4),
('Синдром дефицита внимания с гиперактивностью (СДВГ)', 'Развитие навыков концентрации и управления импульсивностью.', 5),
('Посттравматическое стрессовое расстройство', 'Помощь в преодолении последствий травмы и развитии устойчивости.', 6),
('Химические и нехимические зависимости', 'Работа с зависимым поведением и развитие здоровых копинг-стратегий.', 7);

-- Indications section configuration
INSERT OR IGNORE INTO sections (page_id, name, title, description, type, sort_order, data) VALUES
    (1, 'indications', 'Who Can Benefit', 'DBT can help with various challenges', 'indications', 3,
    '{"items": [
        {"title": "Emotion Regulation", "icon": "emotion-icon.svg", "description": "Learn to understand and manage emotions effectively"},
        {"title": "Mindfulness", "icon": "mindfulness-icon.svg", "description": "Develop present-moment awareness and focus"},
        {"title": "Interpersonal Skills", "icon": "interpersonal-icon.svg", "description": "Improve relationships and communication"},
        {"title": "Stress Tolerance", "icon": "stress-icon.svg", "description": "Build resilience and cope with difficult situations"}
    ]}');
