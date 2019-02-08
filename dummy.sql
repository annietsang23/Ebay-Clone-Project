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
    categoryID VARCHAR(2),
    conditionID VARCHAR(40),
    sellerID VARCHAR(40),
    auctionable BOOLEAN,
    enddate VARCHAR(40),
) 
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Category
(
    categoryID VARCHAR(2) PRIMARY KEY,
    categoryname VARCHAR(40) NOT NULL
) 
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS ConditionIndex
(
    conditionID VARCHAR(2) PRIMARY KEY,
    conditionname VARCHAR(40) NOT NULL
) 
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Archive
(
    archiveID INTEGER AUTO_INCREMENT PRIMARY KEY,
    productID VARCHAR(11) NOT NULL,
    product_description TEXT NOT NULL,
    dealprice NUMERIC NOT NULL,
    quantity INTEGER NOT NULL,
    categoryID VARCHAR(2) NOT NULL,
    conditionID VARCHAR(40) NOT NULL,
    buyerID VARCHAR(40) NOT NULL,
    sellerID VARCHAR(40) NOT NULL,
    auctionable BOOLEAN NOT NULL,
    dealdate VARCHAR(40) NOT NULL
) 
ENGINE = InnoDB;