-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2024 at 11:05 AM
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
-- Database: `login_register`
--

-- --------------------------------------------------------

--
-- Table structure for table `flipbooks`
--

CREATE TABLE `flipbooks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `flipbook_name` varchar(255) NOT NULL,
  `flipbook_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flipbooks`
--

INSERT INTO `flipbooks` (`id`, `user_id`, `flipbook_name`, `flipbook_path`, `created_at`) VALUES
(2, 2, 'My Flipbook', 'uploads/flipbooks/6746035854fca.json', '2024-11-26 17:20:24'),
(3, 2, 'My Flipbook', 'uploads/flipbooks/6746038fafa6c.json', '2024-11-26 17:21:19'),
(5, 2, 'My Flipbook', 'uploads/flipbooks/6746103aa8aca.json', '2024-11-26 18:15:22'),
(7, 2, 'My Flipbook', 'uploads/flipbooks/6746e64be9c28.json', '2024-11-27 09:28:43');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(128) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`) VALUES
(1, 'Aktar', 'aktar@gmail.com', '$2y$10$Jmf9Xk2y8m.fo3c/ZgKmzOrdIRkU05KSGLI0picKLEtr68ll7hjB.'),
(2, 'lavanya', 'lavanya@gmail.com', '$2y$10$haKMgMxVq9KAi0DaB7gZse57Li3Vg8fPfxGo2LYuQcoiLqFh7obH2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `flipbooks`
--
ALTER TABLE `flipbooks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `flipbooks`
--
ALTER TABLE `flipbooks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
