-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 18, 2025 at 01:02 AM
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
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `movie_id`, `user_id`, `comment`, `rating`, `created_at`) VALUES
(21, 18, 15, 'This is the best movie ', 5, '2025-01-17 23:26:13'),
(22, 12, 15, 'asdasdas', 5, '2025-01-17 23:27:00'),
(24, 1, 15, 'dsfsdfsdfsd', 1, '2025-01-17 23:30:48'),
(25, 1, 14, 'eefsdfsddfsfsdfssdfsdfsfsf1', 3, '2025-01-17 23:31:09');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `movie_id`) VALUES
(0, 14, 25),
(0, 13, 12),
(0, 13, 2),
(0, 14, 1);

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `genre` varchar(50) NOT NULL,
  `age_class` varchar(20) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `description` varchar(1500) NOT NULL,
  `Release_Year` int(11) NOT NULL,
  `Trailers` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`id`, `title`, `genre`, `age_class`, `image_url`, `description`, `Release_Year`, `Trailers`) VALUES
(1, 'The Dark Knight', 'action', 'adult', 'Posters/dark-knight.jpg', 'When a menace known as the Joker wreaks havoc and chaos on Gotham, Batman must face his greatest challenge.', 2008, 'https://www.youtube.com/watch?v=LDG9bisJEaI'),
(2, 'Avengers: Endgame', 'action', 'adult', 'Posters/avengers-endgame.jpg', 'After the devastating events of Avengers: Infinity War, the Avengers assemble to undo Thanos\' actions.', 2019, 'https://www.youtube.com/watch?v=KCSNFZKbhZE'),
(3, 'Mad Max: Fury Road', 'action', 'adult', 'Posters/mad-max.jpg', 'In a post-apocalyptic wasteland, a woman rebels against a tyrannical ruler with the help of a drifter.', 2015, 'https://www.youtube.com/watch?v=hEJnMQG9ev8'),
(4, 'John Wick', 'action', 'adult', 'Posters/john-wick.jpg', 'John Wick is a former hitman grieving the loss of his wife when a gang targets him, sparking vengeance.', 2014, 'https://www.youtube.com/watch?v=C0BMx-qxsP4'),
(5, 'Spider-Man: Into the Spider-Verse', 'action', 'kids', 'Posters/spider-verse.jpg', 'A teenager discovers he\'s not the only Spider-Man and must join forces with others to save their universes.', 2018, 'https://www.youtube.com/watch?v=ii3n7hYQOl4'),
(6, 'Finding Nemo', 'comedy', 'kids', 'Posters/finding-nemo.jpg', 'A clownfish searches for his abducted son, making friends along the way in the vast ocean.', 2003, 'https://www.youtube.com/watch?v=SPHfeNgogVs'),
(7, 'Shrek', 'comedy', 'kids', 'Posters/shrek.jpg', 'An ogre\'s peaceful swamp is invaded, leading him on a quest to rescue a princess and regain his home.', 2001, 'https://www.youtube.com/watch?v=ooJJX3R42WM'),
(8, 'The Hangover', 'comedy', 'adult', 'Posters/hangover.jpg', 'Three friends must retrace their steps to find their missing friend after a wild bachelor party in Vegas.', 2009, 'https://www.youtube.com/watch?v=TZc39afdeXU'),
(9, 'Superbad', 'comedy', 'adult', 'Posters/superbad.jpg', 'Two high school friends plan one final wild night before graduation, leading to comedic chaos.', 2007, 'https://www.youtube.com/watch?v=4eaZ_48ZYog'),
(10, 'Toy Story', 'comedy', 'kids', 'Posters/toy-story.jpg', 'A group of toys comes to life and embarks on adventures to protect their owner and each other.', 1995, 'https://www.youtube.com/watch?v=v-PjgYDrg70'),
(11, 'The Conjuring', 'horror', 'adult', 'Posters/conjuring.jpg', 'Paranormal investigators help a family terrorized by dark forces in their haunted house.', 2013, 'https://www.youtube.com/watch?v=k10ETZ41q5o'),
(12, 'A Quiet Place', 'horror', 'adult', 'Posters/a-quiet-place.jpg', 'A family must live in silence to avoid mysterious creatures that hunt by sound.', 2018, 'https://www.youtube.com/watch?v=YPY7J-flzE8'),
(13, 'It', 'horror', 'adult', 'Posters/it.jpg', 'A group of kids face their worst fears as they confront a shape-shifting monster terrorizing their town.', 2017, 'https://www.youtube.com/watch?v=FnCdOQsX5kc'),
(14, 'Coraline', 'horror', 'kids', 'Posters/coraline.jpg', 'A girl discovers a parallel world that harbors sinister secrets behind its seemingly perfect facade.', 2009, 'https://www.youtube.com/watch?v=m9bOpeuvNwY'),
(15, 'The Ring', 'horror', 'adult', 'Posters/ring.jpg', 'A cursed videotape causes death to those who watch it unless the mystery is solved.', 2002, 'https://www.youtube.com/watch?v=yzR2GY-ew8I'),
(16, 'Breaking Bad', 'Drama', 'adult', 'Posters/breaking-bad.jpg', 'A high school chemistry teacher turns to cooking methamphetamine to secure his family\'s future.', 2008, 'https://www.youtube.com/watch?v=ceqOTZnhgY8'),
(17, 'The Crown', 'Drama', 'adult', 'Posters/the-crown.jpg', 'A biographical drama about the reign of Queen Elizabeth II and the challenges faced by the British monarchy.', 2016, 'https://www.youtube.com/watch?v=JWtnJjn6ng0'),
(18, 'Forrest Gump', 'Drama', 'adult', 'Posters/forrest-gump.jpg', 'The life story of a simple man with extraordinary achievements through history\'s defining moments.', 1994, 'https://www.youtube.com/watch?v=VweP1BiUW0o'),
(19, 'The Pursuit of Happyness', 'Drama', 'adult', 'Posters/pursuit-of-happyness.jpg', 'A struggling salesman battles hardship while caring for his young son and chasing his dreams.', 2006, 'https://www.youtube.com/watch?v=DMOBlEcRuw8'),
(20, 'Coco', 'Drama', 'kids', 'Posters/coco.jpg', 'A boy journeys to the Land of the Dead to uncover his family\'s secrets and pursue his love of music.', 2017, 'https://www.youtube.com/watch?v=xlnPHQ3TLX8'),
(21, 'The Notebook', 'romance', 'adult', 'Posters/the-notebook.jpg', 'A timeless love story spanning decades, capturing the trials and triumphs of a couple\'s enduring romance.', 2004, 'https://www.youtube.com/watch?v=011BVAtMEiY'),
(22, 'Titanic', 'romance', 'adult', 'Posters/titanic.jpg', 'A young couple from different social classes fall in love aboard the ill-fated RMS Titanic.', 1997, 'https://www.youtube.com/watch?v=tri6jLT4y0g'),
(23, 'Pride and Prejudice', 'romance', 'adult', 'Posters/pride-and-prejudice.jpg', 'The story of Elizabeth Bennet and Mr. Darcy, navigating societal norms and personal pride.', 2005, 'https://www.youtube.com/watch?v=Ur_DIHs92NM'),
(24, 'Beauty and the Beast', 'romance', 'kids', 'Posters/beauty-and-beast.jpg', 'A young woman discovers the humanity of a cursed prince living as a beast in an enchanted castle.', 1991, 'https://www.youtube.com/watch?v=iurbZwxKFUE'),
(25, 'The Fault in Our Stars', 'romance', 'adult', 'Posters/fault-in-our-stars.jpg', 'Two teens with terminal illnesses find love and meaning in their limited time together.', 2014, 'https://www.youtube.com/watch?v=7OOCaAvDUAg');

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
(13, 'example', 'example@gmail.com', '$2y$10$epLBU3dtpET5ZDhBJBb6WOzkvLov8f7ay1jvMRHLdOzSVaNtfi6NG', '2025-01-07 15:00:15'),
(14, 'test', 'test@gmail.com', '$2y$10$8BpQBDS4.P6apvMxrIM.2Oir3JHb7zAGLA0StihaluOCScoyjy5GW', '2025-01-17 17:10:29'),
(15, 'ashraf', 'ashraf@gmail.com', '$2y$10$0hzN35n9XZp2/YflEcPCsuqE56JgW8M7J9wm8QWp0lDwku2vHdshO', '2025-01-17 23:25:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_id` (`movie_id`),
  ADD KEY `user_id` (`user_id`);

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
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
