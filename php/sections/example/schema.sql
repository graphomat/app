-- Example section schema
CREATE TABLE IF NOT EXISTS example_section_data (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    section_id INTEGER NOT NULL,
    video_id VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (section_id) REFERENCES sections(id)
);

-- Create translations table if it doesn't exist
CREATE TABLE IF NOT EXISTS translations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    language_id INTEGER NOT NULL,
    content_type VARCHAR(50) NOT NULL,
    content_id INTEGER NOT NULL,
    field_name VARCHAR(100) NOT NULL,
    translation TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(language_id, content_type, content_id, field_name)
);

-- Create languages table if it doesn't exist
CREATE TABLE IF NOT EXISTS languages (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    code VARCHAR(5) NOT NULL UNIQUE,
    name VARCHAR(50) NOT NULL,
    is_default INTEGER DEFAULT 0,
    is_active INTEGER DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

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
