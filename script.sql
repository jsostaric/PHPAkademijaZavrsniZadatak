drop database if exists polaznik22;
create database polaznik22 character set utf8mb4 collate utf8mb4_unicode_ci;
use polaznik22;

-- mysql -uroot --default_character_set=utf8mb4 < C:\Users\BoogieLee\PhpstormProjects\antikvarijat\script.sql


create table users(
    id int not null primary key auto_increment,
    username varchar(255) not null,
    email varchar(255) not null,
    password char(60) not null,
    admin bool default 0
);

create table products(
    id int not null primary key auto_increment,
    title varchar(255) not null,
    subtitle varchar(255),
    author varchar(255) not null,
    barcode bigint,
    retail_price int
);

create table conditions(
    id int not null primary key auto_increment,
    name varchar(255) not null,
    sell_price int,
    buy_price int
);

create table repurchases(
    id int not null primary key auto_increment,
    title varchar(255) not null,
    barcode int
);

create table offers(
    id int not null primary key auto_increment,
    product int not null,
    conditions int not null,
    buy_price int not null
);

create table orders(
     id int not null primary key auto_increment,
    product int not null,
    conditions int not null,
    buy_price int not null
);

insert into users(username, email, password, admin)
            values('jsostaric', 'jura@example.com', '$2y$10$LKabvbFgUHjh1sWBGAse6.SGdDLfQZlg91AR96UrW4U5JMSgQMuE2', 1);

insert into products(title,subtitle, author, barcode, retail_price)
            values('Neuromancer', '', 'William Gibson', 9781473217386, 159),
            ('The Colour Of Magic', '', 'Terry Pratchett', 9780552124751, 69),
            ("The Hitchhiker''s Guide to the Galaxy", '', 'Douglas Adams', 9789536996551, 79),
            ('Shadowrun','Never Deal With A Dragon', 'Robert N. Charette', 9780140152395, 99),
            ('Rebel Yell', '', 'Billy Idol', 094632145024, 59),
            ('The Name Of The Wind', '', 'Patrick Rothfuss', 9780575081406, 79),
            ('Blade Itself', '', 'Joe Abercrombie', 9789533168708, 40);