-- Main application database schema

-- Core tables
CREATE TABLE IF NOT EXISTS sites (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(100) NOT NULL,
    domain VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS pages (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    site_id INTEGER NOT NULL,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    meta_description TEXT,
    meta_keywords TEXT,
    status TEXT CHECK(status IN ('draft', 'published')) DEFAULT 'draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (site_id) REFERENCES sites(id),
    UNIQUE (site_id, slug)
);

CREATE TABLE IF NOT EXISTS sections (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    page_id INTEGER,
    name VARCHAR(100) NOT NULL,
    title VARCHAR(255),
    description TEXT,
    type VARCHAR(50) NOT NULL,
    sort_order INTEGER DEFAULT 0,
    data TEXT,
    position INTEGER NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (page_id) REFERENCES pages(id)
);

-- Menu tables
CREATE TABLE IF NOT EXISTS menu_items (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR(100) NOT NULL,
    url VARCHAR(255) NOT NULL,
    parent_id INTEGER,
    position INTEGER DEFAULT 0,
    is_active INTEGER DEFAULT 1,
    target VARCHAR(20) DEFAULT '_self',
    icon_class VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_id) REFERENCES menu_items(id)
);

CREATE TABLE IF NOT EXISTS menu_categories (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL,
    description TEXT,
    parent_id INTEGER,
    sort_order INTEGER DEFAULT 0,
    is_active INTEGER DEFAULT 1,
    show_in_menu INTEGER DEFAULT 1,
    menu_position INTEGER DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_id) REFERENCES menu_categories(id)
);

