drop database if exists polaznik22;
create database polaznik22 character set utf8mb4 collate utf8mb4_unicode_ci;
use polaznik22;

create table users(
    id int not null primary key auto_increment,
    username varchar(255) not null,
    email varchar(255) not null,
    password char(60) not null,
    admin bool default 0
);

create table categories(
    id int not null primary key auto_increment,
    name varchar(255) not null,
    typeOfCat varchar(255) not null default 'Book'
);

create table products(
    id int not null primary key auto_increment,
    title varchar(255) not null,
    subtitle varchar(255),
    author varchar(255) not null,
    barcode varchar(255),
    publisher varchar(255) default 'N/A',
    year varchar(255),
    format varchar(255),
    retailPrice int,
    description text,
    image varchar(255)
);

create table conditions(
    id int not null primary key auto_increment,
    name varchar(255) not null
);

create table product_conditions(
    id int not null primary key auto_increment,
    products int not null,
    conditions int not null,
    sellPrice int not null,
    buyPrice int,
    amount int default 0
);

create table product_categories(
    id int not null primary key auto_increment,
    products int not null,
    categories int not null
);

create table aqusitions(
    id int not null primary key auto_increment,
    title varchar(255) not null,
    barcode int
);

create table orders(
    id int not null primary key auto_increment,
    product int not null,
    conditions int not null,
    buy_price int not null
);

create table offers(
    id int not null primary key auto_increment,
    product int not null,
    conditions int not null,
    buy_price int not null
);

alter table product_categories add foreign key (products) references products(id);
alter table product_categories add foreign key (categories) references categories(id);

alter table product_conditions add foreign key (products) references products(id);
alter table product_conditions add foreign key (conditions) references conditions(id);