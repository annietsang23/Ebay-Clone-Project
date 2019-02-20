DROP DATABASE IF EXISTS DUMMY;
CREATE DATABASE DUMMY
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;
GRANT SELECT,UPDATE,INSERT,DELETE
ON DUMMY.*
TO 'at'@'localhost'
IDENTIFIED BY '123';
USE DUMMY;

CREATE TABLE IF NOT EXISTS Product
(
    productID INTEGER AUTO_INCREMENT PRIMARY KEY,
    product_description TEXT,
    price NUMERIC,
    quantity INTEGER,
    categoryID INTEGER,
    conditionID INTEGER,
    sellerID INTEGER,
    auctionable BOOLEAN,
    enddate VARCHAR(40)
) 
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Category
(
    categoryID INTEGER AUTO_INCREMENT PRIMARY KEY,
    categoryname VARCHAR(40) NOT NULL
) 
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS ConditionIndex
(
    conditionID INTEGER AUTO_INCREMENT PRIMARY KEY,
    conditionname VARCHAR(40) NOT NULL
) 
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Archive
(
    archiveID INTEGER AUTO_INCREMENT PRIMARY KEY,
    productID INTEGER NOT NULL,
    product_description TEXT NOT NULL,
    dealprice NUMERIC NOT NULL,
    quantity INTEGER NOT NULL,
    categoryID INTEGER NOT NULL,
    conditionID INTEGER NOT NULL,
    buyerID INTEGER NOT NULL,
    sellerID INTEGER NOT NULL,
    auctionable BOOLEAN NOT NULL,
    dealdate VARCHAR(40) NOT NULL
) 
ENGINE = InnoDB;

INSERT INTO Category (categoryname)
VALUES ('Electronics');

INSERT INTO Category (categoryname)
VALUES ('Food');

INSERT INTO Category (categoryname)
VALUES ('Fashion');

INSERT INTO Category (categoryname)
VALUES ('Home');

INSERT INTO Category (categoryname)
VALUES ('Health & Beauty');

INSERT INTO Category (categoryname)
VALUES ('Sports');

INSERT INTO Category (categoryname)
VALUES ('Toys & Games');

INSERT INTO Category (categoryname)
VALUES ('Art & Music');

INSERT INTO Category (categoryname)
VALUES ('Miscellaneous');

INSERT INTO ConditionIndex (conditionname)
VALUES ('New');

INSERT INTO ConditionIndex (conditionname)
VALUES ('Refurbished');

INSERT INTO ConditionIndex (conditionname)
VALUES ('Used / Worn');

INSERT INTO Archive (productID,product_description,dealprice,quantity,categoryID,conditionID,buyerID,sellerID,auctionable,dealdate)
VALUES (1,'macbook pro',1300,4,1,1,16,1,0,'2019-01-15');

INSERT INTO Archive (productID,product_description,dealprice,quantity,categoryID,conditionID,buyerID,sellerID,auctionable,dealdate)
VALUES (2,'macbook pro',1300,1,1,1,16,1,0,'2019-01-10');

INSERT INTO Archive (productID,product_description,dealprice,quantity,categoryID,conditionID,buyerID,sellerID,auctionable,dealdate)
VALUES (3,'macbook pro',815,1,1,3,16,2,1,'2019-01-20');

/*
CREATE PHOTOS TABLE 
*/ 

CREATE TABLE IF NOT EXISTS Photos (
	photoID INT NOT NULL,
	productID INT NOT NULL,
	file_path TEXT,
	PRIMARY KEY (photoID)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS BidEvents (
	bidID INT NOT NULL,
    productID INT NOT NULL,
    buyerID INT NOT NULL, 
    payment BOOL NOT NULL,
    bid_price TEXT,
    PRIMARY KEY (bidID)
) ENGINE=INNODB;
