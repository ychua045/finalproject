-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 03, 2023 at 04:15 AM
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
(1, 'Hot Dog Combo', 14.00, 'hotdog.jpg');

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
  `member_card` char(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `memberlist`
--

INSERT INTO `memberlist` (`member_id`, `member_name`, `member_password`, `member_email`, `member_hp`, `member_card`) VALUES
(1, 'rheallyc', 'Gcy1018!', 'rhea1018@outlook.com', '85150357', '1234567812345678');

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
(3, 'The Burial', 'Maggie Betts', 'Jamie Foxx, Tommy Lee Jones, Jurnee Smollett', 'Law, Mystery', 7.1, 126, 'Inspired by true events, a lawyer helps a funeral home owner save his family business from a corporate behemoth, exposing a complex web of race, power, and injustice.', 'theburial.jpg', 'theburial_s.jpg');

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
(1, 'Hot Dog Combo', 14.00, 2),
(2, 'Hot Dog Combo', 14.00, 1),
(2, 'Hamburger Combo', 20.00, 1);

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
(1, '2023-10-30', 1, 1, 2, 12.00),
(2, '2023-11-01 23:00', 1, 2, 3, 12.00);

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
(2, 3, 4),
(2, 3, 5),
(2, 3, 6);

-- --------------------------------------------------------

--
-- Table structure for table `showinfo`
--

CREATE TABLE `showinfo` (
  `show_id` int(10) UNSIGNED NOT NULL,
  `movie_id` int(10) UNSIGNED NOT NULL,
  `cinema_id` int(10) UNSIGNED NOT NULL,
  `hall_id` int(10) UNSIGNED NOT NULL,
  `show_date` char(20) DEFAULT NULL,
  `show_time` char(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `showinfo`
--

INSERT INTO `showinfo` (`show_id`, `movie_id`, `cinema_id`, `hall_id`, `show_date`, `show_time`) VALUES
(1, 1, 1, 1, '2023-11-01', '13:30'),
(2, 2, 2, 2, '2023-11-03', '10:30'),
(3, 2, 2, 1, '2023-11-04', '15:00'),
(4, 2, 2, 1, '2023-11-04', '13:30'),
(5, 2, 1, 1, '2023-11-02', '13:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addonmeals`
--
ALTER TABLE `addonmeals`
  ADD PRIMARY KEY (`meal_id`);

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
  MODIFY `meal_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cinemainfo`
--
ALTER TABLE `cinemainfo`
  MODIFY `cinema_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `memberlist`
--
ALTER TABLE `memberlist`
  MODIFY `member_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `moviecomment`
--
ALTER TABLE `moviecomment`
  MODIFY `comment_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `movieinfo`
--
ALTER TABLE `movieinfo`
  MODIFY `movie_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orderlist`
--
ALTER TABLE `orderlist`
  MODIFY `order_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `showinfo`
--
ALTER TABLE `showinfo`
  MODIFY `show_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
