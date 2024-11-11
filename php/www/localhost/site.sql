-- Create site record for localhost
INSERT INTO sites (name, domain)
SELECT 'DBT Unity Local', 'localhost'
WHERE NOT EXISTS (
    SELECT 1 FROM sites WHERE domain = 'localhost'
);
