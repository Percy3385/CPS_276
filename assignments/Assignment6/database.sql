CREATE TABLE customer (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(255),
    lastname VARCHAR(255),
    address VARCHAR(255),
    city VARCHAR(255),
    state VARCHAR(255),
    zip VARCHAR(255),
    phone VARCHAR(255),
    email VARCHAR(255),
    password VARCHAR(255)
) ENGINE = InnoDB;
CREATE TABLE product_group (
    id INT AUTO_INCREMENT PRIMARY KEY,
    groupname VARCHAR(255),
    imagefolder VARCHAR(255)
) ENGINE = InnoDB;
CREATE TABLE product (
    id INT AUTO_INCREMENT PRIMARY KEY,
    groupid INT,
    productname VARCHAR(255),
    productprice VARCHAR(255),
    image VARCHAR(255),
    description VARCHAR(255)
) ENGINE = InnoDB;
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    timestamp INT,
    customerid INT
) ENGINE = InnoDB;
CREATE TABLE order_info (
    id INT AUTO_INCREMENT PRIMARY KEY,
    orderid INT,
    productid INT,
    amount INT
) ENGINE = InnoDB;
