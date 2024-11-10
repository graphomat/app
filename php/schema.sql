-- Users table for admin authentication
CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL UNIQUE,
    password_hash TEXT NOT NULL,
    api_token TEXT,
    token_expiry DATETIME,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Site configuration table
CREATE TABLE config (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL UNIQUE,
    value TEXT,
    type TEXT DEFAULT 'text',
    description TEXT,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Sections management table
CREATE TABLE sections (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL UNIQUE,
    title TEXT NOT NULL,
    description TEXT,
    is_active BOOLEAN DEFAULT 1,
    sort_order INTEGER DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Menu items table
CREATE TABLE menu_items (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    url TEXT NOT NULL,
    parent_id INTEGER DEFAULT NULL,
    position INTEGER DEFAULT 0,
    is_active BOOLEAN DEFAULT 1,
    FOREIGN KEY (parent_id) REFERENCES menu_items(id)
);

-- Content/Articles table
CREATE TABLE content (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    slug TEXT NOT NULL UNIQUE,
    content TEXT,
    type TEXT DEFAULT 'page',
    status TEXT DEFAULT 'draft',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- SEO settings table
CREATE TABLE seo (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    page_id INTEGER,
    meta_title TEXT,
    meta_description TEXT,
    meta_keywords TEXT,
    og_title TEXT,
    og_description TEXT,
    og_image TEXT,
    canonical_url TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (page_id) REFERENCES content(id)
);

-- Media files table
CREATE TABLE media (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    filename TEXT NOT NULL,
    original_filename TEXT NOT NULL,
    mime_type TEXT NOT NULL,
    file_size INTEGER NOT NULL,
    path TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Initial admin user (password: admin123)
INSERT INTO users (username, password_hash, api_token) VALUES
('admin', '$2y$10$8K1p/a4SWJ1Fm4.5qGkZyOQz6lS6sS6X3g4W5XG5gYX5tG8IhVm2.', '4440f76d4926ae623eb93023c4e2e11d93cb6ea1c542617d8b54a9e989749b7b'),
('olga', '$2y$10$bvSA8B6LsPGorgRrM1ACS.1durPvwxljm5pvDFKlsugDakHdO5m9S', '4440f76d4926ae623eb93023c4e2e11d93cb6ea1c542617d8b54a9e989749b7b');

-- Initial menu items
INSERT INTO menu_items (title, url, position) VALUES
('О НАС', 'index.php', 1),
('ТРЕНИНГ НАВЫКОВ', 'training.php', 2),
('СПЕЦИАЛИСТЫ', 'specialists.php', 3),
('ЧТО ТАКОЕ ДБТ', 'about-dbt.php', 4),
('КОНТАКТЫ', 'contact.php', 5);

-- Initial global SEO settings
INSERT INTO config (name, value, type, description) VALUES
('seo_default_title', 'DBT Unity - Диалектическая поведенческая терапия', 'text', 'Default page title'),
('seo_default_description', 'Комплексная ДБТ терапия для эффективного управления эмоциями и улучшения качества жизни', 'textarea', 'Default meta description'),
('seo_default_keywords', 'ДБТ, диалектическая поведенческая терапия, психотерапия, эмоциональная регуляция', 'text', 'Default meta keywords'),
('seo_og_image', '/img/unitydbt-logo.png', 'text', 'Default OpenGraph image');
