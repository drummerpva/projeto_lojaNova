# Host: localhost  (Version 5.7.23)
# Date: 2018-12-03 03:09:32
# Generator: MySQL-Front 6.0  (Build 2.20)


#
# Structure for table "brands"
#

DROP TABLE IF EXISTS `brands`;
CREATE TABLE `brands` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

#
# Data for table "brands"
#

/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` VALUES (1,'LG'),(2,'SAMSUNG'),(3,'AOC'),(4,'APPLE');
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;

#
# Structure for table "categories"
#

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `sub` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

#
# Data for table "categories"
#

/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (5,NULL,'Monitor'),(6,NULL,'Som'),(7,6,'Headphones'),(8,6,'Microfones'),(9,7,'Com Fio'),(10,7,'Sem Fio');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;

#
# Structure for table "coupons"
#

DROP TABLE IF EXISTS `coupons`;
CREATE TABLE `coupons` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `coupon_type` int(11) DEFAULT '0',
  `coupon_value` float DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "coupons"
#


#
# Structure for table "options"
#

DROP TABLE IF EXISTS `options`;
CREATE TABLE `options` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

#
# Data for table "options"
#

/*!40000 ALTER TABLE `options` DISABLE KEYS */;
INSERT INTO `options` VALUES (1,'Cor'),(2,'Tamanho'),(3,'Memória RAM'),(4,'Polegadas');
/*!40000 ALTER TABLE `options` ENABLE KEYS */;

#
# Structure for table "pages"
#

DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `body` text,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "pages"
#


#
# Structure for table "permission_groups"
#

DROP TABLE IF EXISTS `permission_groups`;
CREATE TABLE `permission_groups` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "permission_groups"
#

/*!40000 ALTER TABLE `permission_groups` DISABLE KEYS */;
INSERT INTO `permission_groups` VALUES (1,'Super Administrador'),(2,'Administrador'),(3,'Gerente'),(7,'Vendedor');
/*!40000 ALTER TABLE `permission_groups` ENABLE KEYS */;

#
# Structure for table "permission_items"
#

DROP TABLE IF EXISTS `permission_items`;
CREATE TABLE `permission_items` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `slug` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "permission_items"
#

/*!40000 ALTER TABLE `permission_items` DISABLE KEYS */;
INSERT INTO `permission_items` VALUES (1,'Criar Cupom de Oferta','cupons_create'),(2,'Ver Permissoes','permissions_view'),(3,'Ver Categories','categories_view');
/*!40000 ALTER TABLE `permission_items` ENABLE KEYS */;

#
# Structure for table "permission_links"
#

DROP TABLE IF EXISTS `permission_links`;
CREATE TABLE `permission_links` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `id_permission_group` int(11) DEFAULT NULL,
  `id_permission_item` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "permission_links"
#

/*!40000 ALTER TABLE `permission_links` DISABLE KEYS */;
INSERT INTO `permission_links` VALUES (2,2,1),(3,3,1),(19,1,1),(20,1,2),(21,1,3);
/*!40000 ALTER TABLE `permission_links` ENABLE KEYS */;

#
# Structure for table "products"
#

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `id_category` int(11) DEFAULT NULL,
  `id_brand` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text,
  `stock` int(11) DEFAULT '0',
  `price` double(10,2) DEFAULT NULL,
  `price_from` double(10,2) DEFAULT NULL,
  `rating` int(11) DEFAULT '0',
  `featured` tinyint(1) DEFAULT '0',
  `sale` tinyint(1) DEFAULT '0',
  `bestseller` tinyint(1) DEFAULT '0',
  `new_product` tinyint(1) DEFAULT '0',
  `options` varchar(200) DEFAULT NULL,
  `weight` double(4,2) DEFAULT '0.00',
  `width` double(4,2) DEFAULT '0.00',
  `height` double(4,2) DEFAULT '0.00',
  `length` double(4,2) DEFAULT '0.00',
  `diameter` double(4,2) DEFAULT '0.00',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

#
# Data for table "products"
#

/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,5,1,'Monitor 21 polegadas','Alguma descrição do produto\t',10,499.00,599.00,0,0,1,0,0,'1,2,4',0.90,20.00,15.00,20.00,15.00),(2,5,2,'Monitor 18 polegadas','Alguma Outra descrição',10,399.00,999.00,4,1,0,1,0,'1,2',0.80,20.00,15.00,20.00,15.00),(3,5,2,'Monitor 19 polegadas','Alguma Outra descrição\n',10,599.00,699.00,0,1,0,0,1,'1,2',0.70,20.00,15.00,20.00,15.00),(4,5,3,'Monitor 18 polegadas','Alguma Outra descrição\n',10,779.00,900.00,0,1,1,1,0,'1,4',0.06,20.00,15.00,20.00,15.00),(5,5,1,'Monitor 20 polegadas','Alguma Outra descrição\n\n',10,299.00,499.00,2,1,0,0,0,'1',0.50,20.00,15.00,20.00,15.00),(6,5,3,'Monitor 20 polegadas','Alguma Outra descrição\n\n',10,699.00,0.00,0,1,0,0,0,'1,2,4',0.40,20.00,15.00,20.00,15.00),(7,5,3,'Monitor 19 polegadas','Alguma Outra descrição\n\n',10,889.00,999.00,5,1,0,0,0,'2,4',0.30,20.00,15.00,20.00,15.00),(8,5,1,'Monitor 18 polegadas','Alguma Outra descrição\n\n',10,599.00,699.00,0,0,1,0,0,'4',0.20,20.00,15.00,20.00,15.00);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

#
# Structure for table "products_images"
#

DROP TABLE IF EXISTS `products_images`;
CREATE TABLE `products_images` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `id_product` int(11) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

#
# Data for table "products_images"
#

/*!40000 ALTER TABLE `products_images` DISABLE KEYS */;
INSERT INTO `products_images` VALUES (1,1,'1.jpg'),(2,2,'2.jpg'),(3,3,'3.jpg'),(4,4,'4.jpg'),(5,5,'1.jpg'),(6,6,'2.jpg'),(7,7,'7.jpg'),(8,8,'4.jpg');
/*!40000 ALTER TABLE `products_images` ENABLE KEYS */;

#
# Structure for table "products_options"
#

DROP TABLE IF EXISTS `products_options`;
CREATE TABLE `products_options` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `id_product` int(255) DEFAULT NULL,
  `id_option` int(11) DEFAULT NULL,
  `p_value` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "products_options"
#

/*!40000 ALTER TABLE `products_options` DISABLE KEYS */;
INSERT INTO `products_options` VALUES (1,1,1,'Azul'),(2,1,2,'23cm'),(3,1,4,'21'),(4,2,1,'Azul'),(5,2,2,'19cm'),(6,3,1,'Vermelha'),(7,3,2,'19cm');
/*!40000 ALTER TABLE `products_options` ENABLE KEYS */;

#
# Structure for table "purchases"
#

DROP TABLE IF EXISTS `purchases`;
CREATE TABLE `purchases` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_coupon` int(11) DEFAULT NULL,
  `total_amount` float DEFAULT NULL,
  `payment_type` varchar(100) DEFAULT NULL,
  `payment_status` int(11) DEFAULT NULL,
  `billet_link` text,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

