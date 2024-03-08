-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 05, 2023 at 05:44 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbprog`
--

-- --------------------------------------------------------

--
-- Table structure for table `combos`
--

CREATE TABLE `combos` (
  `comboID` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `mainCode` int(11) NOT NULL,
  `sideCode` int(11) NOT NULL,
  `drinkCode` int(11) NOT NULL,
  `comboPrice` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `combos`
--

INSERT INTO `combos` (`comboID`, `name`, `mainCode`, `sideCode`, `drinkCode`, `comboPrice`) VALUES
(1, 'Chicken Mash Tea', 3, 5, 7, 387),
(2, 'Steak Veg Beer Combo', 1, 6, 8, 909),
(3, 'Steak It!', 1, 4, 8, 936),
(4, 'Finding Nemo', 2, 6, 9, 828);

-- --------------------------------------------------------

--
-- Table structure for table `food`
--

CREATE TABLE `food` (
  `foodCode` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `category` enum('M','S','D') NOT NULL,
  `price` double NOT NULL,
  `imageID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food`
--

INSERT INTO `food` (`foodCode`, `name`, `category`, `price`, `imageID`) VALUES
(1, 'Steak', 'M', 900, 1),
(2, 'Salmon', 'M', 850, 2),
(3, 'Chicken', 'M', 300, 3),
(4, 'Baked Potato', 'S', 80, 4),
(5, 'Mashed Potato', 'S', 75, 5),
(6, 'Steamed Vegetables', 'S', 50, 6),
(7, 'Ice Tea', 'D', 55, 7),
(8, 'Root Beer', 'D', 60, 8),
(9, 'Water', 'D', 20, 9);

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `imageID` int(11) NOT NULL,
  `originalName` varchar(60) NOT NULL,
  `mime_type` varchar(40) NOT NULL,
  `image_data` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`imageID`, `originalName`, `mime_type`, `image_data`) VALUES
(1, 'm1.png', 'image/png', 'assets/image1.png'),
(2, 'm2.png', 'image/png', 'assets/image2.png'),
(3, 'm3.png', 'image/png', 'assets/image3.png'),
(4, 's1.png', 'image/png', 'assets/image4.png'),
(5, 's2.png', 'image/png', 'assets/image5.png'),
(6, 's3.png', 'image/png', 'assets/image6.png'),
(7, 'd1.png', 'image/png', 'assets/image7.png'),
(8, 'd2.png', 'image/png', 'assets/image8.png'),
(9, 'd3.png', 'image/png', 'assets/image9.png');

-- --------------------------------------------------------

--
-- Table structure for table `receipts`
--

CREATE TABLE `receipts` (
  `receiptID` int(11) NOT NULL,
  `mainCode` int(11) DEFAULT NULL,
  `sideCode` int(11) DEFAULT NULL,
  `drinkCode` int(11) DEFAULT NULL,
  `m1` int(11) DEFAULT NULL,
  `s1` int(11) DEFAULT NULL,
  `d1` int(11) DEFAULT NULL,
  `originalPrice` double NOT NULL,
  `comboID` int(11) DEFAULT NULL,
  `discountPrice` double DEFAULT NULL,
  `totalPrice` double NOT NULL,
  `date` datetime NOT NULL,
  `name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `receipts`
--

INSERT INTO `receipts` (`receiptID`, `mainCode`, `sideCode`, `drinkCode`, `m1`, `s1`, `d1`, `originalPrice`, `comboID`, `discountPrice`, `totalPrice`, `date`, `name`) VALUES
(1, 1, 4, 7, 1, 1, 1, 1035, NULL, NULL, 1035, '2023-08-03 08:30:32', 'cj'),
(18, 3, 5, 7, 2, 2, 3, 915, 1, 86, 829, '2023-08-05 14:19:33', 'min8');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `user` varchar(40) NOT NULL,
  `pass` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `name`, `user`, `pass`) VALUES
(1, 'Ceejay Pascasio', 'ceejay', 'pascasio'),
(2, 'admin', 'admin', 'admin'),
(3, 'minette', 'minette', 'minette'),
(4, 'shannyne', 'shannyne', 'shannyne'),
(5, 'peejay', 'peejay', 'peejay');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `combos`
--
ALTER TABLE `combos`
  ADD PRIMARY KEY (`comboID`);

--
-- Indexes for table `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`foodCode`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`imageID`);

--
-- Indexes for table `receipts`
--
ALTER TABLE `receipts`
  ADD PRIMARY KEY (`receiptID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `combos`
--
ALTER TABLE `combos`
  MODIFY `comboID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `food`
--
ALTER TABLE `food`
  MODIFY `foodCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `imageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `receipts`
--
ALTER TABLE `receipts`
  MODIFY `receiptID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
