-- Team page configuration
INSERT OR IGNORE INTO pages (site_id, title, slug, meta_description, meta_keywords, status) VALUES
    (1, 'Специалисты Unity DBT', 'team',
    'Познакомьтесь с нашей командой сертифицированных специалистов по диалектической поведенческой терапии',
    'DBT терапевты, психологи, специалисты DBT, команда Unity DBT',
    'published');

-- Team page sections configuration
INSERT OR IGNORE INTO sections (page_id, name, title, description, type, sort_order, data, position) VALUES
    (4, 'specialists-intro', 'Наши специалисты', 'Команда сертифицированных DBT терапевтов', 'content', 1,
    '{"content": "Все наши специалисты прошли сертификацию по программе DBT Intensive Training и имеют многолетний опыт работы."}', 0),
    
    (4, 'team-full', 'Команда Unity DBT', 'Подробная информация о специалистах', 'team-full', 2, '{}', 1);
