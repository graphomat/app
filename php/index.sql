-- Insert sample data
-- Default site
INSERT OR IGNORE INTO sites (id, name, domain) VALUES (1, 'Unity DBT', 'localhost:8007');

-- Home page
INSERT OR IGNORE INTO pages (id, site_id, title, slug, status) VALUES (1, 1, 'Unity DBT - Home', 'home', 'published');

-- Meta data for home page
INSERT OR IGNORE INTO meta (page_id, title, description, keywords) 
VALUES ('home', 'Unity DBT - Dialectical Behavior Therapy', 'Learn about our comprehensive DBT programs and services', 'DBT, therapy, mental health, mindfulness, emotion regulation');

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



-- Initial footer configuration
INSERT OR IGNORE INTO config (name, value, type, description) VALUES
    ('footer_copyright', '© 2024 DBT Unity. Все права защищены.', 'text', 'Footer copyright text'),
    ('footer_description', 'Комплексная ДБТ терапия для эффективного управления эмоциями', 'textarea', 'Footer description'),
    ('footer_columns', '3', 'number', 'Number of footer link columns'),
    ('footer_logo', 'img/unitydbt-logo.png', 'text', 'Footer logo image path');

-- Initial footer links
INSERT INTO footer_links (title, url, column_number, sort_order) VALUES
                                                                     ('О нас', '/about', 1, 1),
                                                                     ('Наша команда', '/team', 1, 2),
                                                                     ('Контакты', '/contact', 1, 3),
                                                                     ('Услуги', '/services', 2, 1),
                                                                     ('Тренинг навыков', '/training', 2, 2),
                                                                     ('Консультации', '/consultations', 2, 3),
                                                                     ('Блог', '/blog', 3, 1),
                                                                     ('Политика конфиденциальности', '/privacy', 3, 2),
                                                                     ('Условия использования', '/terms', 3, 3);

-- Initial social media links
INSERT INTO footer_social (platform, url, icon_svg, sort_order) VALUES
                                                                    ('Facebook', 'https://facebook.com/dbtunity', '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"></path></svg>', 1),
                                                                    ('Instagram', 'https://instagram.com/dbtunity', '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd"></path></svg>', 2),
                                                                    ('Telegram', 'https://t.me/dbtunity', '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69.01-.03.01-.14-.07-.2-.08-.06-.19-.04-.27-.02-.12.02-1.96 1.25-5.54 3.69-.52.36-1 .53-1.42.52-.47-.01-1.37-.26-2.04-.48-.82-.27-1.48-.42-1.42-.88.03-.24.27-.48.74-.73 2.87-1.25 4.79-2.08 5.76-2.5 2.74-1.19 3.31-1.4 3.68-1.41.08 0 .27.02.39.12.1.08.13.19.14.27-.01.06.01.24 0 .24z"></path></svg>', 3);


-- Insert default translations
INSERT OR REPLACE INTO translations (language_id, content_type, content_id, field_name, translation)
SELECT
    l.id,
    'section',
    1,
    t.field_name,
    t.default_text
FROM languages l,
     (
         SELECT 'example_section_title' as field_name, 'Example Section' as default_text
         UNION SELECT 'example_section_description', 'This section demonstrates the integration capabilities including YouTube embedding and multilingual content.'
         UNION SELECT 'example_block1_title', 'Feature One'
         UNION SELECT 'example_block1_content', 'This block showcases how to use translations in your content. The text you are reading is automatically translated based on the selected language.'
         UNION SELECT 'example_block2_title', 'Feature Two'
         UNION SELECT 'example_block2_content', 'This block demonstrates dynamic content integration. You can embed videos and other content using shortcodes, making your sections more interactive.'
     ) t
WHERE l.is_default = 1;

-- Insert Spanish translations
INSERT OR REPLACE INTO translations (language_id, content_type, content_id, field_name, translation)
SELECT
    l.id,
    'section',
    1,
    t.field_name,
    t.spanish_text
FROM languages l,
     (
         SELECT 'example_section_title' as field_name, 'Sección de Ejemplo' as spanish_text
         UNION SELECT 'example_section_description', 'Esta sección demuestra las capacidades de integración, incluyendo la incrustación de YouTube y contenido multilingüe.'
         UNION SELECT 'example_block1_title', 'Característica Uno'
         UNION SELECT 'example_block1_content', 'Este bloque muestra cómo usar traducciones en su contenido. El texto que está leyendo se traduce automáticamente según el idioma seleccionado.'
         UNION SELECT 'example_block2_title', 'Característica Dos'
         UNION SELECT 'example_block2_content', 'Este bloque demuestra la integración de contenido dinámico. Puede incrustar videos y otro contenido usando códigos cortos, haciendo sus secciones más interactivas.'
     ) t