-- Configuration table
CREATE TABLE IF NOT EXISTS config (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(100) NOT NULL UNIQUE,
    value TEXT,
    type VARCHAR(50) DEFAULT 'text',
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Meta table for SEO and social media metadata
CREATE TABLE IF NOT EXISTS meta (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    page_id TEXT NOT NULL,
    title TEXT,
    description TEXT,
    keywords TEXT,
    author TEXT,
    robots TEXT,
    og_title TEXT,
    og_description TEXT,
    og_image TEXT,
    og_type TEXT,
    twitter_card TEXT,
    twitter_site TEXT,
    twitter_creator TEXT,
    twitter_title TEXT,
    twitter_description TEXT,
    twitter_image TEXT,
    canonical_url TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(page_id)
);

-- Team members table
CREATE TABLE IF NOT EXISTS team_members (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(100) NOT NULL,
    title VARCHAR(100),
    bio TEXT,
    image_url VARCHAR(255),
    is_active INTEGER DEFAULT 1,
    sort_order INTEGER DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Certification details table
CREATE TABLE IF NOT EXISTS certification_details (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    certification_date DATE,
    expiry_date DATE,
    issuing_body VARCHAR(255),
    certificate_number VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Certification instructors table
CREATE TABLE IF NOT EXISTS certification_instructors (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    certification_id INTEGER,
    name VARCHAR(100) NOT NULL,
    title VARCHAR(100),
    bio TEXT,
    sort_order INTEGER DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (certification_id) REFERENCES certification_details(id)
);

-- Insert sample data
-- Default site
INSERT OR IGNORE INTO sites (id, name, domain) VALUES (1, 'Unity DBT', 'localhost:8007');

-- Home page
INSERT OR IGNORE INTO pages (id, site_id, title, slug, status) VALUES (1, 1, 'Unity DBT - Home', 'home', 'published');

-- Meta data for home page
INSERT OR IGNORE INTO meta (page_id, title, description, keywords) 
VALUES ('home', 'Unity DBT - Dialectical Behavior Therapy', 'Learn about our comprehensive DBT programs and services', 'DBT, therapy, mental health, mindfulness, emotion regulation');

-- Menu items
INSERT OR IGNORE INTO menu_items (title, url, position, is_active) VALUES
('Home', '/', 1, 1),
('About', '/about', 2, 1),
('Programs', '/programs', 3, 1),
('Training', '/training', 4, 1),
('Contact', '/contact', 5, 1);

-- Menu categories
INSERT OR IGNORE INTO menu_categories (name, slug, description, sort_order, is_active, show_in_menu) VALUES
('Main Menu', 'main-menu', 'Main navigation menu', 1, 1, 1),
('Footer Menu', 'footer-menu', 'Footer navigation menu', 2, 1, 1);

-- Menu configuration
INSERT OR IGNORE INTO config (name, value, type, description) VALUES
('menu_style', 'horizontal', 'text', 'Menu display style'),
('menu_animation', 'fade', 'text', 'Menu animation effect'),
('menu_position', 'top', 'text', 'Menu position on page');

-- Sections for home page
INSERT OR IGNORE INTO sections (page_id, name, title, description, type, sort_order, data) VALUES 
(1, 'hero', 'Welcome to Unity DBT', 'Comprehensive Dialectical Behavior Therapy Programs', 'hero', 1, 
'{"subtitle": "Evidence-based therapy for better living", "cta_text": "Learn More", "cta_link": "/about"}'),

(1, 'about', 'About Unity DBT', 'Discover our approach to Dialectical Behavior Therapy', 'about', 2,
'{"content": "Unity DBT provides comprehensive dialectical behavior therapy programs designed to help individuals develop effective coping skills and improve their quality of life.", "image": "/img/about-unity.jpg"}'),

(1, 'indications', 'Who Can Benefit', 'DBT can help with various challenges', 'indications', 3,
'{"items": [
    {"title": "Emotion Regulation", "icon": "emotion-icon.svg", "description": "Learn to understand and manage emotions effectively"},
    {"title": "Mindfulness", "icon": "mindfulness-icon.svg", "description": "Develop present-moment awareness and focus"},
    {"title": "Interpersonal Skills", "icon": "interpersonal-icon.svg", "description": "Improve relationships and communication"},
    {"title": "Stress Tolerance", "icon": "stress-icon.svg", "description": "Build resilience and cope with difficult situations"}
]}'),

(1, 'program', 'Our Programs', 'Comprehensive DBT Training and Support', 'program', 4,
'{"programs": [
    {"title": "Individual Therapy", "description": "One-on-one sessions tailored to your needs"},
    {"title": "Group Skills Training", "description": "Learn and practice DBT skills in a supportive group setting"},
    {"title": "Phone Coaching", "description": "Get support between sessions when needed"},
    {"title": "Therapist Consultation", "description": "Our team meets regularly to provide the best care"}
]}');

-- Sample team members
INSERT OR IGNORE INTO team_members (name, title, bio, is_active, sort_order) VALUES
('Dr. Sarah Johnson', 'Clinical Director', 'Dr. Johnson is a licensed psychologist with over 15 years of experience in DBT.', 1, 1),
('Dr. Michael Chen', 'Lead DBT Therapist', 'Dr. Chen specializes in adolescent DBT and family therapy.', 1, 2),
('Lisa Rodriguez, LCSW', 'Group Skills Trainer', 'Lisa has extensive experience leading DBT skills training groups.', 1, 3),
('James Wilson, PhD', 'Research Director', 'Dr. Wilson focuses on treatment outcomes and program development.', 1, 4);

-- Sample certification details
INSERT OR IGNORE INTO certification_details (
    title, 
    description, 
    certification_date, 
    expiry_date, 
    issuing_body, 
    certificate_number
) VALUES (
    'DBT-Linehan Board Certification',
    'Certified DBT program meeting highest standards of DBT treatment delivery',
    '2023-01-15',
    '2026-01-15',
    'DBT-Linehan Board of Certification',
    'DBT-2023-1234'
);

-- Sample certification instructors
INSERT OR IGNORE INTO certification_instructors (certification_id, name, title, sort_order) VALUES
(1, 'Dr. Sarah Johnson', 'Program Director', 1),
(1, 'Dr. Michael Chen', 'Lead Instructor', 2),
(1, 'Lisa Rodriguez, LCSW', 'Skills Training Supervisor', 3);

-- Configuration settings
INSERT OR IGNORE INTO config (name, value, type, description) VALUES
('site_name', 'Unity DBT', 'text', 'Website name'),
('contact_email', 'contact@unitydbt.com', 'email', 'Contact email address'),
('phone_number', '(555) 123-4567', 'text', 'Contact phone number'),
('address', '123 Therapy Street, Suite 100, Mental Health City, MH 12345', 'text', 'Physical address');
