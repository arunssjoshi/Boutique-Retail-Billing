-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2015 at 06:19 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `billing`
--

-- --------------------------------------------------------

--
-- Table structure for table `batch`
--

CREATE TABLE IF NOT EXISTS `batch` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `batch` varchar(256) DEFAULT NULL,
  `description` varchar(4096) DEFAULT NULL,
  `purchased_on` date NOT NULL,
  `status` enum('Active','Deleted') DEFAULT NULL,
  `sort_order` int(10) DEFAULT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_batch` (`created_by`),
  KEY `FK_batch_updated_by` (`updated_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Table structure for table `batch_shops`
--

CREATE TABLE IF NOT EXISTS `batch_shops` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `batch_id` int(10) unsigned NOT NULL,
  `shop_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_batch_shops` (`batch_id`),
  KEY `FK_batch_shops_shop_id` (`shop_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(32) DEFAULT NULL,
  `status` enum('Active','Deleted') DEFAULT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_category` (`created_by`),
  KEY `FK_category_updated_by` (`updated_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `category_property`
--

CREATE TABLE IF NOT EXISTS `category_property` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL,
  `property_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_category_property` (`category_id`),
  KEY `FK_category_property_id` (`property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `property`
--

CREATE TABLE IF NOT EXISTS `property` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `property` varchar(32) DEFAULT NULL,
  `status` enum('Active','Deleted') DEFAULT NULL,
  `sort_order` int(10) DEFAULT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_property` (`created_by`),
  KEY `FK_property_updated_by` (`updated_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=69 ;

-- --------------------------------------------------------

--
-- Table structure for table `property_option`
--

CREATE TABLE IF NOT EXISTS `property_option` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `property_id` int(10) unsigned DEFAULT NULL,
  `option` varchar(32) DEFAULT NULL,
  `status` enum('Active','Deleted') DEFAULT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_property_value` (`property_id`),
  KEY `FK_property_value_created_by` (`created_by`),
  KEY `FK_property_value_updated_by` (`updated_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=148 ;

-- --------------------------------------------------------

--
-- Table structure for table `shop`
--

CREATE TABLE IF NOT EXISTS `shop` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop` varchar(256) DEFAULT NULL,
  `city` varchar(256) DEFAULT NULL,
  `status` enum('Active','Deleted') DEFAULT NULL,
  `sort_order` int(10) DEFAULT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_shop` (`created_by`),
  KEY `FK_shop_updated_by` (`updated_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(128) DEFAULT NULL,
  `password` varchar(256) DEFAULT NULL,
  `first_name` varchar(64) DEFAULT NULL,
  `last_name` varchar(64) DEFAULT NULL,
  `role` enum('Admin','User') DEFAULT NULL,
  `remember_token` varchar(256) DEFAULT NULL,
  `status` enum('Active','Inactive','Deleted') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `batch`
--
ALTER TABLE `batch`
  ADD CONSTRAINT `FK_batch` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_batch_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `batch_shops`
--
ALTER TABLE `batch_shops`
  ADD CONSTRAINT `FK_batch_shops` FOREIGN KEY (`batch_id`) REFERENCES `batch` (`id`),
  ADD CONSTRAINT `FK_batch_shops_shop_id` FOREIGN KEY (`shop_id`) REFERENCES `shop` (`id`);

--
-- Constraints for table `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `FK_category` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_category_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `category_property`
--
ALTER TABLE `category_property`
  ADD CONSTRAINT `FK_category_property_id` FOREIGN KEY (`property_id`) REFERENCES `property` (`id`),
  ADD CONSTRAINT `FK_category_property` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Constraints for table `property`
--
ALTER TABLE `property`
  ADD CONSTRAINT `FK_property` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_property_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `property_option`
--
ALTER TABLE `property_option`
  ADD CONSTRAINT `FK_property_value` FOREIGN KEY (`property_id`) REFERENCES `property` (`id`),
  ADD CONSTRAINT `FK_property_value_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_property_value_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `shop`
--
ALTER TABLE `shop`
  ADD CONSTRAINT `FK_shop` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_shop_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
