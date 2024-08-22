-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 22, 2024 at 12:46 PM
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
-- Database: `egppbunker`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id_customer` int(10) NOT NULL,
  `customer_name` varchar(60) NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id_customer`, `customer_name`, `address`) VALUES
(1, 'PT HANSWAY INDONESIA', 'Jl. Duyung, Komp. Citra Super Mall Blok B No. 5-6 Harbour Bay - Batu Ampar, Batam 29432 Indonesia'),
(2, 'PT MITO INDONESIA', 'Jl. Pegangsaan Timur No. 56, Jakarta Timur');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_order`
--

CREATE TABLE `delivery_order` (
  `id_do` int(10) NOT NULL,
  `po_number` varchar(50) DEFAULT NULL,
  `do_number` varchar(50) NOT NULL,
  `do_date` date DEFAULT NULL,
  `customer_id` int(10) NOT NULL,
  `product` varchar(60) NOT NULL,
  `armada` varchar(60) NOT NULL,
  `quantity` varchar(12) NOT NULL,
  `driver` varchar(50) DEFAULT NULL,
  `departure_time` varchar(30) DEFAULT NULL,
  `arrival_time` varchar(30) DEFAULT NULL,
  `loading_port` varchar(50) NOT NULL,
  `discharging_port` varchar(50) NOT NULL,
  `commence_pump` varchar(30) DEFAULT NULL,
  `finished_pump` varchar(30) DEFAULT NULL,
  `seal_number1` varchar(30) DEFAULT NULL,
  `seal_number2` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_order`
--

INSERT INTO `delivery_order` (`id_do`, `po_number`, `do_number`, `do_date`, `customer_id`, `product`, `armada`, `quantity`, `driver`, `departure_time`, `arrival_time`, `loading_port`, `discharging_port`, `commence_pump`, `finished_pump`, `seal_number1`, `seal_number2`) VALUES
(6, '001/PO-GPP-2024', '001/DO-GPP/VIII/2024', '2024-08-22', 1, 'Biosolar', 'TK Selaras 01', '2.000.000', '', '', '', 'Batam', 'Port B', '', '', '', ''),
(7, '002/PO-GPP-2024', '002/DO-GPP/VIII/2024', NULL, 1, 'Pertadex', 'TB. Tiga Permata', '1000', '', '', '', 'Port A', 'Port B', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama`, `email`, `password`, `is_admin`) VALUES
(1, 'Muhammad Mabrur Al Mutaqi', 'mabrur@globalpetro.co.id', '$2y$10$6nanbsAnc5UF34AuObTtU.twKhccYkHVdyYj9.Ziu3qY60Mn9Nc.m', 1),
(3, 'Niken Binti Masitoh', 'niken@globalpetro.co.id', '$2y$10$RHbqewEh/ePFs42iL8mj0Ormo5vP4ACdVdrANOAgzZ9JhTAHDU2.e', 0),
(4, 'Raden Sulaiman Sanjeev', 'sanjeev@globalpetro.co.id', '$2y$10$EmdDmw7rFi4IY0DOWDW6xuEklwJKUOtn9cqFLKP6S1tjcH9JAkGDa', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id_customer`);

--
-- Indexes for table `delivery_order`
--
ALTER TABLE `delivery_order`
  ADD PRIMARY KEY (`id_do`),
  ADD UNIQUE KEY `po_number` (`po_number`,`do_number`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id_customer` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `delivery_order`
--
ALTER TABLE `delivery_order`
  MODIFY `id_do` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `delivery_order`
--
ALTER TABLE `delivery_order`
  ADD CONSTRAINT `delivery_order_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id_customer`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
