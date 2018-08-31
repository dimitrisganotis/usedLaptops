
DROP SCHEMA IF EXISTS usedLaptops;
CREATE SCHEMA usedLaptops DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE usedLaptops;

CREATE TABLE users (
	userID INT UNSIGNED NOT NULL AUTO_INCREMENT,
    username VARCHAR(25) NOT NULL,
    password VARCHAR(106) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone BIGINT NOT NULL,
    activationCode MEDIUMINT NOT NULL,
    status BOOLEAN NOT NULL,
    PRIMARY KEY (userID)
);

CREATE TABLE laptops (
	laptopID INT UNSIGNED NOT NULL AUTO_INCREMENT,
    userID INT UNSIGNED NOT NULL,
    brand VARCHAR(25) NOT NULL,
    model VARCHAR(100) NOT NULL,
    launchDate YEAR NOT NULL,
    cpuBrand ENUM('Intel', 'AMD') NOT NULL,
    cpuModel VARCHAR(20) NOT NULL,
    cpuCores ENUM('1', '2', '4', '8') NOT NULL,
    cpuFrequency DECIMAL(3,2) NOT NULL,
    ramSize TINYINT UNSIGNED NOT NULL,
    storageSize SMALLINT UNSIGNED NOT NULL,
    os SET('Windows 7/8/8.1/10', 'Linux', 'ΜacOS', 'No OS') NOT NULL,
    damage BOOLEAN NOT NULL,
    price SMALLINT UNSIGNED NOT NULL,
    dateOfUpdate TIMESTAMP,	
    PRIMARY KEY (laptopID),
    FOREIGN KEY (userID) REFERENCES users(userID)
);	

CREATE TABLE images (
	imageID INT UNSIGNED NOT NULL AUTO_INCREMENT,
    laptopID INT UNSIGNED NOT NULL,
    name VARCHAR(30) NOT NULL,
    description TEXT NOT NULL,
    PRIMARY KEY (imageID),
    FOREIGN KEY (laptopID) REFERENCES laptops(laptopID)
);

INSERT INTO users (username, password, email, phone, activationCode, status) VALUES 
	('root','$6$7)5WdHMixonQpvXa$5mBrQf5DAdL5JPFKcfS/EYqH2G597rlau6yeM4mGKyF96DALcV8UD.XkjsLExXwXUnWrbnzoF32CqqnBzSiZv0','root@usedlaptops.com',6969696969,99999,1),
	('dimitris','$6$7)5WdHMixonQpvXa$5mBrQf5DAdL5JPFKcfS/EYqH2G597rlau6yeM4mGKyF96DALcV8UD.XkjsLExXwXUnWrbnzoF32CqqnBzSiZv0','dimitris@gmail.com',6974410860,88888,1),
    ('axilleas','$6$7)5WdHMixonQpvXa$5mBrQf5DAdL5JPFKcfS/EYqH2G597rlau6yeM4mGKyF96DALcV8UD.XkjsLExXwXUnWrbnzoF32CqqnBzSiZv0','axilleas@gmail.com',6969696969,77777,1),
    ('kleanthis','$6$7)5WdHMixonQpvXa$5mBrQf5DAdL5JPFKcfS/EYqH2G597rlau6yeM4mGKyF96DALcV8UD.XkjsLExXwXUnWrbnzoF32CqqnBzSiZv0','kleanthis@gmail.com',6969696969,66666,1),
    ('nefeli','$6$7)5WdHMixonQpvXa$5mBrQf5DAdL5JPFKcfS/EYqH2G597rlau6yeM4mGKyF96DALcV8UD.XkjsLExXwXUnWrbnzoF32CqqnBzSiZv0','nefeli@gmail.com',6969696969,55555,1),
    ('jason','$6$7)5WdHMixonQpvXa$5mBrQf5DAdL5JPFKcfS/EYqH2G597rlau6yeM4mGKyF96DALcV8UD.XkjsLExXwXUnWrbnzoF32CqqnBzSiZv0','jason@gmail.com',6969696969,44444,1),
    ('nikoleta','$6$7)5WdHMixonQpvXa$5mBrQf5DAdL5JPFKcfS/EYqH2G597rlau6yeM4mGKyF96DALcV8UD.XkjsLExXwXUnWrbnzoF32CqqnBzSiZv0','nikoleta@gmail.com',6969696969,33333,1),
    ('stauros','$6$7)5WdHMixonQpvXa$5mBrQf5DAdL5JPFKcfS/EYqH2G597rlau6yeM4mGKyF96DALcV8UD.XkjsLExXwXUnWrbnzoF32CqqnBzSiZv0','stauros@gmail.com',6969696969,22222,1),
    ('stathis','$6$7)5WdHMixonQpvXa$5mBrQf5DAdL5JPFKcfS/EYqH2G597rlau6yeM4mGKyF96DALcV8UD.XkjsLExXwXUnWrbnzoF32CqqnBzSiZv0','stathis@gmail.com',6969696969,11111,1),
    ('alex','$6$7)5WdHMixonQpvXa$5mBrQf5DAdL5JPFKcfS/EYqH2G597rlau6yeM4mGKyF96DALcV8UD.XkjsLExXwXUnWrbnzoF32CqqnBzSiZv0','alex@gmail.com',6969696969,98765,1),
    ('klearxos','$6$7)5WdHMixonQpvXa$5mBrQf5DAdL5JPFKcfS/EYqH2G597rlau6yeM4mGKyF96DALcV8UD.XkjsLExXwXUnWrbnzoF32CqqnBzSiZv0','klearxos@gmail.com',6969696969,12345,1);
    
