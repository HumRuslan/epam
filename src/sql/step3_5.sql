create database `shop`;
use `shop`;
CREATE TABLE IF NOT EXISTS `category` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `category` VARCHAR(255) NOT NULL,
    `description` VARCHAR(255)
    );

CREATE TABLE IF NOT EXISTS `tovar` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `category_id` INT NOT NULL,
    `tovar` VARCHAR(255) NOT NULL,
    `price` FLOAT NOT NULL, CHECK (`price` > 0),
    `count` FLOAT NOT NULL, CHECK (`count` >= 0),
    `image` JSON,
    `description` VARCHAR(255),
    FOREIGN KEY `FK_CATEGORY` (`category_id`) REFERENCES `category`(`id`)
    );

CREATE TABLE IF NOT EXISTS `customer` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `login` VARCHAR(255) NOT NULL,
    `family` VARCHAR(255) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `phone` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `adress`  VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL
    );

CREATE TABLE IF NOT EXISTS `order` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `number` VARCHAR(255) NOT NULL,
    `date` VARCHAR(255) NOT NULL,
    `status` BOOLEAN DEFAULT FALSE,
    `customer_id` INT NOT NULL,
    FOREIGN KEY `FK_CUSTOMER` (`customer_id`) REFERENCES `customer`(`id`)
    );

CREATE TABLE IF NOT EXISTS `item` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `order_id` INT NOT NULL,
    `tovar_id` INT NOT NULL,
    `count` FLOAT NOT NULL, CHECK (`count` > 0),
    FOREIGN KEY `FK_ORDER` (`order_id`) REFERENCES `order`(`id`),
    FOREIGN KEY `FK_TOVAR` (`tovar_id`) REFERENCES `tovar`(`id`)
    );

INSERT INTO `category` (`category`, `description`)
VALUES
    ('PHONE', 'DESCRIPTION PHONE'),
    ('PC', 'DESCRIPTION PC'),
    ('TV', 'DESCRIPTION TV'),
    ('LAPTOP', 'DESCRIPTION LAPTOP'),
    ('NOT CATEGORY', NULL);

INSERT INTO `customer` (`login`, `family`, `name`, `phone`, `email`, `adress`, `password`)
VALUES
    ('liam', 'Johnson', 'Liam', '+44-002-111-11-11', 'liam@gmail.com', 'Suite 12, 2nd Floor, Queens House, 180 Tottenham Court Road, London W1T 7PD', 'aljwfs12345gqond123'),
    ('emma', 'Williams', 'Emma', '+44-002-111-11-11', 'emma@gmail.com', 'Suite 12, 2nd Floor, Queens House, 180 Tottenham Court Road, London W1T 7PD', 'aljwfs12345gqond123'),
    ('noah', 'Jones', 'Noah', '+44-002-111-11-11', 'noah@gmail.com', 'Suite 12, 2nd Floor, Queens House, 180 Tottenham Court Road, London W1T 7PD', 'aljwfs12345gqond123'),
    ('olivia', 'Brown', 'Olivia', '+44-002-111-11-11', 'olivia@gmail.com', 'Suite 12, 2nd Floor, Queens House, 180 Tottenham Court Road, London W1T 7PD', 'aljwfs12345gqond123'),
    ('mason', 'Smith', 'Mason', '+44-002-111-11-11', 'mason@gmail.com', 'Suite 12, 2nd Floor, Queens House, 180 Tottenham Court Road, London W1T 7PD', 'aljwfs12345gqond123'),
    ('ava', 'Davis', 'Ava', '+44-002-111-11-11', 'ava@gmail.com', 'Suite 12, 2nd Floor, Queens House, 180 Tottenham Court Road, London W1T 7PD', 'aljwfs12345gqond123');

