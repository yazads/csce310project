-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2022 at 01:23 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `petsitting`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `appointmentID` int(11) NOT NULL,
  `petOwner` int(11) DEFAULT NULL,
  `petSitter` int(11) DEFAULT NULL,
  `startTime` datetime DEFAULT NULL,
  `duration` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`appointmentID`, `petOwner`, `petSitter`, `startTime`, `duration`) VALUES
(1, 1, 2, '2001-01-01 01:01:01', 1),
(2, 3, 4, '2002-02-02 02:02:02', 2),
(3, 5, 6, '2003-03-03 03:03:03', 3),
(4, 7, 8, '2004-04-04 04:04:04', 4),
(5, 9, 10, '2005-05-05 05:05:05', 5),
(6, 11, 12, '2006-06-06 06:06:06', 6),
(7, 13, 14, '2007-07-07 07:07:07', 7),
(8, 15, 16, '2008-08-08 08:08:08', 8),
(9, 17, 18, '2009-09-09 09:09:09', 9),
(10, 19, 20, '2010-10-10 10:10:10', 10),
(11, 21, 22, '2011-11-11 11:11:11', 11),
(12, 23, 2, '2012-12-12 12:12:12', 12),
(13, 1, 4, '2013-01-13 13:13:13', 13),
(14, 3, 6, '2014-02-14 14:14:14', 14),
(15, 5, 8, '2015-03-15 15:15:15', 15),
(16, 7, 10, '2016-04-16 16:16:16', 16),
(17, 9, 12, '2017-05-17 17:17:17', 17),
(18, 11, 14, '2018-06-18 18:18:18', 18),
(19, 13, 16, '2019-07-19 19:19:19', 19),
(20, 15, 18, '2020-08-20 20:20:20', 20),
(21, 17, 20, '2021-09-21 21:21:21', 21),
(22, 19, 22, '2022-10-22 22:22:22', 22),
(23, 21, 2, '2023-11-23 23:23:23', 23);

--
-- Triggers `appointment`
--
DELIMITER $$
CREATE TRIGGER `beforeDeleteAppointment` BEFORE DELETE ON `appointment` FOR EACH ROW BEGIN
        DELETE FROM review WHERE appointmentID = old.appointmentID;
        DELETE FROM petAppointment WHERE appointmentID = old.appointmentID;
    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `appointmentview`
-- (See below for the actual view)
--
CREATE TABLE `appointmentview` (
`ownerFName` mediumtext
,`ownerLName` mediumtext
,`ownerEmail` mediumtext
,`sitterFName` mediumtext
,`sitterLName` mediumtext
,`sitterEmail` mediumtext
,`startTime` datetime
,`duration` int(11)
,`appointmentID` int(11)
,`reviewText` mediumtext
);

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `personID` int(11) NOT NULL,
  `email` mediumtext DEFAULT NULL,
  `passphrase` mediumtext DEFAULT NULL,
  `phone` int(11) DEFAULT NULL,
  `personFName` mediumtext DEFAULT NULL,
  `personLName` mediumtext DEFAULT NULL,
  `streetAddress` mediumtext DEFAULT NULL,
  `city` mediumtext DEFAULT NULL,
  `USState` mediumtext DEFAULT NULL,
  `zipCode` int(11) DEFAULT NULL,
  `personType` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`personID`, `email`, `passphrase`, `phone`, `personFName`, `personLName`, `streetAddress`, `city`, `USState`, `zipCode`, `personType`) VALUES
