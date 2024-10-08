-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 08, 2024 at 06:18 AM
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
  `vessel_cust` varchar(60) DEFAULT NULL,
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

--
-- Dumping data for table `bdr`
--

INSERT INTO `bdr` (`id_bdr`, `do_id`, `bdr_no`, `delivered_by`, `vessel_cust`, `next_port`, `visc`, `density`, `flashpoint`, `sulphur`, `water_content`, `net_metric_ton`, `vcf`, `wcf`, `temp`, `table_52`, `table_1`) VALUES
(43, 28, '007/BDR-GPP/IX/2024', 'By Bunker Service', 'Lanpan 16', '', '4,200', '857.8', '84.0', '0.080', '200.3', '25.437', '0.9891', '0.8479', '30', '6.293', '0.98421');

-- --------------------------------------------------------

--
-- Table structure for table `bunker_checklist`
--

CREATE TABLE `bunker_checklist` (
  `id_checklist` int(10) NOT NULL,
  `do_id` int(10) NOT NULL,
  `port_of_supply` varchar(255) NOT NULL,
  `type_of_fuel` varchar(255) NOT NULL,
  `quantity_checklist` bigint(15) NOT NULL,
  `sender` varchar(100) DEFAULT NULL,
  `receiver` varchar(100) DEFAULT NULL,
  `date` varchar(50) DEFAULT NULL,
  `time` varchar(50) DEFAULT NULL
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
(5, 'PT NUSA HALMAHERA MINERAL ', 'Jl. Pluit Utara Raya No. 53 RT10 RW05 Jakarta Utara, Jl. Pluit Utara Raya No. 53 RT10 RW05 Jakarta Utara'),
(7, 'PT CIWI SEMPURNA BETON', 'Jl. Raya Barelang KM. 02 Tembesi'),
(8, 'PT SEASCAPE SURVEYS INDONESIA', 'The Manhattan Square-Mid Tower Lt. 7, Unit Jl. TB Simatupang Kav. 1S - Jakarta Selatan'),
(9, 'PT Lubricant Indo Makmur', 'Komp. Rezeki Graha Mas Blok H2, No. 09 Sei. Panas - Batam'),
(10, 'PT L A ENGINEERING', 'Kawasan Industri Shipyard Kel. Tanjung Uncang Kec. Batu Aji - Batam'),
(11, 'PT UNITED SHIPPING INDONESIA', 'Ruko Satelit Town Square Blok A-09 dan A-10 Jl. Raya Sukomanunggal Jaya, Kota Surabaya, Jawa Timur - 60181');

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
(24, '24/PO-CSB/IX/006', '025/DO-GPP/IX/2024', NULL, 7, 'Biosolar', 'Truck', 10000, '', '', '', 'Batam', 'Trans Barelang', '', '', '', ''),
(25, '', '026/DO-GPP/IX/2024', NULL, 8, 'Biosolar', 'By Bunker Service', 50000, '', '', '', 'Batam', 'Utraco - Batu Ampar', '', '', '', ''),
(26, 'LIM/PO.2024/0240', '027/DO-GPP/IX/2024', NULL, 9, 'Biosolar', 'Truck', 1000, '', '', '', 'Batam', 'Sei. Panas', '', '', '', ''),
(27, '280/PO/LAE/24', '028/DO-GPP/IX/2024', NULL, 10, 'Biosolar', 'Truck', 1000, '', '', '', 'Batam', 'Tanjung Uncang', '', '', '', ''),
(28, '24637', '029/DO-GPP/IX/2024', NULL, 8, 'Biosolar', 'By Bunker Service', 30000, '', '', '', 'Batam', 'Utraco - Batu Ampar', '', '', '', ''),
(29, 'PO 053/USI/GPP001/09/24', '030/DO-GPP/X/2024', '2024-09-26', 11, 'Biosolar', 'KN Pulau Nipah 321', 70000, '', '', '', 'Depo Pertamina', 'Dermaga Jakarta', '', '', '', ''),
(30, 'PO 056/USI/GPP001/09/24', '031/DO-GPP/X/2024', '2024-09-26', 11, 'Biosolar', 'KN Belut Laut 406', 14000, '', '', '', 'Depo Pertamina', 'Dermaga Sekupang', '', '', '', ''),
(31, 'PO 057/USI/GPP001/09/24', '032/DO-GPP/X/2024', '2024-09-28', 11, 'Biosolar', 'KN Pulau Dana 323', 100000, '', '', '', 'Depo Pertamina', 'Dermaga Jakarta', '', '', '', ''),
(39, 'PO 013/USI/GPP001/10/24', '033/DO-GPP/X/2024', '2024-10-03', 11, 'Biosolar', 'Truck', 128000, '', '', '', 'Batam', 'Batu Ampar', '', '', '', ''),
(40, '301/PO/LAE/24', '034/DO-GPP/X/2024', NULL, 10, 'Biosolar', 'Truck', 1000, '', '', '', 'Batam', 'Tanjung Uncang', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `sample_receipt`
--

CREATE TABLE `sample_receipt` (
  `id_sample` int(10) NOT NULL,
  `do_id` int(10) NOT NULL,
  `truck_or_vessel` varchar(100) DEFAULT NULL,
  `cargo` varchar(100) NOT NULL,
  `port` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(4, 'Raden Sulaiman Sanjeev', 'sanjeev@globalpetro.co.id', '$2y$10$EmdDmw7rFi4IY0DOWDW6xuEklwJKUOtn9cqFLKP6S1tjcH9JAkGDa', 0),
(6, 'Regina Linda Lintang', 'regina@globalpetro.co.id', '$2y$10$yyEZ1hGAevZQRo6zZ8pEXui1hIq6y9QdC6oMiXNDiXM4Q3UNKwNQ.', 0);

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
-- Indexes for table `bunker_checklist`
--
ALTER TABLE `bunker_checklist`
  ADD PRIMARY KEY (`id_checklist`),
  ADD KEY `do_id` (`do_id`);

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
-- Indexes for table `sample_receipt`
--
ALTER TABLE `sample_receipt`
  ADD PRIMARY KEY (`id_sample`),
  ADD KEY `do_id` (`do_id`);

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
  MODIFY `id_bdr` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `bunker_checklist`
--
ALTER TABLE `bunker_checklist`
  MODIFY `id_checklist` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id_customer` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `delivery_order`
--
ALTER TABLE `delivery_order`
  MODIFY `id_do` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `sample_receipt`
--
ALTER TABLE `sample_receipt`
  MODIFY `id_sample` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bdr`
--
ALTER TABLE `bdr`
  ADD CONSTRAINT `bdr_ibfk_1` FOREIGN KEY (`do_id`) REFERENCES `delivery_order` (`id_do`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bunker_checklist`
--
ALTER TABLE `bunker_checklist`
  ADD CONSTRAINT `bunker_checklist_ibfk_1` FOREIGN KEY (`do_id`) REFERENCES `delivery_order` (`id_do`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `delivery_order`
--
ALTER TABLE `delivery_order`
  ADD CONSTRAINT `delivery_order_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id_customer`);

--
-- Constraints for table `sample_receipt`
--
ALTER TABLE `sample_receipt`
  ADD CONSTRAINT `sample_receipt_ibfk_1` FOREIGN KEY (`do_id`) REFERENCES `delivery_order` (`id_do`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
