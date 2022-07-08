-- CREATE DB --

CREATE DATABASE IF NOT EXISTS
PetManagement;

-- tUserType TABLE query --

CREATE TABLE `petmanagement`.`tUserType`
(
    `userTypeId` INT(11) NOT NULL AUTO_INCREMENT ,
    `role` VARCHAR(50) NOT NULL ,
    PRIMARY KEY (`userTypeId`)
) ENGINE = InnoDB;


-- tUserType INSERT query --

INSERT INTO `petmanagement`.`tUserType` (`userTypeId`, `role`) VALUES ('1', 'Admin'), ('2', 'Customer');


-- tAdminUser  TABLE query --

CREATE TABLE `petmanagement`.`tUser`
(   `userId` INT(11) NOT NULL AUTO_INCREMENT ,
    `username` VARCHAR(255) NOT NULL ,
    `email` VARCHAR(50) NOT NULL ,
    `password` VARCHAR(255) NOT NULL ,
    `userTypeId` INT NOT NULL ,
    `createdDate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
    `IsActive` BOOLEAN NOT NULL DEFAULT 0,
    PRIMARY KEY (`userId`),
    CONSTRAINT fk_userTypeId FOREIGN KEY(userTypeId) REFERENCES tUserType(userTypeId)
) ENGINE = InnoDB;


-- tProducts TABLE query --
CREATE TABLE `petmanagement`.`tProduct`
(
    `productId` INT(11) NOT NULL AUTO_INCREMENT ,
    `productName` VARCHAR(255) NOT NULL ,
    `productImage` VARCHAR(255)  ,
    `productDescription` VARCHAR(255)  ,
    `productPrice` DOUBLE (12,2) NOT NULL ,
    `productCode` VARCHAR(50) NOT NULL,
    `productQuantity` INT  ,
    `
` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
    PRIMARY KEY (`productId`)

)ENGINE = InnoDB;