WHERE l.code = 'es';

-- Example webhook configuration 2
INSERT OR REPLACE INTO admin_integrations (name, type, config, is_active)
VALUES (
    'Example Section Updates',
    'webhook',
    '{
        "url": "https://api.example.com/webhooks/content-updates",
        "events": ["content.created", "content.updated", "content.deleted"],
        "secret_key": "your-secret-key-here"
    }',
    1
    );

-- Example shortcode configuration
INSERT OR REPLACE INTO admin_integrations (name, type, config, is_active)
VALUES
    (
    'YouTube Embed',
    'shortcode',
    '{
        "tag": "youtube",
        "handler": "YouTubeShortcode",
        "description": "Embeds a YouTube video using the video ID"
    }',
    1
    ),
    (
    'Translation',
    'shortcode',
    '{
        "tag": "translate",
        "handler": "TranslationProcessor",
        "description": "Displays translated content based on the current language"
    }',
    1
    );




-- Initial footer configuration
INSERT OR IGNORE INTO config (name, value, type, description) VALUES
    ('footer_copyright', '© 2024 DBT Unity. Все права защищены.', 'text', 'Footer copyright text'),
    ('footer_description', 'Комплексная ДБТ терапия для эффективного управления эмоциями', 'textarea', 'Footer description'),
    ('footer_columns', '3', 'number', 'Number of footer link columns'),
    ('footer_logo', 'img/unitydbt-logo.png', 'text', 'Footer logo image path');

-- Initial footer links
INSERT INTO footer_links (title, url, column_number, sort_order) VALUES
                                                                     ('О нас', '/about', 1, 1),
                                                                     ('Наша команда', '/team', 1, 2),
                                                                     ('Контакты', '/contact', 1, 3),
                                                                     ('Услуги', '/services', 2, 1),
                                                                     ('Тренинг навыков', '/training', 2, 2),
                                                                     ('Консультации', '/consultations', 2, 3),
                                                                     ('Блог', '/blog', 3, 1),
                                                                     ('Политика конфиденциальности', '/privacy', 3, 2),
                                                                     ('Условия использования', '/terms', 3, 3);

-- Initial social media links
INSERT INTO footer_social (platform, url, icon_svg, sort_order) VALUES
                                                                    ('Facebook', 'https://facebook.com/dbtunity', '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"></path></svg>', 1),
                                                                    ('Instagram', 'https://instagram.com/dbtunity', '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd"></path></svg>', 2),
                                                                    ('Telegram', 'https://t.me/dbtunity', '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69.01-.03.01-.14-.07-.2-.08-.06-.19-.04-.27-.02-.12.02-1.96 1.25-5.54 3.69-.52.36-1 .53-1.42.52-.47-.01-1.37-.26-2.04-.48-.82-.27-1.48-.42-1.42-.88.03-.24.27-.48.74-.73 2.87-1.25 4.79-2.08 5.76-2.5 2.74-1.19 3.31-1.4 3.68-1.41.08 0 .27.02.39.12.1.08.13.19.14.27-.01.06.01.24 0 .24z"></path></svg>', 3);



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


-- Menu section configuration
INSERT OR REPLACE INTO sections (name, title, description, type, sort_order) VALUES
    ('menu', 'Menu Section', 'Main navigation menu', 'menu', 1);

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


-- Initial categories
INSERT INTO menu_categories (name, slug, description, show_in_menu, menu_position) VALUES
                                                                                       ('Блог', 'blog', 'Статьи и новости', 1, 6),
                                                                                       ('Услуги', 'services', 'Наши услуги', 1, 7);


-- Program section configuration
INSERT OR REPLACE INTO sections (name, title, description, type, sort_order) VALUES
    ('program', 'Program Section', 'DBT program components', 'program', 5);

