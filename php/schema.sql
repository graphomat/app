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

-- Team members table
CREATE TABLE team_members (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    position TEXT,
    bio TEXT,
    is_active BOOLEAN DEFAULT 1,
    sort_order INTEGER DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Certification details table
CREATE TABLE certification_details (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    institution TEXT NOT NULL,
    program TEXT NOT NULL,
    part1_dates TEXT,
    part2_dates TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Certification instructors table
CREATE TABLE certification_instructors (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    certification_id INTEGER NOT NULL,
    name TEXT NOT NULL,
    title TEXT,
    sort_order INTEGER DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (certification_id) REFERENCES certification_details(id)
);

-- DBT indications table
CREATE TABLE dbt_indications (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    description TEXT,
    sort_order INTEGER DEFAULT 0,
    is_active BOOLEAN DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Program components table
CREATE TABLE program_components (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    description TEXT,
    icon_svg TEXT,
    sort_order INTEGER DEFAULT 0,
    is_active BOOLEAN DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Initial admin user (password: admin123)
INSERT INTO users (username, password_hash, api_token) VALUES
('admin', '$2y$10$8K1p/a4SWJ1Fm4.5qGkZyOQz6lS6sS6X3g4W5XG5gYX5tG8IhVm2.', '4440f76d4926ae623eb93023c4e2e11d93cb6ea1c542617d8b54a9e989749b7b'),
('olga', '$2y$10$bvSA8B6LsPGorgRrM1ACS.1durPvwxljm5pvDFKlsugDakHdO5m9S', '4440f76d4926ae623eb93023c4e2e11d93cb6ea1c542617d8b54a9e989749b7b');

-- Initial site configuration
INSERT INTO config (name, value, type, description) VALUES
('site_name', 'DBT Unity', 'text', 'Site name'),
('site_description', 'Комплексная ДБТ терапия', 'textarea', 'Site description'),
('contact_email', 'info@dbt-unity.com', 'email', 'Contact email'),
('contact_phone', '+1 (234) 567-890', 'text', 'Contact phone'),
('app_env', 'production', 'text', 'Application environment'),
('app_debug', 'false', 'boolean', 'Debug mode'),
('app_url', 'http://localhost:8007', 'text', 'Application URL'),
('admin_session_lifetime', '120', 'number', 'Admin session lifetime in minutes'),
('api_version', '1.0', 'text', 'API version'),
('hero_title', 'Комплексная<br>ДБТ терапия', 'text', 'Hero section main title'),
('hero_subtitle', '"Создание жизни, достойной того чтобы жить"', 'text', 'Hero section subtitle'),
('hero_cta_text', 'ЗАПИСАТЬСЯ НА ПРИЕМ СПЕЦИАЛИСТА', 'text', 'Hero section CTA button text');

-- Initial sections
INSERT INTO sections (name, title, description, sort_order) VALUES
('header', 'Header Section', 'Main site header with navigation', 1),
('hero', 'Hero Section', 'Main hero banner with call to action', 2),
('about', 'About Section', 'Information about the team and certification', 3),
('indications', 'Indications Section', 'DBT therapy indications', 4),
('program', 'Program Section', 'DBT program components', 5),
('footer', 'Footer Section', 'Site footer with additional links', 6);

-- Initial menu items
INSERT INTO menu_items (title, url, position) VALUES
('О НАС', 'index.php', 1),
('ТРЕНИНГ НАВЫКОВ', 'training.php', 2),
('СПЕЦИАЛИСТЫ', 'specialists.php', 3),
('ЧТО ТАКОЕ ДБТ', 'about-dbt.php', 4),
('КОНТАКТЫ', 'contact.php', 5);

-- Initial team members
INSERT INTO team_members (name, sort_order) VALUES
('Daria Dymont', 1),
('Ekaterina Khisamieva', 2),
('Anastasia Nikolaeva', 3),
('Alsou Fazullina', 4),
('Olga Sapietta', 5),
('Liudmila Grishanova', 6);

-- Initial certification details
INSERT INTO certification_details (institution, program, part1_dates, part2_dates) VALUES
('Behavioral Tech Institute', 'DBT Intensive Training', 'March 1-3, 2024 & April 5-7, 2024', 'September 20-22, 2024 & October 11-13, 2024');

-- Initial certification instructors
INSERT INTO certification_instructors (certification_id, name, title, sort_order) VALUES
(1, 'André Ivanoff', 'PhD', 1),
(1, 'Dmitry Pushkarev', 'MD, PhD', 2);

-- Initial DBT indications
INSERT INTO dbt_indications (title, description, sort_order) VALUES
('Трудности с регуляцией эмоционального состояния', 'Помощь в управлении эмоциями и развитии навыков эмоциональной регуляции.', 1),
('Пограничное расстройство личности', 'Эффективная терапия для людей с ПРЛ, помогающая стабилизировать эмоции и улучшить межличностные отношения.', 2),
('Биполярное аффективное расстройство (БАР)', 'Поддержка в управлении симптомами БАР и предотвращении рецидивов.', 3),
('Расстройства пищевого поведения', 'Работа над нормализацией пищевого поведения и связанных с ним эмоциональных трудностей.', 4),
('Синдром дефицита внимания с гиперактивностью (СДВГ)', 'Развитие навыков концентрации и управления импульсивностью.', 5),
('Посттравматическое стрессовое расстройство', 'Помощь в преодолении последствий травмы и развитии устойчивости.', 6),
('Химические и нехимические зависимости', 'Работа с зависимым поведением и развитие здоровых копинг-стратегий.', 7);

-- Initial program components
INSERT INTO program_components (title, description, icon_svg, sort_order) VALUES
('Индивидуальные сессии', 'с личным терапевтом в течение 24-48 недель', '<svg class="w-12 h-12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M20 7L12 3L4 7M20 7L12 11M20 7V17L12 21M12 11L4 7M12 11V21M4 7V17L12 21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>', 1),
('Кризисное консультирование', '24/7 по телефону во время кризиса', '<svg class="w-12 h-12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M3 5C3 3.89543 3.89543 3 5 3H8.27924C8.70967 3 9.09181 3.27543 9.22792 3.68377L10.7257 8.17721C10.8831 8.64932 10.6694 9.16531 10.2243 9.38787L7.96701 10.5165C9.06925 12.9612 11.0388 14.9308 13.4835 16.033L14.6121 13.7757C14.8347 13.3306 15.3507 13.1169 15.8228 13.2743L20.3162 14.7721C20.7246 14.9082 21 15.2903 21 15.7208V19C21 20.1046 20.1046 21 19 21H18C9.71573 21 3 14.2843 3 6V5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>', 2),
('Тренинг навыков', '24-48 недель', '<svg class="w-12 h-12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M12 6.25278V19.2528M12 6.25278C10.8321 5.47686 9.24649 5 7.5 5C5.75351 5 4.16789 5.47686 3 6.25278V19.2528C4.16789 18.4769 5.75351 18 7.5 18C9.24649 18 10.8321 18.4769 12 19.2528M12 6.25278C13.1679 5.47686 14.7535 5 16.5 5C18.2465 5 19.8321 5.47686 21 6.25278V19.2528C19.8321 18.4769 18.2465 18 16.5 18C14.7535 18 13.1679 18.4769 12 19.2528" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>', 3);
