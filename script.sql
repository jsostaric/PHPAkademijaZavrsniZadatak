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

insert into users(username, email, password, admin)
            values('jsostaric', 'jura@example.com', '$2y$10$LKabvbFgUHjh1sWBGAse6.SGdDLfQZlg91AR96UrW4U5JMSgQMuE2', 1);

insert into categories(name, typeOfCat) values('Fiction', 'Book'),
                                                ('Crime and Thriller', 'Book'),
                                                ('Art', 'Book'),
                                                ('Crafts', 'Book'),
                                                ('History', 'Book'),
                                                ('Bussiness', 'Book'),
                                                ('Mathematics', 'Book'),
                                                ('Geography', 'Book'),
                                                ('Health', 'Book'),
                                                ('Pets', 'Book'),
                                                ('Rock', 'Music'),
                                                ('Pop', 'Music'),
                                                ('Synthwave', 'Music');

insert into products(title, subtitle, author, publisher, format, barcode, retailPrice)
            values('Neuromancer', '', 'William Gibson', 'Gollancz', 'paperback', '9781473217386', 159),
            ('The Colour Of Magic', '', 'Terry Pratchett', 'Corgi', 'paperback', '9780552124751', 69),
            ('The Hitchhikers Guide to the Galaxy', '', 'Douglas Adams', 'Zagrebačka naklada', 'paperback', '9789536996551', 79),
            ('Shadowrun','Never Deal With A Dragon', 'Robert N. Charette', 'RoC', 'paperback', '9780140152395', 99),
            ('Rebel Yell', '', 'Billy Idol', '', '', '094632145024', 59),
            ('The Name Of The Wind', '', 'Patrick Rothfuss', 'Gollancz', 'paperback', '9780575081406', 79),
            ('Blade Itself', '', 'Joe Abercrombie', 'Algoritam', 'paperback', '9789533168708', 40);

insert into conditions(name) values('Like New'), ('Good'), ('Bad');

insert into product_conditions(products, conditions, sellPrice, buyPrice, amount)
        values (1,1,110,55,2),
                (2,2,49,20,1),
                (3,2,40,20,1),
                (4,3,40,15,0),
                (5,3,45,20,0),
                (6,3,35,15,0),
                (7,2,20,10,1),
                (1,2,95,45,1),
                (3,2,45,20,1);

insert into product_categories(products,categories)
        values(1,1),(1,2),
                (2,5),
                (3,7),
                (4,4),(4,10),
                (5,11),
                (6,3),
                (7,6);