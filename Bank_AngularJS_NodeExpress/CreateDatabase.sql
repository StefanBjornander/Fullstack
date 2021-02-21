drop database if exists bank_angularjs;
create database bank_angularjs;
use bank_angularjs;

drop table if exists customer;
create table customer (customer_number integer not null auto_increment key, customer_name varchar(256));
/*describe customer;*/

drop table if exists account;
create table account (account_number integer not null auto_increment key,
                      customer_number integer not null,
                      foreign key (customer_number) references customer(customer_number));
/*describe account;*/

drop table if exists history;
create table history (account_number integer not null, time timestamp, amount real,
                      foreign key (account_number) references account(account_number));
/*describe history;*/

delete from customer;
insert into customer(customer_name)
  values ('Adam Bertilsson'), ('Bertil Ceasarsson'),  ('Ceasar Davidsson'),
         ('David Eriksson'), ('Erik Filipsson'),  ('Filip Gustavsson');

delete from account;
insert into account(customer_number) select customer_number from customer where customer_name = 'Adam Bertilsson';
insert into account(customer_number) select customer_number from customer where customer_name = 'Bertil Ceasarsson';
insert into account(customer_number) select customer_number from customer where customer_name = 'Adam Bertilsson';
insert into account(customer_number) select customer_number from customer where customer_name = 'Bertil Ceasarsson';
insert into account(customer_number) select customer_number from customer where customer_name = 'Adam Bertilsson';
insert into account(customer_number) select customer_number from customer where customer_name = 'Bertil Ceasarsson';
insert into account(customer_number) select customer_number from customer where customer_name = 'Ceasar Davidsson';
insert into account(customer_number) select customer_number from customer where customer_name = 'David Eriksson';
insert into account(customer_number) select customer_number from customer where customer_name = 'Ceasar Davidsson';
insert into account(customer_number) select customer_number from customer where customer_name = 'David Eriksson';
insert into account(customer_number) select customer_number from customer where customer_name = 'Erik Filipsson';
insert into account(customer_number) select customer_number from customer where customer_name = 'Filip Gustavsson';
--delete from account where account_number = 1;

delete from history;
insert into history(account_number, amount) select account_number, 100 from account;
insert into history(account_number, amount) select account_number, 200 from account where account_number = 1;
insert into history(account_number, amount) select account_number, 200 from account where account_number = 2;
insert into history(account_number, amount) select account_number, 300 from account where account_number = 3;
insert into account(customer_number) select customer_number from customer where customer_name = 'Bertil Ceasarsson';
insert into account(customer_number) select customer_number from customer where customer_name = 'Adam Bertilsson';
insert into account(customer_number) select customer_number from customer where customer_name = 'Bertil Ceasarsson';
insert into account(customer_number) select customer_number from customer where customer_name = 'Adam Bertilsson';
insert into account(customer_number) select customer_number from customer where customer_name = 'Bertil Ceasarsson';
insert into account(customer_number) select customer_number from customer where customer_name = 'Ceasar Davidsson';
insert into account(customer_number) select customer_number from customer where customer_name = 'David Eriksson';
insert into account(customer_number) select customer_number from customer where customer_name = 'Ceasar Davidsson';
insert into account(customer_number) select customer_number from customer where customer_name = 'David Eriksson';
insert into account(customer_number) select customer_number from customer where customer_name = 'Erik Filipsson';
insert into account(customer_number) select customer_number from customer where customer_name = 'Filip Gustavsson';

select * from customer;
select customer_number, account_number from account order by customer_number;
select account_number, sum(amount) from history group by account_number;

/*
main
add_customer
customer_added
edit_customer
customer_edited
customer_removed
account_added
account_viewed
deposit
deposit_done
withdraw
withdraw_done
account_removed
*/