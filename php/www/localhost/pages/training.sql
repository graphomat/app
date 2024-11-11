-- Get site ID and create training page
INSERT INTO pages (site_id, title, slug, meta_description, status)
SELECT 
    id,
    'Training | DBT Unity',
    'training',
    'DBT Skills Training Program - Learn essential skills for emotional regulation, mindfulness, and interpersonal effectiveness.',
    'published'
FROM sites 
WHERE domain = 'localhost'
AND NOT EXISTS (
    SELECT 1 FROM pages WHERE slug = 'training'
);

-- Create training-intro section
INSERT INTO sections (page_id, name, title, description, type, sort_order)
SELECT 
    p.id,
    'training-intro',
    'DBT Skills Training Program',
    'Our comprehensive DBT skills training program is designed to help you develop essential skills for managing emotions, improving relationships, and building a life worth living.',
    'content',
    0
FROM pages p
WHERE p.slug = 'training'
AND NOT EXISTS (
    SELECT 1 FROM sections s 
    JOIN pages p2 ON s.page_id = p2.id 
    WHERE p2.slug = 'training' AND s.name = 'training-intro'
);

-- Create modules section
INSERT INTO sections (page_id, name, title, description, type, sort_order, data)
SELECT 
    p.id,
    'modules',
    'Core Training Modules',
    'Our DBT skills training program consists of four essential modules that work together to build comprehensive emotional management and interpersonal skills.',
    'modules',
    1,
    '{
        "modules": [
            {
                "title": "Mindfulness",
                "description": "Develop skills for staying present in the moment and observing without judgment.",
                "icon": "/img/mindfulness-icon.svg"
            },
            {
                "title": "Distress Tolerance",
                "description": "Learn effective techniques for managing crisis situations and emotional pain.",
                "icon": "/img/stress-icon.svg"
            },
            {
                "title": "Emotion Regulation",
                "description": "Master skills for understanding and managing your emotions effectively.",
                "icon": "/img/emotion-icon.svg"
            },
            {
                "title": "Interpersonal Effectiveness",
                "description": "Improve your relationships through better communication and boundary-setting skills.",
                "icon": "/img/interpersonal-icon.svg"
            }
        ]
    }'
FROM pages p
WHERE p.slug = 'training'
AND NOT EXISTS (
    SELECT 1 FROM sections s 
    JOIN pages p2 ON s.page_id = p2.id 
    WHERE p2.slug = 'training' AND s.name = 'modules'
);
