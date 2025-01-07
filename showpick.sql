-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2025 at 04:04 PM
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
-- Database: `showpick`
--

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `genre` varchar(50) NOT NULL,
  `age_class` varchar(20) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`id`, `title`, `genre`, `age_class`, `image_url`) VALUES
(1, 'The Dark Knight', 'action', 'adult', 'Posters/dark-knight.jpg'),
(2, 'Avengers: Endgame', 'action', 'adult', 'Posters/avengers-endgame.jpg'),
(3, 'Mad Max: Fury Road', 'action', 'adult', 'Posters/mad-max.jpg'),
(4, 'John Wick', 'action', 'adult', 'Posters/john-wick.jpg'),
(5, 'Spider-Man: Into the Spider-Verse', 'action', 'kids', 'Posters/spider-verse.jpg'),
(6, 'Finding Nemo', 'comedy', 'kids', 'Posters/finding-nemo.jpg'),
(7, 'Shrek', 'comedy', 'kids', 'Posters/shrek.jpg'),
(8, 'The Hangover', 'comedy', 'adult', 'Posters/hangover.jpg'),
(9, 'Superbad', 'comedy', 'adult', 'Posters/superbad.jpg'),
(10, 'Toy Story', 'comedy', 'kids', 'Posters/toy-story.jpg'),
(11, 'The Conjuring', 'horror', 'adult', 'Posters/conjuring.jpg'),
(12, 'A Quiet Place', 'horror', 'adult', 'Posters/a-quiet-place.jpg'),
(13, 'It', 'horror', 'adult', 'Posters/it.jpg'),
(14, 'Coraline', 'horror', 'kids', 'Posters/coraline.jpg'),
(15, 'The Ring', 'horror', 'adult', 'Posters/ring.jpg'),
(16, 'Breaking Bad', 'Drama', 'adult', 'Posters/breaking-bad.jpg'),
(17, 'The Crown', 'Drama', 'adult', 'Posters/the-crown.jpg'),
(18, 'Forrest Gump', 'Drama', 'adult', 'Posters/forrest-gump.jpg'),
(19, 'The Pursuit of Happyness', 'Drama', 'adult', 'Posters/pursuit-of-happyness.jpg'),
(20, 'Coco', 'Drama', 'kids', 'Posters/coco.jpg'),
(21, 'The Notebook', 'romance', 'adult', 'Posters/the-notebook.jpg'),
(22, 'Titanic', 'romance', 'adult', 'Posters/titanic.jpg'),
(23, 'Pride and Prejudice', 'romance', 'adult', 'Posters/pride-and-prejudice.jpg'),
(24, 'Beauty and the Beast', 'romance', 'kids', 'Posters/beauty-and-beast.jpg'),
(25, 'The Fault in Our Stars', 'romance', 'adult', 'Posters/fault-in-our-stars.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(13, 'example', 'example@gmail.com', '$2y$10$epLBU3dtpET5ZDhBJBb6WOzkvLov8f7ay1jvMRHLdOzSVaNtfi6NG', '2025-01-07 15:00:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
