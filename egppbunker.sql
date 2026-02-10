-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 10, 2026 at 10:32 AM
-- Server version: 10.3.39-MariaDB-cll-lve
-- PHP Version: 8.1.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mitk3341_ebunker`
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
(43, 28, '007/BDR-GPP/IX/2024', 'By Bunker Service', 'Lanpan 16', '', '4,200', '857.8', '84.0', '0.080', '200.3', '25.437', '0.9891', '0.8479', '30', '6.293', '0.98421'),
(53, 43, '008/BDR-GPP/X/2024', 'By Bunker Service', 'RAWABI 99', '', '4.200', '857.8', '84.0', '0.080', '200.3', '25.437', '0.9891', '0.8479', '30.0', '6.293', '0.98421'),
(54, 46, '009/BDR-GPP/X/2024', 'By Bunker Service', 'RAWABI 99', '', '4.200', '857.8', '84.0', '0.080', '200.3', '21.198', '0.9891', '0.8479', '30.0', '6.293', '0.98421'),
(55, 47, '010/BDR-GPP/X/2024', 'By Bunker Service', 'RAWABI 99', '', '4.200', '857.8', '84.0', '0.080', '200.3', '21.198', '0.9891', '0.8479', '30.0', '6.293', '0.98421'),
(58, 55, '011/BDR-GPP/XII/2024', 'Truck', '', '', '4.200', '857.8', '84.0', '0.080', '200.3', '8.479', '0.9891', '0.8479', '30.0', '6.293', '0.98421'),
(59, 56, '012/BDR-GPP/XII/2024', 'Truck', '', '', '4.200', '857.8', '84.0', '0.080', '200.3', '8.479', '0.9891', '0.8479', '30.0', '6.293', '0.98421'),
(60, 63, '013/BDR-GPP/VI/2025', 'Truck', 'POE Giant 6', '', '4.200', '857.8', '84.0', '0.080', '200.3', '4.240', '0.9891', '0.8479', '30.0', '6.293', '0.98421'),
(62, 65, '014/BDR-GPP/VII/2025', 'By Bunker Service', 'TB Optimus 721', '', '4.200', '857.8', '84.0', '0.080', '200.3', '25.437', '0.9891', '0.8479', '30.0', '6.293', '0.98421'),
(63, 68, '015/BDR-GPP/VII/2025', 'By Bunker Service', '', '', '4.200', '857.8', '84.0', '0.080', '200.3', '84.790', '0.9891', '0.8479', '30.0', '6.293', '0.98421'),
(64, 69, '016/BDR-GPP/VII/2025', 'By Bunker Service', '', '', '4.200', '857.8', '84.0', '0.080', '200.3', '29.677', '0.9891', '0.8479', '30.0', '6.293', '0.98421'),
(65, 70, '017/BDR-GPP/VII/2025', 'By Bunker Service', '', '', '4.200', '857.8', '84.0', '0.080', '200.3', '29.677', '0.9891', '0.8479', '30.0', '6.293', '0.98421'),
(66, 73, '018/BDR-GPP/VIII/2025', 'Truck', 'TB Pioneer Conqueror', '', '4.200', '857.8', '84.0', '0.080', '200.3', '16.958', '0.9891', '0.8479', '30.0', '6.293', '0.98421'),
(67, 75, '019/BDR-GPP/X/2025', 'Truck', 'Pioneer Prestige', '', '4.200', '857.8', '84.0', '0.080', '200.3', '8.479', '0.9891', '0.8479', '30.0', '6.293', '0.98421'),
(68, 77, '020/BDR-GPP/X/2025', 'Truck', 'Pioneer Prestige', '', '4.200', '857.8', '84.0', '0.080', '200.3', '4.240', '0.9891', '0.8479', '30.0', '6.293', '0.98421'),
(69, 81, '021/BDR-GPP/I/2026', 'By Bunker Service', 'AWB Rajawali Miracle', '', '4.200', '857.8', '84.0', '0.080', '200.3', '38.156', '0.9891', '0.8479', '30.0', '6.293', '0.98421'),
(70, 82, '022/BDR-GPP/I/2026', 'By Bunker Service', 'AHTS ERA INDONESIA', '', '4.200', '857.8', '84.0', '0.080', '200.3', '211.975', '0.9891', '0.8479', '30.0', '6.293', '0.98421'),
(72, 83, '023/BDR-GPP/I/2026', 'SPOB Pandawa X', 'MV. Meratus Project Prima', '', '4.200', '857.8', '84.0', '0.080', '200.3', '279.807', '0.9891', '0.8479', '30.0', '6.293', '0.98421');

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

--
-- Dumping data for table `bunker_checklist`
--

INSERT INTO `bunker_checklist` (`id_checklist`, `do_id`, `port_of_supply`, `type_of_fuel`, `quantity_checklist`, `sender`, `receiver`, `date`, `time`) VALUES
(13, 43, 'Utraco - Batu Ampar', 'Biosolar', 30000, 'By Bunker Service', 'RAWABI 99', '', ''),
(14, 46, 'Utraco - Batu Ampar', 'Biosolar', 25000, 'By Bunker Service', 'RAWABI 99', '', ''),
(15, 47, 'Utraco - Batu Ampar', 'Biosolar', 25000, 'By Bunker Service', 'RAWABI 99', '', ''),
(18, 55, 'Sagulung', 'Biosolar', 10000, 'Truck', '', '', ''),
(20, 65, 'Telaga Punggur', 'Biosolar', 30000, 'By Bunker Service', 'TB Optimus 721', '', ''),
(21, 68, 'Tanjung Sauh', 'Biosolar', 30000, 'By Bunker Service', '', '', ''),
(22, 69, 'Tanjung Sauh', 'Biosolar', 35000, 'By Bunker Service', '', '', ''),
(23, 70, 'Tanjung Sauh', 'Biosolar', 35000, 'By Bunker Service', '', '', '');

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
(11, 'PT UNITED SHIPPING INDONESIA', 'Ruko Satelit Town Square Blok A-09 dan A-10 Jl. Raya Sukomanunggal Jaya, Kota Surabaya, Jawa Timur - 60181'),
(12, 'PT Saipem Indonesia, Karimun Branch', 'Jl. Raja Haji Fisabilillah, RT 001/RW 004, Desa Pangke, Kec. Meral, Kab. Karimun, Kepulauan Riau, Indonesia #29664'),
(13, 'PT WEELIM INDO PERKASA', 'Graphika Commercial Park Blok B1 No. 1, Jl. Bakal, Taman Baloi, Batam Kota'),
(14, 'PT Pioneer Offshore Indo Raya', 'Jl. Sei Binti Sagulung, Sungai Binti, Kec. Sagulung, Kota Batam'),
(15, 'PT ANUGERAH PRIMA SAMUDERA', 'Komplek CBD Pluit Blok S No. 01, Jl. Raya Pluit Selatan Jakarta Utara 14440'),
(16, 'PT MAJU BERSAMA JAYA', 'Jl. Telaga Punggur RT 001 RW 001 - Batam'),
(17, 'PT TATAMULIA NUSANTARA INDAH', 'Jl. Rawa Gelam V, Kav. OR-3B, Kawasan Industri. Pulogadung. Jakarta 13930 - Indonesia'),
(18, 'PT Karimun Sembawang Shipyard', 'Teluk Pagi, Kel. Pasir Panjang, Kec. Meral Barat, Tanjung Balai Karimun - KEPRI'),
(19, 'PT Nara Tirta Abadi', 'Buana Central Park no. 17, Kibing, Kota Batam, Kepulauan Riau'),
(20, 'PT AMANCARE CITANESIA SAMUDERA', 'Jl. Pasir Putih Kawasan Wisata Ocarina Blok Antartika, WT 66 Rondane Mountains Batam Center'),
(21, 'PT TRI BATARA OIL', 'Jl. Diponegoro No. 17, RT. 009, RW.000, Berbas Pantai, Bontang Selatan, Kota Bontang, Kalimantan Timur');

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
(40, '301/PO/LAE/24', '034/DO-GPP/X/2024', NULL, 10, 'Biosolar', 'Truck', 1000, '', '', '', 'Batam', 'Tanjung Uncang', '', '', '', ''),
(43, '24709', '035/DO-GPP/X/2024', NULL, 8, 'Biosolar', 'By Bunker Service', 30000, '', '', '', 'Batam', 'Utraco - Batu Ampar', '', '', '', ''),
(44, 'PO 048/USI/GPP001/10/24', '036/DO-GPP/X/2024', '2024-10-06', 11, 'Biosolar', 'Truck', 32000, '', '', '', 'Batam', 'Batu Ampar', '', '', '', ''),
(45, 'PO 050/USI/GPP001/10/24', '037/DO-GPP/X/2024', '2024-10-08', 11, 'Biosolar', 'By Bunker Service', 95000, '', '', '', 'Jakarta', 'Banten', '', '', '', ''),
(46, '24740', '038/DO-GPP/X/2024', NULL, 8, 'Biosolar', 'By Bunker Service', 25000, '', '', '', 'Batam', 'Utraco - Batu Ampar', '', '', '', ''),
(47, '24745', '039/DO-GPP/X/2024', NULL, 8, 'Biosolar', 'By Bunker Service', 25000, '', '', '', 'Batam', 'Utraco - Batu Ampar', '', '', '', ''),
(48, '308/PO/LAE/24', '040/DO-GPP/X/2024', NULL, 10, 'Biosolar', 'Truck', 1000, '', '', '', 'Batam', 'Tanjung Uncang', '', '', '', ''),
(50, 'WIP/PO.2024/0194', '041/DO-GPP/XI/2024', NULL, 13, 'Biosolar B35', 'Truck', 400, '', '', '', 'Batam', 'Sei. Panas', '', '', '', ''),
(51, '379/PO/LAE/24', '042/DO-GPP/XI/2024', NULL, 10, 'Biosolar', 'Truck', 1000, '', '', '', 'Batam', 'Tanjung Uncang', '', '', '', ''),
(53, '411/PO/LAE/24', '043/DO-GPP/XII/2024', NULL, 10, 'Biosolar', 'Truck', 1000, '', '', '', 'Batam', 'Tanjung Uncang', '', '', '', ''),
(54, '', '044/DO-GPP/XII/2024', NULL, 8, 'Biosolar', 'Truck', 1000, '', '', '', 'Batam', 'Utraco - Batu Ampar', '', '', '', ''),
(55, '00002391', '045/DO-GPP/XII/2024', NULL, 14, 'Biosolar', 'Truck', 10000, '', '', '', 'Batam', 'Sagulung', '', '', '', ''),
(56, '00002397', '046/DO-GPP/XII/2024', NULL, 14, 'Biosolar', 'Truck', 10000, '', '', '', 'Batam', 'Sagulung', '', '', '', ''),
(57, '420/PO/LAE/24', '047/DO-GPP/XII/2024', NULL, 10, 'Biosolar', 'Truck', 1000, '', '', '', 'Batam', 'Tanjung Uncang', '', '', '', ''),
(58, '022/PO/LAE/25', '048/DO-GPP/I/2025', NULL, 10, 'Biosolar', 'Truck', 1000, '', '', '', 'Batam', 'Tanjung Uncang', '', '', '', ''),
(59, '049/PO/LAE/25', '049/DO-GPP/II/2025', NULL, 10, 'Biosolar', 'Truck', 1000, '', '', '', 'Batam', 'Tanjung Uncang', '', '', '', ''),
(60, '00002425', '050/DO-GPP/II/2025', NULL, 14, 'Biosolar', 'Truck', 10000, '', '', '', 'Batam', 'Sagulung', '', '', '', ''),
(61, 'WIP/PO.2025/0054', '051/DO-GPP/IV/2025', NULL, 13, 'Biosolar', 'Truck', 1000, '', '', '', 'Batam', 'Sei. Panas', '', '', '', ''),
(62, 'LIM/PO.2025/0106', '052/DO-GPP/IV/2025', NULL, 9, 'Biosolar', 'Truck', 1000, '', '', '', 'Batam', 'Sei. Panas', '', '', '', ''),
(63, '00002507', '053/DO-GPP/VI/2025', NULL, 14, 'Biosolar', 'Truck', 5000, '', '', '', 'Batam', 'Sagulung', '', '', '', ''),
(64, 'WIP/PO.2025/0107', '054/DO-GPP/VI/2025', NULL, 13, 'Biosolar', 'Truck', 1000, '', '', '', 'Batam', 'Taman Baloi', '', '', '', ''),
(65, '008/PO-APS/VII/2025', '055/DO-GPP/VII/2025', NULL, 15, 'Biosolar', 'By Bunker Service', 30000, '', '', '', 'Batam', 'Telaga Punggur', '', '', '', ''),
(66, 'MBJ/PO/VII/2025/124', '056/DO-GPP/VII/2025', NULL, 16, 'Biosolar', 'Truck', 5000, '', '', '', 'Batam', 'Punggur', '', '', '', ''),
(67, 'LIM/PO.2025/0165', '057/DO-GPP/VII/2025', NULL, 9, 'Biosolar', 'Truck', 1000, '', '', '', 'Batam', 'Sei. Panas', '', '', '', ''),
(68, 'PO/25/0000427', '058/DO-GPP/VII/2025', NULL, 17, 'Biosolar', 'By Bunker Service', 30000, '', '', '', 'Batam', 'Tanjung Sauh', '', '', '', ''),
(69, 'PO/25/0000427', '059/DO-GPP/VII/2025', NULL, 17, 'Biosolar', 'By Bunker Service', 35000, '', '', '', 'Batam', 'Tanjung Sauh', '', '', '', ''),
(70, 'PO/25/0000427', '060/DO-GPP/VII/2025', NULL, 17, 'Biosolar', 'By Bunker Service', 35000, '', '', '', 'Batam', 'Tanjung Sauh', '', '', '', ''),
(72, '', '062/DO-GPP/VIII/2025', NULL, 13, 'Biosolar', 'Truck', 600, '', '', '', 'Batam', 'Batam Center', '', '', '', ''),
(73, '00002581', '063/DO-GPP/VIII/2025', NULL, 14, 'Biosolar', 'Truck', 20000, '', '', '', 'Batam', 'Sagulung', '', '', '', ''),
(74, '', '064/DO-GPP/IX/2025', NULL, 19, 'Biosolar', 'Truck', 200, '', '', '', 'Batam', 'Bandara', '', '', '', ''),
(75, '00002606', '065/DO-GPP/IX/2025', NULL, 14, 'Biosolar', 'Truck', 10000, '', '', '', 'Batam', 'Sagulung', '', '', '', ''),
(76, '00002605', '066/DO-GPP/IX/2025', NULL, 14, 'Biosolar', 'Truck', 15000, '', '', '', 'Batam', 'Sagulung', '', '', '', ''),
(77, '00002625', '067/DO-GPP/X/2025', NULL, 14, 'Biosolar', 'Truck', 5000, '', '', '', 'Batam', 'Sagulung', '', '', '', ''),
(78, '00002628', '068/DO-GPP/XI/2025', NULL, 14, 'Biosolar', 'Truck', 10000, '', '', '', 'Batam', 'Sagulung', '', '', '', ''),
(79, '024/PO-APS/XII/2025', '069/DO-GPP/XII/2025', NULL, 15, 'Biosolar', 'By Bunker Service', 16000, '', '', '', 'Bintan', 'Kijang', '', '', '', ''),
(80, '00002657', '070/DO-GPP/XII/2025', NULL, 14, 'Biosolar', 'Truck', 10000, '', '', '', 'Batam', 'Sagulung', '', '', '', ''),
(81, 'PO/ACS/001/GPP/2026', '071/DO-GPP/I/2026', NULL, 20, 'Biosolar', 'By Bunker Service', 45000, '', '', '', 'Batam', 'Batu Ampar', '', '', '', ''),
(82, 'PO/ACS/002/GPP/2026', '072/DO-GPP/I/2026', NULL, 20, 'Biosolar', 'By Bunker Service', 250000, '', '', '', 'Batam', 'Batu Ampar', '', '', '', ''),
(83, '001/PO/TBO-BTG/I/2026', '073/DO-GPP/I/2026', NULL, 21, 'Biosolar', 'SPOB Pandawa X', 250000, '', '', '', 'Kalimantan', 'Pelabuhan Loktuan, Bontang.', '', '', '', ''),
(84, '00002710', '074/DO-GPP/II/2026', NULL, 14, 'Biosolar', 'Truck', 10000, '', '', '', 'Batam', 'Sagulung', '', '', '', '');

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

--
-- Dumping data for table `sample_receipt`
--

INSERT INTO `sample_receipt` (`id_sample`, `do_id`, `truck_or_vessel`, `cargo`, `port`) VALUES
(10, 43, 'By Bunker Service', 'Biosolar', 'Utraco - Batu Ampar'),
(11, 46, 'By Bunker Service', 'Biosolar', 'Utraco - Batu Ampar'),
(12, 47, 'By Bunker Service', 'Biosolar', 'Utraco - Batu Ampar'),
(14, 55, 'Truck', 'Biosolar', 'Sagulung'),
(16, 65, 'By Bunker Service', 'Biosolar', 'Telaga Punggur'),
(17, 68, 'By Bunker Service', 'Biosolar', 'Tanjung Sauh'),
(18, 69, 'By Bunker Service', 'Biosolar', 'Tanjung Sauh'),
(19, 70, 'By Bunker Service', 'Biosolar', 'Tanjung Sauh');

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
(1, 'Muhammad Mabrur Al Mutaqi', 'mabrur@globalpetro.co.id', '$2y$10$.iSVGTJ48YrGtBCPjze2mePVpHPlspsERqDUIgi9cxit/AJyKhN9u', 1),
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
  MODIFY `id_bdr` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `bunker_checklist`
--
ALTER TABLE `bunker_checklist`
  MODIFY `id_checklist` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id_customer` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `delivery_order`
--
ALTER TABLE `delivery_order`
  MODIFY `id_do` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `sample_receipt`
--
ALTER TABLE `sample_receipt`
  MODIFY `id_sample` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
