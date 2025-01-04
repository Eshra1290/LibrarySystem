-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2025 at 04:30 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `librarysystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) DEFAULT NULL,
  `isbn` varchar(50) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `book_cover` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `title`, `author`, `isbn`, `quantity`, `book_cover`) VALUES
(1, 'The 48 Laws of Power', 'Robert Greene', '1234456788', 1, 'uploads/images.png'),
(2, 'The High 5 Habits', 'Mel Robbins', '1234456787', 6, 'uploads/images (1).png'),
(3, 'No Longer Human', 'Osamu Dazai', '1234456730', 4, 'uploads/9780811204811.jpg'),
(6, 'The Setting Sun', 'Osamu Dazai', '1234456783', 2, 'uploads/images (1).jpg'),
(8, 'Atomic Habits', 'James Clear', '1234456756', 6, 'uploads/book_covers/book_6777efce97f012.46064796.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `book_borrowings`
--

CREATE TABLE `book_borrowings` (
  `borrowing_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `borrow_date` date DEFAULT curdate(),
  `return_date` date DEFAULT NULL,
  `status` varchar(50) DEFAULT 'borrowed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book_borrowings`
--

INSERT INTO `book_borrowings` (`borrowing_id`, `user_id`, `book_id`, `borrow_date`, `return_date`, `status`) VALUES
(1, 3, 1, '2025-01-03', NULL, 'borrowed'),
(2, 3, 2, '2025-01-03', NULL, 'borrowed'),
(3, 3, 3, '2025-01-03', NULL, 'borrowed'),
(4, 3, 3, '2025-01-03', NULL, 'borrowed'),
(5, 3, 2, '2025-01-03', NULL, 'borrowed'),
(6, 3, 2, '2025-01-03', NULL, 'borrowed'),
(7, 3, 8, '2025-01-03', NULL, 'borrowed'),
(8, 3, 8, '2025-01-03', NULL, 'borrowed'),
(9, 3, 1, '2025-01-03', NULL, 'borrowed'),
(10, 3, 1, '2025-01-03', NULL, 'borrowed'),
(11, 3, 1, '2025-01-03', NULL, 'borrowed'),
(12, 3, 3, '2025-01-03', NULL, 'reserved'),
(13, 3, 3, '2025-01-03', NULL, 'reserved'),
(14, 3, 3, '2025-01-03', NULL, 'reserved'),
(15, 3, 3, '2025-01-03', NULL, 'reserved'),
(16, 3, 3, '2025-01-03', NULL, 'reserved'),
(17, 3, 3, '2025-01-03', NULL, 'reserved'),
(18, 3, 3, '2025-01-03', NULL, 'reserved');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `user_id` int(11) NOT NULL,
  `profile_picture` varchar(255) DEFAULT 'uploads/profile_pictures/default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `role`, `user_id`, `profile_picture`) VALUES
('Eshra', '$2y$10$OCQMLUDXl5GysWfQaN2e/.1AcvqEsqWzpQHK1v7iFbKwjU8OPDKDq', 'user', 1, 'uploads/profile_pictures/default.jpg'),
('John', '$2y$10$oX32tOc49ad.D/dpUpWU8OT/9cgeVXnlaX7G7i3yOE1h6M09BihPi', 'user', 2, 'uploads/profile_pictures/default.jpg'),
('amy', '$2y$10$IE/A4b.cEs1daJNae5Nx.umZNn3Zwq5pR14LCQnL61PzHDusqmfhm', 'user', 3, 'uploads/profile_pictures/default.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `book_borrowings`
--
ALTER TABLE `book_borrowings`
  ADD PRIMARY KEY (`borrowing_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `book_borrowings`
--
ALTER TABLE `book_borrowings`
  MODIFY `borrowing_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book_borrowings`
--
ALTER TABLE `book_borrowings`
  ADD CONSTRAINT `book_borrowings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `book_borrowings_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