INSERT INTO `tovar` (`category_id`, `tovar`, `price`, `count`, `image`, `description`)
VALUES
    (1, 'APPLE iPhone 12 64GB Black (MGJ53FS/A)', 28999, 100, '[".\/image\/1.jpg",".\/image\/2.jpg"]', 'Smartphone'),
    (1, 'APPLE iPhone SE 64GB Black (MX9R2FS/A)', 144999, 150, '[".\/image\/3.jpg",".\/image\/4.jpg"]', 'Smartphone'),
    (1, 'SAMSUNG Galaxy S21+ 8/128 Gb Dual Sim Phantom Black (SM-G996BZKDSEK)', 31999, 150, '[".\/image\/5.jpg",".\/image\/6.jpg"]', 'Smartphone'),
    (1, 'SAMSUNG Galaxy A51 4/64 Gb Dual Sim Black (SM-A515FZKUSEK)', 9999, 0, '[".\/image\/7.jpg",".\/image\/8.jpg"]', 'Smartphone'),
    (2, 'LENOVO IdeaCentre A340-24IWL Black (F0E800HAUA)', 165999, 0, '[".\/image\/9.jpg",".\/image\/10.jpg"]', 'Monoblock'),
    (2, 'LENOVO ideacentre A340-24IWL (F0E800QBUA)', 197999, 25, '[".\/image\/11.jpg",".\/image\/12.jpg"]', 'Monoblock'),
    (2, 'ARCHOS Vision 215', 8484, 30, '[".\/image\/13.jpg",".\/image\/14.jpg"]', 'Monoblock'),
    (3, 'SAMSUNG UE43TU7100UXUA', 11999, 30, '[".\/image\/15.jpg",".\/image\/16.jpg"]', 'Smart TV'),
    (3, 'SAMSUNG QE55Q60TAUXUA', 24999, 10, '[".\/image\/17.jpg",".\/image\/18.jpg"]', 'Smart TV'),
    (3, 'SAMSUNG UE32T5300AUXUA', 7899, 15, '[".\/image\/19.jpg",".\/image\/20.jpg"]', 'Smart TV'),
    (3, 'SAMSUNG UE55TU7100UXUA', 16499, 25, '[".\/image\/21.jpg",".\/image\/22.jpg"]', 'Smart TV'),
    (3, 'SAMSUNG UE43TU8000UXUA', 13999, 0, '[".\/image\/23.jpg",".\/image\/24.jpg"]', 'Smart TV'),
    (4, 'APPLE MacBook Air 13" 2020 Silver (MWTK2UA/A)', 37999, 0, '[".\/image\/25.jpg",".\/image\/26.jpg"]', NULL),
    (4, 'ACER Aspire 5 A515-55G-57C8 Silver (NX.HZHEU.006)', 20999, 5, '[".\/image\/27.jpg",".\/image\/28.jpg"]', NULL),
    (4, 'HP Pavilion Gaming 16-a0001ua (28Z78EA)', 37999, 5, '[".\/image\/29.jpg",".\/image\/30.jpg"]', NULL),
    (4, 'ASUS TUF FX506LI-HN039 Grey (90NR03T1-M03870)', 26999, 5, '[".\/image\/31.jpg",".\/image\/32.jpg"]', NULL),
    (4, 'LENOVO S145-15API Granite Black (81UT00NRRA)', 8999, 0, '[".\/image\/33.jpg",".\/image\/34.jpg"]', NULL),
    (4, 'DELL Inspiron 3593 (I3558S2NDW-75S)', 227999, 5, '[".\/image\/35.jpg",".\/image\/36.jpg"]', NULL),
    (5, 'ASUS CROSSHAIR VIII IMPACT', 12450, 10, NULL, 'Motherboard'),
    (5, 'AMD Ryzen 5 2600 (YD2600BBAFBOX)', 7018, 10, NULL, 'Processor'),
    (5, 'MSI GeForce GT710 2Gb 64bit 954/1600MHz (GT 710 2GD3H LP)', 1560, 10, NULL, 'Video card'),
    (5, 'MICRON CRUCIAL Ballistix DDR4 2x8Gb 3200Mhz', 2984, 10, NULL, 'Memory module');

INSERT INTO `order` (`number`, `date`, `status`, `customer_id`)
VALUES
    ('N_1', '2020-01-12', true, 1),
    ('N_2', '2020-01-12', false, 2),
    ('N_3', '2020-01-12', false, 1),
    ('N_4', '2020-01-12', true, 3),
    ('N_5', '2020-01-12', true, 4),
    ('N_6', '2020-01-20', true, 4),
    ('N_7', '2020-01-20', false, 1),
    ('N_8', '2020-01-20', true, 3),
    ('N_9', '2020-01-20', false, 4);

INSERT INTO `item` (`order_id`, `tovar_id`, `count`)
VALUES
    (1, 1, 1),
    (1, 8, 1),
    (2, 15, 1),
    (3, 18, 1),
    (4, 10, 1),
    (5, 1, 1),
    (6, 1, 1),
    (7, 10, 1),
    (8, 19, 1),
    (8, 20, 1),
    (8, 21, 1),
    (8, 22, 1),
    (9, 10, 1);