#
# Data for table "purchases"
#

/*!40000 ALTER TABLE `purchases` DISABLE KEYS */;
INSERT INTO `purchases` VALUES (1,2,NULL,533.29,'pcCktTransparente',1,NULL),(2,2,NULL,533.29,'pcCktTransparente',1,NULL),(3,2,NULL,533.29,'pcCktTransparente',1,NULL),(4,2,NULL,533.29,'pcCktTransparente',1,NULL),(5,2,NULL,533.29,'pcCktTransparente',1,NULL),(6,2,NULL,533.29,'pcCktTransparente',1,NULL),(7,2,NULL,533.29,'pcCktTransparente',1,NULL),(8,2,NULL,533.29,'pcCktTransparente',1,NULL),(9,2,NULL,533.29,'pcCktTransparente',1,NULL),(10,2,NULL,533.29,'pcCktTransparente',1,NULL),(11,2,NULL,533.29,'pcCktTransparente',1,NULL),(12,2,NULL,533.29,'pcCktTransparente',1,NULL),(13,2,NULL,533.29,'pcCktTransparente',1,NULL),(14,2,NULL,533.29,'pcCktTransparente',1,NULL),(15,2,NULL,533.29,'pcCktTransparente',1,NULL),(16,2,NULL,533.29,'pcCktTransparente',1,NULL),(17,2,NULL,533.29,'pcCktTransparente',1,NULL),(18,2,NULL,533.29,'pcCktTransparente',1,NULL),(19,2,NULL,533.29,'pcCktTransparente',1,NULL),(20,2,NULL,533.29,'pcCktTransparente',1,NULL),(21,4,NULL,533.29,'mp',1,NULL),(22,4,NULL,533.29,'mp',1,NULL),(23,4,NULL,533.29,'mp',1,NULL),(24,4,NULL,533.29,'mp',1,NULL),(25,4,NULL,533.29,'paypal',1,NULL),(26,4,NULL,533.29,'paypal',1,NULL),(27,4,NULL,533.29,'paypal',1,NULL),(28,4,NULL,533.29,'paypal',1,NULL),(29,4,NULL,533.29,'paypal',1,NULL),(30,4,NULL,533.29,'paypal',1,NULL),(31,4,NULL,533.29,'paypal',1,'https://visualizacaosandbox.gerencianet.com.br/emissao/187962_2_HIDO4/A4XB-187962-372475-LOPA1');
/*!40000 ALTER TABLE `purchases` ENABLE KEYS */;

