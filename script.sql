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

create table acquisitions(
                             id int not null primary key auto_increment,
                             users int not null,
                             total int,
                             dateOfEntry timestamp default now(),
                             completed int default 0
);

create table acquisitionCart(
                                id int not null primary key auto_increment,
                                users int not null,
                                products int not null,
                                conditions int not null
);

create table acquisitionProducts(
                                    id int not null primary key auto_increment,
                                    products int not null,
                                    conditions int not null,
                                    receipt varchar(255) not null,
                                    acquisitions int not null
);


create table paydesk(
                        id int not null primary key auto_increment,
                        users int not null,
                        products int not null,
                        title varchar(255) not null,
                        subtitle varchar(255) not null,
                        author varchar(255) not null,
                        conditions varchar(255) not null,
                        sellPrice int not null,
                        amount int not null
);

alter table product_categories add foreign key (products) references products(id) on delete cascade;
alter table product_categories add foreign key (categories) references categories(id) on delete cascade;

alter table product_conditions add foreign key (products) references products(id) on delete cascade;
alter table product_conditions add foreign key (conditions) references conditions(id) on delete cascade;

alter table acquisitions add foreign key (users) references users(id);
alter table acquisitionProducts add foreign key (products) references products(id) on delete cascade;
alter table acquisitionProducts add foreign key (conditions) references conditions(id) on delete cascade;
alter table acquisitionProducts add foreign key (acquisitions) references acquisitions(id) on delete cascade;






