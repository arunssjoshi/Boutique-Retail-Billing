-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2015 at 05:35 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `batch`
--

INSERT INTO `batch` (`id`, `batch`, `description`, `purchased_on`, `status`, `sort_order`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'Eranakulam Purchase', 'Saree purchase.\r\nJoshi, Vinu, Shaji, Deepa, Induchoodan, Neelima', '2015-04-06', 'Active', 1, 1, '2015-04-07 11:28:52', NULL, NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `batch_shops`
--

INSERT INTO `batch_shops` (`id`, `batch_id`, `shop_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(32) DEFAULT NULL,
  `category_short_code` varchar(4) DEFAULT NULL,
  `description` varchar(4096) DEFAULT NULL,
  `tax` float DEFAULT NULL,
  `unit` enum('Nos','Meter') DEFAULT NULL,
  `status` enum('Active','Deleted') DEFAULT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_category` (`created_by`),
  KEY `FK_category_updated_by` (`updated_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category`, `category_short_code`, `description`, `tax`, `unit`, `status`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'Churidar', 'CH', NULL, 5, 'Nos', 'Active', 1, '2015-04-07 00:00:00', NULL, NULL),
(2, 'Top', 'TP', NULL, 5, 'Nos', 'Active', 1, '2015-04-07 00:00:00', NULL, NULL),
(3, 'Saree', 'SR', NULL, 0, 'Nos', 'Active', 1, '2015-04-07 00:00:00', NULL, NULL),
(4, 'Leggings', 'LG', NULL, 5, 'Nos', 'Active', 1, '2015-04-07 00:00:00', NULL, NULL),
(5, 'Shawl', 'DP', NULL, 0, 'Nos', 'Active', 1, '2015-04-07 00:00:00', NULL, NULL),
(6, 'Lining', 'LN', NULL, 0, 'Nos', 'Active', 1, '2015-04-07 00:00:00', NULL, NULL),
(7, 'Blowse Pieces', 'BP', NULL, 0, 'Nos', 'Active', 1, '2015-04-07 00:00:00', NULL, NULL),
(8, 'Churidar Material', 'CM', NULL, 0, 'Nos', 'Active', 1, '2015-04-07 00:00:00', NULL, NULL),
(9, 'Panties', 'PN', NULL, 0, 'Nos', 'Active', 1, '2015-04-07 00:00:00', NULL, NULL),
(10, 'Brassiers', 'BR', NULL, 0, 'Nos', 'Active', 1, '2015-04-07 00:00:00', NULL, NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company` varchar(256) DEFAULT NULL,
  `description` varchar(4096) DEFAULT NULL,
  `purchased_on` date NOT NULL,
  `status` enum('Active','Deleted') DEFAULT NULL,
  `sort_order` int(10) DEFAULT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_company` (`created_by`),
  KEY `FK_company_updated_by` (`updated_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_code` varchar(16) DEFAULT NULL,
  `group_id` varchar(32) DEFAULT NULL,
  `name` varchar(128) DEFAULT NULL,
  `description` varchar(2048) DEFAULT NULL,
  `company_id` int(10) unsigned DEFAULT NULL,
  `model` varchar(32) DEFAULT NULL,
  `model_no` varchar(32) DEFAULT NULL,
  `category_id` int(10) unsigned DEFAULT NULL,
  `quantity` int(10) DEFAULT NULL,
  `batch_shop_id` int(10) unsigned DEFAULT NULL,
  `purchase_price` float DEFAULT NULL,
  `margin` float DEFAULT NULL,
  `selling_price` float DEFAULT NULL,
  `status` enum('Active','Hold','Damaged','Deleted','Owned','Soldout') DEFAULT 'Active',
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_product` (`company_id`),
  KEY `FK_product_category_id` (`category_id`),
  KEY `FK_product_batch_shop_id` (`batch_shop_id`),
  KEY `FK_product_created_by` (`created_by`),
  KEY `FK_product_updated_by` (`updated_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `product_property_option`
--

CREATE TABLE IF NOT EXISTS `product_property_option` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned DEFAULT NULL,
  `property_option_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_product_property_option` (`product_id`),
  KEY `FK_product_property_option_id` (`property_option_id`)
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `property`
--

INSERT INTO `property` (`id`, `property`, `status`, `sort_order`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'Size', 'Active', 1, 1, NULL, 1, NULL),
(2, 'Sleev', 'Active', 2, 1, NULL, 1, NULL),
(3, 'Color', 'Active', 1, 1, '2015-01-25 07:17:00', NULL, NULL),
(4, 'Collar', 'Active', 1, 1, '2015-02-06 06:51:17', NULL, NULL),
(5, 'Slit', 'Active', 1, 1, '2015-02-06 06:51:35', NULL, NULL),
(6, 'Length', 'Active', 1, 1, '2015-02-27 05:50:05', 1, '2015-02-27 05:50:40'),
(7, 'Fabric', 'Active', 1, 1, '2015-02-09 06:05:54', 1, '2015-02-27 05:49:21');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `property_option`
--

INSERT INTO `property_option` (`id`, `property_id`, `option`, `status`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 1, 'M', 'Active', 1, NULL, 1, NULL),
(2, 1, 'L', 'Active', 1, NULL, 1, NULL),
(3, 1, 'XL', 'Active', 1, NULL, 1, NULL),
(4, 1, 'XXL', 'Active', 1, NULL, 1, NULL),
(5, 1, 'XXXL', 'Active', 1, NULL, 1, NULL),
(6, 2, 'Half', 'Active', 1, NULL, 1, NULL),
(7, 2, 'ThreeFourth', 'Active', 1, NULL, 1, NULL),
(8, 2, 'Full', 'Active', 1, NULL, 1, NULL),
(9, 4, 'Yes', 'Active', 1, '2015-02-06 06:51:17', NULL, NULL),
(10, 4, 'No', 'Active', 1, '2015-02-06 06:51:17', NULL, NULL),
(11, 5, 'Yes', 'Active', 1, '2015-02-06 06:51:36', NULL, NULL),
(12, 5, 'No', 'Active', 1, '2015-02-06 06:51:36', NULL, NULL),
(13, 7, 'Cotton', 'Active', 1, '2015-04-02 05:19:44', NULL, NULL),
(14, 7, 'Polyster', 'Active', 1, '2015-04-02 05:19:44', NULL, NULL),
(15, 7, 'Linen', 'Active', 1, '2015-04-02 05:19:44', NULL, NULL),
(16, 7, 'Poly cotton', 'Active', 1, '2015-04-02 05:19:44', NULL, NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `shop`
--

INSERT INTO `shop` (`id`, `shop`, `city`, `status`, `sort_order`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'Novelty', 'Eranakulam', 'Active', 1, 1, '2015-04-07 11:21:29', NULL, NULL),
(2, 'AS Fabrics', 'Eranakulam', 'Active', 1, 1, '2015-04-07 11:21:54', NULL, NULL),
(3, 'Just look', 'Eranakulam', 'Active', 1, 1, '2015-04-07 11:23:01', NULL, NULL),
(4, 'Just Look Western', 'Eranakulam', 'Active', 1, 1, '2015-04-07 11:23:25', NULL, NULL),
(5, 'Lovely Churidar', 'Eranakulam', 'Active', 1, 1, '2015-04-07 11:26:40', NULL, NULL),
(6, 'Lovely Material', 'Eranakulam', 'Active', 1, 1, '2015-04-07 11:27:03', NULL, NULL),
(7, 'Sarath', 'Eranakulam', 'Active', 1, 1, '2015-04-07 11:27:13', NULL, NULL);

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
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `first_name`, `last_name`, `role`, `remember_token`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'admin@daavani.com', '$2y$10$573y.0Tl5GlK0WSz.V8bv.w7VPWNBqBfnhE.tL35Nq/GHH0xTNE96', 'Arun', 'SS', 'Admin', 'AlfA9bV43OLqUq8HjhZlVGFQS68HBENVcN1dWj2PNdu1TBXknp3miaJd8yjd', 'Active', NULL, 0, '2015-02-23 16:39:49', NULL),
(2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL);

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
  ADD CONSTRAINT `FK_category_property` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `FK_category_property_id` FOREIGN KEY (`property_id`) REFERENCES `property` (`id`);

--
-- Constraints for table `company`
--
ALTER TABLE `company`
  ADD CONSTRAINT `FK_company` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_company_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_product` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`),
  ADD CONSTRAINT `FK_product_batch_shop_id` FOREIGN KEY (`batch_shop_id`) REFERENCES `batch_shops` (`id`),
  ADD CONSTRAINT `FK_product_category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `FK_product_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_product_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `product_property_option`
--
ALTER TABLE `product_property_option`
  ADD CONSTRAINT `FK_product_property_option` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `FK_product_property_option_id` FOREIGN KEY (`property_option_id`) REFERENCES `property_option` (`id`);

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
SET FOREIGN_KEY_CHECKS=1;
