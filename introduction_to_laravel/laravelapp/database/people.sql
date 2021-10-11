create table people (
 id integer primary key autoincrement,
 name text not null,
 mail text,
 age integer
);

insert into people values (1, 'taro', 'taro@yamada.jp', 35);
insert into people values (2, 'hanako', 'hanako@yamada.jp', 24);
insert into people values (3, 'sachiko', 'sachiko@happy.org', 47);