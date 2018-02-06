-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.28-MariaDB - Source distribution
-- Server OS:                    Linux
-- HeidiSQL Version:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for bookstore
CREATE DATABASE IF NOT EXISTS `bookstore` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `bookstore`;

-- Dumping structure for table bookstore.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

-- Dumping data for table bookstore.admin: ~0 rows (approximately)
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` (`id`, `username`, `password`) VALUES
	(16, 'admin14', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.ImFkbWluIg.Yb9fIrMj3aohT7pWHfEAbp6USF14olJrwLlpLcIxIGI');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;

-- Dumping structure for table bookstore.book
CREATE TABLE IF NOT EXISTS `book` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `isbn` char(13) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `stock` smallint(5) unsigned NOT NULL DEFAULT '0',
  `price` float unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `isbn` (`isbn`),
  KEY `title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

-- Dumping data for table bookstore.book: ~18 rows (approximately)
/*!40000 ALTER TABLE `book` DISABLE KEYS */;
INSERT INTO `book` (`id`, `isbn`, `title`, `author`, `stock`, `price`) VALUES
	(1, '9780882339726', '1984', 'George Orwell', 12, 7.5),
	(2, '9789724621081', '1Q84', 'Haruki Murakami', 9, 9.75),
	(3, '9780736692427', 'Animal Farm', 'George Orwell', 8, 3.5),
	(4, '9780307350169', 'Dracula', 'Bram Stoker', 30, 10.15),
	(5, '9780753179246', '19 minutes', 'Jodi Picoult', 0, 10),
	(6, '9781416500360', 'Odyssey', 'Homer', 0, 4.23),
	(7, '78436872632', 'membunuh burung', 'jaka', 21, 1.5),
	(8, '32232', 'joshn', 'haha', 2121, 2.5),
	(10, '12345', 'cara membunuh manuk', 'dawd', 3, 2.4),
	(11, 'not defined', 'cara membunuh manuk 2', 'dawd', 3, 2.4),
	(14, '72647324', 'cara membunuh manuk 3', 'dawd', 3, 2.4),
	(15, '7264732afdw4', 'cara membunuh manuk 4', 'dawd', 3, 2.4),
	(16, 'Jangan marah', 'cahyo', '2321831321', 21, 5),
	(33, 'Check', 'cahyo', '4217438', 5, 2),
	(34, 'Check2', 'cahyo', '42174389', 5, 2.1),
	(35, 'check21', 'salya', '437286213', 2, 3),
	(36, 'sajak angin', 'tania', '32131231', 2, 2),
	(37, 'hahaha', 'era', '32312432', 3, 2),
	(39, 'check211', 'sahila', '2432453287', 4, 2);
/*!40000 ALTER TABLE `book` ENABLE KEYS */;

-- Dumping structure for table bookstore.borrowed_books
CREATE TABLE IF NOT EXISTS `borrowed_books` (
  `book_id` int(10) unsigned NOT NULL,
  `customer_id` int(10) unsigned NOT NULL,
  `start` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end` datetime DEFAULT NULL,
  KEY `book_id` (`book_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `borrowed_books_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`),
  CONSTRAINT `borrowed_books_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table bookstore.borrowed_books: ~0 rows (approximately)
/*!40000 ALTER TABLE `borrowed_books` DISABLE KEYS */;
INSERT INTO `borrowed_books` (`book_id`, `customer_id`, `start`, `end`) VALUES
	(1, 2, '2018-02-02 19:31:14', '2018-12-01 00:00:00');
/*!40000 ALTER TABLE `borrowed_books` ENABLE KEYS */;

-- Dumping structure for table bookstore.customer
CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `type` enum('basic','premium') DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table bookstore.customer: ~2 rows (approximately)
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` (`id`, `firstname`, `surname`, `email`, `type`) VALUES
	(1, 'Han', 'Solo', 'han@tatooine.com', 'premium'),
	(2, 'James', 'Kirk', 'enter@prise', 'basic');
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;

-- Dumping structure for table bookstore.sale
CREATE TABLE IF NOT EXISTS `sale` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) unsigned NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `sale_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table bookstore.sale: ~0 rows (approximately)
/*!40000 ALTER TABLE `sale` DISABLE KEYS */;
/*!40000 ALTER TABLE `sale` ENABLE KEYS */;

-- Dumping structure for table bookstore.sale_book
CREATE TABLE IF NOT EXISTS `sale_book` (
  `sale_id` int(10) unsigned NOT NULL,
  `book_id` int(10) unsigned NOT NULL,
  `amount` smallint(5) unsigned NOT NULL DEFAULT '1',
  `price` float NOT NULL,
  KEY `sale_id` (`sale_id`),
  KEY `book_id` (`book_id`),
  CONSTRAINT `sale_book_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sale` (`id`),
  CONSTRAINT `sale_book_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table bookstore.sale_book: ~0 rows (approximately)
/*!40000 ALTER TABLE `sale_book` DISABLE KEYS */;
/*!40000 ALTER TABLE `sale_book` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
