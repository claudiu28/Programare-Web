DROP TABLE IF EXISTS rute;

CREATE TABLE rute (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    plecare TEXT NOT NULL,
    sosire TEXT NOT NULL
);

INSERT INTO
    rute (plecare, sosire)
VALUES ('Oras1', 'Oras2'),
    ('Oras1', 'Oras3'),
    ('Oras2', 'Oras4'),
    ('Oras2', 'Oras5'),
    ('Oras3', 'Oras6'),
    ('Oras4', 'Oras1'),
    ('Oras5', 'Oras7'),
    ('Oras6', 'Oras8'),
    ('Oras7', 'Oras9'),
    ('Oras8', 'Oras10');