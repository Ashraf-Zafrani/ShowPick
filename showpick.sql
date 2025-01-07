-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2025 at 03:36 PM
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
(2, 'ss', 'ss@gmail.com', '$2y$10$P43jXOLW0cAnVPT6LUsqYebTQFF/BocU0T0AHv3ecbvWXbUKtUo3q', '2025-01-06 22:50:18'),
(3, 'ddd', 'ddd@gamil.com', '$2y$10$h/bujK0zlFhl9VCI9u1/s.99DVvyHmLN9AwXtlVuoPLnYpQYaT7Ae', '2025-01-06 22:57:39'),
(4, 'ahmed', 'ahmed@gmail.com', '$2y$10$JF74Ipr7CcA1BfG59KJ1P.nv.rpSqwk8Mv1fap19U6en/yKcf/UHe', '2025-01-06 22:59:10'),
(6, '11', '11@gmai.com', '$2y$10$XlhsUgR8qYAfTltOoU9VSeWu9h0i9JOFW0pYqFh97azr14I93LB.C', '2025-01-06 23:25:14'),
(7, 'hello', 'hello@gmail.com', '$2y$10$gwxL1FYBRE7pm7VTUXlEFutjcHE2PjuDmULaQxoGUUjqIaHO1nSP.', '2025-01-06 23:56:03'),
(9, 'ashraf', 'ashraf123@gmail.com', '$2y$10$iJOEzlJLvIJT1dc9nxacr.4kb0AMudYHbUTl.t9iuYcEZEbw1DtYO', '2025-01-07 10:20:02'),
(11, 'dddd', 'dddd@gamil.com', '$2y$10$7vXG0dLZ.qJ37N5pXez4r.5KbJQ3AVKvB17AveXATPeAo0PEZR1gi', '2025-01-07 14:27:12');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
