drop table if exists books;

create table books (
    id integer primary key autoincrement,
    title text not null,
    author text not null,
    year integer not null
);

insert into
    books (title, author, year)
values (
        'Clean Code',
        'Robert C. Martin',
        2008
    ),
    (
        'The Pragmatic Programmer',
        'Andy Hunt',
        1999
    ),
    (
        'Introduction to Algorithms',
        'Cormen et al.',
        2009
    ),
    (
        'You Do not Know JS',
        'Kyle Simpson',
        2015
    ),
    (
        'Design Patterns',
        'Erich Gamma',
        1994
    );

select * from books;