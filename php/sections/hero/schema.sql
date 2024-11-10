-- Hero section configuration
INSERT INTO sections (name, title, description, sort_order) VALUES
('hero', 'Hero Section', 'Main hero banner with call to action', 2);

-- Hero section specific configuration
INSERT INTO config (name, value, type, description) VALUES
('hero_title', 'Комплексная<br>ДБТ терапия', 'text', 'Hero section main title'),
('hero_subtitle', '"Создание жизни, достойной того чтобы жить"', 'text', 'Hero section subtitle'),
('hero_cta_text', 'ЗАПИСАТЬСЯ НА ПРИЕМ СПЕЦИАЛИСТА', 'text', 'Hero section CTA button text'),
('hero_image', 'img/unitydbt-logo.png', 'text', 'Hero section main image'),
('hero_image_alt', 'DBT Unity логотип - Диалектическая поведенческая терапия', 'text', 'Hero section image alt text');
