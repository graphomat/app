-- Menu items
INSERT INTO menu_items (title, url, position, is_active) VALUES
                                                             ('О НАС', 'home', 1, 1),
                                                             ('ТРЕНИНГ НАВЫКОВ', 'training', 2, 1),
                                                             ('СПЕЦИАЛИСТЫ', 'specialists', 3, 1),
                                                             ('ЧТО ТАКОЕ ДБТ', 'about-dbt', 4, 1),
                                                             ('КОНТАКТЫ', 'contact', 5, 1);

-- Menu categories
INSERT INTO menu_categories (name, slug, description, show_in_menu, menu_position) VALUES
                                                                                       ('Блог', 'blog', 'Статьи и новости', 1, 6),
                                                                                       ('Услуги', 'services', 'Наши услуги', 1, 7);

-- Menu section configuration
INSERT OR IGNORE INTO sections (page_id, name, title, description, type, sort_order, data) VALUES
(1, 'menu', 'Main Menu', 'Navigation menu', 'menu', 0,
    '{"logo": "/img/unitydbt-logo.png", "logo_alt": "Unity DBT", "show_search": true, "sticky": true, "mobile_breakpoint": 768, "cta_text": "ЗАПИСАТЬСЯ НА ПРИЕМ", "cta_url": "#contact"}'),

(2, 'menu', 'Main Menu', 'Navigation menu', 'menu', 0,
    '{"logo": "/img/unitydbt-logo.png", "logo_alt": "Unity DBT", "show_search": true, "sticky": true, "mobile_breakpoint": 768, "cta_text": "ЗАПИСАТЬСЯ НА ПРИЕМ", "cta_url": "#contact"}'),

(3, 'menu', 'Main Menu', 'Navigation menu', 'menu', 0,
    '{"logo": "/img/unitydbt-logo.png", "logo_alt": "Unity DBT", "show_search": true, "sticky": true, "mobile_breakpoint": 768, "cta_text": "ЗАПИСАТЬСЯ НА ПРИЕМ", "cta_url": "#contact"}'),

(4, 'menu', 'Main Menu', 'Navigation menu', 'menu', 0,
    '{"logo": "/img/unitydbt-logo.png", "logo_alt": "Unity DBT", "show_search": true, "sticky": true, "mobile_breakpoint": 768, "cta_text": "ЗАПИСАТЬСЯ НА ПРИЕМ", "cta_url": "#contact"}'),

(5, 'menu', 'Main Menu', 'Navigation menu', 'menu', 0,
    '{"logo": "/img/unitydbt-logo.png", "logo_alt": "Unity DBT", "show_search": true, "sticky": true, "mobile_breakpoint": 768, "cta_text": "ЗАПИСАТЬСЯ НА ПРИЕМ", "cta_url": "#contact"}'),

(6, 'menu', 'Main Menu', 'Navigation menu', 'menu', 0,
    '{"logo": "/img/unitydbt-logo.png", "logo_alt": "Unity DBT", "show_search": true, "sticky": true, "mobile_breakpoint": 768, "cta_text": "ЗАПИСАТЬСЯ НА ПРИЕМ", "cta_url": "#contact"}');
