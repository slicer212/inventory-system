-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 10, 2024 at 12:51 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `borrow_requests`
--

CREATE TABLE `borrow_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `added_date` date NOT NULL,
  `request_date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Accepted','Rejected') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrow_requests`
--


-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `parent_cat` int(11) DEFAULT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `parent_cat`, `category_name`) VALUES
(103, 0, 'Binis'),
(104, 0, 'One Piece'),
(105, 0, 'Car');

-- --------------------------------------------------------

--
-- Table structure for table `currently_borrowed_items`
--


-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `pid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_stock` int(11) NOT NULL,
  `added_date` date NOT NULL,
  `i_status` enum('1','0') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`pid`, `cid`, `item_name`, `item_stock`, `added_date`, `i_status`) VALUES
(36, 103, 'Gwen', 12, '2024-09-04', '1'),
(39, 103, 'Aiah', 1, '2024-09-05', '1'),
(41, 105, 'Toyota', 100, '2024-09-09', '1'),
(42, 105, 'Raptor', 1, '2024-09-09', '1');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `usertype` enum('Admin','Faculty') NOT NULL,
  `register_date` date NOT NULL,
  `last_login` date NOT NULL,
  `notes` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `usertype`, `register_date`, `last_login`, `notes`) VALUES
(1, 'John Carlo Bautista', 'johnbautista1261@gmail.com', '$2y$08$95roMl4sbfDyTz1X7iJDpeud60ssICIyNfT1tjJUSpgePh5wPMxiO', 'Admin', '2024-08-21', '2024-09-10', ''),
(2, 'JC', 'johnbautista121@gmail.com', '$2y$08$I.sXOkJAksSlAjchnM7D6OELY3VMiwkzr0pn15XYTOC2CwI.FoqFC', 'Admin', '2024-08-21', '2024-08-21', ''),
(3, 'Sedrick', 'sedrick@gmail.com', '$2y$08$4I48tcRtFVwOvGLgpDe8tOWx2y.lWrfnjX1bNJ5qL8B7k.BjH/UsC', '', '2024-09-03', '2024-09-03', ''),
(4, 'Xander', 'xander@gmail.com', '$2y$08$.1vd5Oag.DDHt5J146gVdukSpp4W3O4Xij2ksqwTt9caWsF5qzKSu', 'Faculty', '2024-09-03', '2024-09-03', ''),
(5, 'Anghelo', 'anghelo@gmail.com', '$2y$08$VKMUyLQcSen4AZAg2SknROp/BynoN3HAs8TuzNxZv5CkXD0Sr0FiS', 'Faculty', '2024-09-03', '2024-09-03', ''),
(6, 'Kenneth', 'kenneth@gmail.com', '$2y$08$qpNTESpi7E3MTLNEz/yWpOoUJzs4vTfMXRhR6aj2Qz1Trx9rOcIWK', 'Faculty', '2024-09-03', '2024-09-10', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `borrow_requests`
--
ALTER TABLE `borrow_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `currently_borrowed_items`
--

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`pid`),
  ADD UNIQUE KEY `item_name` (`item_name`),
  ADD KEY `cid` (`cid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `borrow_requests`
--
ALTER TABLE `borrow_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `currently_borrowed_items`
--

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrow_requests`
--
ALTER TABLE `borrow_requests`
  ADD CONSTRAINT `borrow_requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `currently_borrowed_items`
--

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
