-- MySQL dump 10.13  Distrib 5.7.30, for Linux (x86_64)
--
-- Host: localhost    Database: mydevice
-- ------------------------------------------------------
-- Server version	5.7.30-0ubuntu0.18.04.1-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullName` text NOT NULL,
  `phone` text NOT NULL,
  `description` text CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` VALUES (1,'Ð Ð°ÑÐºÐ¾Ð»Ð±Ð°ÑÐ¾Ð² ÐÑ€ÑÐµÐ½Ð¸Ð¹ ÐÐ²Ð³ÑƒÑÑ‚Ð¸Ð½Ð¾Ð²Ð¸Ñ‡','2134','Ñ‹Ð²Ð¿Ð°Ð²Ð°Ñ‹Ð¸Ð²Ð°Ð¿Ð¸'),(26,'Ð¤Ð˜Ðž ÐºÐ»Ð¸ÐµÐ½Ñ‚Ð°','+7 (678) 465 45 64',''),(27,'1111111111','+7 (111) 111 11 11',''),(28,'Ð˜Ð²Ð°Ð½ Ð˜Ð²Ð°Ð½ Ð˜Ð²Ð°Ð½Ð¾Ð²Ð¸Ñ‡','+7 (566) 889 65 44',''),(29,'11111111','+7 (111) 111 11 11',''),(48,'ÐšÐ»Ð¸ÐµÐ½Ñ‚','+7 (675) 456 45 94',''),(49,'ÐšÐ»Ð¸ÐµÐ½Ñ‚','+7 (675) 456 45 94',''),(50,'ÐšÐ»Ð¸ÐµÐ½Ñ‚','+7 (675) 456 45 94',''),(51,'ÐšÐ»Ð¸ÐµÐ½Ñ‚','+7 (675) 456 45 94',''),(52,'Ð¡ÐµÐ¼ÑÐ±Ñ‹ÐºÐ¾Ð² ÐŸÐ¾Ñ€Ñ„Ð¸Ñ€Ð¸Ð¹ ÐŸÑ€Ð¾ÐºÐ¾Ñ„ÑŒÐµÐ²Ð¸Ñ‡','+7 (576) 454 65 45','');
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `devices`
--

DROP TABLE IF EXISTS `devices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `devices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `number` text NOT NULL,
  `clientID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `devices`
--

LOCK TABLES `devices` WRITE;
/*!40000 ALTER TABLE `devices` DISABLE KEYS */;
INSERT INTO `devices` VALUES (1,'test','123',4),(2,'test','123',5),(3,'test','123',14),(4,'test','123',15),(5,'test','123',16),(6,'test','123',17),(7,'test','123',18),(8,'test','123',19),(9,'test','123',20),(10,'test','123',21),(11,'test','123',22),(12,'test','123',23),(13,'test','123',24),(14,'test','123',26),(15,'Ð£ÑÑ‚Ñ€Ð¾Ð¹ÑÑ‚Ð²Ð¾','123456789',26),(16,'111111111','1111111111',26),(17,'samsung','6554545646545456',28),(37,'iphone 13','95456485456456456456',52);
/*!40000 ALTER TABLE `devices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `executers`
--

DROP TABLE IF EXISTS `executers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `executers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullName` text NOT NULL,
  `phone` text NOT NULL,
  `workType` text NOT NULL,
  `executerDesc` text NOT NULL,
  `date` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `executers`
--

LOCK TABLES `executers` WRITE;
/*!40000 ALTER TABLE `executers` DISABLE KEYS */;
INSERT INTO `executers` VALUES (1,'asdsadasd','+7 (232) 132 13 21','0','asdasdasd',NULL),(2,'asdsadasd','+7 (232) 132 13 21','0','asdasdasd','1620753896'),(3,'asdsadasd','+7 (232) 132 13 21','0','asdasdasd','1620753920'),(4,'Ð˜Ð²Ð°Ð½Ð¾Ð² ÐŸÐµÑ‚Ñ€ Ð˜Ð¾ÑÐ¸Ñ„Ð¾Ð²Ð¸Ñ‡1','+7 (232) 132 13 21','2','','1620753938');
/*!40000 ALTER TABLE `executers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client` int(11) NOT NULL,
  `executer` int(11) NOT NULL,
  `deviceID` text NOT NULL,
  `deviceDesc` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `deviceDefect` text NOT NULL,
  `preliminaryPrice` text NOT NULL,
  `status` text NOT NULL,
  `workDesc` text,
  `totalPrice` text,
  `dateCreate` int(11) NOT NULL,
  `dateFinish` int(11) DEFAULT NULL,
  `createBy` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (16,52,3,'37','Ñ†Ð°Ñ€Ð°Ð¿Ð¸Ð½Ñ‹','ÐºÐ°Ð¼ÐµÑ€Ð°','10000','new',NULL,NULL,1619362126,NULL,3),(17,54,1,'39','Ñ†Ð°Ñ€Ð°Ð¿Ð¸Ð½Ñ‹','ÐºÐ°Ð¼ÐµÑ€Ð°1','10000','new',NULL,NULL,1619675944,NULL,1),(18,55,1,'40','Ñ†Ð°Ñ€Ð°Ð¿Ð¸Ð½Ñ‹','ÐºÐ°Ð¼ÐµÑ€Ð°','10000','new',NULL,NULL,1619676068,NULL,1);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` text NOT NULL,
  `password` text NOT NULL,
  `role` int(11) NOT NULL,
  `session` text NOT NULL,
  `phone` text,
  `workType` int(11) DEFAULT NULL,
  `desc` text,
  `fullName` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','5f4dcc3b5aa765d61d8327deb882cf99',0,'f8b89f95d83a69e2b997db9577f6d25c',NULL,NULL,NULL,'Admin'),(3,'Nalimova','5f4dcc3b5aa765d61d8327deb882cf99',1,'',NULL,NULL,NULL,'ÐÐ°Ð»Ð¸Ð¼Ð¾Ð²Ð° Ð˜Ð½Ð½Ð° Ð“ÐµÑ€Ð¼Ð°Ð½Ð¾Ð²Ð½Ð°'),(4,'Melehin','5f4dcc3b5aa765d61d8327deb882cf99',2,'',NULL,NULL,NULL,'ÐœÐµÐ»ÐµÑ…Ð¸Ð½ Ð“ÐµÐ»ÑŒÐ¼ÑƒÑ‚ Ð’Ð°ÑÐ¸Ð»ÑŒÐµÐ²Ð¸Ñ‡');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-05-13 10:58:25
