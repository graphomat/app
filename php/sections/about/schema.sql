-- About section configuration
INSERT OR REPLACE INTO sections (name, title, description, type, sort_order) VALUES
('about', 'About Section', 'Information about the team and certification', 'about', 3);

-- Team members table schema and data
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

INSERT INTO team_members (name, sort_order) VALUES
('Daria Dymont', 1),
('Ekaterina Khisamieva', 2),
('Anastasia Nikolaeva', 3),
('Alsou Fazullina', 4),
('Olga Sapietta', 5),
('Liudmila Grishanova', 6);

-- Certification details table schema and data
CREATE TABLE certification_details (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    institution TEXT NOT NULL,
    program TEXT NOT NULL,
    part1_dates TEXT,
    part2_dates TEXT,
    certificate_file TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO certification_details (institution, program, part1_dates, part2_dates, certificate_file) VALUES
('Behavioral Tech Institute', 'DBT Intensive Training', 
 'March 1-3, 2024 & April 5-7, 2024', 
 'September 20-22, 2024 & October 11-13, 2024',
 'Cert_Unity_241108_073542.pdf');

-- Certification instructors table schema and data
CREATE TABLE certification_instructors (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    certification_id INTEGER NOT NULL,
    name TEXT NOT NULL,
    title TEXT,
    sort_order INTEGER DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (certification_id) REFERENCES certification_details(id)
);

INSERT INTO certification_instructors (certification_id, name, title, sort_order) VALUES
(1, 'André Ivanoff', 'PhD', 1),
(1, 'Dmitry Pushkarev', 'MD, PhD', 2);

-- About section specific configuration
INSERT INTO config (name, value, type, description) VALUES
('about_cert_image', 'img/unitydbt-cert.png', 'text', 'Certification image path'),
('about_cert_image_alt', 'Сертификат DBT Intensive Training от Behavioral Tech Institute', 'text', 'Certification image alt text');
