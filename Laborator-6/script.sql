drop table if exists produse;

create table produse (
    id integer primary key autoincrement,
    denumire text not null,
    pret numeric not null,
    descriere text
);

insert into
    produse (denumire, pret, descriere)
values (
        'Produs A',
        99.99,
        'Descriere A'
    ),
    (
        'Produs B',
        49.50,
        'Descriere B'
    ),
    (
        'Produs C',
        30.00,
        'Descriere C'
    ),
    (
        'Produs D',
        15.75,
        'Descriere D'
    ),
    (
        'Produs E',
        120.00,
        'Descriere E'
    ),
    (
        'Produs F',
        60.95,
        'Descriere F'
    ),
    (
        'Produs G',
        22.30,
        'Descriere G'
    ),
    (
        'Produs H',
        80.49,
        'Descriere H'
    ),
    (
        'Produs I',
        5.99,
        'Descriere I'
    ),
    (
        'Produs J',
        250.00,
        'Descriere J'
    ),
    (
        'Produs K',
        14.00,
        'Descriere K'
    ),
    (
        'Produs L',
        42.42,
        'Descriere L'
    );

select * from produse;