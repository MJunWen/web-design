create table login (
    loginid int unsigned not null auto_increment primary key,
    user varchar(50) not null,
    pass varchar(50) not null
);
create table products (
    productid int unsigned not null auto_increment primary key,
    product_img_path varchar(50) not null,
    product_name varchar(50) not null,
    product_price float(10,2) not null,
    category varchar(50) not null,
    quantity int unsigned
);

 create table orders (
    orderid int unsigned not null auto_increment primary key,
    loginid int unsigned not null,
    productid int unsigned not null,
    amount float(6,2)
);