(1, 'test@1.com', 'pass1', 111111111, 'first', 'firstperson', '111 America Ave', 'Agusta', 'Alabama', 1111111, 1),
(2, 'test@2.com', 'pass2', 222222222, 'second', 'secondperson', '222 Austin Ave', 'Anchorage', 'Alaska', 2222222, 2),
(3, 'test@3.com', 'pass3', 333333333, 'third', 'thirdperson', '333 Atlanta Ave', 'Athens', 'Arizona', 3333333, 1),
(4, 'test@4.com', 'pass4', 444444444, 'fourth', 'fourthperson', '444 Alameda Ave', 'Annapolis', 'Arkansas', 4444444, 2),
(5, 'test@5.com', 'pass5', 555555555, 'fourth', 'fourthperson', '555 Chicago Ct', 'Cupertino', 'California', 5555555, 1),
(6, 'test@6.com', 'pass6', 666666666, 'sixth', 'sixthperson', '666 Cypress Ct', 'Colorado Springs', 'Colorado', 6666666, 2),
(7, 'test@7.com', 'pass7', 77777777, 'seventh', 'seventhperson', '777 Corpus Christi Ct', 'Chicopee', 'Connecticut', 7777777, 1),
(8, 'test@8.com', 'pass8', 888888888, 'eighth', 'eighthperson', '888 Dallas Dr', 'Dover', 'Delaware', 8888888, 2),
(9, 'test@9.com', 'pass9', 999999999, 'ninth', 'ninthperson', '999 Fort Worth Fld', 'Fort Myers', 'Florida', 9999999, 1),
(10, 'test@10.com', 'pass10', 101010101, 'tenth', 'tenthperson', '010 Gainesville Gdn', 'Grovetown', 'Georgia', 1010101, 2),
(11, 'test@11.com', 'pass11', 110110111, 'eleventh', 'eleventhperson', '011 Houston Hgts', 'Honolulu', 'Hawaii', 110110, 1),
(12, 'test@12.com', 'pass12', 121212121, 'twelfth', 'twelfthperson', '012 Independence Intl', 'Island Park', 'Idaho', 1212121, 2),
(13, 'test@13.com', 'pass13', 131313131, 'thirteenth', 'thirteenthperson', '013 Integrity Intl', 'Irving Park', 'Illinois', 1313131, 1),
(14, 'test@14.com', 'pass14', 141414141, 'fourteenth', 'fourteenthperson', '014 Ipswich Intl', 'Indianaplis', 'Indiana', 1414141, 2),
(15, 'test@15.com', 'pass15', 151515151, 'fifteenth', 'fifteenthperson', '015 Integrity Intl', 'Iowa City', 'Iowa', 1515151, 1),
(16, 'test@16.com', 'pass16', 161616161, 'sixteenth', 'sixteenthperson', '016 Jacksonville Jct', 'Kansas City', 'Kansas', 1616161, 2),
(17, 'test@17.com', 'pass17', 171717171, 'seventeenth', 'seventeenthperson', '017 Justice Jct', 'Kingsport', 'Kentucky', 1717171, 1),
(18, 'test@18.com', 'pass18', 181818181, 'eighteenth', 'eighteenthperson', '018 Lewisville Ln', 'Lafayette', 'Louisiana', 1818181, 2),
(19, 'test@19.com', 'pass19', 191919191, 'ninteenth', 'ninteenthperson', '019 Mountainview Mnr', 'Monson', 'Maine', 1919191, 1),
(20, 'test@20.com', 'pass20', 202020202, 'twentieth', 'twentiethperson', '020 Mahogany Mnr', 'Mt Airy', 'Maryland', 2020202, 2),
(21, 'test@21.com', 'pass21', 212121212, 'twentyfirst', 'twentyfirstperson', '021 Montgomery Mnr', 'Marlborough', 'Massachusetts', 2121212, 1),
(22, 'test@22.com', 'pass22', 220220220, 'twentysecond', 'twentysecondperson', '022 Madisonville Mnr', 'Marquette', 'Michigan', 2202202, 2),
(23, 'test@23.com', 'pass23', 232323232, 'twentythird', 'twentythirdperson', '023 Major Mnr', 'Marshfield', 'Missouri', 2323232, 1),
(24, 'test@24.com', 'pass24', 242424242, 'twentyfourth', 'twentyfourthperson', '024 Magnolia Mnr', 'Meridian', 'Mississippi', 2424242, 3);

--
-- Triggers `person`
--
DELIMITER $$
CREATE TRIGGER `beforeDeleteAccount` BEFORE DELETE ON `person` FOR EACH ROW BEGIN
        IF(old.personType = '1')
        -- case 1: the person being deleted is a pet owner
        THEN
            -- delete their reviews, pets, and appts
            DELETE FROM review WHERE personID = old.personID;
            DELETE FROM pet WHERE personID = old.personID;
            DELETE FROM appointment WHERE petOwner = old.personID;
        END IF;
        IF(old.personType = '2')
        -- case 2: the person being deleted is a pet sitter
        THEN
            -- update all the rows in appt with this pet sitter to be null
            UPDATE appointment SET petSitter = NULL WHERE petSitter = old.personID;
        END IF;
    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pet`
--

CREATE TABLE `pet` (
  `petID` int(11) NOT NULL,
  `personID` int(11) DEFAULT NULL,
  `petName` mediumtext DEFAULT NULL,
  `species` int(11) DEFAULT NULL,
  `requirements` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pet`