INSERT INTO laptops (userID, brand, model, launchDate, cpuBrand, cpuModel, cpuCores, cpuFrequency, ramSize, storageSize, os, damage, price, dateOfUpdate) VALUES 
	(1, 'Apple', 'MacBook Pro MPTT2 15.4" Retina Touch Bar/ID', 2017, 'Intel', 'Core i7', '4', 2.9, 16, 512, 'ΜacOS', 0, 3000, '2018-01-05 14:19:15'),
	(2, 'Asus', 'Rog Strix GL503VD-FY127T 15.6" FHD', 2017, 'Intel', 'i7-7700HQ', '4', 2.8, 8, 256, 'Windows 7/8/8.1/10', 0, 1200, '2018-02-05 12:12:50'),
	(3, 'Dell', 'Vostro 3568 15.6" FHD', 2017, 'Intel', 'i7-7500U', '2', 2.7, 8, 256, 'Windows 7/8/8.1/10', 0, 800, '2018-03-05 10:42:38'),
	(4, 'Acer', 'Aspire A517-51G-59B0 17.3" FHD', 2018, 'Intel', 'i5-8250U', '4', 1.6, 8, 256, 'Windows 7/8/8.1/10', 0, 820, '2018-04-05 20:59:43'),
	(5, 'Acer', 'Swift 3 SF315-41', 2017, 'AMD', 'Ryzen 5 - 2500U', '4', 2, 8, 128, 'Windows 7/8/8.1/10', 0, 680, '2018-05-05 17:02:00'),
	(6, 'Lenovo', '110 80TH0013UK 15.6" HD', 2017, 'Intel', 'i5-7200U', '2', 2.5, 4, 128, 'Windows 7/8/8.1/10', 0, 450, '2018-06-01 16:12:23'),
	(7, 'Asus', 'ZenBook UX305CA-FB073T 13.3" QHD', 2017, 'Intel', 'M-6Y30', '4', 0.9, 4, 256, 'Windows 7/8/8.1/10', 0, 1000, '2018-06-02 17:17:07'),
	(8, 'HP', '250 G6 1WY33EA 15.6" HD', 2017, 'Intel', 'Celeron N3060', '2', 1.6, 4, 500, 'No OS', 1, 120, '2018-06-03 18:17:03'),
	(9, 'Dell', 'Inspiron 3567 15.6" HD', 2016, 'Intel', 'i3-6006U', '2', 2, 4, 1000, 'Linux', 0, 350, '2018-06-04 06:19:13'),
	(10, 'MSI', 'GS43VR 7RE-059NL 14" FHD', 2017, 'Intel', 'i7-7700HQ', '4', 2.8, 16, 256, 'Windows 7/8/8.1/10', 0, 1450, '2018-06-05 11:15:23'),
	(11, 'Microsoft', 'Surface Book 2 13.5" QHD', 2017, 'Intel', 'i5-7300U', '4', 2.6, 8, 256, 'Windows 7/8/8.1/10', 1, 1400, '2018-06-06 23:19:03');
    
INSERT INTO images (laptopID, name, description) VALUES
	(1, 'mac', 'my mac'),
    (2, 'asus', 'my asus'),
    (3, 'dell', 'my dell'),
    (4, 'acer', 'my acer'),
    (5, 'acer', 'my acer'),
    (6, 'lenovo', 'my lenovo'),
    (7, 'asus', 'my asus'),
    (8, 'hp', 'my hp'),
    (9, 'dell', 'my dell'),
    (10, 'msi', 'my msi'),
    (11, 'microsoft', 'my microsoft');
