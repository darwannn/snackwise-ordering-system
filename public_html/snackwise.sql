-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2022 at 10:28 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `snackwise`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `menu_id`, `quantity`) VALUES
(1, 1, 0, 1),
(2, 1, 25, 1),
(3, 1, 25, 1),
(4, 1, 0, 1),
(5, 1, 0, 1),
(6, 1, 0, 1),
(7, 1, 0, 1),
(8, 1, 25, 1),
(9, 1, 25, 1),
(10, 1, 25, 1),
(11, 1, 25, 1),
(12, 1, 25, 1),
(13, 1, 25, 1),
(14, 1, 25, 1),
(15, 1, 25, 1),
(16, 1, 25, 1),
(17, 1, 25, 1),
(18, 1, 25, 1),
(19, 1, 25, 1),
(20, 1, 25, 1),
(21, 1, 25, 1),
(22, 1, 25, 1),
(23, 1, 25, 1),
(24, 1, 25, 1),
(25, 1, 25, 1),
(26, 1, 25, 1);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `name`) VALUES
(1, 'Pizza'),
(2, 'Drinks');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `menu_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `discount` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `date` date NOT NULL,
  `availability` tinyint(1) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `name`, `description`, `category`, `discount`, `price`, `date`, `availability`, `image`) VALUES
(25, 'a', 's', '1', '76', 56, '2022-10-10', 1, 'C:\\xampp\\tmp\\phpEF01.tmp');

-- --------------------------------------------------------

--
-- Table structure for table `orderlist`
--

CREATE TABLE `orderlist` (
  `orderlist_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `qr_image` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `municipality` varchar(255) NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `attempt` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `firstname`, `lastname`, `username`, `email`, `contact`, `password`, `province`, `municipality`, `barangay`, `street`, `attempt`, `status`, `code`, `user_type`) VALUES
(1, 'dd', 'dd', 'd', 'd', '', '', 'none', 'none', 'none', '', 1, 'verified', '0', 'staff'),
(2, '', '', '', '', '', '', 'none', 'none', 'none', '', 0, 'verified', '0', 'staff'),
(3, '', '', '', '', '', '', 'none', 'none', 'none', '', 0, 'verified', '0', 'staff'),
(4, '', '', '', '', '', '', 'none', 'none', 'none', '', 0, 'verified', '0', 'staff'),
(5, '', '', '', '', '', '', 'none', 'none', 'none', '', 0, 'verified', '0', 'staff'),
(6, '', '', '', '', '', '', 'none', 'none', 'none', '', 0, 'verified', '0', 'staff'),
(7, '', '', '', '', '', '', 'none', 'none', 'none', '', 0, 'verified', '0', 'staff'),
(8, '', '', '', '', '', '', 'none', 'none', 'none', '', 0, 'verified', '0', 'staff'),
(9, '', '', '', '', '', '', 'none', 'none', 'none', '', 0, 'verified', '0', 'staff'),
(10, 'Bulacan', '', 'darwin', 'darwinsanluis.ramos14@gmail.com', '09323887940', '$2y$10$Wt.PPD3RC/SPT8nA8rpc1OyM3o9avvu1jI0Oueupf2M20hFAeDEU2', 'none', 'none', 'none', '', 3, 'verified', 'OevFKGailhDFeVsu', 'staff'),
(11, '', '', 'ddddd', '', '', '', 'none', 'none', 'none', '', 0, 'verified', '0', 'staff'),
(12, '', '', '', '', '', '', 'none', 'none', 'none', '', 0, 'verified', '0', 'staff'),
(13, '', '', '', '', '', '', 'none', 'none', 'none', '', 0, 'verified', '0', 'staff'),
(14, '', '', '', 'darwin.ramos.sl@bulsu.edu.ph', '', '', 'none', 'none', 'none', '', 0, 'unverified', 'wpnMSAp3gmqkKCR3', 'staff'),
(15, '', '', '', '', '', '', 'none', 'none', 'none', '', 0, 'unverified', 'Jw%$Hwn9CIAv2WxQ', 'staff'),
(16, '', '', '', '', '', '', 'none', 'none', 'none', '', 0, 'unverified', 'pvBdFsS7xaOE6fo%', 'staff'),
(17, '', '', '', '', '', '', 'none', 'none', 'none', '', 0, 'unverified', '9Wey0nBLNkzlGfJ4', 'staff');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `orderlist`
--
ALTER TABLE `orderlist`
  ADD PRIMARY KEY (`orderlist_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `orderlist`
--
ALTER TABLE `orderlist`
  MODIFY `orderlist_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
