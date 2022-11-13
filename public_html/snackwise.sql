-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2022 at 06:25 PM
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
-- Table structure for table `holiday`
--

CREATE TABLE `holiday` (
  `holiday_id` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `holiday`
--

INSERT INTO `holiday` (`holiday_id`, `date`) VALUES
(10, '2022-11-23');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `menu_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `category` int(255) NOT NULL,
  `discount` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `date` date NOT NULL,
  `availability` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `name`, `description`, `category`, `discount`, `price`, `date`, `availability`, `image`) VALUES
(29, '', '', 1, '3', 20, '0000-00-00', 'available', 'v1666536941/SnackWise/Menu/ef2ydimmoyxk9koo0bz7'),
(32, '', '', 1, '', 0, '0000-00-00', 'available', 'v1666706051/SL Visuals/wuydgk806ec1prq6olfw'),
(36, '', '', 1, '', 0, '2022-11-12', 'available', 'v1666713769/SnackWise/Menu/uhvl60djov3qo5mblflo'),
(37, '', '', 1, '', 0, '0000-00-00', 'available', 'v1666713899/SnackWise/Menu/ofqgig22d8tmuqqgzt5d'),
(38, '', '', 1, '', 324, '0000-00-00', 'available', 'v1666714902/SnackWise/Menu/qtjxcewm643c0qmjjv0x'),
(40, 'Alpha', '4', 1, '54', 545, '2022-11-03', 'available', 'v1667404510/SnackWise/Menu/1'),
(41, 'name', 'descrip', 0, '0', 10, '0000-00-00', 'available', 'null'),
(42, 'name', 'descrip', 0, '0', 10, '0000-00-00', 'available', 'null'),
(43, 'name', 'descrip', 0, '0', 10, '0000-00-00', 'available', 'null'),
(44, 'name', 'descrip', 0, '0', 10, '0000-00-00', 'available', 'null');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notification_id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`notification_id`, `message`, `user_id`, `status`) VALUES
(1, 'order has been claimed', 1, 'read'),
(2, 'order has been claimed', 1, 'read'),
(3, 'notif1', 0, 'unread'),
(4, 'notif2', 1, 'read'),
(5, 'order has been claimed', 1, 'read'),
(6, 'order has been claimed', 1, 'read'),
(7, 'order has been claimed', 1, 'read'),
(8, 'order has been claimed', 1, 'read'),
(9, 'order has been claimed', 1, 'read'),
(10, 'order has been claimed', 1, 'read'),
(11, 'order has been claimed', 1, 'read'),
(12, 'order has been claimed', 1, 'read'),
(13, 'order has been claimed', 1, 'read'),
(14, 'order has been claimed', 1, 'read'),
(15, 'order has been claimed', 1, 'read'),
(16, 'order has been claimed', 1, 'read'),
(17, 'order has been claimed', 1, 'read'),
(18, 'order has been claimed', 1, 'read'),
(19, 'order has been claimed', 1, 'read'),
(20, 'order has been claimed', 1, 'read'),
(21, 'order has been claimed', 1, 'read'),
(22, 'order has been claimed', 1, 'read'),
(23, 'order has been claimed', 1, 'read'),
(24, 'order has been claimed', 1, 'read'),
(25, 'order has been claimed', 1, 'read'),
(26, 'order has been claimed', 1, 'read'),
(27, 'order has been claimed', 1, 'read'),
(28, 'order has been claimed', 1, 'read'),
(29, 'order has been claimed', 1, 'read'),
(30, 'order has been claimed', 1, 'read'),
(31, 'order has been claimed', 1, 'read'),
(32, 'order has been claimed', 1, 'read'),
(33, 'order has been claimed', 1, 'read'),
(34, 'order has been claimed', 1, 'read'),
(35, 'order has been claimed', 1, 'read'),
(36, 'order has been claimed', 1, 'read'),
(37, 'order has been claimed', 1, 'read'),
(38, 'order has been claimed', 1, 'read'),
(39, 'order has been claimed', 1, 'read'),
(40, 'order has been claimed', 1, 'read'),
(41, 'order has been claimed', 1, 'read'),
(42, 'order has been claimed', 1, 'read'),
(43, 'order has been claimed', 1, 'read'),
(44, 'order has been claimed', 1, 'read'),
(45, 'order has been claimed', 1, 'read'),
(46, 'order has been claimed', 1, 'read'),
(47, 'order has been claimed', 1, 'read'),
(48, 'order has been claimed', 1, 'read'),
(49, 'notif2', 1, 'unread'),
(50, 'Your order has been claimed', 1, 'unread'),
(51, 'Your order has been claimed', 1, 'unread'),
(52, 'Your order has been claimed', 1, 'unread'),
(53, 'Your order has been claimed', 1, 'unread'),
(54, 'Your order has been claimed', 1, 'unread'),
(55, 'notif1', 1, 'unread'),
(56, 'Your order has been claimed', 1, 'unread'),
(57, 'Your order has been claimed', 1, 'unread'),
(58, 'Your order has been claimed', 1, 'unread'),
(59, 'Your order has been claimed', 1, 'unread'),
(60, 'Your order has been claimed', 1, 'unread'),
(61, 'Your order has been claimed', 1, 'unread'),
(62, 'Your order has been claimed', 1, 'unread'),
(63, 'Your order has been claimed', 1, 'unread'),
(64, 'Your order has been claimed', 1, 'unread'),
(65, 'Your order has been claimed', 1, 'unread'),
(66, 'Your order has been claimed', 1, 'unread'),
(67, 'Your order has been claimed', 1, 'unread');

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

--
-- Dumping data for table `orderlist`
--

INSERT INTO `orderlist` (`orderlist_id`, `order_id`, `menu_id`, `quantity`) VALUES
(70, 1, 29, 1),
(71, 2, 29, 1),
(72, 2, 27, 4),
(73, 2, 29, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `qr_code` varchar(255) NOT NULL,
  `qr_image` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `date`, `time`, `qr_code`, `qr_image`, `status`) VALUES
(1, 1, '2022-11-05', '12:47:00', 'RMZxjQbBQDNl0tU8', 'v1667623694/SnackWise/QR/RMZxjQbBQDNl0tU8', 'ready'),
(2, 1, '2022-11-05', '19:57:00', 'jIWvKC7pLwOCvAre', 'v1667649494/SnackWise/QR/jIWvKC7pLwOCvAre', 'ready'),
(4, 1, '0000-00-00', '00:00:00', '78GiRtmfSoeYO9JB', 'v1667985458/SnackWise/QR/78GiRtmfSoeYO9JB', 'Preparing'),
(5, 1, '0000-00-00', '00:00:00', 'LsUR7a31yF9FpFg0', 'v1667985465/SnackWise/QR/kNaKStYhwxdgqacj', 'Preparing'),
(6, 1, '0000-00-00', '00:00:00', 'uuzgjtO9vdE6kMJF', 'v1667985471/SnackWise/QR/uuzgjtO9vdE6kMJF', 'Preparing'),
(7, 1, '0000-00-00', '00:00:00', 'eAlyPDvClRNlYqhI', 'v1667985489/SnackWise/QR/eAlyPDvClRNlYqhI', 'Preparing'),
(8, 1, '0000-00-00', '00:00:00', 'u3T2Y0SS9lEe6MK4', 'v1667985501/SnackWise/QR/u3T2Y0SS9lEe6MK4', 'Preparing'),
(9, 1, '0000-00-00', '00:00:00', 'ukgIs2mTXtPiNo4B', 'v1667985531/SnackWise/QR/ukgIs2mTXtPiNo4B', 'Preparing'),
(10, 1, '0000-00-00', '00:00:00', 'LsUR7a31yF9FpFg0', 'v1667985534/SnackWise/QR/VqiECnLPD3rzFyWA', 'Preparing');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `transaction_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`transaction_id`, `order_id`, `user_id`, `date`, `price`) VALUES
(65, 2, 1, '2022-11-12', 0),
(66, 2, 1, '2022-11-12', 0),
(67, 2, 1, '2022-11-12', 0),
(68, 2, 1, '2022-11-12', 0),
(69, 2, 1, '2022-11-12', 110),
(70, 2, 1, '2022-11-12', 0),
(71, 2, 1, '2022-11-12', 0),
(72, 2, 1, '2022-11-12', 0),
(73, 2, 1, '2022-11-12', 19.4);

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
  `region` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `municipality` varchar(255) NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `attempt` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `code_expiration` datetime NOT NULL,
  `user_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `firstname`, `lastname`, `username`, `email`, `contact`, `region`, `password`, `province`, `municipality`, `barangay`, `street`, `image`, `attempt`, `status`, `code`, `code_expiration`, `user_type`) VALUES
(1, 'sheldon', 'sheldon', '', 'sheldon@gmail.com', '09999999999', 'none', '', 'none', 'none', 'none', '', 'v1666750529/SnackWise/User/nzfnaihagbhzgaumbs7q', 3, 'verified', 'eJ4NAIvqH8U0rZOx', '0000-00-00 00:00:00', 'admin'),
(2, 'sheldon', 'sheldon', '', 'sheldon@gmail.com', '09999999999', 'none', '', 'none', 'none', 'none', '', 'v1666750529/SnackWise/User/nzfnaihagbhzgaumbs7q', 0, 'verified', '0', '0000-00-00 00:00:00', 'staff'),
(3, 'sheldon', 'sheldon', '', 'sheldon@gmail.com', '09999999999', 'none', '', 'none', 'none', 'none', '', 'v1666750529/SnackWise/User/nzfnaihagbhzgaumbs7q', 0, 'verified', '0', '0000-00-00 00:00:00', 'staff'),
(4, 'sheldon', 'sheldon', '', 'sheldon@gmail.com', '09999999999', 'none', '', 'none', 'none', 'none', '', 'v1666750529/SnackWise/User/nzfnaihagbhzgaumbs7q', 0, 'verified', '0', '0000-00-00 00:00:00', 'staff'),
(5, 'sheldon', 'sheldon', '', 'sheldon@gmail.com', '09999999999', 'none', '', 'none', 'none', 'none', '', 'v1666750529/SnackWise/User/nzfnaihagbhzgaumbs7q', 0, 'verified', '0', '0000-00-00 00:00:00', 'staff'),
(6, 'sheldon', 'sheldon', '', 'sheldon@gmail.com', '09999999999', 'none', '', 'none', 'none', 'none', '', 'v1666750529/SnackWise/User/nzfnaihagbhzgaumbs7q', 0, 'verified', '0', '0000-00-00 00:00:00', 'staff'),
(7, 'sheldon', 'sheldon', '', 'sheldon@gmail.com', '09999999999', 'none', '', 'none', 'none', 'none', '', 'v1666750529/SnackWise/User/nzfnaihagbhzgaumbs7q', 0, 'verified', '0', '0000-00-00 00:00:00', 'staff'),
(8, 'sheldon', 'sheldon', '', 'sheldon@gmail.com', '09999999999', 'none', '', 'none', 'none', 'none', '', 'v1666750529/SnackWise/User/nzfnaihagbhzgaumbs7q', 0, 'verified', '0', '0000-00-00 00:00:00', 'staff'),
(9, 'sheldon', 'sheldon', '', 'sheldon@gmail.com', '09999999999', 'none', '', 'none', 'none', 'none', '', 'v1666750529/SnackWise/User/nzfnaihagbhzgaumbs7q', 0, 'verified', '0', '0000-00-00 00:00:00', 'staff'),
(12, 'sheldon', 'sheldon', '', 'sheldon@gmail.com', '09999999999', 'none', '', 'none', 'none', 'none', '', 'v1666750529/SnackWise/User/nzfnaihagbhzgaumbs7q', 0, 'verified', '0', '0000-00-00 00:00:00', 'staff'),
(15, 'sheldon', 'sheldon', '', 'sheldon@gmail.com', '09999999999', 'none', '', 'none', 'none', 'none', '', 'v1666750529/SnackWise/User/nzfnaihagbhzgaumbs7q', 0, 'unverified', 'Jw%$Hwn9CIAv2WxQ', '0000-00-00 00:00:00', 'staff'),
(16, 'sheldon', 'sheldon', '', 'sheldon@gmail.com', '09999999999', 'none', '', 'none', 'none', 'none', '', 'v1666750529/SnackWise/User/nzfnaihagbhzgaumbs7q', 0, 'unverified', 'pvBdFsS7xaOE6fo%', '0000-00-00 00:00:00', 'staff'),
(17, 'sheldon', 'sheldon', '', 'sheldon@gmail.com', '09999999999', 'none', '', 'none', 'none', 'none', '', 'v1666750529/SnackWise/User/nzfnaihagbhzgaumbs7q', 0, 'unverified', '9Wey0nBLNkzlGfJ4', '0000-00-00 00:00:00', 'staff'),
(18, 'sheldon', 'sheldon', '', 'sheldon@gmail.com', '09999999999', 'none', '', 'none', 'none', 'none', '', 'v1666750529/SnackWise/User/nzfnaihagbhzgaumbs7q', 0, 'unverified', 'r8W4sSqbXJFRBAzA', '0000-00-00 00:00:00', 'staff'),
(20, 'sheldon', 'sheldon', '', 'sheldon@gmail.com', '09999999999', 'none', '', 'none', 'none', 'none', '', 'v1666750529/SnackWise/User/nzfnaihagbhzgaumbs7q', 0, 'unverified', 'xMYYxOIVf$eS9O0V', '0000-00-00 00:00:00', 'staff'),
(21, 'sheldon', 'sheldon', '', 'sheldon@gmail.com', '09999999999', 'none', '', 'none', 'none', 'none', '', 'v1666750529/SnackWise/User/nzfnaihagbhzgaumbs7q', 0, 'unverified', 'vL7OoV1MJc$R$yrq', '0000-00-00 00:00:00', 'user'),
(22, 'sheldon', 'sheldon', '', 'sheldon@gmail.com', '09999999999', 'none', '', 'none', 'none', 'none', '', 'v1666750529/SnackWise/User/nzfnaihagbhzgaumbs7q', 0, 'unverified', 'pNz4SueFrbDiu4F1', '0000-00-00 00:00:00', 'user'),
(23, 'sheldon', 'sheldon', '', 'sheldon@gmail.com', '09999999999', 'none', '', 'none', 'none', 'none', '', 'v1666750529/SnackWise/User/nzfnaihagbhzgaumbs7q', 0, 'unverified', 'wRJ3NURwOCMGnphM', '0000-00-00 00:00:00', 'user'),
(24, 'sheldon', 'sheldon', '', 'sheldon@gmail.com', '09999999999', 'none', '', 'none', 'none', 'none', '', 'v1666750529/SnackWise/User/nzfnaihagbhzgaumbs7q', 0, 'unverified', 'bBVxCt67v5Y9h0Ga', '0000-00-00 00:00:00', 'staff'),
(25, 'sheldon', 'sheldon', '', 'sheldon@gmail.com', '09999999999', 'none', '', 'none', 'none', 'none', '', 'v1666750529/SnackWise/User/nzfnaihagbhzgaumbs7q', 0, 'unverified', 'tamuV3aWxofsD2qb', '0000-00-00 00:00:00', 'staff'),
(26, 'sheldon', 'sheldon', '', 'sheldon@gmail.com', '09999999999', 'none', '', 'none', 'none', 'none', '', 'v1666750529/SnackWise/User/nzfnaihagbhzgaumbs7q', 0, 'unverified', '663omXBQCxoWMPm0', '0000-00-00 00:00:00', 'staff'),
(27, 'sheldon', 'sheldon', '', 'sheldon@gmail.com', '09999999999', 'none', '', 'none', 'none', 'none', '', 'v1666750529/SnackWise/User/nzfnaihagbhzgaumbs7q', 0, 'verified', '0', '0000-00-00 00:00:00', 'staff'),
(28, 'sheldon', 'sheldon', '', 'sheldon@gmail.com', '09999999999', 'none', '', 'none', 'none', 'none', '', 'v1666750529/SnackWise/User/nzfnaihagbhzgaumbs7q', 0, 'unverified', '4487AGoWucmL3Py1', '0000-00-00 00:00:00', 'staff'),
(29, 'sheldon', 'sheldon', 'sheldon', 'sheldon@gmail.com', '09999999999', 'none', '', 'none', 'none', 'none', '', 'v1666750529/SnackWise/User/nzfnaihagbhzgaumbs7q', 0, 'unverified', '1gJb73xlprPACOZF', '0000-00-00 00:00:00', 'staff'),
(30, 'sheldon', 'sheldon', '', 'sheldon@gmail.com', '09999999999', 'none', '', 'none', 'none', 'none', '', 'v1666750529/SnackWise/User/nzfnaihagbhzgaumbs7q', 0, 'unverified', 'iqpQr80ygBLxfh5K', '0000-00-00 00:00:00', 'staff'),
(31, '', '', '', '', '', 'none', '', 'none', 'none', 'none', '', '', 0, 'unverified', 'WvPCe6aztXT7lCbz', '0000-00-00 00:00:00', 'user'),
(32, '', '', '', '', '', 'none', '', 'none', 'none', 'none', '', '', 0, 'unverified', 'AeA7O9Hyp59za9wm', '0000-00-00 00:00:00', 'user'),
(33, '', '', '', '', '', 'none', '', 'none', 'none', 'none', '', '', 0, 'unverified', 'Y0$SfluqYKm4$0ds', '0000-00-00 00:00:00', 'user'),
(34, '', '', '', '', '', 'none', 'd', 'none', 'none', 'none', '', '', 0, 'unverified', '1nNoyu01jEkfML9Z', '0000-00-00 00:00:00', 'user'),
(35, '', '', '', '', '', 'none', 'd', 'none', 'none', 'none', '', '', 0, 'unverified', 'XlLyKnyuPyBHqp6i', '0000-00-00 00:00:00', 'user'),
(36, '', '', '', '', '', 'none', 'fdgdf5646', 'none', 'none', 'none', '', '', 0, 'unverified', 'v6ltxIUN7B0$i%nW', '0000-00-00 00:00:00', 'user'),
(37, '', '', '', '', '', 'none', 'ddd', 'none', 'none', 'none', '', '', 0, 'unverified', 'QYCKvQjeIcD7nCH0', '0000-00-00 00:00:00', 'user'),
(38, '', '', '', '', '', 'none', 'd', 'none', 'none', 'none', '', '', 0, 'unverified', 'JgOSP%eHKU0J3m24', '0000-00-00 00:00:00', 'user'),
(39, '', '', '', '', '', 'none', 'd', 'none', 'none', 'none', '', '', 0, 'unverified', 'nD9cm5ZhAkIMZSJi', '0000-00-00 00:00:00', 'user'),
(40, '', '', '', '', '', '', '', 'none', 'none', 'none', '', '', 0, 'unverified', 'qQhHzlLgL3qDYM7t', '0000-00-00 00:00:00', 'staff'),
(41, '', '', '', '', '', '', '', 'none', 'none', 'none', '', '', 0, 'unverified', '8LbPfFiI1EmUD4ad', '0000-00-00 00:00:00', 'staff'),
(42, '', '', '', '', '', '', 'd', 'none', 'none', 'none', '', '', 0, 'unverified', 'P$IKSx$trp2eE8QR', '0000-00-00 00:00:00', 'staff'),
(43, '', '', '', '', '', 'none', 'dsdf545DSD34', 'none', 'none', 'none', '', '', 0, 'unverified', 'GCk$yMIAPRRLupPD', '0000-00-00 00:00:00', 'user'),
(44, '', '', '', '', '', 'none', 'd', 'none', 'none', 'none', '', '', 0, 'unverified', '78BxV%F9ER0W2Ota', '0000-00-00 00:00:00', 'user'),
(45, '', '', '', '', '', 'none', 'dsad', 'none', 'none', 'none', '', '', 0, 'unverified', 't8lW7JRKc8TSA3ek', '0000-00-00 00:00:00', 'user'),
(46, '', '', '', '', '', 'none', 'd', 'none', 'none', 'none', '', '', 0, 'unverified', '68C%FoanLOeQuKxO', '0000-00-00 00:00:00', 'user'),
(47, '', '', '', '', '', 'none', 'd', 'none', 'none', 'none', '', '', 0, 'unverified', 'DVHVlU47s4BRryWu', '0000-00-00 00:00:00', 'user'),
(48, '', '', '', '', '', 'none', 'ddd', 'none', 'none', 'none', '', '', 0, 'unverified', 'pM2qZm$pZsvTqM1D', '0000-00-00 00:00:00', 'user'),
(49, '', '', '', '', '', 'none', 'dd', 'none', 'none', 'none', '', '', 0, 'unverified', 'RrxttJ$9YMrBsYwD', '0000-00-00 00:00:00', 'user'),
(50, '', '', '', '', '', 'none', 'ff', 'none', 'none', 'none', '', '', 0, 'unverified', 'cAns017FXpulewZW', '0000-00-00 00:00:00', 'user'),
(51, '', '', '', '', '', 'none', 'd', 'none', 'none', 'none', '', '', 0, 'unverified', 'rlwI3xt6UdvM2%0c', '0000-00-00 00:00:00', 'user'),
(52, '', '', '', '', '', 'none', 'dasdasda', 'none', 'none', 'none', '', '', 0, 'unverified', 'L6HnxyiRa2dkmxc2', '0000-00-00 00:00:00', 'user'),
(53, '', '', '', '', '', 'none', 'ddd', 'none', 'none', 'none', '', '', 0, 'unverified', 'ZPJLstsY5hfDuqaz', '0000-00-00 00:00:00', 'user'),
(54, '', '', '', '', '', 'none', 's', 'none', 'none', 'none', '', '', 0, 'unverified', 'E4nV1OasrU4h0zoC', '0000-00-00 00:00:00', 'user'),
(55, '', '', '', '', '', 'none', 'ffff', 'none', 'none', 'none', '', '', 0, 'unverified', 'C$c13asCegdKUMnx', '0000-00-00 00:00:00', 'user'),
(56, '', '', '', '', '', 'none', 'ddd', 'none', 'none', 'none', '', '', 0, 'unverified', 'q182m2T$t2HhWFdg', '0000-00-00 00:00:00', 'user'),
(57, '', '', '', '', '', 'none', 'd', 'none', 'none', 'none', '', '', 0, 'unverified', 'CBljvvXGkM90aQBg', '0000-00-00 00:00:00', 'user'),
(58, '', '', '', '', '', 'none', 'dd', 'none', 'none', 'none', '', '', 0, 'unverified', 'TPEbENKYQXqce1Pq', '0000-00-00 00:00:00', 'user'),
(59, '', '', '', '', '', 'none', 'dsd', 'none', 'none', 'none', '', '', 0, 'unverified', 'vrebTwj5f64gWxJh', '0000-00-00 00:00:00', 'user'),
(60, '', '', '', '', 's', 'none', 's', 'none', 'none', 'none', '', '', 0, 'unverified', 'cVqlw44jZChBH2SW', '0000-00-00 00:00:00', 'user'),
(61, '', '', '', '', '', 'none', 'ddsdad', 'none', 'none', 'none', '', '', 0, 'unverified', 'KGGFoilqDrcMHTs1', '0000-00-00 00:00:00', 'user'),
(62, '', '', '', '', '', 'none', 'ddsdad45345FDF%', 'none', 'none', 'none', '', '', 0, 'unverified', 'ILm8dz7egw0PJlbG', '0000-00-00 00:00:00', 'user'),
(63, '', '', '', '', '', 'none', 'fF5%ffffff', 'none', 'none', 'none', '', '', 0, 'unverified', '1cQgdntzWwbf8FLu', '0000-00-00 00:00:00', 'user'),
(64, '', '', '', '', '', 'none', 'dsds', 'none', 'none', 'none', '', '', 0, 'unverified', '7LJvNPPHmF4hM29I', '0000-00-00 00:00:00', 'user'),
(65, '', '', '', '', '', 'none', 'fdsfFDFGGgg565%', 'none', 'none', 'none', '', '', 0, 'unverified', 'vfGCqpTlIdcVWURx', '0000-00-00 00:00:00', 'user'),
(66, '', '', '', '', '', 'none', 'rtrt', 'none', 'none', 'none', '', '', 0, 'unverified', '8BpxHHP$Wb8ct5cw', '0000-00-00 00:00:00', 'user'),
(67, '', '', '', '', '', 'none', 'Ddd34$jjddfdfddsd', 'none', 'none', 'none', '', '', 0, 'unverified', 'SgJJpOj12MHhRMSX', '0000-00-00 00:00:00', 'user'),
(68, '', '', '', '', '', 'none', 'fdfd', 'none', 'none', 'none', '', '', 0, 'unverified', 'L6P9muzxBszh%E4e', '0000-00-00 00:00:00', 'user'),
(69, '', '', '', '', '', 'none', 'ddd', 'none', 'none', 'none', '', '', 0, 'unverified', 'DP8IXJxkhlHF7YYo', '0000-00-00 00:00:00', 'user'),
(70, '', '', '', '', '', 'none', 'ss', 'none', 'none', 'none', '', '', 0, 'unverified', 'QTfNpJx%ijXFeQbR', '0000-00-00 00:00:00', 'user'),
(71, '', '', '', '', '', 'none', 'd', 'none', 'none', 'none', '', '', 0, 'unverified', 'AVzS2aC3xE2tQK$x', '0000-00-00 00:00:00', 'user'),
(72, '', '', '', '', '', 'none', 'rrrrr', 'none', 'none', 'none', '', '', 0, 'unverified', 'GCDwerx46$uXzb%e', '0000-00-00 00:00:00', 'user'),
(73, '', '', '', '', '', 'none', 'erwe', 'none', 'none', 'none', '', '', 0, 'unverified', 'G3WcMKBW9UEY3EjR', '0000-00-00 00:00:00', 'user'),
(74, '', '', '', '', '', 'none', '67567567', 'none', 'none', 'none', '', '', 0, 'unverified', 'ti6HzsHJB7%XIa7G', '0000-00-00 00:00:00', 'user'),
(75, '', '', '', '', '', 'none', 'g', 'none', 'none', 'none', '', '', 0, 'unverified', 'ss4N1cq5aZoV0FdJ', '0000-00-00 00:00:00', 'user'),
(76, '', '', '', '', '', 'none', '', 'none', 'none', 'none', '', '', 0, 'unverified', 'lo6kNT9q1yFJazPf', '0000-00-00 00:00:00', 'user'),
(77, '', '', '', '', '', 'none', '', 'none', 'none', 'none', '', '', 0, 'unverified', 'yEZim$kQSI$I1C28', '0000-00-00 00:00:00', 'user'),
(78, '', '', '', '', '', 'none', '', 'none', 'none', 'none', '', '', 0, 'unverified', '', '2022-11-02 11:46:00', 'user'),
(79, '', '', '', '', '', '', '', 'none', 'none', 'none', '', '', 0, 'unverified', 'tIBqDAelcnIAHn8E', '0000-00-00 00:00:00', 'staff'),
(80, '', '', '', '', '', 'none', '$2y$10$5x8KDL1Dsg6CnBGj7UVCl.IyH1c4R7TZJTqMLijcSjEIttYRFgFTq', 'none', 'none', 'none', '', '', 0, 'unverified', '', '2022-11-10 09:39:15', 'customer'),
(81, '', '', '', '', '', 'none', '$2y$10$SgsR1b7XcFhMhtskhKfkPeiw.iBQJNMzp5av3hh36dX6r..KyjWwO', 'none', 'none', 'none', '', '', 0, 'unverified', '', '2022-11-10 09:41:33', 'customer'),
(82, '', '', '', '', '', 'none', '$2y$10$2Ef1iLFApcbu3Bna2TKV3./n3MEYkibFzpUrp1t4/nzA8faV4l58C', 'none', 'none', 'none', '', '', 0, 'unverified', '', '2022-11-10 09:42:34', 'customer'),
(83, '', '', '', '', '', 'none', '$2y$10$SIirjeyxTzrftBZ0bnUIJukOyb8LHt76lkKdj0Ook1K1Djh1K92zm', 'none', 'none', 'none', '', '', 0, 'unverified', '', '2022-11-10 09:42:44', 'customer'),
(84, '', '', '', '', '', 'none', '$2y$10$Ar7SWjqMwPftNRB/zs1cZ.FjVYn./oGr4lSTwD.g3J9BSLDtf09z2', 'none', 'none', 'none', '', '', 0, 'verified', '', '2022-11-10 09:46:24', 'customer'),
(85, '', '', '', '', '', 'none', '$2y$10$kpCNCxdFtg8ffsMlbk2VWeZrOUSyUh.KoQEKZXqIksDr7nXrWJuYK', 'none', 'none', 'none', '', '', 0, 'unverified', '', '2022-11-10 09:50:15', 'customer'),
(86, '', '', '', '', '', 'none', '$2y$10$T32lpReTjsNhTTvrDeLtWuP/J9isii/MiKbZIJ0mnWPAT0hFN8mBC', 'none', 'none', 'none', '', '', 0, 'unverified', '', '2022-11-10 09:54:28', 'customer'),
(87, '', '', '', '', '', 'none', '$2y$10$E8.BtA4FJYx/03AmhJS97OxHTRISxoM8QhVIExVbTlmnWmBBkkwgO', 'none', 'none', 'none', '', '', 0, 'unverified', '', '2022-11-10 10:01:35', 'customer'),
(88, '', '', '', '', '', 'none', '$2y$10$Ke3iYaYLhoxg1rCeu13SLeG1xEMXa5uKPoWVUUb0.rYYKt48WXIwu', 'none', 'none', 'none', '', '', 0, 'unverified', '', '2022-11-10 11:18:34', 'customer'),
(89, '', '', '', '', '', '', '', 'none', 'none', 'none', '', '', 0, 'unverified', 'hVfAEA8XpdyRzQvT', '0000-00-00 00:00:00', 'staff'),
(90, '', '', '', '', '', 'none', '', 'none', 'none', 'none', '', '', 0, 'unverified', '', '2022-11-10 19:31:00', 'user'),
(91, 'd', 'd', 'darwan', 'darwan@email.com', '09999999998', 'Region XI (Davao Region)', '$2y$10$cLua2x835A.huhwTPRO/teVxjZZ/KrMHZF6tEDLBJBgZsw0B5iZbi', 'Compostela Valley', 'Monkayo', 'Salvacion', '5', '', 0, 'unverified', '', '2022-11-11 05:39:26', 'customer');

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
-- Indexes for table `holiday`
--
ALTER TABLE `holiday`
  ADD PRIMARY KEY (`holiday_id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menu_id`);

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
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `holiday`
--
ALTER TABLE `holiday`
  MODIFY `holiday_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `orderlist`
--
ALTER TABLE `orderlist`
  MODIFY `orderlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
