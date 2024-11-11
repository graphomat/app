-- Contact sections configuration
INSERT OR IGNORE INTO sections (page_id, name, title, description, type, sort_order, data) VALUES
    (6, 'contact-info', 'Контактная информация', 'Как с нами связаться', 'contact', 1,
    '{"phone": "+7 (XXX) XXX-XX-XX", "email": "contact@unitydbt.ru", "address": "Адрес клиники"}'),
    (6, 'contact-form', 'Форма обратной связи', 'Отправьте нам сообщение', 'form', 2, '{}'),
    (6, 'map', 'Как добраться', 'Схема проезда', 'map', 3, '{"coordinates": "XX.XXXXX,XX.XXXXX"}');

-- Contact configuration
INSERT INTO config (name, value, type, description) VALUES
    ('contact_email', 'contact@unitydbt.com', 'email', 'Contact email address'),
    ('phone_number', '(555) 123-4567', 'text', 'Contact phone number'),
    ('address', '123 Therapy Street, Suite 100, Mental Health City, MH 12345', 'text', 'Physical address');
