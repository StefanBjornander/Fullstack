DROP DATABASE IF EXISTS CarRenter;
CREATE DATABASE CarRenter;
USE CarRenter;

CREATE TABLE Customer(person varchar(10), primary key (person),
                      name VARCHAR(256), address VARCHAR(256), postal varchar(256), phone varchar(10));

insert into Customer(person, name, address, postal, phone)
            values("9512249112", "Adam Bertilsson", "Stora gatan 1", "12345 Hjo", "0123456789"),
                  ("9405016750", "Bertil Ceasarsson", "Stora gatan 2", "12345 Hjo","0234567890"),
                  ("9412262587", "Ceasar Davidsson", "Stora gatan 3", "12345 Hjo", "0345678901"),
                  ("6212203738", "David Eriksson", "Stora gatan 4", "12345 Hjo", "0456789012"),
                  ("8706148049", "Erik Filipsson", "Stora gatan 5", "12345 Hjo", "0567890123"),
                  ("1103138606", "Filip Gustavsson", "Stora gatan 6", "12345 Hjo", "0678901234"),
                  ("2809144989", "Gustav Haraldsson", "Stora gatan 7", "12345 Hjo","0789012345"),
                  ("4006170130", "Harald Ivarsson", "Stora gatan 8", "12345 Hjo", "0890123467"),
                  ("2512270824", "Ivar Jakobsson", "Stora gatan 9", "12345 Hjo", "0901234678"),
                  ("3303060101", "Jakob Karlsson", "Stora gatan 10", "12345 Hjo", "0012346789");

CREATE TABLE Make(make varchar(100));
INSERT INTO Make(make) VALUES("Peugeot"),
                             ("Suzuki"),
                             ("Fiat"),
                             ("Honda"),
                             ("Ford"),
                             ("Hyundai"),
                             ("Renault"),
                             ("Toyota"),
                             ("Volkswagen"),
                             ("Chrystler");

CREATE TABLE Color(color varchar(100));
INSERT INTO Color(color) VALUES("Blue"), 
                               ("Red"),
                               ("Green"),
                               ("Yellow"),
                               ("Black"),
                               ("White"),
                               ("Magenta"),
                               ("Orange"),
                               ("Grey"),
                               ("Brown");

CREATE TABLE Car(registration varchar(6), primary key (registration),
                 make VARCHAR(256), color VARCHAR(256), year int, price float,
                 person varchar(10), foreign key (person) references Customer(person),
                 time datetime);

insert into Car(registration, make, color, year, price, person, time)
            values("ABC123", "Peugeot", "Blue", 2010, 100, "9512249112", current_timestamp()),
                  ("BCD234", "Suzuki", "Red", 2011, 200, null, null),
                  ("CDE345", "Fiat", "Green", 2012, 300, "9405016750", current_timestamp()),
                  ("EFG456", "Honda", "Yellow", 2013, 400, null, null),
                  ("FGH567", "Ford", "Black", 2014, 500, "8706148049", current_timestamp()),
                  ("GHI678", "Hyundai", "White", 2015, 600, null, null),
                  ("HIJ789", "Renault", "Magenta", 2016, 700, "9412262587", current_timestamp()),
                  ("IJK890", "Toyota", "Orange", 2017, 800, null, null),
                  ("JKL901", "Volkswagen", "Grey", 2018, 1000, "2512270824", current_timestamp()),
                  ("KLM012", "Chrystler", "Brown", 2019, 1100, null, null);

CREATE TABLE Event(registration varchar(6), foreign key (registration) references Car(registration),
                   person varchar(10), foreign key (person) references Customer(person),
                   checkOutTime datetime, checkInTime datetime, days int, cost float);

/*
insert into Event(person, registration, checkOutTime, checkInTime)
            values("9512249112", "ABC123", current_timestamp(), current_timestamp() + 10),
                  ("9405016750", "BCD234", current_timestamp(), current_timestamp() + 10),
                  ("9412262587", "CDE345", current_timestamp(), current_timestamp() + 10),
                  ("6212203738", "EFG456", current_timestamp(), current_timestamp() + 10),
                  ("8706148049", "FGH567", current_timestamp(), current_timestamp() + 10),
                  ("1103138606", "GHI678", current_timestamp(), current_timestamp() + 10),
                  ("2809144989", "HIJ789", current_timestamp(), current_timestamp() + 10),
                  ("4006170130", "IJK890", current_timestamp(), current_timestamp() + 10),
                  ("2512270824", "JKL901", current_timestamp(), current_timestamp() + 10),
                  ("3303060101", "KLM012", current_timestamp(), current_timestamp() + 10);
*/

select * from Customer;
select * from Car;
select * from Event;
select * from Make;
select * from Color;
