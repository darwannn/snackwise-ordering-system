-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2022 at 09:21 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `name`) VALUES
(1, 'Combo'),
(2, 'Fries'),
(3, 'Burger'),
(4, 'Drinks');

-- --------------------------------------------------------

--
-- Table structure for table `closed_date`
--

CREATE TABLE `closed_date` (
  `closed_date_id` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `menu_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `category` int(50) NOT NULL,
  `discount` varchar(50) NOT NULL,
  `price` double NOT NULL,
  `date` date NOT NULL,
  `availability` varchar(20) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `name`, `description`, `category`, `discount`, `price`, `date`, `availability`, `image`) VALUES
(65, 'Combo A', 'Includes: Regular Burger, Regular Fries, Blue Lemonade', 1, '10', 75, '2022-11-29', 'Unavailable', 'v1668393471/SnackWise/Menu/Alpha'),
(66, 'Combo B', 'Includes: Regular Burger, Carbonara, Blue Lemonade', 1, '10', 90, '2022-11-18', 'Available', 'v1669200184/SnackWise/Menu/Combo B'),
(67, 'Combo C', 'Includes: Regular Hotdog, Regular Fries, Blue Lemonade', 1, '10', 80, '2022-11-18', 'Available', 'v1668702383/SnackWise/Menu/Combo C'),
(68, 'Combo D', 'Includes: Regular Fries, Carbonara, Blue Lemonade', 1, '0', 85, '2022-11-18', 'Available', 'v1669200230/SnackWise/Menu/Combo D'),
(69, 'Combo E', 'Includes: Regular Burger, Regular Fries, Spaghetti, Blue Lemonade', 1, '0', 120, '2022-11-18', 'Available', 'v1669200270/SnackWise/Menu/Combo E'),
(70, 'Barkada Meal', 'Good for 4 People. Includes: 4 Regular Fries, 4 Regular Burger, 4 Blue Lemonade', 1, '5', 300, '2022-11-18', 'Available', 'v1669200309/SnackWise/Menu/Barkada Meal'),
(71, 'F1', 'Includes: Cheesy Fries, Blue Lemonade', 2, '0', 29, '2022-11-18', 'Available', 'v1669200399/SnackWise/Menu/F1'),
(72, 'F2', 'Includes: Cheesy Fries, Hotdog, Blue Lemonade', 2, '0', 39, '2022-11-18', 'Available', 'v1669200414/SnackWise/Menu/F2'),
(73, 'F3', 'Includes: Cheesy Fries, Nuggets, Blue Lemonade', 2, '0', 39, '2022-11-18', 'Available', 'v1669200428/SnackWise/Menu/F3'),
(74, 'F4', 'Includes: Cheesy Fries, Cheese Sticks, Blue Lemonade', 2, '0', 39, '2022-11-18', 'Available', 'v1669200443/SnackWise/Menu/F4'),
(75, 'Nacho Fries', 'Seasoned french fries, topped with nacho cheese sauce, and sautéed ground pork', 2, '0', 55, '2022-11-18', 'Available', 'v1669200460/SnackWise/Menu/Nacho Fries'),
(76, 'Regular Burger', 'A classic burger with beef patty, ketchup, and mayonnaise', 3, '0', 29, '2022-11-18', 'Available', 'v1669200508/SnackWise/Menu/Regular Burger'),
(77, 'Bacon Cheese Burger', 'Burger with  bacon, beef patty, cheese, ketchup, and mayonnaise', 3, '0', 49, '2022-11-18', 'Available', 'v1669200525/SnackWise/Menu/Bacon Cheese Burger'),
(78, 'Chicken Burger', 'Burger with crispy seasoned chicken breast, topped with mayonnaise', 3, '0', 49, '2022-11-18', 'Unavailable', 'v1669200541/SnackWise/Menu/Chicken Burger'),
(79, 'Double Dutch Frappé', '22oz Double Dutch flavored milk shake with kream puff, and pearl', 4, '0', 55, '2022-11-18', 'Available', 'v1669200567/SnackWise/Menu/Double Dutch Frappé'),
(80, 'Cookies and Cream Frappé', '22oz Vanilla milk shake mixed with crushed oreo cookies, and pearl', 4, '0', 55, '2022-11-18', 'Available', 'v1669200626/SnackWise/Menu/Cookies and Cream Frappé'),
(81, 'Buko Pandan Frappé', '22oz Buko pandan flavored milkshake with pandan jelly, coconut meat, and pearl', 4, '0', 55, '2022-11-18', 'Available', 'v1669200639/SnackWise/Menu/Buko Pandan Frappé'),
(82, 'Ube  Frappé', '22oz A classic flavoured milk shake vanilla mixed with purple yam (ube), and pearl', 4, '0', 55, '2022-11-18', 'Available', 'v1669201229/SnackWise/Menu/Ube  Frappé'),
(83, 'Chocolate Milk Tea', '22oz Chocolate flavored milk tea with kream puff, and pearl', 4, '0', 55, '2022-11-18', 'Available', 'v1669201266/SnackWise/Menu/Chocolate Milk Tea'),
(84, 'Mango Cheese Cake Milk Tea', '22oz Mango flavored milk tea with a creamy cheesecake, and pearl ', 4, '0', 55, '2022-11-18', 'Available', 'v1669201285/SnackWise/Menu/Mango Cheese Cake Milk Tea');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter`
--

CREATE TABLE `newsletter` (
  `newsletter_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `code` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notification_id` int(11) NOT NULL,
  `type` varchar(10) NOT NULL,
  `message` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`notification_id`, `type`, `message`, `user_id`, `order_id`, `date`, `status`) VALUES
(376, 'Placed', 'Your order is now confirmed and now processing', 127, 85, '2022-12-18 16:19:49', 'read'),
(377, 'Placed', 'An order has been placed.', 0, 85, '2022-12-18 16:19:49', 'unread');

-- --------------------------------------------------------

--
-- Table structure for table `orderlist`
--

CREATE TABLE `orderlist` (
  `orderlist_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `orderlist`
--

INSERT INTO `orderlist` (`orderlist_id`, `order_id`, `menu_id`, `quantity`) VALUES
(201, 85, 68, 1),
(202, 85, 69, 1),
(203, 85, 67, 1),
(204, 85, 66, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `total_price` float NOT NULL,
  `qr_code` varchar(50) NOT NULL,
  `qr_image` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `date`, `time`, `total_price`, `qr_code`, `qr_image`, `status`) VALUES
(85, 127, '2022-12-18', '18:19:00', 358, '9ExslqUifIrwtDOF', 'v1671351588/SnackWise/QR/9ExslqUifIrwtDOF', 'Placed');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `transaction_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `total_price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(100) NOT NULL,
  `attempt` int(11) NOT NULL,
  `status` varchar(10) NOT NULL,
  `code` varchar(50) NOT NULL,
  `code_expiration` datetime NOT NULL,
  `user_type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `firstname`, `lastname`, `username`, `email`, `contact`, `password`, `image`, `attempt`, `status`, `code`, `code_expiration`, `user_type`) VALUES
(1, 'Snackwise', 'Snackwise', 'snackwise', 'snackwise.hagonoy@gmail.com', '09708601544', '$2y$10$9x/2nojXw7xtbZabhCONQuHrVxJyKhTdqBz4OX.r5CtwG0.h4P/L2', 'v1670389435/SnackWise/User/snackwise', 0, 'verified', '', '2022-11-27 20:55:23', 'admin'),
(127, 'Clarence', 'Joseph', 'clarencetinator', 'clarence.dimafelix07@gmail.com', '09083662675', '$2y$10$23EVCmKOemNMlU8ExYspxOKdtHcmvKPQRo54lQrqwZWPcGa29kiXe', 'v1669374591/SnackWise/User/no-image_sohawv.jpg', 0, 'verified', '0', '2022-12-18 16:18:56', 'customer');

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
-- Indexes for table `closed_date`
--
ALTER TABLE `closed_date`
  ADD PRIMARY KEY (`closed_date_id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`newsletter_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notification_id`);

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
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transaction_id`);

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
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=310;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `closed_date`
--
ALTER TABLE `closed_date`
  MODIFY `closed_date_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `newsletter_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=378;

--
-- AUTO_INCREMENT for table `orderlist`
--
ALTER TABLE `orderlist`
  MODIFY `orderlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=205;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
