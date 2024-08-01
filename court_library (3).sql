-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 01, 2024 at 02:21 AM
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
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'CELESTINO', '$2y$10$3mP2weMmX5081Q5XeCE/YuQi6W2MHy2yFw5nQL6O4a4rVwm/ysB2K');

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
(1, 'samuel', '32447', '0765432454'),
(3, 'emmanuel', '32447432', '0765432454');

-- --------------------------------------------------------

--
-- Table structure for table `librarians`
--

CREATE TABLE `librarians` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `librarians`
--

INSERT INTO `librarians` (`id`, `full_name`, `username`, `phone`, `email`, `password`, `created_at`) VALUES
(1, 'OTIENO CELESTINO ONYANGO', 'ONYANGO', '0759967367', 'ictclassintake@gmail.com', '$2y$10$f7.1Y30NzDpkx5UiBFhgbOUkH20xTx1P6olqfbrVZSblnYqDqc1Va', '2024-07-27 21:53:43'),
(2, 'PAUL OMONDI', 'pp', '0789674532', 'njorogestanley18fr6@gmail.com', '$2y$10$9m7slSHQEw89j7xTK7OexeakNL/qpV4ZFugCfL8q7QGZumWIyUZP2', '2024-07-31 22:12:45'),
(3, 'PAUL OMONDI', 'NJERI', '0759967367', 'njorogestanley186SF@gmail.com', '$2y$10$wGFi77HF14agaTYhMucZvuspBkGNSNAVvNgpIK1h7v41oMWifhNQe', '2024-07-31 23:27:44');

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
(12, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', 'Bound High Court Decision', '2312'),
(13, 10, '324238', 're', 'GLADYS BOSS SHOLEI', 'sf', '321', '54et6', '2023', '9966-821-01-5', '234', '23', 'available', 'Case Book', NULL),
(14, 11, '898', 'fsd', 'LE PELLEY', '234', '2', '23', '2023', '23234', '53', '2', 'borrowed', 'Case Book', NULL),
(15, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', 'Bound High Court Decision', '54643'),
(16, 13, '123', '123', '123', '123', '123', '123', '0000', '123', '123', '123', 'borrowed', 'Case Book', NULL);

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
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `resource_id` int(11) DEFAULT NULL,
  `action` enum('borrowed','returned') DEFAULT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `borrowed_on` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `resource_id`, `action`, `transaction_date`, `borrowed_on`) VALUES
(5, NULL, 14, 'borrowed', '2024-07-31 23:18:40', '2024-07-31 16:18:40'),
(6, NULL, 14, 'returned', '2024-07-31 23:22:32', '2024-07-31 16:22:32'),
(7, 2, 14, 'borrowed', '2024-07-31 23:36:36', '2024-07-31 16:36:36'),
(8, 2, 16, 'borrowed', '2024-08-01 00:03:16', '2024-07-31 17:03:16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','librarian') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `username`, `phone`, `email`, `password`, `role`, `created_at`) VALUES
(2, 'Ann Njeri', 'Ann', '0789674532', 'njorogestanley186@gmail.com', '$2y$10$3TcFSYQhTluikxP0Kit9EeVWRWbXL6mYvmVmwr7FQ7L0daaTAlq02', 'admin', '2024-07-31 21:36:32'),
(3, 'OTIENO CELESTINO ONYANGO', 'njorogesta', '0759967367', 'poppixiieempire@gmail.com', '$2y$10$m9WTG4oT1Fs7jWAg6lW5FO/ukpICUxslEeI.1/IbXf1TOh70Av54i', 'admin', '2024-07-31 22:13:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_no` (`id_no`);

--
-- Indexes for table `librarians`
--
ALTER TABLE `librarians`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `resource_number` (`resource_number`),
  ADD UNIQUE KEY `accession_no` (`accession_no`),
  ADD UNIQUE KEY `index_number` (`index_number`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `resource_id` (`resource_id`);

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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `librarians`
--
ALTER TABLE `librarians`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `resources`
--
ALTER TABLE `resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `librarians` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`resource_id`) REFERENCES `resources` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
