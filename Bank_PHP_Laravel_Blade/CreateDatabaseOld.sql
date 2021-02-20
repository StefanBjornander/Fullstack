DROP DATABASE IF EXISTS Bank;CREATE DATABASE Bank;USE Bank;

CREATE TABLE customers(customerNumber INTEGER AUTO_INCREMENT KEY,
                       customerName VARCHAR(256));

CREATE TABLE accounts(accountNumber INTEGER AUTO_INCREMENT KEY,
                      customerNumber INTEGER,
                      FOREIGN KEY (customerNumber) REFERENCES customers(customerNumber));

CREATE TABLE events(accountNumber INTEGER,
                    time TIMESTAMP,
                    amount FLOAT,
                    FOREIGN KEY (accountNumber) REFERENCES accounts(accountNumber));

INSERT INTO customers(customerName)
  VALUES ('Adam Bertilsson'), ('Bertil Ceasarsson'),  ('Ceasar Davidsson'),
         ('David Eriksson'), ('Erik Filipsson'),  ('Filip Gustavsson');

INSERT INTO accounts(customerNumber) SELECT customerNumber FROM customers WHERE customerName = 'Adam Bertilsson';
INSERT INTO accounts(customerNumber) SELECT customerNumber FROM customers WHERE customerName = 'Bertil Ceasarsson';
INSERT INTO accounts(customerNumber) SELECT customerNumber FROM customers WHERE customerName = 'Adam Bertilsson';
INSERT INTO accounts(customerNumber) SELECT customerNumber FROM customers WHERE customerName = 'Bertil Ceasarsson';
INSERT INTO accounts(customerNumber) SELECT customerNumber FROM customers WHERE customerName = 'Adam Bertilsson';
INSERT INTO accounts(customerNumber) SELECT customerNumber FROM customers WHERE customerName = 'Bertil Ceasarsson';
INSERT INTO accounts(customerNumber) SELECT customerNumber FROM customers WHERE customerName = 'Ceasar Davidsson';
INSERT INTO accounts(customerNumber) SELECT customerNumber FROM customers WHERE customerName = 'David Eriksson';
INSERT INTO accounts(customerNumber) SELECT customerNumber FROM customers WHERE customerName = 'Ceasar Davidsson';
INSERT INTO accounts(customerNumber) SELECT customerNumber FROM customers WHERE customerName = 'David Eriksson';
INSERT INTO accounts(customerNumber) SELECT customerNumber FROM customers WHERE customerName = 'Erik Filipsson';
INSERT INTO accounts(customerNumber) SELECT customerNumber FROM customers WHERE customerName = 'Filip Gustavsson';

INSERT INTO events(accountNumber, amount) SELECT accountNumber, 100 FROM accounts;
INSERT INTO events(accountNumber, amount) SELECT accountNumber, -200 FROM accounts WHERE accountNumber = 1;
INSERT INTO events(accountNumber, amount) SELECT accountNumber, 200 FROM accounts WHERE accountNumber = 2;
INSERT INTO events(accountNumber, amount) SELECT accountNumber, -300 FROM accounts WHERE accountNumber = 3;

INSERT INTO accounts(customerNumber) SELECT customerNumber FROM customers WHERE customerName = 'Bertil Ceasarsson';
INSERT INTO accounts(customerNumber) SELECT customerNumber FROM customers WHERE customerName = 'Adam Bertilsson';
INSERT INTO accounts(customerNumber) SELECT customerNumber FROM customers WHERE customerName = 'Bertil Ceasarsson';
INSERT INTO accounts(customerNumber) SELECT customerNumber FROM customers WHERE customerName = 'Adam Bertilsson';
INSERT INTO accounts(customerNumber) SELECT customerNumber FROM customers WHERE customerName = 'Bertil Ceasarsson';
INSERT INTO accounts(customerNumber) SELECT customerNumber FROM customers WHERE customerName = 'Ceasar Davidsson';
INSERT INTO accounts(customerNumber) SELECT customerNumber FROM customers WHERE customerName = 'David Eriksson';
INSERT INTO accounts(customerNumber) SELECT customerNumber FROM customers WHERE customerName = 'Ceasar Davidsson';
INSERT INTO accounts(customerNumber) SELECT customerNumber FROM customers WHERE customerName = 'David Eriksson';
INSERT INTO accounts(customerNumber) SELECT customerNumber FROM customers WHERE customerName = 'Erik Filipsson';
INSERT INTO accounts(customerNumber) SELECT customerNumber FROM customers WHERE customerName = 'Filip Gustavsson';

select * from customers;
select * from accounts;
select * from events;
