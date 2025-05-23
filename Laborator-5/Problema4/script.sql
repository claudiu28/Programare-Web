drop table if exists games;

CREATE TABLE games (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    tabla TEXT NOT NULL,
    status_curent TEXT NOT NULL,
    castigator TEXT
);

select * from games;