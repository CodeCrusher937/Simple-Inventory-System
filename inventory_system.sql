-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2026 at 09:54 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `buying_price` decimal(10,2) NOT NULL,
  `selling_price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `product_image`, `buying_price`, `selling_price`, `quantity`, `description`, `created_at`) VALUES
(1, 'Dell Vostro 3910', NULL, 300000.00, 800000.00, 12, '8th gen', '0000-00-00 00:00:00'),
(2, 'Dell Laptop Core i7', NULL, 1100000.00, 1350000.00, 3, 'Dell laptop with Intel Core i7 processor', '2026-09-29 09:30:39'),
(3, 'Desktop PC Core i5', NULL, 750000.00, 950000.00, 7, 'Desktop computer with Intel Core i5 processor', '2026-09-29 07:43:33'),
(4, 'HP Monitor 24 inch', NULL, 280000.00, 350000.00, 8, '24 inch HP LED monitor', '2026-09-29 07:43:33'),
(5, 'Mechanical Keyboard', NULL, 80000.00, 120000.00, 10, 'USB mechanical gaming keyboard', '2026-09-29 07:43:33'),
(6, 'Wireless Mouse', NULL, 25000.00, 40000.00, 20, 'Wireless optical computer mouse', '2026-09-29 07:43:33'),
(7, '8GB DDR4 RAM', NULL, 70000.00, 100000.00, 15, '8GB DDR4 desktop memory module', '2026-09-29 07:43:33'),
(8, '512GB SSD', NULL, 120000.00, 170000.00, 10, '512GB solid state drive for computer storage', '2026-09-29 07:43:33'),
(9, '1TB HDD', NULL, 90000.00, 130000.00, 7, '1TB hard disk drive for computer storage', '2026-09-29 07:43:33'),
(12, 'HP PROBOOK', '1790846528_download (4).jpg', 729000.00, 900000.00, 8, 'This Is HP ProBook Core i5 with 256-SSD AND 8-RAM.', '2026-10-01 09:22:08'),
(13, 'HP PROBOOK', '1790846568_download (4).jpg', 729000.00, 900000.00, 4, 'This Is HP ProBook Core i5 with 256-SSD AND 8-RAM.', '2026-10-01 09:22:48'),
(14, 'HP EliteBook', '1790857793_download (4).jpg', 500000.00, 700000.00, 3, '11th Gen ram 8', '2026-10-01 12:29:53'),
(15, 'Gwagons', '1790858905_Mercedes G wagon.jpg', 99999999.99, 99999999.99, 25, 'money determine the quality!', '2026-10-01 12:48:25');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_revenue` decimal(10,2) NOT NULL DEFAULT 0.00,
  `sale_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `user_id`, `total_amount`, `total_revenue`, `sale_date`) VALUES
(1, 3, 3600000.00, 684000.00, '2026-10-01 14:27:13');

-- --------------------------------------------------------

--
-- Table structure for table `sale_items`
--

CREATE TABLE `sale_items` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `buying_price` decimal(10,2) NOT NULL,
  `selling_price` decimal(10,2) NOT NULL,
  `revenue` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sale_items`
--

INSERT INTO `sale_items` (`id`, `sale_id`, `product_id`, `quantity`, `buying_price`, `selling_price`, `revenue`) VALUES
(6, 1, 13, 4, 729000.00, 900000.00, 684000.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','customer') NOT NULL DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `phone`) VALUES
(1, 'Toni Njemet', 'codecrusher4@gmail.com', '06e329aa1414fae7e6fb03388aee7b8a30e53229', 'customer', '2026-09-28 09:53:08', '255629832546'),
(2, 'Admin', 'admin@gmail.com', 'a29c57c6894dee6e8251510d58c07078ee3f49bf', 'admin', '2026-09-28 12:10:13', '255629832546'),
(3, 'Sharifa Rajabu', 'sharifa@gmail.com', '0cf006fd13dc9d12a56448ffbe6d63d7bda49ee6', 'customer', '2026-09-28 12:25:32', '255682435647'),
(4, 'Salih Saleh', 'salih@gmail.com', '8833bd83c1a432932c45feb782ebdf5b6a9bc4a8', 'customer', '2026-10-01 12:44:24', '255623446007'),
(5, 'Code Crusher', 'crusher123@gmail.com', '9e4ecc9afd58be00d016a2c34ece063828d1c935', 'customer', '2026-10-01 14:12:18', '255798797961'),
(6, 'Rafia Noel', 'rafiah@gmail.com', 'a9fa606d262af1c2ea7179dcb6309da96e2b5e49', 'customer', '2026-10-02 05:30:07', '0623885431');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD CONSTRAINT `sale_items_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`),
  ADD CONSTRAINT `sale_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
