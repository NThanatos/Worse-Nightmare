-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 27, 2015 at 04:28 PM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gamernationdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `buyer`
--

CREATE TABLE IF NOT EXISTS `buyer` (
  `UserID` varchar(255) NOT NULL DEFAULT '',
  `Total_Expenditure` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE IF NOT EXISTS `game` (
  `GameID` int(11) NOT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `Publisher` varchar(255) DEFAULT NULL,
  `Year_Released` int(11) DEFAULT NULL,
  `Platform` varchar(255) DEFAULT NULL,
  `Region` varchar(255) DEFAULT NULL,
  `Price` float DEFAULT NULL,
  `imagePath` varchar(500) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `game`
--

INSERT INTO `game` (`GameID`, `Title`, `Publisher`, `Year_Released`, `Platform`, `Region`, `Price`, `imagePath`) VALUES
(1, 'Diablo 3', 'Blizzard', 2015, 'PC', 'Asia', 100, 'Picture/diablo_3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `imagetype`
--

CREATE TABLE IF NOT EXISTS `imagetype` (
  `typeID` int(11) NOT NULL,
  `typeName` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `imagetype`
--

INSERT INTO `imagetype` (`typeID`, `typeName`) VALUES
(0, 'PUBLIC'),
(1, 'PRIVATE');

-- --------------------------------------------------------

--
-- Table structure for table `ordered_product`
--

CREATE TABLE IF NOT EXISTS `ordered_product` (
  `Supplier_UserID` varchar(255) NOT NULL DEFAULT '',
  `GameID` int(11) NOT NULL,
  `OrderID` varchar(255) NOT NULL DEFAULT '',
  `Buyer_UserID` varchar(255) NOT NULL DEFAULT '',
  `Quantity` int(11) DEFAULT NULL,
  `Price` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order_make`
--

CREATE TABLE IF NOT EXISTS `order_make` (
  `OrderID` varchar(255) NOT NULL,
  `Buyer_UserID` varchar(255) DEFAULT NULL,
  `Purchare_Time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `review_have`
--

CREATE TABLE IF NOT EXISTS `review_have` (
  `GameID` int(11) NOT NULL,
  `UserID` varchar(255) NOT NULL DEFAULT '',
  `Rating` float DEFAULT NULL,
  `Comment` varchar(255) DEFAULT NULL,
  `TimeStamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE IF NOT EXISTS `supplier` (
  `UserID` varchar(255) NOT NULL DEFAULT '',
  `Total_Sales` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `supplier_own_game`
--

CREATE TABLE IF NOT EXISTS `supplier_own_game` (
  `Supplier_UserID` varchar(255) NOT NULL DEFAULT '',
  `GameID` int(11) NOT NULL,
  `Stock` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `UserID` varchar(255) NOT NULL,
  `Hashed_Password` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Salt` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `Hashed_Password`, `Email`, `Salt`) VALUES
('necrodiverTesting', 'a3c69166757134256ac5b9ea63bc9900fe80698f283e122db12327b86402852a', 'darkdanito@hotmail.com', '25cbdda0f4273d4a3a683522');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buyer`
--
ALTER TABLE `buyer`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`GameID`),
  ADD UNIQUE KEY `GameID` (`GameID`);

--
-- Indexes for table `imagetype`
--
ALTER TABLE `imagetype`
  ADD PRIMARY KEY (`typeID`);

--
-- Indexes for table `ordered_product`
--
ALTER TABLE `ordered_product`
  ADD PRIMARY KEY (`Supplier_UserID`,`GameID`,`OrderID`,`Buyer_UserID`),
  ADD KEY `OrderID` (`OrderID`),
  ADD KEY `Buyer_UserID` (`Buyer_UserID`);

--
-- Indexes for table `order_make`
--
ALTER TABLE `order_make`
  ADD PRIMARY KEY (`OrderID`),
  ADD UNIQUE KEY `OrderID` (`OrderID`),
  ADD KEY `Buyer_UserID` (`Buyer_UserID`);

--
-- Indexes for table `review_have`
--
ALTER TABLE `review_have`
  ADD PRIMARY KEY (`GameID`,`UserID`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `supplier_own_game`
--
ALTER TABLE `supplier_own_game`
  ADD PRIMARY KEY (`Supplier_UserID`,`GameID`),
  ADD KEY `GameID` (`GameID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `UserID` (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `game`
--
ALTER TABLE `game`
  MODIFY `GameID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `buyer`
--
ALTER TABLE `buyer`
  ADD CONSTRAINT `buyer_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);

--
-- Constraints for table `ordered_product`
--
ALTER TABLE `ordered_product`
  ADD CONSTRAINT `ordered_product_ibfk_1` FOREIGN KEY (`Supplier_UserID`, `GameID`) REFERENCES `supplier_own_game` (`Supplier_UserID`, `GameID`);

--
-- Constraints for table `order_make`
--
ALTER TABLE `order_make`
  ADD CONSTRAINT `order_make_ibfk_1` FOREIGN KEY (`Buyer_UserID`) REFERENCES `buyer` (`UserID`) ON DELETE NO ACTION;

--
-- Constraints for table `review_have`
--
ALTER TABLE `review_have`
  ADD CONSTRAINT `review_have_ibfk_1` FOREIGN KEY (`GameID`) REFERENCES `game` (`GameID`) ON DELETE CASCADE;

--
-- Constraints for table `supplier`
--
ALTER TABLE `supplier`
  ADD CONSTRAINT `supplier_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);

--
-- Constraints for table `supplier_own_game`
--
ALTER TABLE `supplier_own_game`
  ADD CONSTRAINT `supplier_own_game_ibfk_1` FOREIGN KEY (`Supplier_UserID`) REFERENCES `supplier` (`UserID`),
  ADD CONSTRAINT `supplier_own_game_ibfk_2` FOREIGN KEY (`GameID`) REFERENCES `game` (`GameID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
