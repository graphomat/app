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

-- Pages table
CREATE TABLE pages (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL UNIQUE,
    title TEXT NOT NULL,
    slug TEXT NOT NULL UNIQUE,
    template TEXT DEFAULT 'default',
    status TEXT DEFAULT 'draft',
    is_active BOOLEAN DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Sections table
CREATE TABLE sections (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL UNIQUE,
    title TEXT NOT NULL,
    description TEXT,
    type TEXT NOT NULL,
    sort_order INTEGER DEFAULT 0,
    is_active BOOLEAN DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Page sections relationship and ordering
CREATE TABLE page_sections (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    page_id INTEGER NOT NULL,
    section_id INTEGER NOT NULL,
    sort_order INTEGER DEFAULT 0,
    is_active BOOLEAN DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (page_id) REFERENCES pages(id),
    FOREIGN KEY (section_id) REFERENCES sections(id)
);

-- Section data storage
CREATE TABLE section_data (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    section_id INTEGER NOT NULL,
    page_id INTEGER NOT NULL,
    field_name TEXT NOT NULL,
    field_value TEXT,
    field_type TEXT DEFAULT 'text',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (section_id) REFERENCES sections(id),
    FOREIGN KEY (page_id) REFERENCES pages(id)
);

-- Components table
CREATE TABLE components (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL UNIQUE,
    title TEXT NOT NULL,
    description TEXT,
    type TEXT NOT NULL,
    is_active BOOLEAN DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Page components relationship and ordering
CREATE TABLE page_components (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    page_id INTEGER NOT NULL,
    component_id INTEGER NOT NULL,
    section_id INTEGER,
    sort_order INTEGER DEFAULT 0,
    is_active BOOLEAN DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (page_id) REFERENCES pages(id),
    FOREIGN KEY (component_id) REFERENCES components(id),
    FOREIGN KEY (section_id) REFERENCES sections(id)
);

-- Component data storage
CREATE TABLE component_data (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    component_id INTEGER NOT NULL,
    page_id INTEGER NOT NULL,
    field_name TEXT NOT NULL,
    field_value TEXT,
    field_type TEXT DEFAULT 'text',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (component_id) REFERENCES components(id),
    FOREIGN KEY (page_id) REFERENCES pages(id)
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
    FOREIGN KEY (page_id) REFERENCES pages(id)
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

-- Initial pages
INSERT INTO pages (name, title, slug, status, is_active) VALUES
('Home', 'Главная', 'home', 'published', 1),
('Training', 'Тренинг навыков', 'training', 'published', 1),
('About', 'О нас', 'about', 'published', 1),
('Contact', 'Контакты', 'contact', 'published', 1);

-- Initial sections
INSERT INTO sections (name, title, type, sort_order, is_active) VALUES
('hero', 'Hero Section', 'hero', 1, 1),
('about', 'About Section', 'about', 2, 1),
('program', 'Program Section', 'program', 3, 1),
('indications', 'Indications Section', 'indications', 4, 1),
('menu', 'Menu Section', 'menu', 5, 1),
('footer', 'Footer Section', 'footer', 6, 1);

-- Initial components
INSERT INTO components (name, title, type, is_active) VALUES
('gallery', 'Gallery Component', 'gallery', 1),
('upload', 'Upload Component', 'upload', 1),
('files', 'Files Component', 'files', 1);