--

INSERT INTO `pet` (`petID`, `personID`, `petName`, `species`, `requirements`) VALUES
(1, 1, 'Amber', 1, 'loves to have her butt scratched'),
(2, 3, 'River', 1, 'only barks when she wants attention from a human'),
(3, 3, 'Storm', 1, 'barks at everything'),
(4, 5, 'Abby', 1, 'loves to balance a dog biscuit on her nose and wait for your permission to eat it'),
(5, 5, 'Rex', 1, 'probably has Downs Syndrome, is not capable of pacing himself'),
(6, 7, 'Opal', 1, 'actually chases her tail for fun'),
(7, 9, 'Stormie', 1, 'does not tolerate cold weather well'),
(8, 11, 'Gator', 1, 'not an alligator (but will bite you)'),
(9, 13, 'Firework', 3, 'likely to die in the next three months'),
(10, 15, 'Shadow', 1, 'worlds biggest dog'),
(11, 17, 'Casey', 1, 'definitely a water dog'),
(12, 19, 'Amus', 1, 'NOT sweet like Famous Amus cookies--approach with caution'),
(13, 21, 'Toby', 1, 'somehow coexists with Amus'),
(14, 21, 'Fatcat', 2, 'ellusive cat that is fat'),
(15, 23, 'Cisco', 2, 'sibling of cat whose name I forgot'),
(16, 23, 'Poncho', 2, 'I think the other cat was named poncho?'),
(17, 1, 'Madison', 1, 'worldest freakiest-looking dog'),
(18, 3, 'Lucky', 1, 'lives at the Stack'),
(19, 5, 'Jesse', 1, 'the dog belonging to Chase'),
(20, 7, 'Balu', 1, 'has some sort of skin condition'),
(21, 9, 'Doerre', 1, 'needs at least 10 acres of open space'),
(22, 11, 'Scoobert Doo', 1, 'also answers to Scooby-Doo, Scooby-Dooby-Doo, Scooby, and Scoob'),
(23, 13, 'George', 5, 'also responses to Curious George, often with the Man with the Yellow Hat');

