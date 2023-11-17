-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2023 at 07:35 AM
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
  `meal_name` char(50) NOT NULL,
  `meal_price` float(4,2) NOT NULL,
  `meal_image` char(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addonmeals`
--

INSERT INTO `addonmeals` (`meal_id`, `meal_name`, `meal_price`, `meal_image`) VALUES
(1, 'Hot Dog Combo', 14.00, 'hotdogcombo.png'),
(2, 'Popcorn Combo', 12.00, 'popcorncombo.png'),
(3, 'Burger Combo', 13.00, 'burger.jpg'),
(4, 'Iced Lemon Tea', 2.00, 'lemontea.jpg'),
(5, 'Iced Milk Tea', 4.50, 'milktea.png'),
(6, 'Iced Coca Cola', 3.00, 'cola.png');

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
  `member_name` char(25) NOT NULL,
  `member_password` char(25) NOT NULL,
  `member_email` char(255) NOT NULL,
  `member_hp` char(20) NOT NULL,
  `member_card` char(25) NOT NULL,
  `register_date` char(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `memberlist`
--

INSERT INTO `memberlist` (`member_id`, `member_name`, `member_password`, `member_email`, `member_hp`, `member_card`, `register_date`) VALUES
(1, 'Jane', 'Jane0101#', 'jane@localhost', '81193988', '1234567812345678', '2023-11-09'),
(2, 'rheallyc', 'Gcy1018!', 'rheallyc@localhost', '85150358', '1234567812345678', '2022-10-01');

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
  `release_date` char(20) NOT NULL,
  `synopsis` char(250) DEFAULT NULL,
  `poster` char(50) NOT NULL,
  `splash_poster` char(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movieinfo`
--

INSERT INTO `movieinfo` (`movie_id`, `movie_name`, `directors`, `casts`, `genre`, `rating`, `runtime`, `release_date`, `synopsis`, `poster`, `splash_poster`) VALUES
(1, 'Barbie', 'Greta Gerwig', 'Margot Robbie, Ryan Gosline, Issa Rae', 'Fantasy, Slice of life', 7.0, 114, '2023-10-30', 'Barbie suffers a crisis that leads her to question her world and her existence.', 'barbie.jpeg', 'barbie_s.jpeg'),
(2, 'Oppenheimer', 'Christopher Nolan', 'Cillian Murphy, Emily Blunt, Matt Damin', 'Action, Mystery', 8.5, 240, '2023-10-25', 'The story of American scientist, J. Robert Oppenheimer, and his role in the development of the atomic bomb.', 'Oppenheimer.jpg', 'Oppenheimer_s.jpeg'),
(3, 'The Burial', 'Maggie Betts', 'Jamie Foxx, Tommy Lee Jones, Jurnee Smollett', 'Law, Mystery', 7.1, 126, '2023-09-11', 'Inspired by true events, a lawyer helps a funeral home owner save his family business from a corporate behemoth, exposing a complex web of race, power, and injustice.', 'theburial.jpg', 'theburial_s.jpg'),
(4, 'Talk to Me', 'Danny Philippou, Michael Philippou', 'Ari McCarthy, Hamish Phillips, Kit Erhart-Bruce', 'Horror', 7.2, 95, '2023-10-21', 'When a group of friends discover how to conjure spirits using an embalmed hand, they become hooked on the new thrill, until one of them goes too far and unleashes terrifying supernatural forces.', 'talktome.jpeg', 'talktome_s.jpg'),
(5, 'Taylor Swift: The Eras Tour', 'Sam Wrench', 'Taylor Swift', 'Music', 8.4, 240, '2023-11-03', 'Experience the breathtaking Eras Tour concert, performed by the one and only Taylor Swift.', 'taylorswift.jpeg', 'taylorswift_s.jpeg'),
(6, 'Moscow Mission', 'Herman Yau', 'Hanyu Zhang, Andy Lau, Xuan Huang', 'Action, Crime, Drama', 6.1, 248, '2023-09-25', 'Tough Chinese detectives go on a mission to Moscow to hunt down ruthless robbers who have been plaguing the trans-Siberian railway with violence and chaos.', 'moscowmission.jpg', 'moscowmission_s.jpeg'),
(7, 'The Exorcist: Believer', 'David Gordon Green', 'Lafortune Joseph, Leslie Odom Jr., Gastner Legerme', 'Horror', 5.0, 111, '2023-10-04', 'When two girls disappear into the woods and return three days later with no memory of what happened to them, the father of one girl seeks out Chris MacNeil, who\'s been forever altered by what happened to her daughter fifty years ago.', 'theexorcist.png', 'theexorcist_s.jpeg'),
(8, 'Killers of the Flower Moon', 'Martin Scorsese', 'Leonardo DiCaprio, Robert De Niro, Lily Gladstone', 'Tragedy', 8.7, 360, '2023-07-01', 'When oil is discovered in 1920s Oklahoma under Osage Nation land, the Osage people are murdered one by one - until the FBI steps in to unravel the mystery.', 'killersoftheflowermoon.jpeg', 'killersoftheflowermoon_s.jpeg'),
(9, 'Air Mata Di Ujung Sajadah', 'Key Mangunsong', 'Titi Kamal, Fedi Nuril, Citra Kirana', 'Family', 6.5, 105, '2023-09-01', 'Aqilla discovers her long-lost son, Baskara, but faces a moral dilemma as he has been raised by another couple; a heartfelt struggle ensues.', 'airmata.jpeg', 'airmata_s.jpeg'),
(10, 'A Haunting in Venice', 'Kenneth Branagh', 'Kenneth Branagh, Michelle Yeoh, Jamie Dornan', 'Mystery', 6.8, 104, '2023-10-21', 'In post-World War II Venice, Poirot, now retired and living in his own exile, reluctantly attends a seance. But when one of the guests is murdered, it is up to the former detective to once again uncover the killer.', 'ahauntinginvenice.jpg', 'ahauntinginvenice_s.jpeg'),
(11, 'Leo', 'Lokesh Kanagaraj', 'Joseph Vijay, Sanjay Dutt, Trisha Krishnan', 'Action, Crime, Drama', 8.0, 300, '2023-08-10', 'Parthiban is a mild mannered cafe owner in Kashmir, who fends off a gang of murderous thugs and gains attention from a drug cartel claiming he was once a part of them.', 'leo.jpeg', 'leo_s.jpeg'),
(12, 'X', 'Ti West', 'Mia Goth, Jenna Ortega, Brittany Snow', 'Horror, Mystery', 6.6, 105, '2023-07-01', 'In 1979, a group of young filmmakers set out to make an adult film in rural Texas, but when their reclusive, elderly hosts catch them in the act, the cast find themselves fighting for their lives.', 'x.jpeg', 'x_s.jpeg'),
(13, 'Schindler\'s List', 'Steven Spielberg', 'Liam Neeson, Ralph Fiennes, Ben Kingsley', 'Biography, Drama', 9.0, 255, '1993-03-10', 'In German-occupied Poland during World War II, industrialist Oskar Schindler gradually becomes concerned for his Jewish workforce after witnessing their persecution by the Nazis.', 'schindler.jpg', 'schindler_s.jpeg'),
(14, 'Winnie the Pooh: Blood and Honey', 'Rhys Frake-Waterfield', 'Nikolai Leon, Maria Taylor, Natasha Rose Mills', 'Horror, Mystery', 2.8, 184, '2022-12-01', 'After Christopher Robin abandons them for college, Pooh and Piglet embark on a bloody rampage as they search for a new source of food.', 'winnie.jpg', 'winnie_s.jpeg'),
(15, 'Eileen', 'William Oldroyd', 'Thomasin McKenzie, Shea Whigham, Sam Nivola', 'Drama, Mystery', 7.0, 97, '2023-10-28', 'A woman\'s friendship with a new co-worker at the prison facility where she works takes a sinister turn.', 'eileen.jpeg', 'eileen_s.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `orderaddon`
--

CREATE TABLE `orderaddon` (
  `order_id` int(10) UNSIGNED NOT NULL,
  `meal_name` char(50) NOT NULL,
  `meal_price` float(4,2) NOT NULL,
  `meal_quantity` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderaddon`
--

INSERT INTO `orderaddon` (`order_id`, `meal_name`, `meal_price`, `meal_quantity`) VALUES
(2, 'Hot Dog Combo', 14.00, 1),
(2, 'Popcorn Combo', 12.00, 2),
(3, 'Hot Dog Combo', 14.00, 2),
(4, 'Hot Dog Combo', 14.00, 2),
(5, 'Popcorn Combo', 12.00, 2),
(6, 'Popcorn Combo', 12.00, 2),
(7, 'Popcorn Combo', 12.00, 2),
(7, 'Iced Lemon Tea', 2.00, 1),
(7, 'Iced Milk Tea', 4.50, 2),
(7, 'Iced Coca Cola', 3.00, 1),
(8, 'Burger Combo', 13.00, 3),
(8, 'Iced Milk Tea', 4.50, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orderlist`
--

CREATE TABLE `orderlist` (
  `order_id` int(10) UNSIGNED NOT NULL,
  `order_dt` char(20) NOT NULL,
  `account_id` int(10) UNSIGNED NOT NULL,
  `show_id` int(10) UNSIGNED NOT NULL,
  `num_tickets` int(10) UNSIGNED NOT NULL,
  `ticket_price` float(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderlist`
--

INSERT INTO `orderlist` (`order_id`, `order_dt`, `account_id`, `show_id`, `num_tickets`, `ticket_price`) VALUES
(1, '2023-11-09 17:03:32', 2, 19, 3, 12.00),
(2, '2023-11-09 17:08:37', 2, 8, 4, 12.00),
(3, '2023-11-09 17:11:07', 2, 2, 3, 14.00),
(4, '2023-11-09 18:30:16', 1, 2, 2, 14.00),
(5, '2023-11-09 18:38:25', 1, 8, 1, 12.00),
(6, '2023-11-09 18:40:41', 1, 8, 3, 12.00),
(7, '2023-11-09 19:46:37', 2, 15, 4, 14.00),
(8, '2023-11-10 06:55:43', 2, 8, 2, 12.00);

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
(1, 3, 5),
(1, 3, 6),
(1, 3, 7),
(2, 3, 4),
(2, 3, 5),
(2, 3, 6),
(2, 3, 7),
(3, 3, 5),
(3, 3, 6),
(3, 3, 4),
(4, 2, 4),
(4, 2, 5),
(5, 2, 5),
(6, 2, 6),
(6, 2, 7),
(6, 2, 8),
(7, 3, 4),
(7, 3, 5),
(7, 3, 6),
(7, 3, 7),
(8, 2, 4),
(8, 2, 3);

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
(1, 1, 1, 1, '2023-11-21', '13:30', 14.00),
(2, 2, 2, 2, '2023-11-19', '10:30', 14.00),
(3, 4, 2, 1, '2023-11-18', '15:00', 14.00),
(4, 3, 2, 1, '2023-11-18', '13:30', 14.00),
(5, 5, 1, 1, '2023-11-25', '13:30', 14.00),
(6, 6, 1, 2, '2023-11-19', '20:00', 14.00),
(7, 7, 1, 1, '2023-11-19', '17:00', 14.00),
(8, 1, 1, 1, '2023-11-20', '13:00', 12.00),
(9, 1, 2, 1, '2023-11-19', '16:00', 12.00),
(10, 1, 1, 1, '2023-11-20', '20:00', 12.00),
(11, 1, 1, 2, '2023-11-20', '15:00', 12.00),
(12, 8, 2, 3, '2023-11-20', '15:00', 14.00),
(13, 9, 1, 2, '2023-11-20', '13:30', 14.00),
(14, 10, 2, 3, '2023-11-21', '12:00', 14.00),
(15, 11, 1, 3, '2023-11-19', '13:00', 14.00),
(16, 12, 2, 2, '2023-11-25', '13:30', 12.00),
(17, 13, 1, 2, '2023-11-22', '15:30', 12.00),
(18, 14, 1, 3, '2023-11-26', '15:30', 12.00),
(19, 15, 2, 3, '2023-11-21', '15:30', 12.00);

-- --------------------------------------------------------

--
-- Table structure for table `tmpseats`
--

CREATE TABLE `tmpseats` (
  `show_id` int(10) UNSIGNED NOT NULL,
  `seat_row` int(10) UNSIGNED NOT NULL,
  `seat_col` int(10) UNSIGNED NOT NULL,
  `member_id` int(10) UNSIGNED NOT NULL,
  `start_dt` char(20) NOT NULL
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
  MODIFY `meal_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cinemainfo`
--
ALTER TABLE `cinemainfo`
  MODIFY `cinema_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `memberlist`
--
ALTER TABLE `memberlist`
  MODIFY `member_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `movieinfo`
--
ALTER TABLE `movieinfo`
  MODIFY `movie_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orderlist`
--
ALTER TABLE `orderlist`
  MODIFY `order_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `showinfo`
--
ALTER TABLE `showinfo`
  MODIFY `show_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
