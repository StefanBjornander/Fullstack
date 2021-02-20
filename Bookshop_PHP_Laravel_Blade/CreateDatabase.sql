drop database if exists bookshop;
create database bookshop;
use bookshop;

create table Books(id integer auto_increment key, author varchar(100), title varchar(100), price float);

insert into Books(author, title, price)
  values("Dean Koontz", "Jane Hawk", 100),
        ("David Baldacci", "Skulden", 200),
        ("Stephen King", "Talismanen", 300),
        ("Mans Kallentoft", "Se mig falla", 400),
        ("Anna Karolina", "Star dig ingen ater", 500),
        ("Markus Lutteman", "Leon", 600);

create table Orders(id integer, number integer, foreign key(id) references Books(id));

select * from Books;
select * from Orders;