--
-- Triggers `pet`
--
DELIMITER $$
CREATE TRIGGER `beforeDeletePet` BEFORE DELETE ON `pet` FOR EACH ROW DELETE FROM petAppointment WHERE petID = old.petID
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `petandowner`
-- (See below for the actual view)
--
CREATE TABLE `petandowner` (
`email` mediumtext
,`petName` mediumtext
,`species` int(11)
,`requirements` mediumtext
,`petID` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `petappointment`
--

CREATE TABLE `petappointment` (
  `petID` int(11) NOT NULL,
  `appointmentID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `petappointment`
--

INSERT INTO `petappointment` (`petID`, `appointmentID`) VALUES
(1, 1),
(2, 2),
(3, 2),
(4, 3),
(5, 3),
(6, 4),
(7, 5),
(8, 6),
(9, 7),
(10, 8),
(10, 20),
(11, 9),
(11, 21),
(12, 10),
(12, 22),
(13, 11),
(14, 23),
(15, 12),
(16, 12),
(17, 13),
(18, 14),
(19, 15),
(20, 16),
(21, 17),
(22, 18),
(23, 19);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `reviewID` int(11) NOT NULL,
  `personID` int(11) DEFAULT NULL,
  `appointmentID` int(11) DEFAULT NULL,
  `reviewText` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`reviewID`, `personID`, `appointmentID`, `reviewText`) VALUES
(1, 1, 1, 'review for appt 1 user 1'),
(2, 3, 2, 'review for appt 2 user 3'),
(3, 5, 3, 'review for appt 3 user 5'),
(4, 7, 4, 'review for appt 4 user 7'),
(5, 9, 5, 'review for appt 5 user 9'),
(6, 11, 6, 'review for appt 6 user 11'),
(7, 13, 7, 'review for appt 7 user 13'),
(8, 15, 8, 'review for appt 8 user 15'),
(9, 17, 9, 'review for appt 9 user 17'),
(10, 19, 10, 'review for appt 10 user 19'),
(11, 21, 11, 'review for appt 11 user 21'),
(12, 23, 12, 'review for appt 12 user 23'),
(13, 1, 13, 'review for appt 13 user 1'),
(14, 3, 14, 'review for appt 14 user 3'),
(15, 5, 15, 'review for appt 15 user 5'),
(16, 7, 16, 'review for appt 16 user 7'),
(17, 9, 17, 'review for appt 17 user 9'),
(18, 11, 18, 'review for appt 18 user 11'),
(19, 13, 19, 'review for appt 19 user 13'),
(20, 15, 20, 'review for appt 20 user 15'),
(21, 17, 21, 'review for appt 21 user 17'),
(22, 19, 22, 'review for appt 22 user 19'),
(23, 21, 23, 'review for appt 23 user 21');

-- --------------------------------------------------------

--
-- Structure for view `appointmentview`
--
DROP TABLE IF EXISTS `appointmentview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `appointmentview`  AS SELECT DISTINCT `person1`.`personFName` AS `ownerFName`, `person1`.`personLName` AS `ownerLName`, `person1`.`email` AS `ownerEmail`, `person2`.`personFName` AS `sitterFName`, `person2`.`personLName` AS `sitterLName`, `person2`.`email` AS `sitterEmail`, `appointment`.`startTime` AS `startTime`, `appointment`.`duration` AS `duration`, `appointment`.`appointmentID` AS `appointmentID`, `review`.`reviewText` AS `reviewText` FROM (((`appointment` join `person` `person1` on(`appointment`.`petOwner` = `person1`.`personID`)) left join `person` `person2` on(`appointment`.`petSitter` = `person2`.`personID`)) left join `review` on(`appointment`.`appointmentID` = `review`.`appointmentID`))  ;

-- --------------------------------------------------------

--
-- Structure for view `petandowner`
--
DROP TABLE IF EXISTS `petandowner`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `petandowner`  AS SELECT `person`.`email` AS `email`, `pet`.`petName` AS `petName`, `pet`.`species` AS `species`, `pet`.`requirements` AS `requirements`, `pet`.`petID` AS `petID` FROM (`pet` join `person` on(`pet`.`personID` = `person`.`personID`))  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`appointmentID`),
  ADD KEY `petOwner` (`petOwner`),
  ADD KEY `petSitter` (`petSitter`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`personID`),
  ADD KEY `personEmail` (`email`(768));

--
-- Indexes for table `pet`
--
ALTER TABLE `pet`
  ADD PRIMARY KEY (`petID`),
  ADD KEY `personID` (`personID`);

--
-- Indexes for table `petappointment`
--
ALTER TABLE `petappointment`
  ADD PRIMARY KEY (`petID`,`appointmentID`),
  ADD KEY `appointmentID` (`appointmentID`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`reviewID`),
  ADD KEY `personID` (`personID`),
  ADD KEY `appointmentID` (`appointmentID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `appointmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `personID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `pet`
--
ALTER TABLE `pet`
  MODIFY `petID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `reviewID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`petOwner`) REFERENCES `person` (`personID`),
  ADD CONSTRAINT `appointment_ibfk_2` FOREIGN KEY (`petSitter`) REFERENCES `person` (`personID`);

--
-- Constraints for table `pet`
--
ALTER TABLE `pet`
  ADD CONSTRAINT `pet_ibfk_1` FOREIGN KEY (`personID`) REFERENCES `person` (`personID`);

--
-- Constraints for table `petappointment`
--
ALTER TABLE `petappointment`
  ADD CONSTRAINT `petappointment_ibfk_1` FOREIGN KEY (`petID`) REFERENCES `pet` (`petID`),
  ADD CONSTRAINT `petappointment_ibfk_2` FOREIGN KEY (`appointmentID`) REFERENCES `appointment` (`appointmentID`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`personID`) REFERENCES `person` (`personID`),
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`appointmentID`) REFERENCES `appointment` (`appointmentID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
