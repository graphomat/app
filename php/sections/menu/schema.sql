-- Menu section configuration
INSERT INTO sections (name, title, description, sort_order) VALUES
('menu', 'Menu Section', 'Main navigation menu', 1);

-- Menu items table schema
CREATE TABLE menu_items (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    url TEXT NOT NULL,
    parent_id INTEGER DEFAULT NULL,
    position INTEGER DEFAULT 0,
    is_active BOOLEAN DEFAULT 1,
    target TEXT DEFAULT '_self',
    icon_class TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_id) REFERENCES menu_items(id)
);

-- Menu settings in config
INSERT INTO config (name, value, type, description) VALUES
('menu_logo', 'img/unitydbt-logo.png', 'text', 'Menu logo image path'),
('menu_logo_alt', 'DBT Unity', 'text', 'Menu logo alt text'),
('menu_mobile_breakpoint', '768', 'number', 'Mobile menu breakpoint in pixels'),
('menu_sticky', 'true', 'boolean', 'Enable sticky menu'),
('menu_show_search', 'true', 'boolean', 'Show search in menu'),
('menu_cta_text', 'ЗАПИСАТЬСЯ НА ПРИЕМ', 'text', 'Call to action button text'),
('menu_cta_url', '#contact', 'text', 'Call to action button URL');

-- Initial menu items
INSERT INTO menu_items (title, url, position, is_active) VALUES
('О НАС', 'index.php', 1, 1),
('ТРЕНИНГ НАВЫКОВ', 'training.php', 2, 1),
('СПЕЦИАЛИСТЫ', 'specialists.php', 3, 1),
('ЧТО ТАКОЕ ДБТ', 'about-dbt.php', 4, 1),
('КОНТАКТЫ', 'contact.php', 5, 1);

-- Menu categories table
CREATE TABLE menu_categories (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    slug TEXT NOT NULL UNIQUE,
    description TEXT,
    parent_id INTEGER DEFAULT NULL,
    sort_order INTEGER DEFAULT 0,
    is_active BOOLEAN DEFAULT 1,
    show_in_menu BOOLEAN DEFAULT 0,
    menu_position INTEGER DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_id) REFERENCES menu_categories(id)
);

-- Initial categories
INSERT INTO menu_categories (name, slug, description, show_in_menu, menu_position) VALUES
('Блог', 'blog', 'Статьи и новости', 1, 6),
('Услуги', 'services', 'Наши услуги', 1, 7);
