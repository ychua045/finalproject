-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 07, 2023 at 03:51 PM
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
-- Database: `chuangu`
--

-- --------------------------------------------------------

--
-- Table structure for table `addonmeals`
--

CREATE TABLE `addonmeals` (
  `meal_id` int(10) UNSIGNED NOT NULL,
  `meal_name` char(50) DEFAULT NULL,
  `meal_price` float(4,2) DEFAULT NULL,
  `meal_image` char(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addonmeals`
--

INSERT INTO `addonmeals` (`meal_id`, `meal_name`, `meal_price`, `meal_image`) VALUES
(1, 'Hot Dog Combo', 14.00, 'hotdogcombo.png'),
(2, 'Popcorn Combo', 12.00, 'popcorncombo.png');

-- --------------------------------------------------------

--
-- Table structure for table `cardlist`
--

CREATE TABLE `cardlist` (
  `card_id` int(10) UNSIGNED NOT NULL,
  `card_number` char(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cardlist`
--

INSERT INTO `cardlist` (`card_id`, `card_number`) VALUES
(1, '1234567812345678');

-- --------------------------------------------------------

--
-- Table structure for table `cinemainfo`
--

CREATE TABLE `cinemainfo` (
  `cinema_id` int(10) UNSIGNED NOT NULL,
  `cinema_name` char(50) NOT NULL,
  `num_halls` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cinemainfo`
--

INSERT INTO `cinemainfo` (`cinema_id`, `cinema_name`, `num_halls`) VALUES
(1, 'Jem', 5),
(2, 'Suntec City', 5);

-- --------------------------------------------------------

--
-- Table structure for table `memberlist`
--

CREATE TABLE `memberlist` (
  `member_id` int(10) UNSIGNED NOT NULL,
  `member_name` char(25) DEFAULT NULL,
  `member_password` char(25) DEFAULT NULL,
  `member_email` char(255) DEFAULT NULL,
  `member_hp` char(20) DEFAULT NULL,
  `member_card` char(25) DEFAULT NULL,
  `register_date` char(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `memberlist`
--

INSERT INTO `memberlist` (`member_id`, `member_name`, `member_password`, `member_email`, `member_hp`, `member_card`, `register_date`) VALUES
(1, 'rheallyc', 'Gcy1018#', 'rheallyc@localhost', '85150357', '1234567812345678', '2022-10-01'),
(3, 'Rhea', 'Gcy20021018!', 'rhea@localhost', '85150358', '1234567812345678', '2023-11-01'),
(4, 'Rebecca', 'Gcy2002!', 'cgu002@localhost', '85150359', '1234567812345678', '2023-11-05');

-- --------------------------------------------------------

--
-- Table structure for table `moviecomment`
--

CREATE TABLE `moviecomment` (
  `comment_id` int(10) UNSIGNED NOT NULL,
  `movie_id` int(10) UNSIGNED NOT NULL,
  `commentor` char(20) DEFAULT NULL,
  `comment_content` char(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `movieinfo`
--

CREATE TABLE `movieinfo` (
  `movie_id` int(10) UNSIGNED NOT NULL,
  `movie_name` char(50) NOT NULL,
  `directors` char(50) DEFAULT NULL,
  `casts` char(100) DEFAULT NULL,
  `genre` char(100) DEFAULT NULL,
  `rating` float(3,1) DEFAULT NULL,
  `runtime` int(10) UNSIGNED DEFAULT NULL,
  `synopsis` char(250) DEFAULT NULL,
  `poster` char(50) DEFAULT NULL,
  `splash_poster` char(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movieinfo`
--

INSERT INTO `movieinfo` (`movie_id`, `movie_name`, `directors`, `casts`, `genre`, `rating`, `runtime`, `synopsis`, `poster`, `splash_poster`) VALUES
(1, 'Barbie', 'Greta Gerwig', 'Margot Robbie, Ryan Gosline, Issa Rae', 'Fantasy, Slice of life', 7.0, 114, 'Barbie suffers a crisis that leads her to question her world and her existence.', 'barbie.jpeg', 'barbie_s.jpeg'),
(2, 'Oppenheimer', 'Christopher Nolan', 'Cillian Murphy, Emily Blunt, Matt Damin', 'Action, Mystery', 8.5, 240, 'The story of American scientist, J. Robert Oppenheimer, and his role in the development of the atomic bomb.', 'Oppenheimer.jpg', 'Oppenheimer_s.jpeg'),
(3, 'The Burial', 'Maggie Betts', 'Jamie Foxx, Tommy Lee Jones, Jurnee Smollett', 'Law, Mystery', 7.1, 126, 'Inspired by true events, a lawyer helps a funeral home owner save his family business from a corporate behemoth, exposing a complex web of race, power, and injustice.', 'theburial.jpg', 'theburial_s.jpg'),
(4, 'Talk to Me', 'Danny Philippou, Michael Philippou', 'Ari McCarthy, Hamish Phillips, Kit Erhart-Bruce', 'Horror', 7.2, 95, 'When a group of friends discover how to conjure spirits using an embalmed hand, they become hooked on the new thrill, until one of them goes too far and unleashes terrifying supernatural forces.', 'talktome.jpeg', 'talktome_s.jpg'),
(5, 'Taylor Swift: The Eras Tour', 'Sam Wrench', 'Taylor Swift', 'Music', 8.4, 240, 'Experience the breathtaking Eras Tour concert, performed by the one and only Taylor Swift.', 'taylorswift.jpeg', 'taylorswift_s.jpeg'),
(6, 'Moscow Mission', 'Herman Yau', 'Hanyu Zhang, Andy Lau, Xuan Huang', 'Action, Crime, Drama', 6.1, 248, 'Tough Chinese detectives go on a mission to Moscow to hunt down ruthless robbers who have been plaguing the trans-Siberian railway with violence and chaos.', 'moscowmission.jpg', 'moscowmission_s.jpeg'),
(7, 'The Exorcist: Believer', 'David Gordon Green', 'Lafortune Joseph, Leslie Odom Jr., Gastner Legerme', 'Horror', 5.0, 111, 'When two girls disappear into the woods and return three days later with no memory of what happened to them, the father of one girl seeks out Chris MacNeil, who\'s been forever altered by what happened to her daughter fifty years ago.', 'theexorcist.png', 'theexorcist_s.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `orderaddon`
--

CREATE TABLE `orderaddon` (
  `order_id` int(10) UNSIGNED NOT NULL,
  `meal_name` char(50) DEFAULT NULL,
  `meal_price` float(4,2) DEFAULT NULL,
  `meal_quantity` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderaddon`
--

INSERT INTO `orderaddon` (`order_id`, `meal_name`, `meal_price`, `meal_quantity`) VALUES
(1, 'Popcorn Combo', 12.00, 1),
(2, 'Hot Dog Combo', 14.00, 2),
(2, 'Popcorn Combo', 12.00, 1),
(3, 'Popcorn Combo', 12.00, 2);

-- --------------------------------------------------------

--
-- Table structure for table `orderlist`
--

CREATE TABLE `orderlist` (
  `order_id` int(10) UNSIGNED NOT NULL,
  `order_dt` char(20) DEFAULT NULL,
  `account_id` int(10) UNSIGNED NOT NULL,
  `show_id` int(10) UNSIGNED NOT NULL,
  `num_tickets` int(10) UNSIGNED NOT NULL,
  `ticket_price` float(4,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderlist`
--

INSERT INTO `orderlist` (`order_id`, `order_dt`, `account_id`, `show_id`, `num_tickets`, `ticket_price`) VALUES
(1, '2023-11-07 11:37:11', 1, 1, 2, 14.00),
(2, '2023-11-07 11:43:38', 1, 2, 3, 14.00),
(3, '2023-11-07 14:10:02', 1, 2, 2, 14.00);

-- --------------------------------------------------------

--
-- Table structure for table `orderseat`
--

CREATE TABLE `orderseat` (
  `order_id` int(10) UNSIGNED NOT NULL,
  `seat_row` int(10) UNSIGNED NOT NULL,
  `seat_col` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderseat`
--

INSERT INTO `orderseat` (`order_id`, `seat_row`, `seat_col`) VALUES
(1, 2, 5),
(1, 2, 6),
(2, 2, 4),
(2, 2, 5),
(2, 2, 6),
(3, 3, 6),
(3, 3, 5);

-- --------------------------------------------------------

--
-- Table structure for table `showinfo`
--

CREATE TABLE `showinfo` (
  `show_id` int(10) UNSIGNED NOT NULL,
  `movie_id` int(10) UNSIGNED NOT NULL,
  `cinema_id` int(10) UNSIGNED NOT NULL,
  `hall_id` int(10) UNSIGNED NOT NULL,
  `show_date` char(20) NOT NULL,
  `show_time` char(20) NOT NULL,
  `ticket_price` float(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `showinfo`
--

INSERT INTO `showinfo` (`show_id`, `movie_id`, `cinema_id`, `hall_id`, `show_date`, `show_time`, `ticket_price`) VALUES
(1, 1, 1, 1, '2023-11-09', '13:30', 14.00),
(2, 2, 2, 2, '2023-11-10', '10:30', 14.00),
(3, 4, 2, 1, '2023-11-09', '15:00', 14.00),
(4, 3, 2, 1, '2023-11-08', '13:30', 14.00),
(5, 5, 1, 1, '2023-11-11', '13:30', 14.00),
(6, 6, 1, 2, '2023-11-09', '20:00', 14.00),
(7, 7, 1, 1, '2023-11-09', '17:00', 14.00),
(8, 1, 1, 1, '2023-11-09', '20:00', 12.00),
(9, 1, 1, 1, '2023-11-09', '16:00', 12.00),
(10, 1, 1, 1, '2023-11-10', '20:00', 12.00),
(11, 1, 2, 1, '2023-11-10', '20:00', 12.00);

-- --------------------------------------------------------

--
-- Table structure for table `tmpseats`
--

CREATE TABLE `tmpseats` (
  `show_id` int(10) UNSIGNED NOT NULL,
  `seat_row` int(10) UNSIGNED NOT NULL,
  `seat_col` int(10) UNSIGNED NOT NULL,
  `member_id` int(10) UNSIGNED NOT NULL,
  `start_dt` char(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addonmeals`
--
ALTER TABLE `addonmeals`
  ADD PRIMARY KEY (`meal_id`);

--
-- Indexes for table `cardlist`
--
ALTER TABLE `cardlist`
  ADD PRIMARY KEY (`card_id`);

--
-- Indexes for table `cinemainfo`
--
ALTER TABLE `cinemainfo`
  ADD PRIMARY KEY (`cinema_id`);

--
-- Indexes for table `memberlist`
--
ALTER TABLE `memberlist`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `moviecomment`
--
ALTER TABLE `moviecomment`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `movieinfo`
--
ALTER TABLE `movieinfo`
  ADD PRIMARY KEY (`movie_id`);

--
-- Indexes for table `orderlist`
--
ALTER TABLE `orderlist`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `showinfo`
--
ALTER TABLE `showinfo`
  ADD PRIMARY KEY (`show_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addonmeals`
--
ALTER TABLE `addonmeals`
  MODIFY `meal_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cardlist`
--
ALTER TABLE `cardlist`
  MODIFY `card_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cinemainfo`
--
ALTER TABLE `cinemainfo`
  MODIFY `cinema_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `memberlist`
--
ALTER TABLE `memberlist`
  MODIFY `member_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `moviecomment`
--
ALTER TABLE `moviecomment`
  MODIFY `comment_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `movieinfo`
--
ALTER TABLE `movieinfo`
  MODIFY `movie_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orderlist`
--
ALTER TABLE `orderlist`
  MODIFY `order_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `showinfo`
--
ALTER TABLE `showinfo`
  MODIFY `show_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
