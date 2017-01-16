-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2017 at 09:23 PM
-- Server version: 5.7.14
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wt_creda`
--

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `id` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8_slovenian_ci NOT NULL,
  `number_of_citizens` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`id`, `name`, `number_of_citizens`) VALUES
(1, 'Sarajevo', 500000),
(3, 'Mostar', 250000),
(5, 'Zenica', 20000),
(11, 'Tuzla', 100009),
(15, 'Reims', 696969),
(16, 'Jablanica', 50),
(17, 'Konjic', 5000);

-- --------------------------------------------------------

--
-- Table structure for table `flight`
--

CREATE TABLE `flight` (
  `id` int(11) NOT NULL,
  `from_city` int(11) NOT NULL,
  `to_city` int(11) NOT NULL,
  `date` varchar(50) COLLATE utf8_slovenian_ci NOT NULL,
  `duration` int(11) NOT NULL,
  `cost` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `flight`
--

INSERT INTO `flight` (`id`, `from_city`, `to_city`, `date`, `duration`, `cost`) VALUES
(1, 1, 11, '21/12/2012 15:00', 50, 50),
(2, 3, 11, '21/12/2012 15:00', 50, 50),
(3, 11, 15, '21/12/2012 15:00', 50, 50),
(4, 1, 11, '21/12/2012 15:00', 50, 50),
(23, 1, 11, 'sfsdf', 45, 45),
(25, 1, 1, 'dfgdfg', 34, 34565656),
(26, 1, 1, 'sdfasfsd', 56, 56);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(10) NOT NULL,
  `first_name` varchar(30) COLLATE utf8_slovenian_ci NOT NULL,
  `last_name` varchar(30) COLLATE utf8_slovenian_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_slovenian_ci NOT NULL,
  `username` varchar(50) COLLATE utf8_slovenian_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_slovenian_ci NOT NULL,
  `city_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `email`, `username`, `password`, `city_id`) VALUES
(11, 'Creda Brat', 'Bratam Svog', 'weed@hotmail.com', 'crefa', '179ad45c6ce2cb97cf1029e212046e81', 1),
(14, 'kasko', 'kasko', 'kasko@gmail.com', 'kasko', 'da5e085ceb59d829fd83832592a29312', 1),
(15, 'Vedad', 'Mulic', 'creda@gmail.com', 'credad', 'd930807e48a46653a72ccba6f5290bb1', 1),
(16, 'sdfasf', 'sfadsf', 'sdfasd@gmail.com', 'sfasfsd', '93279e3308bdbbeed946fc965017f67a', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `flight`
--
ALTER TABLE `flight`
  ADD PRIMARY KEY (`id`),
  ADD KEY `from_city` (`from_city`) USING BTREE,
  ADD KEY `from_city_2` (`from_city`) USING BTREE,
  ADD KEY `from_city_3` (`from_city`) USING BTREE,
  ADD KEY `from_city_4` (`from_city`) USING BTREE,
  ADD KEY `to_city` (`to_city`) USING BTREE;

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `grad_id` (`city_id`) USING BTREE,
  ADD KEY `grad_id_2` (`city_id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `flight`
--
ALTER TABLE `flight`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `flight`
--
ALTER TABLE `flight`
  ADD CONSTRAINT `flight_ibfk_1` FOREIGN KEY (`from_city`) REFERENCES `city` (`id`),
  ADD CONSTRAINT `flight_ibfk_2` FOREIGN KEY (`to_city`) REFERENCES `city` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
