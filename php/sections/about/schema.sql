-- Team members table schema and data
CREATE TABLE team_members
(
    id         INTEGER PRIMARY KEY AUTOINCREMENT,
    name       TEXT NOT NULL,
    position   TEXT,
    bio        TEXT,
    is_active  BOOLEAN  DEFAULT 1,
    sort_order INTEGER  DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);


-- Certification details table schema and data
CREATE TABLE certification_details
(
    id               INTEGER PRIMARY KEY AUTOINCREMENT,
    institution      TEXT NOT NULL,
    program          TEXT NOT NULL,
    part1_dates      TEXT,
    part2_dates      TEXT,
    certificate_file TEXT,
    created_at       DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at       DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Certification instructors table schema and data
CREATE TABLE certification_instructors
(
    id               INTEGER PRIMARY KEY AUTOINCREMENT,
    certification_id INTEGER NOT NULL,
    name             TEXT    NOT NULL,
    title            TEXT,
    sort_order       INTEGER  DEFAULT 0,
    created_at       DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (certification_id) REFERENCES certification_details (id)
);
