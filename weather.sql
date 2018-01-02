-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2016 at 05:33 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `weather`
--

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

CREATE TABLE IF NOT EXISTS `data` (
  `sensor_id` int(11) NOT NULL,
  `reading` float NOT NULL,
  `unit` varchar(15) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data`
--

INSERT INTO `data` (`sensor_id`, `reading`, `unit`, `time_stamp`) VALUES
(8, 94987, 'Pascal', '2015-11-19 09:20:18'),
(8, 94949, 'Pascal', '2015-11-19 10:28:04'),
(8, 94955, 'Pascal', '2015-11-19 10:35:04'),
(8, 94969, 'Pascal', '2015-11-19 10:42:04'),
(8, 94985, 'Pascal', '2015-11-19 10:49:04'),
(8, 94995, 'Pascal', '2015-11-19 10:56:04'),
(8, 94990, 'Pascal', '2015-11-19 11:00:05'),
(8, 95016, 'Pascal', '2015-11-19 11:07:05'),
(8, 95042, 'Pascal', '2015-11-19 11:14:05'),
(8, 95045, 'Pascal', '2015-11-19 11:21:04'),
(8, 95032, 'Pascal', '2015-11-19 11:28:04'),
(8, 95027, 'Pascal', '2015-11-19 11:35:04'),
(8, 95042, 'Pascal', '2015-11-19 11:42:04'),
(8, 95064, 'Pascal', '2015-11-19 11:49:05'),
(8, 95112, 'Pascal', '2015-11-19 11:56:04'),
(8, 95102, 'Pascal', '2015-11-19 12:00:04'),
(8, 95111, 'Pascal', '2015-11-19 12:07:04'),
(8, 95141, 'Pascal', '2015-11-19 12:14:04'),
(8, 95152, 'Pascal', '2015-11-19 12:21:04'),
(8, 95172, 'Pascal', '2015-11-19 12:28:04'),
(8, 95151, 'Pascal', '2015-11-19 12:35:53'),
(8, 95152, 'Pascal', '2015-11-19 12:42:05'),
(8, 95186, 'Pascal', '2015-11-19 12:49:06'),
(8, 95186, 'Pascal', '2015-11-19 12:49:07'),
(8, 95245, 'Pascal', '2015-11-19 12:56:05'),
(8, 95250, 'Pascal', '2015-11-19 13:00:05'),
(8, 95254, 'Pascal', '2015-11-19 13:07:05'),
(8, 95237, 'Pascal', '2015-11-19 13:14:04'),
(8, 95253, 'Pascal', '2015-11-19 13:21:05'),
(8, 95251, 'Pascal', '2015-11-19 13:28:05'),
(8, 95266, 'Pascal', '2015-11-19 13:35:05'),
(8, 95287, 'Pascal', '2015-11-19 13:42:04'),
(8, 95308, 'Pascal', '2015-11-19 13:49:04'),
(8, 95306, 'Pascal', '2015-11-19 13:49:05'),
(8, 95327, 'Pascal', '2015-11-19 13:56:05'),
(8, 95342, 'Pascal', '2015-11-19 14:00:05'),
(8, 95333, 'Pascal', '2015-11-19 14:07:05'),
(8, 95344, 'Pascal', '2015-11-19 14:14:05'),
(8, 95345, 'Pascal', '2015-11-19 14:21:04'),
(8, 95340, 'Pascal', '2015-11-19 14:21:05'),
(8, 95357, 'Pascal', '2015-11-19 14:28:05'),
(8, 95372, 'Pascal', '2015-11-19 14:35:04'),
(8, 95362, 'Pascal', '2015-11-19 14:42:05'),
(8, 95385, 'Pascal', '2015-11-19 14:49:05'),
(8, 95378, 'Pascal', '2015-11-19 14:56:05'),
(8, 95378, 'Pascal', '2015-11-19 15:00:05'),
(8, 95384, 'Pascal', '2015-11-19 15:07:05'),
(8, 95393, 'Pascal', '2015-11-19 15:14:06'),
(8, 95412, 'Pascal', '2015-11-19 15:21:05'),
(8, 95452, 'Pascal', '2015-11-19 16:21:05'),
(8, 95449, 'Pascal', '2015-11-19 16:28:05'),
(8, 95438, 'Pascal', '2015-11-19 16:35:05'),
(8, 95425, 'Pascal', '2015-11-19 16:42:05'),
(8, 95415, 'Pascal', '2015-11-19 16:49:06'),
(11, 95286, 'Pascal', '2015-11-22 17:07:02'),
(11, 95275, 'Pascal', '2015-11-22 17:07:03'),
(11, 95275, 'Pascal', '2015-11-22 17:14:02'),
(11, 95263, 'Pascal', '2015-11-22 17:21:03'),
(11, 95261, 'Pascal', '2015-11-22 17:28:03'),
(11, 95255, 'Pascal', '2015-11-22 17:35:03'),
(11, 95251, 'Pascal', '2015-11-22 17:42:02'),
(11, 95235, 'Pascal', '2015-11-22 17:42:03'),
(11, 95239, 'Pascal', '2015-11-22 17:49:03'),
(11, 95237, 'Pascal', '2015-11-22 17:56:02'),
(11, 95236, 'Pascal', '2015-11-22 18:00:03'),
(11, 95232, 'Pascal', '2015-11-22 18:07:03'),
(11, 95223, 'Pascal', '2015-11-22 18:14:03'),
(11, 95212, 'Pascal', '2015-11-22 18:21:03'),
(11, 95217, 'Pascal', '2015-11-22 18:21:04'),
(11, 95217, 'Pascal', '2015-11-22 18:28:03');

-- --------------------------------------------------------

--
-- Table structure for table `geo_coord`
--

CREATE TABLE IF NOT EXISTS `geo_coord` (
`location_id` int(11) NOT NULL,
  `lat` int(11) NOT NULL,
  `long` int(11) NOT NULL,
  `location_name` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `geo_coord`
--

INSERT INTO `geo_coord` (`location_id`, `lat`, `long`, `location_name`) VALUES
(1, 7, 81, 'Kandy');

-- --------------------------------------------------------

--
-- Table structure for table `node`
--

CREATE TABLE IF NOT EXISTS `node` (
`node_id` int(11) NOT NULL,
  `node_name` varchar(50) NOT NULL,
  `location` int(11) NOT NULL,
  `node_type` varchar(50) NOT NULL,
  `uniq_str` varchar(100) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `node`
--

INSERT INTO `node` (`node_id`, `node_name`, `location`, `node_type`, `uniq_str`, `time_stamp`) VALUES
(10, 'rajawatte_ctl', 1, 'weather', '_stesh_i0ygcte_s_ibh_s3nhi4sahbihea5641a58a258409.37938910', '2015-11-22 16:42:02'),
(11, 'hanthana_ctl', 1, 'weather', '_enbsg_hhiaaii30is_bthc_st4yeh_sesh5641e01d0fe097.14392423', '2015-11-18 13:35:39'),
(14, 'augusta_hill', 1, 'weather', '3_bgea_a_iehtyi4etshssb_ih0chns_ish564ea724f15086.69091806', '2015-11-22 18:28:03'),
(15, 'test_weather', 1, 'weather', 'iisc__e_eha_sghhnyitah_tess4bih03bs565ad4f7e5dc02.14347932', '2015-11-29 10:35:35');

-- --------------------------------------------------------

--
-- Table structure for table `sensor`
--

CREATE TABLE IF NOT EXISTS `sensor` (
`sensor_id` int(11) NOT NULL,
  `node_id` int(11) DEFAULT NULL,
  `sensor_type` varchar(50) NOT NULL,
  `activated` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sensor`
--

INSERT INTO `sensor` (`sensor_id`, `node_id`, `sensor_type`, `activated`) VALUES
(4, 11, 'temperature', 1),
(8, 10, 'pressure', 1),
(9, 10, 'temperature', 1),
(10, 10, 'humidity', 0),
(11, 14, 'pressure', 1),
(12, 14, 'humidity', 0),
(13, NULL, 'temperature', 1),
(14, NULL, 'pressure', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `username` varchar(25) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_code` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `generated_string` varchar(255) NOT NULL,
  `confirmed` int(1) NOT NULL,
`id` int(11) NOT NULL,
  `freq` int(11) NOT NULL DEFAULT '1800',
  `type` varchar(10) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `email`, `email_code`, `password`, `generated_string`, `confirmed`, `id`, `freq`, `type`) VALUES
('bhashithe', 'bhashithe@hotmail.com', 'bhs_3yiieshs_ethcsi4_bnh_0ihget_asa5610ba9e5307d2.92683290', '$2y$12$99738213325610ba9e530u8Hu4ywKVZ1Xd0h4I5IHpVoWZ6tnleOm', '', 1, 1, 360, 'admin'),
('chichi', 'chi@chi.chi', 'ybi0_stiha_anse_g_bchisths_hsi4ehe35610bdd22fa8a1.21580661', '$2y$12$5643086205610bdd22fabueRMI8Ei/YGaBDmXiIU9FNsYQ5DkNd9O', '', 1, 2, 1800, 'user'),
('ola', 'ola@gmail.com', 'g_sia_4bnish_h3tcs_s_ehiyatihsee0bh564181d95cb691.58201462', '$2y$12$134300207564181d95cb8uMBAl28WaHEyaTIxNYdkbteViv1RkRgi', '', 0, 3, 1800, 'user'),
('rashmie', 'rash045@gmail.com', 's3h4e_btsg_t0ihsais_hn_esbech_hiyia56527e8744a114.64717819', '$2y$12$308090221356527e87542uIXof5Y0ysENDajb4J.45obXeRylDvz6', '', 0, 4, 1800, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `user_node`
--

CREATE TABLE IF NOT EXISTS `user_node` (
  `node_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_node`
--

INSERT INTO `user_node` (`node_id`, `user_id`) VALUES
(10, 1),
(11, 3),
(14, 1),
(15, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data`
--
ALTER TABLE `data`
 ADD PRIMARY KEY (`sensor_id`,`time_stamp`), ADD KEY `for_fk` (`sensor_id`);

--
-- Indexes for table `geo_coord`
--
ALTER TABLE `geo_coord`
 ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `node`
--
ALTER TABLE `node`
 ADD PRIMARY KEY (`node_id`), ADD KEY `location` (`location`);

--
-- Indexes for table `sensor`
--
ALTER TABLE `sensor`
 ADD PRIMARY KEY (`sensor_id`), ADD KEY `node_id` (`node_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_node`
--
ALTER TABLE `user_node`
 ADD PRIMARY KEY (`node_id`,`user_id`), ADD UNIQUE KEY `node_id` (`node_id`), ADD KEY `node_id_2` (`node_id`), ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `geo_coord`
--
ALTER TABLE `geo_coord`
MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `node`
--
ALTER TABLE `node`
MODIFY `node_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `sensor`
--
ALTER TABLE `sensor`
MODIFY `sensor_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `data`
--
ALTER TABLE `data`
ADD CONSTRAINT `fk_sensor` FOREIGN KEY (`sensor_id`) REFERENCES `sensor` (`sensor_id`);

--
-- Constraints for table `node`
--
ALTER TABLE `node`
ADD CONSTRAINT `fk_coord` FOREIGN KEY (`location`) REFERENCES `geo_coord` (`location_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sensor`
--
ALTER TABLE `sensor`
ADD CONSTRAINT `fk_node` FOREIGN KEY (`node_id`) REFERENCES `node` (`node_id`);

--
-- Constraints for table `user_node`
--
ALTER TABLE `user_node`
ADD CONSTRAINT `fk_nde` FOREIGN KEY (`node_id`) REFERENCES `node` (`node_id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_uesr` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
