-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 26, 2024 at 07:48 AM
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
-- Database: `final`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `price` decimal(10,3) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `title`, `price`, `created_at`, `quantity`) VALUES
(24, 'Áo Hoodie Cho Chó Dễ Thương', 130.000, '2024-08-25 17:15:55', 1),
(25, 'Áo Hoodie Cho Chó Dễ Thương', 130.000, '2024-08-25 18:00:41', 1),
(26, 'Áo Hoodie Cho Chó Dễ Thương', 130.000, '2024-08-26 03:24:58', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `discount_price` decimal(10,2) DEFAULT NULL,
  `img` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `subtitle`, `description`, `price`, `discount_price`, `img`, `created_at`) VALUES
(1, 'Ba lô phi hành gia', NULL, 'Balo phi hành gia nhựa trong, balo vận chuyển cho chó mèo nhiều màu, chất liệu không gây độc hại.', 200000.00, 400000.00, 'assets/img/slide-3.png', '2024-08-23 09:31:00'),
(2, 'ROYAL CANIN Mini Puppy 800g', NULL, 'Thức ăn cho chó con, giàu dinh dưỡng và chất lượng.', 180000.00, 360000.00, 'assets/img/slide-2.png', '2024-08-23 09:31:00'),
(3, 'Royal canin kitten 36 - 1kg', NULL, 'Protein dễ hoà tan để tối đa hoá việc hấp thụ dinh dưỡng va đảm bảo cho mèo con có hệ tiêu hoá hoàn toàn khỏe mạnh.', 160000.00, 320000.00, 'assets/img/slide-1.png', '2024-08-23 09:31:00'),
(4, 'Áo Hoodie Cho Chó Dễ Thương', NULL, 'Áo hoodie dễ thương cho chó, chất liệu flannel.', 130000.00, 271000.00, 'assets/img/new-1.png', '2024-08-23 09:31:00'),
(5, 'Quần Áo Thú Cưng Polo Sọc', NULL, 'Quần áo polo sọc cho thú cưng, chất liệu cotton.', 125000.00, 250000.00, 'assets/img/new-2.png', '2024-08-23 09:31:00'),
(6, 'Áo Thú Cưng Ấm Áp Mùa Đông', NULL, 'Áo ấm áp cho thú cưng, chất liệu mềm mại.', 100000.00, 200000.00, 'assets/img/new-3.png', '2024-08-23 09:31:00'),
(7, 'Áo Thú Cưng Ấm Áp Mùa Đông', NULL, 'Áo ấm áp cho thú cưng, chất liệu mềm mại.', 100000.00, 200000.00, 'assets/img/new-4.png', '2024-08-23 09:31:00'),
(8, 'Áo Sơ Mi Cổ Tròn Khủng Long', NULL, 'Áo sơ mi dễ thương cho thú cưng, chất liệu cotton.', 75000.00, 150000.00, 'assets/img/new-5.png', '2024-08-23 09:31:00'),
(9, 'Áo Len Ấm Áp Dễ Thương', NULL, 'Áo len ấm áp cho thú cưng, chất liệu len.', 130000.00, 240000.00, 'assets/img/new-6.png', '2024-08-23 09:31:00'),
(10, 'Chuồng chó bằng nhôm', NULL, 'Chuồng chó bằng nhôm, bền và nhẹ.', 200000.00, 250000.00, 'assets/img/imghavebg/chuongcho1.jpg', '2024-08-23 09:31:00'),
(11, 'Chuồng chó ấm áp', NULL, 'Chuồng chó ấm áp cho mùa đông.', 180000.00, 220000.00, 'assets/img/imghavebg/chuongcho2.jpg', '2024-08-23 09:31:00'),
(12, 'Chuồng chó nghèo', NULL, 'Chuồng chó giá rẻ.', 5000.00, 10000.00, 'assets/img/imghavebg/chuongcho3.jpg', '2024-08-23 09:31:00'),
(13, 'Lồng sắt', NULL, 'Lồng sắt cho chó, chắc chắn và an toàn.', 7000.00, 28000.00, 'assets/img/imghavebg/chuongcho4.jpg', '2024-08-23 09:31:00'),
(14, 'Thức ăn hạt Dog Mania Premium', NULL, 'Thức ăn hạt Dog Mania Premium, dinh dưỡng đầy đủ cho chó.', 348000.00, 510000.00, 'assets/img/fooddog-1.png', '2024-08-23 09:31:00'),
(15, 'Đồ Ăn Cho Chó Vị Thịt Bò Và Rau Củ Pedigree (3Kg)', NULL, 'Đồ ăn cho chó vị thịt bò và rau củ, dinh dưỡng cân bằng.', 170000.00, 300000.00, 'assets/img/fooddog-2.png', '2024-08-23 09:31:00'),
(16, 'DOG MANIA Premium Puppy vị hỗn hợp', NULL, 'Thức ăn cho chó con DOG MANIA Premium vị hỗn hợp.', 120000.00, 220000.00, 'assets/img/fooddog-3.png', '2024-08-23 09:31:00'),
(17, 'LOFFE Kucing Backpack', NULL, 'Balo LOFFE Kucing, chất liệu nhựa bền đẹp.', 395000.00, 599000.00, 'assets/img/balo-1.png', '2024-08-23 09:31:00'),
(18, 'LOFFE Supreme', NULL, 'Balo LOFFE Supreme, chất liệu nhựa cao cấp.', 395000.00, 599000.00, 'assets/img/balo-2.png', '2024-08-23 09:31:00'),
(19, 'LeShang LS006', NULL, 'Balo LeShang LS006, chất liệu vải bền.', 150000.00, 200000.00, 'assets/img/balo-3.png', '2024-08-23 09:31:00'),
(20, 'Lược Chải Lông Cho Chó Mèo', NULL, 'Lược chải lông cho chó mèo, giúp lông mềm mượt.', 8000.00, 26000.00, 'assets/img/dochoi-1.png', '2024-08-23 09:31:00'),
(21, 'Đồ Chơi Banh Cao Su Cho Chó Mèo', NULL, 'Đồ chơi banh cao su, an toàn cho thú cưng.', 42000.00, 50000.00, 'assets/img/dochoi-2.png', '2024-08-23 09:31:00'),
(22, 'Giường Chó Mèo Zerti', NULL, 'Giường cho chó mèo Zerti, êm ái và thoải mái.', 266000.00, 380000.00, 'assets/img/dochoi-3.png', '2024-08-23 09:31:00'),
(23, 'Trò chơi thú cưng cho mèo ăn chậm và đồ chơi khay thức ăn cho chó', NULL, 'Trò chơi cho mèo và chó, giúp thú cưng ăn chậm lại.', 179000.00, 260000.00, 'assets/img/dochoi-4.png', '2024-08-23 09:31:00'),
(24, 'Whiskas Adult Ocean Fish', NULL, 'Thức ăn cho mèo Whiskas, vị cá đại dương.', 115000.00, 160000.00, 'assets/img/foodcat-1.png', '2024-08-23 09:31:00'),
(25, 'CATIDEA Fairy Chef British Shorthair', NULL, 'Thức ăn cho mèo CATIDEA, phù hợp với giống British Shorthair.', 200000.00, 315000.00, 'assets/img/foodcat-2.png', '2024-08-23 09:31:00'),
(26, 'CATIDEA Basic Meat Freeze Dried', NULL, 'Thức ăn thịt đông khô CATIDEA, dinh dưỡng cao.', 430000.00, 580000.00, 'assets/img/foodcat-3.png', '2024-08-23 09:31:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `email`) VALUES
(1, 'admin', '$2y$10$4z5p5FywlwACKXVQEeY6t.171Uq24gL5BVu9ahMurUpWaK84K4FPu', 'admin', 'admin@example.com'),
(2, 'phapdang', '$2y$10$894HFOLowYmcBK92QCMGI.n4y/aFh4D0BKKS8MjomO2sGfd/qrI8K', 'user', 'phapdang@example.com'),
(3, 'XuanDieu', '$2y$10$wRGeAnyfMBQFSF0ODEUEi.1zuNFrA8X0oQJg8/uY1g4jG7V4v77iq', 'user', 'XuanDieu@example.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
