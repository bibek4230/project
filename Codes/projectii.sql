-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 06, 2025 at 04:12 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projectii`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `qty`) VALUES
(43, 1),
(46, 1),
(53, 1),
(58, 1);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `fname` varchar(40) DEFAULT NULL,
  `mname` varchar(15) DEFAULT NULL,
  `lname` varchar(40) DEFAULT NULL,
  `address` varchar(35) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `gender` varchar(1) DEFAULT NULL,
  `email` varchar(35) DEFAULT NULL,
  `uname` varchar(40) DEFAULT NULL,
  `pwd` varchar(255) DEFAULT NULL,
  `acc` int(11) DEFAULT NULL,
  `status` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`fname`, `mname`, `lname`, `address`, `mobile`, `gender`, `email`, `uname`, `pwd`, `acc`, `status`) VALUES
('pupa', 'kumari', 'ghalan', 'bharatpur', '9875423456', 'f', 'rupa@gmail.com', 'pupa123', '123456', 1, 'active'),
('jason', '', 'Statham', 'kathmandu-01 bagmati,nepal', '9856435423', 'm', 'jason@gmail.com', 'jason123', '123456', 2, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `pid` int(11) DEFAULT NULL,
  `uid` varchar(60) DEFAULT NULL,
  `cstar` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`pid`, `uid`, `cstar`) VALUES
(47, 'jason123', 3),
(48, 'jason123', 3),
(52, 'jason123', 3),
(56, 'jason123', 3),
(60, 'jason123', 3),
(62, 'jason123', 5),
(58, 'jason123', 5),
(54, 'jason123', 5),
(55, 'jason123', 5);

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE `uploads` (
  `id` int(11) NOT NULL,
  `pname` varchar(30) DEFAULT NULL,
  `pprice` int(11) DEFAULT NULL,
  `serchar` int(11) DEFAULT NULL,
  `tax` varchar(10) DEFAULT NULL,
  `total` varchar(10) DEFAULT NULL,
  `pdes` varchar(1000) DEFAULT NULL,
  `fname` varchar(200) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uploads`
--

INSERT INTO `uploads` (`id`, `pname`, `pprice`, `serchar`, `tax`, `total`, `pdes`, `fname`, `category`, `stock`) VALUES
(47, 'Remote Control Car', 450, 50, '58.5', '558.5', 'This is remote control car for kids above 5yrs with 5 cell capacity with operating hours of approx 1000hrs per batch of cell.', '../files/remotcontrolcar.jpeg', 'kids', 100),
(48, 'Office Supply', 2300, 20, '299', '2619', 'This item includes kit of multiple stationary items per batch which meets all the office requirement all at once.', '../files/officesupply.jpeg', 'books', 100),
(49, 'Horlicks', 200, 10, '26', '236', 'This product is enriched with vitamin A,B and C with iron included which keeps kids healty.', '../files/horlicks.jpeg', 'food', 1200),
(50, 'Hookha', 1400, 100, '182', '1682', 'This hookha is provided with three best flavour of the customer choice. ', '../files/hookha.jpg', 'luxury', 105),
(52, 'GoPro', 5600, 200, '728', '6528', 'This headphone has features of 4k recording and can be upgraded to 8k with slightest change costing less than rs.500.', '../files/gopro.jpeg', 'electronics', 24),
(53, 'Dabur Glucose', 230, 10, '29.9', '269.9', 'New enerzising glucose.', '../files/glucose.jpeg', 'food', 80),
(54, 'Home Refregerator', 34000, 2000, '4420', '40420', 'This refregerator is for home appliance and has capacity of 80 ltr.', '../files/fridge.jpeg', 'electronics', 10),
(55, 'Five Point someone', 340, 30, '44.2', '414.2', 'This book is written by chetan bhagat and has higest selling record in nepal.', '../files/fivepointsomeone.jpeg', 'books', 100),
(56, 'Drone', 3400, 30, '442', '3872', 'It has capacity to remain in the air for more than an hour in single full charge.', '../files/drone.jpeg', 'electronics', 20),
(58, 'Cotton Candy', 20, 5, '2.6', '27.6', 'Sugar free cotton candy.', '../files/cottoncandy.jpg', 'kids', 1000),
(59, 'Samsung A71', 45000, 100, '5850', '50950', 'It has features of 4g,6gb ram,500gb ssd and 8 quad processor with the speed of 2.85ghz.', '../files/cellphone.jpeg', 'electronics', 56),
(60, 'Cauli Flower', 20, 5, '2.6', '27.6', 'Fresh yield cauliflower grown without the use of fertilizer.', '../files/cauliflower.jpeg', 'food', 100),
(61, 'Egg Fruit', 20, 3, '2.6', '25.6', 'Freshly yield egg fruit grown without the use of chemical fertilizer.', '../files/brinjal.jpeg', 'food', 100),
(62, 'Barbie Doll', 200, 25, '26', '251', 'The low cost beautiful barbie doll for your kids.', '../files/barbiedoll.jpeg', 'kids', 1000),
(64, 'Ray Ban Goggle', 350, 30, '45.5', '425.5', 'This goggle is polarized which will save your eyes from the hazardious ray from the sun.', '../files/goggle.jpg', 'luxury', 20);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD KEY `fk_rating_pid` (`pid`);

--
-- Indexes for table `uploads`
--
ALTER TABLE `uploads`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `uploads`
--
ALTER TABLE `uploads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `fk_rating_pid` FOREIGN KEY (`pid`) REFERENCES `uploads` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
