-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 02, 2024 at 06:44 AM
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
-- Table structure for table `bdr`
--

CREATE TABLE `bdr` (
  `id_bdr` int(10) NOT NULL,
  `do_id` int(10) NOT NULL,
  `bdr_no` varchar(50) NOT NULL,
  `delivered_by` varchar(50) DEFAULT NULL,
  `vessel_cust` varchar(60) NOT NULL,
  `next_port` varchar(60) DEFAULT NULL,
  `visc` varchar(10) NOT NULL,
  `density` varchar(10) NOT NULL,
  `flashpoint` varchar(10) NOT NULL,
  `sulphur` varchar(10) NOT NULL,
  `water_content` varchar(10) NOT NULL,
  `net_metric_ton` varchar(15) NOT NULL,
  `vcf` varchar(10) NOT NULL,
  `wcf` varchar(10) NOT NULL,
  `temp` varchar(10) NOT NULL,
  `table_52` varchar(10) NOT NULL,
  `table_1` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(4, 'PT MITO INDONESIA', 'Komp. The Centro Town House No. 20, Sukajadi'),
(5, 'PT NUSA HALMAHERA MINERAL ', 'Jl. Pluit Utara Raya No. 53 RT10 RW05 Jakarta Utara, Jl. Pluit Utara Raya No. 53 RT10 RW05 Jakarta Utara'),
(6, 'PT CITRA MARITIM', 'Sungai Panas, Batam Center');

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
  `quantity` bigint(15) NOT NULL,
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
(23, '45000800', '001/DO-GPP/IX/2024', NULL, 5, 'Pertadex', 'TB Hary 02 & OB Hubmar 03', 1000000, '', '', '', 'Batam', 'Jakarta', '', '', '', '');

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
-- Indexes for table `bdr`
--
ALTER TABLE `bdr`
  ADD PRIMARY KEY (`id_bdr`),
  ADD UNIQUE KEY `bdr_no` (`bdr_no`),
  ADD KEY `bdr_ibfk_1` (`do_id`);

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
  ADD KEY `delivery_order_ibfk_1` (`customer_id`);

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
-- AUTO_INCREMENT for table `bdr`
--
ALTER TABLE `bdr`
  MODIFY `id_bdr` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id_customer` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `delivery_order`
--
ALTER TABLE `delivery_order`
  MODIFY `id_do` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bdr`
--
ALTER TABLE `bdr`
  ADD CONSTRAINT `bdr_ibfk_1` FOREIGN KEY (`do_id`) REFERENCES `delivery_order` (`id_do`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `delivery_order`
--
ALTER TABLE `delivery_order`
  ADD CONSTRAINT `delivery_order_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id_customer`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
