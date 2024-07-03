-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2024 at 10:25 PM
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
-- Database: `sound_track_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `year` varchar(255) NOT NULL,
  `artist` varchar(255) NOT NULL,
  `album` varchar(255) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `year`, `artist`, `album`, `genre`, `image_path`) VALUES
(3, '123', 'da', 'qw', 'we', NULL),
(4, '123', 'da', 'qw', 'we', NULL),
(5, '123', 'da', 'qw', 'we', 'uploads/images/scrnli_6_22_2024_4-50-41 AM.png'),
(6, '123', 'da', 'qw', 'we', 'uploads/images/medical-team.png');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `music`
--

CREATE TABLE `music` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `artist` varchar(255) NOT NULL,
  `album` varchar(255) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `language` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `music`
--

INSERT INTO `music` (`id`, `name`, `artist`, `album`, `year`, `genre`, `language`, `description`, `file_path`, `created_at`, `user_id`) VALUES
(3, 'hafeez', 'ww1', 'qw', 123, 'w', 'ad', 'fgdf', 'uploads/music/short-5-209448.mp3', '2024-07-02 07:12:36', 0),
(10, 'hafeez', 'ww1', 'teri meri', 123, 'we', '214', 'sd', 'uploads/music/short-5-209448.mp3', '2024-07-03 19:48:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reviews_ratings`
--

CREATE TABLE `reviews_ratings` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `review` text DEFAULT NULL,
  `rating` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews_ratings`
--

INSERT INTO `reviews_ratings` (`id`, `category_id`, `review`, `rating`) VALUES
(1, 3, 'fdf', 123),
(2, 3, 'fdf', 123),
(3, 4, 'fdf', 3),
(4, 5, 'fdf', 123),
(5, 5, 'fdf', 123),
(6, 5, 'fdf', 123),
(7, 5, 'fdf', 123),
(8, 5, 'sasa', 2.5),
(9, 5, 'sasa', 2.5),
(10, 5, 'sasa', 2.5),
(11, 5, 'das', 12),
(12, 5, 'hgh', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `hobby` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `hobby`, `age`, `created_at`) VALUES
(3, 'khanbai', 'aa@gmail.com', '$2y$10$OEZ8Ql4XKxPq6IDczhsrz.FPPGgmIlimH8oJA3EV/CKBQkb5XIqoe', 'user', 'music', 45, '2024-06-29 17:40:44'),
(7, 'abc', 'alian12@gmail.com', '$2y$10$s8skJJsrJiBkcNFQc3.gf.QtQlfLTxobxoD4pdGo4m.NfJlbWCb2G', 'user', 'music', 23, '2024-06-29 18:11:19'),
(9, 'admin1234', '12@gmail.com', '$2y$10$DuNsNfhDMdyC8TWYxTL49uWPFjxZE62.eMZjV19w1jHSTPXyU5tBC', 'user', 'music', 23, '2024-06-29 18:16:54'),
(10, 'admin', 'ad@gmail.com', '$2y$10$9L05xol7U4bUaMeih0s5V.Mtpz4Ga08tX35BKA1ySG1.ai6ysFnsq', 'admin', 'music', 23, '2024-06-29 18:18:09'),
(11, 'aaah', 'user@gmail.comsing', '$2y$10$zMDNB59cwqbOvQJmLQjMI.9ijPhStyveloUTOUiRnV7yUurF.viM6', 'user', 'sports', 453, '2024-06-29 18:19:14'),
(12, 'murtaza khan', 'murtaza@gmail.com', '$2y$10$gXAz3jOufrJMLztSwzY4eOUALm9osjYkubv86TBMkGXqRledt0q8G', 'user', 'sports', 24, '2024-06-30 19:00:56'),
(13, 'jk', 'jk@gmail.com', '$2y$10$jd9LtK0eMkDL6LFq8UDcfOYm1HyLlSVmfCb.BnTnEF/dBxrzADUU2', 'user', 'sports', 24, '2024-07-01 20:05:15');

-- --------------------------------------------------------

--
-- Table structure for table `video`
--

CREATE TABLE `video` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `artist` varchar(255) NOT NULL,
  `album` varchar(255) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `language` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `video`
--

INSERT INTO `video` (`id`, `name`, `artist`, `album`, `year`, `genre`, `language`, `description`, `file_path`, `created_at`, `user_id`) VALUES
(2, 'malaika', 'da', 'qw', 123, 'we', 'ad', 'dfsf', 'uploads/videos/screen-capture.mp4', '2024-07-02 07:17:22', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `music`
--
ALTER TABLE `music`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `reviews_ratings`
--
ALTER TABLE `reviews_ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `music`
--
ALTER TABLE `music`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `reviews_ratings`
--
ALTER TABLE `reviews_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `video`
--
ALTER TABLE `video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `music`
--
ALTER TABLE `music`
  ADD CONSTRAINT `music_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews_ratings`
--
ALTER TABLE `reviews_ratings`
  ADD CONSTRAINT `reviews_ratings_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `video`
--
ALTER TABLE `video`
  ADD CONSTRAINT `video_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
