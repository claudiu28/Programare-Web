create table formular (
    id integer primary key autoincrement,
    nume text not null,
    telefon text not null,
    email text not null
);

insert into
    formular (nume, telefon, email)
values (
        'Andrei Popescu',
        '0723123456',
        'andrei.popescu@example.com'
    ),
    (
        'Maria Ionescu',
        '0744567890',
        'maria.ionescu@example.com'
    ),
    (
        'Ion Vasilescu',
        '0766123456',
        'ion.vasilescu@example.com'
    ),
    (
        'Elena Georgescu',
        '0733112233',
        'elena.georgescu@example.com'
    ),
    (
        'Alexandru Dobre',
        '0729988776',
        'alex.dobre@example.com'
    ),
    (
        'Cristina Petrescu',
        '0744123456',
        'cristina.petrescu@example.com'
    ),
    (
        'Mihai Marinescu',
        '0755667788',
        'mihai.marinescu@example.com'
    ),
    (
        'Ana Stan',
        '0733888444',
        'ana.stan@example.com'
    ),
    (
        'George Oprea',
        '0722333444',
        'george.oprea@example.com'
    ),
    (
        'Laura Toma',
        '0744777888',
        'laura.toma@example.com'
    ),
    (
        'Vlad Radu',
        '0766999888',
        'vlad.radu@example.com'
    ),
    (
        'Bianca Stoica',
        '0755333444',
        'bianca.stoica@example.com'
    );

select * from formular;