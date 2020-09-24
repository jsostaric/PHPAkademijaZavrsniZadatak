drop database if exists polaznik22;
create database polaznik22 character set utf8mb4 collate utf8mb4_unicode_ci;
use polaznik22;

create table users(
    id int not null primary key auto_increment,
    username varchar(255) not null,
    email varchar(255) not null,
    password char(60) not null,
    admin int default 0
);

create table products(
    id int not null primary key auto_increment,
    title varchar(255) not null,
    subtitle varchar(255),
    author varchar(255) not null,
    barcode int,
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