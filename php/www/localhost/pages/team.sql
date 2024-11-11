-- Create team page
INSERT INTO pages (site_id, title, slug, meta_description, status) 
VALUES (
    1, 
    'Our Team',
    'team',
    'Meet our dedicated team of professionals',
    'published'
);

-- Add team section using last_insert_rowid()
INSERT INTO sections (page_id, name, title, type, position)
VALUES (
    last_insert_rowid(),
    'team',
    'Our Team',
    'team',
    1
);