-- Initial program components data
INSERT INTO program_components (title, description, icon_svg, sort_order) VALUES
                                                                              ('Индивидуальные сессии',
                                                                               'с личным терапевтом в течение 24-48 недель',
                                                                               '<svg class="w-12 h-12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M20 7L12 3L4 7M20 7L12 11M20 7V17L12 21M12 11L4 7M12 11V21M4 7V17L12 21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                                                                               1),
                                                                              ('Кризисное консультирование',
                                                                               '24/7 по телефону во время кризиса',
                                                                               '<svg class="w-12 h-12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M3 5C3 3.89543 3.89543 3 5 3H8.27924C8.70967 3 9.09181 3.27543 9.22792 3.68377L10.7257 8.17721C10.8831 8.64932 10.6694 9.16531 10.2243 9.38787L7.96701 10.5165C9.06925 12.9612 11.0388 14.9308 13.4835 16.033L14.6121 13.7757C14.8347 13.3306 15.3507 13.1169 15.8228 13.2743L20.3162 14.7721C20.7246 14.9082 21 15.2903 21 15.7208V19C21 20.1046 20.1046 21 19 21H18C9.71573 21 3 14.2843 3 6V5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                                                                               2),
                                                                              ('Тренинг навыков',
                                                                               '24-48 недель',
                                                                               '<svg class="w-12 h-12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M12 6.25278V19.2528M12 6.25278C10.8321 5.47686 9.24649 5 7.5 5C5.75351 5 4.16789 5.47686 3 6.25278V19.2528C4.16789 18.4769 5.75351 18 7.5 18C9.24649 18 10.8321 18.4769 12 19.2528M12 6.25278C13.1679 5.47686 14.7535 5 16.5 5C18.2465 5 19.8321 5.47686 21 6.25278V19.2528C19.8321 18.4769 18.2465 18 16.5 18C14.7535 18 13.1679 18.4769 12 19.2528" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                                                                               3);

-- Program section specific configuration
INSERT INTO config (name, value, type, description) VALUES
                                                        ('program_title', 'Что включает в себя комплексная ДБТ программа', 'text', 'Program section main title'),
                                                        ('program_subtitle', 'Наша программа состоит из трех основных компонентов, которые работают вместе для достижения максимальной эффективности терапии', 'text', 'Program section subtitle'),
                                                        ('program_show_cta', 'true', 'boolean', 'Show call to action button'),
                                                        ('program_cta_text', 'ЗАПИСАТЬСЯ НА ПРИЕМ СПЕЦИАЛИСТА', 'text', 'Call to action button text'),
                                                        ('program_cta_link', '#contact', 'text', 'Call to action button link');


-- Indications section configuration
INSERT OR REPLACE INTO sections (name, title, description, type, sort_order) VALUES
    ('indications', 'Indications Section', 'DBT therapy indications', 'indications', 4);

-- Initial DBT indications data
INSERT INTO dbt_indications (title, description, sort_order) VALUES
                                                                 ('Трудности с регуляцией эмоционального состояния', 'Помощь в управлении эмоциями и развитии навыков эмоциональной регуляции.', 1),
                                                                 ('Пограничное расстройство личности', 'Эффективная терапия для людей с ПРЛ, помогающая стабилизировать эмоции и улучшить межличностные отношения.', 2),
                                                                 ('Биполярное аффективное расстройство (БАР)', 'Поддержка в управлении симптомами БАР и предотвращении рецидивов.', 3),
                                                                 ('Расстройства пищевого поведения', 'Работа над нормализацией пищевого поведения и связанных с ним эмоциональных трудностей.', 4),
                                                                 ('Синдром дефицита внимания с гиперактивностью (СДВГ)', 'Развитие навыков концентрации и управления импульсивностью.', 5),
                                                                 ('Посттравматическое стрессовое расстройство', 'Помощь в преодолении последствий травмы и развитии устойчивости.', 6),
                                                                 ('Химические и нехимические зависимости', 'Работа с зависимым поведением и развитие здоровых копинг-стратегий.', 7);

-- Indications section specific configuration
INSERT INTO config (name, value, type, description) VALUES
                                                        ('indications_title', 'Кому показана комплексная ДБТ программа', 'text', 'Indications section main title'),
                                                        ('indications_subtitle', 'Диалектическая поведенческая терапия эффективна при следующих состояниях:', 'text', 'Indications section subtitle'),
                                                        ('indications_show_cta', 'true', 'boolean', 'Show call to action button'),
                                                        ('indications_cta_text', 'Записаться на консультацию', 'text', 'Call to action button text'),
                                                        ('indications_cta_link', '#contact', 'text', 'Call to action button link');