#
# Structure for table "purchases_products"
#

DROP TABLE IF EXISTS `purchases_products`;
CREATE TABLE `purchases_products` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `id_purchase` int(11) DEFAULT NULL,
  `id_product` int(11) DEFAULT NULL,
  `product_price` double(10,2) DEFAULT '0.00',
  `quantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "purchases_products"
#

/*!40000 ALTER TABLE `purchases_products` DISABLE KEYS */;
INSERT INTO `purchases_products` VALUES (1,2,NULL,1.00,499),(2,3,1,1.00,499),(3,4,1,1.00,499),(4,5,1,1.00,499),(5,6,1,1.00,499),(6,7,1,1.00,499),(7,8,1,1.00,499),(8,9,1,1.00,499),(9,10,1,1.00,499),(10,11,1,1.00,499),(11,12,1,1.00,499),(12,13,1,1.00,499),(13,14,1,1.00,499),(14,15,1,1.00,499),(15,16,1,1.00,499),(16,17,1,1.00,499),(17,18,1,1.00,499),(18,19,1,1.00,499),(19,20,1,1.00,499),(20,21,1,1.00,499),(21,22,1,1.00,499),(22,23,1,1.00,499),(23,24,1,1.00,499),(24,25,1,1.00,499),(25,26,1,1.00,499),(26,27,1,1.00,499),(27,28,1,1.00,499),(28,29,1,1.00,499),(29,30,1,1.00,499),(30,31,1,1.00,499);
/*!40000 ALTER TABLE `purchases_products` ENABLE KEYS */;

#
# Structure for table "purchases_transactions"
#

DROP TABLE IF EXISTS `purchases_transactions`;
CREATE TABLE `purchases_transactions` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `id_purchase` int(11) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `transaction_code` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "purchases_transactions"
#


#
# Structure for table "rates"
#

DROP TABLE IF EXISTS `rates`;
CREATE TABLE `rates` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `id_product` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `date_rated` datetime DEFAULT NULL,
  `points` int(11) DEFAULT NULL,
  `comment` text,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "rates"
#

/*!40000 ALTER TABLE `rates` DISABLE KEYS */;
INSERT INTO `rates` VALUES (1,2,1,'2018-11-23 00:00:00',4,'Ótimo'),(2,2,1,'2018-11-22 00:00:00',4,'Ótimo');
/*!40000 ALTER TABLE `rates` ENABLE KEYS */;

#
# Structure for table "users"
#

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `id_permission` int(11) DEFAULT '0',
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `admin` tinyint(1) DEFAULT '0',
  `token` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

#
# Data for table "users"
#

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,1,'Douglas Poma','teste@teste.com','81dc9bdb52d04dc20036dbd8313ed055',1,'4926e8e47bf219533f035e186f4038c5'),(2,7,'Douglas Poma','c82436053912049324975@sandbox.pagseguro.com.br','be04aaba2f8ab572d2837ab0fb0204dd',0,NULL),(3,NULL,NULL,'testempdgpsc@hotmail.com','d41d8cd98f00b204e9800998ecf8427e',0,NULL),(4,NULL,NULL,'teste@mp.com','202cb962ac59075b964b07152d234b70',0,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
