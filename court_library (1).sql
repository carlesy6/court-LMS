-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2024 at 01:11 AM
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
-- Database: `court_library`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `id_no` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `id_no`, `phone`) VALUES
(1, 'emmanuel', '32447', '0765432454');

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE `resources` (
  `id` int(11) NOT NULL,
  `resource_number` int(11) NOT NULL,
  `accession_no` varchar(50) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `edition` varchar(50) DEFAULT NULL,
  `volume` varchar(50) DEFAULT NULL,
  `publisher` varchar(255) DEFAULT NULL,
  `year_of_publication` year(4) DEFAULT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `class` varchar(50) DEFAULT NULL,
  `station` varchar(100) DEFAULT NULL,
  `status` enum('available','borrowed') DEFAULT 'available',
  `resource_type` enum('Case Book','Bound High Court Decision') NOT NULL,
  `index_number` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resources`
--

INSERT INTO `resources` (`id`, `resource_number`, `accession_no`, `title`, `author`, `edition`, `volume`, `publisher`, `year_of_publication`, `isbn`, `class`, `station`, `status`, `resource_type`, `index_number`) VALUES
(1, 1, '740', 'KENYA LAW REPORT', 'GLADYS BOSS SHOLEI', '-', '2', 'NATIONAL COUNCIL FOR LAW REPORTING', '2004', '9966-821-01-5', '-', 'MERU', 'available', 'Case Book', NULL),
(2, 2, '559', 'EAST AFRICA LAW REPORT', 'LE PELLEY', '-', '-', 'PROFESSIONAL BOOKS LTD', '1970', '-', '-', 'MERU', 'available', 'Case Book', NULL),
(4, 3, '876', 'hgjg', 'yfn', '6', '8', 'PROFFESSIONAL BOOKS LTD', '2004', '37575889', '-', 'MERU', 'borrowed', 'Case Book', NULL);

--
-- Triggers `resources`
--
DELIMITER $$
CREATE TRIGGER `before_insert_resources` BEFORE INSERT ON `resources` FOR EACH ROW BEGIN
    DECLARE max_resource_number INT;
    SET max_resource_number = (SELECT COALESCE(MAX(resource_number), 0) + 1 FROM resources);
    SET NEW.resource_number = max_resource_number;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `resource_id` int(11) DEFAULT NULL,
  `action` enum('borrowed','returned') DEFAULT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `resource_id`, `action`, `transaction_date`) VALUES
(1, NULL, 4, 'borrowed', '2024-07-26 22:04:56'),
(2, NULL, 4, 'returned', '2024-07-26 22:09:42'),
(3, 1, 4, 'borrowed', '2024-07-26 22:41:14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'CELESTINO', '$2y$10$HgBUo0UljMymacZQRllpPuN4biJad6RB0QwhER.erVZkSl3qBS3/.', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_no` (`id_no`);

--
-- Indexes for table `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `resource_number` (`resource_number`),
  ADD UNIQUE KEY `accession_no` (`accession_no`),
  ADD UNIQUE KEY `index_number` (`index_number`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `resource_id` (`resource_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `resources`
--
ALTER TABLE `resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`resource_id`) REFERENCES `resources` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;