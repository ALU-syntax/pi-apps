-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.3.10-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             9.5.0.5327
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for partsdb
DROP DATABASE IF EXISTS `partsdb`;
CREATE DATABASE IF NOT EXISTS `partsdb` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `partsdb`;

-- Dumping structure for table partsdb.is_part
DROP TABLE IF EXISTS `is_part`;
CREATE TABLE IF NOT EXISTS `is_part` (
  `kode_part` varchar(7) NOT NULL,
  `nama_part` varchar(60) NOT NULL,
  `group` varchar(15) NOT NULL DEFAULT '',
  `kategori` varchar(15) NOT NULL DEFAULT '',
  `satuan` varchar(20) NOT NULL,
  `stok` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_user` int(3) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_user` int(3) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`kode_part`),
  KEY `created_user` (`created_user`),
  KEY `updated_user` (`updated_user`),
  CONSTRAINT `is_part_ibfk_1` FOREIGN KEY (`created_user`) REFERENCES `is_users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `is_part_ibfk_2` FOREIGN KEY (`updated_user`) REFERENCES `is_users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table partsdb.is_part: ~232 rows (approximately)
DELETE FROM `is_part`;
/*!40000 ALTER TABLE `is_part` DISABLE KEYS */;
INSERT INTO `is_part` (`kode_part`, `nama_part`, `group`, `kategori`, `satuan`, `stok`, `created_user`, `created_date`, `updated_user`, `updated_date`) VALUES
	('B000001', 'AIR FILTER MAN C 24650/1', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 2.00, 3, '2017-04-01 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000002', 'AIR FILTER MITSUBISHI', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-04-02 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000003', 'AMPLAS CW 1000 "EAGLE"', 'Produksi\r\n', 'Moving\r\n', 'LBR\r\n', 3.00, 3, '2017-04-03 00:00:00', 3, '2018-11-07 08:55:24'),
	('B000004', 'AMPLAS CW 220 "EAGLE"\r\n', 'Produksi\r\n', 'Moving\r\n', 'LBR\r\n', 0.00, 3, '2017-04-04 00:00:00', 3, '2018-11-07 08:55:49'),
	('B000005', 'AMPLAS CW 500 "EAGLE"\r\n', 'Produksi\r\n', 'Moving\r\n', 'LBR\r\n', 0.00, 3, '2017-04-05 00:00:00', 3, '2018-11-07 08:56:02'),
	('B000006', 'AS 190 X 160 X 15 MHP 1554\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-04-06 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000007', 'AS ROLLER CONVEYOR 8 METER\r\n', 'Mek. Packing\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-04-07 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000008', 'AUXILIARY CONTACT BLOCK 3TX40\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 3.00, 3, '2017-04-08 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000009', 'BALL SOCKET 3EB - 24 - 21311\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-04-09 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000010', 'BALL TEFLON 1/2" 93100 - 4\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 2.00, 3, '2017-04-10 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000011', 'BALL TEFLON 90532 - 4\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 4.00, 3, '2017-04-11 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000012', 'BALL VALVE KUNINGAN KITZ 2"\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 3.00, 3, '2017-04-12 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000013', 'BALL VALVE SS KITZ 1 1/2"\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-04-13 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000014', 'BALLAST TL 36W PHILIPS\r\n', 'Elektrik', 'Slow Moving\r\n', 'PCS\r\n', 5.00, 3, '2017-04-14 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000015', 'BAN DALAM 600 - 9 BRIDGESTONE\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 2.00, 3, '2017-04-15 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000016', 'BAN PERUT 600 - 9 BRIDGESTONE\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 3.00, 3, '2017-04-16 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000017', 'BAND HEATER 1100W - 380V 250 X 40MM\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-04-17 00:00:00', 3, '2018-11-20 15:44:12'),
	('B000018', 'BAND HEATER 2000W - 220V 168 X 70MM\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-04-18 00:00:00', 3, '2018-11-20 15:44:12'),
	('B000019', 'BAND HEATER 550W - 380V 250 X 40MM\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-04-19 00:00:00', 3, '2018-11-20 15:44:12'),
	('B000020', 'BATERAI 9V KOTAK ENERGIZER\r\n', 'Produksi\r\n', 'Slow Moving\r\n', 'PCS\r\n', 0.00, 3, '2017-04-20 00:00:00', 3, '2018-11-07 09:11:24'),
	('B000021', 'BATEREI AAA ALKALINE\r\n', 'Produksi\r\n', 'Slow Moving\r\n', 'PCS\r\n', 0.00, 3, '2017-04-21 00:00:00', 3, '2018-11-07 09:11:35'),
	('B000022', 'BATU BATERAI ABC BESAR\r\n', 'Produksi\r\n', 'Slow Moving\r\n', 'SET\r\n', 0.00, 3, '2017-04-22 00:00:00', 3, '2018-11-07 09:13:20'),
	('B000023', 'BATU BATEREI AA ALKALINE\r\n', 'Produksi\r\n', 'Slow Moving\r\n', 'SET\r\n', 0.00, 3, '2017-04-23 00:00:00', 3, '2018-11-07 09:13:29'),
	('B000024', 'BATU GERINDA POTONG 4', 'Workshop', 'Moving', 'PCS', 13.00, 3, '2017-04-24 00:00:00', 1, '2018-11-20 15:40:58'),
	('B000025', 'BELT CONVEYOR RB 0411 - L UK : PJG : 5.065 X L : 230', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 10.00, 3, '2017-04-25 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000026', 'BELT TEFLON 750 X 15\r\n', 'Mek. Packing\r\n', 'Slow Moving\r\n', 'PCS\r\n', 10.00, 3, '2017-04-26 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000027', 'BLACK TTF RIBBON 33mM X 400M PN 3511\r\n', 'Produksi\r\n', 'Moving\r\n', 'ROLL', 5.00, 3, '2017-04-27 00:00:00', 3, '2018-11-20 18:44:23'),
	('B000028', 'BOHLAM LAMPU 7,2V\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS', 10.00, 3, '2017-04-28 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000029', 'BUSHING IRT 35 X 40 X 17\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS', 4.00, 3, '2017-04-29 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000030', 'CAGE BALL 93097 - 1\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS', 2.00, 3, '2017-04-30 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000031', 'CARBON BRUSH CONTINOUS SEAL \r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS', 4.00, 3, '2017-05-01 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000032', 'CARBON BRUSH MOTOR FILM\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS', 15.00, 3, '2017-05-02 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000033', 'CAT F-TALIT PERMANENT RED\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS', 2.00, 3, '2017-05-03 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000034', 'CAT F-TALIT RIVER BLUE\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS', 1.00, 3, '2017-05-04 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000035', 'CAT F-TALIT VITA CREAM\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS', 1.00, 3, '2017-05-05 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000036', 'CAT NIPPE 2000\r\n', 'Mek. Packing\r\n', 'Slow Moving\r\n', 'KLG\r\n', 1.00, 3, '2017-05-06 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000037', 'CEK VALVE UH 25189\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'SET\r\n', 5.00, 3, '2017-05-07 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000038', 'CHLORINE TABLET \r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-05-08 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000039', 'CLEANING SOLUTION V-901Q\r\n', 'Produksi\r\n', 'Moving\r\n', 'BTL', 9.00, 3, '2017-05-09 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000040', 'COMPR SPRING 1612 4048 00\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS', 1.00, 3, '2017-05-10 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000041', 'COMPR SPRING 1612 4049 00\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-05-11 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000042', 'DIAPHRAM BACK UP 92973 - B\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 4.00, 3, '2017-05-12 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000043', 'DIODA BAUT TYPE : 40HF40\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 3.00, 3, '2017-05-13 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000044', 'DIODA BAUT TYPE : 40HFR40\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 5.00, 3, '2017-05-14 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000045', 'DOP GALV 2"\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 4.00, 3, '2017-05-15 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000046', 'DOUBLE NEPPLE GALV 2"\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 4.00, 3, '2017-05-16 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000047', 'DOUBLE TAPE FOAM 2"\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 3.00, 3, '2017-05-17 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000048', 'ELBOW GALV 1 1/2"\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 2.00, 3, '2017-05-18 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000049', 'ELBOW GALV 2"\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 3.00, 3, '2017-05-19 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000050', 'ELBOW SS 1"\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 2.00, 3, '2017-05-20 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000051', 'END CUP PNEUMATIC KH\r\n', 'Mek. Packing\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-05-21 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000052', 'FILM FEED BELT \r\n', 'Mek. Packing\r\n', 'Slow Moving\r\n', 'PCS\r\n', 2.00, 3, '2017-05-22 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000053', 'FILTER 2901 - 0219 - 00\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-05-23 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000054', 'FILTER DRYER EK - 164\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-05-24 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000055', 'FILTER DRYER EK - 305\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 2.00, 3, '2017-05-25 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000056', 'FILTER ELEMENT 58X\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-05-26 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000057', 'FILTER ELEMENT 58Z\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 2.00, 3, '2017-05-27 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000058', 'FLEXIBLE HOSE 0574 - 9919 - 01\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-05-28 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000059', 'FLEXIBLE HOSE 0575 1205 11\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-05-29 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000060', 'FLEXIBLE HOSE 0575 1216 62\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-05-30 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000061', 'FLEXIBLE HOSE 571244 - 50', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-05-31 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000062', 'FREON R 32\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'TBG\r\n', 1.00, 3, '2017-06-01 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000063', 'FREON R 404A\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'TBG\r\n', 1.00, 3, '2017-06-02 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000064', 'FREON R 407\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'TBG\r\n', 1.00, 3, '2017-06-03 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000065', 'FUEL FILTER WDK 725\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 2.00, 3, '2017-06-04 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000066', 'FUSE KACA 10A M6 X 30\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 5.00, 3, '2017-06-05 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000067', 'FUSE KERAMIK 10A M6 X 30\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 6.00, 3, '2017-06-06 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000068', 'FUSE KERAMIK 25A M6 X 25\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 3.00, 3, '2017-06-07 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000069', 'FUSE KERAMIK 4A M6 X 30\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-06-08 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000070', 'FUSE KERAMIK 5A M5 X 20\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-06-09 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000071', 'FUSE KERAMIK AC 40 AGG M14 X 51\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 7.00, 3, '2017-06-10 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000072', 'FUSE SIBA 630A - 500V\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 3.00, 3, '2017-06-11 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000073', 'GATE VALVE SPIRAX SARCO PN 25\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 2.00, 3, '2017-06-12 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000074', 'GATE VALVE SPIRAX SARCO PN 40\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-06-13 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000075', 'GLAND PACKING TEFLON 8 X 8\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'KG\r\n', 5.00, 3, '2017-06-14 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000076', 'GREASE ALMASOL 1250\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'TUBE\r\n', 2.00, 3, '2017-06-15 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000077', 'HANDLE MC KODING KIONG HO\r\n', 'Mek. Packing\r\n', 'Slow Moving\r\n', 'PCS\r\n', 15.00, 3, '2017-06-16 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000078', 'HARDENER NIPPE 2000\r\n', 'Mek. Packing\r\n', 'Slow Moving\r\n', 'KLG\r\n', 2.00, 3, '2017-06-17 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000079', 'HEATER CATRIDGE 1000W - 220V Ø 12 X 400MM\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS', 3.00, 3, '2017-06-18 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000080', 'HEATER CATRIDGE 100W - 230V Ø 6.5 X 60MM\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 3.00, 3, '2017-06-19 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000081', 'HEATER CATRIDGE 200W - 220V Ø 10 X 270MM\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 4.00, 3, '2017-06-20 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000082', 'HEATER CATRIDGE 200W - 220V Ø 12 X 100MM\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 2.00, 3, '2017-06-21 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000083', 'HEATER CATRIDGE 200W - 220V Ø 8 X 140MM\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-06-22 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000084', 'HEATER CATRIDGE 600W - 220V Ø 9,5 X 220MM\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 4.00, 3, '2017-06-23 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000085', 'HEATER CATRIDGE 60W - 220V Ø 12 X 35MM\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 2.00, 3, '2017-06-24 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000086', 'HEATER CATRIDGE Ø 8 X 280MM\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 6.00, 3, '2017-06-25 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000087', 'HEATER IMMERSION 9KW - 380V, FLANGE DRAT : 2", PJG : 40CM\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 2.00, 3, '2017-06-26 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000088', 'HEATER IMMERSION LLOVERAS 9KW - 415V\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-06-27 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000089', 'HEATER STRIP 170W - 110V Ø 210 X 20MM\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 5.00, 3, '2017-06-28 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000090', 'HOSING MARSH UNICORN\r\n', 'Mek. Packing\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-06-29 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000091', 'HOT MELT ADHESIVE CX-G 616', 'Produksi\r\n', 'Moving\r\n', ' KG', 100.00, 3, '2017-06-30 00:00:00', 3, '2018-11-07 10:19:13'),
	('B000092', 'INK HITACHI 1072 K\r\n', 'Produksi\r\n', 'Moving\r\n', 'PCS\r\n', 0.00, 3, '2017-07-01 00:00:00', 3, '2018-11-07 10:19:26'),
	('B000093', 'INK V - 411 - D\r\n', 'Produksi\r\n', 'Moving\r\n', 'PCS\r\n', 0.00, 3, '2017-07-02 00:00:00', 3, '2018-11-07 10:19:36'),
	('B000094', 'INK VIDEO JET 16 - 8530 Q\r\n', 'Produksi\r\n', 'Moving\r\n', 'PCS\r\n', 0.00, 3, '2017-07-03 00:00:00', 3, '2018-11-07 10:19:46'),
	('B000095', 'KAPASITOR 0,47 MF 250V\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 9.00, 3, '2017-07-04 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000096', 'KAPASITOR 1,5 MF 400V\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 4.00, 3, '2017-07-05 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000097', 'KAPASITOR 1,8 MF 400V\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 3.00, 3, '2017-07-06 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000098', 'KAPASITOR CBB65 45UF\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-07-07 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000099', 'KARBON PLAT VACCUM HASSIA 4 X 39 X 95\r\n', 'Mek. Packing\r\n', 'Slow Moving\r\n', 'PCS\r\n', 12.00, 3, '2017-07-08 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000100', 'KARET NOZZLE VACUM\r\n', 'Produksi\r\n', 'Moving\r\n', 'SET', 0.00, 3, '2017-07-09 00:00:00', 3, '2018-11-07 10:21:17'),
	('B000101', 'KLAKSON COMPACT 12V\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 2.00, 3, '2017-07-10 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000102', 'KONDENSOR 39110 - 01120\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 3.00, 3, '2017-07-11 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000103', 'KONTACTOR 35810 - 05590\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-07-12 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000104', 'KONTACTOR 35810 - 05650\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-07-13 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000105', 'KRYTOX CORRUGATOR 226 FG\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 2.00, 3, '2017-07-14 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000106', 'MAKE UP INK  TH - TYPE A\r\n', 'Produksi\r\n', 'Moving\r\n', 'LTR', 6.00, 3, '2017-07-15 00:00:00', 3, '2018-11-07 10:30:28'),
	('B000107', 'MAKE UP INK S1018\r\n', 'Produksi\r\n', 'Moving\r\n', 'PCS\r\n', 0.00, 3, '2017-07-16 00:00:00', 3, '2018-11-07 10:30:41'),
	('B000108', 'MAKE UP V - 706 - D\r\n', 'Produksi\r\n', 'Moving\r\n', 'PCS\r\n', 0.00, 3, '2017-07-17 00:00:00', 3, '2018-11-07 10:31:39'),
	('B000109', 'MAKE UP V - 853 R ', 'Produksi\r\n', 'Moving\r\n', 'PCS\r\n', 0.00, 3, '2017-07-18 00:00:00', 3, '2018-11-07 10:31:49'),
	('B000110', 'MINYAK REM PRESTONE \r\n', 'Utility\r\n', 'Slow Moving\r\n', 'BTL', 2.00, 3, '2017-07-19 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000111', 'NOCK SEAL TC 35 X 52 X 7\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 5.00, 3, '2017-07-20 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000112', 'NOCK SEAL TC 35 X 52 X 8\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS', 1.00, 3, '2017-07-21 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000113', 'NOCK SEAL TC 45 X 65 X 10\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 3.00, 3, '2017-07-22 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000114', 'NOCK SEAL TC 50 X 72 X 12\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 2.00, 3, '2017-07-23 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000115', 'O - RING 0663 - 3133 - 00\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-07-24 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000116', 'O RING 0663 7183 00\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 2.00, 3, '2017-07-25 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000117', 'O RING EXTRUDER 280 X 5,0MM\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 2.00, 3, '2017-07-26 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000118', 'O RING TEFLON NO. 19\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-07-27 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000119', 'O RING Y325 - 125\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 4.00, 3, '2017-07-28 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000120', 'O RING Y325 - 20\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 2.00, 3, '2017-07-29 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000121', 'O/H KIT 3EB - 61 - 05090\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'SET', 1.00, 3, '2017-07-30 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000122', 'OIL SEPARATOR KIT 1613 - 7502\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-07-31 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000123', 'OLI BECHEM 220 H1\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PAIL', 2.00, 3, '2017-08-01 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000124', 'OLI BP ENERGOL HLP 32\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PAIL', 3.00, 3, '2017-08-02 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000125', 'OLI BP VANELUS V3 EXTRA \r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PAIL', 1.00, 3, '2017-08-03 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000126', 'OLI DTE EXTRA HEAVY 150 VG 150\r\n', 'Utility\r\n', 'Slow Moving', 'PAIL', 1.00, 3, '2017-08-04 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000127', 'OLI SUNISO SL32\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'JRG', 1.00, 3, '2017-08-05 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000128', 'OPTIBELT 255 - 3M\r\n', 'Mek. Packing\r\n', 'Slow Moving\r\n', 'PCS\r\n', 10.00, 3, '2017-08-06 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000129', 'OPTIBELT T5 - 815 - ST - 18MM DOUBLE\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 5.00, 3, '2017-08-07 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000130', 'OPTIBELT T5 - 815 - ST - 21MM\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 4.00, 3, '2017-08-08 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000131', 'PANEL METER HELES CR45\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-08-09 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000132', 'PER SELENOID FESTO \r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 11.00, 3, '2017-08-10 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000133', 'PER TARIK SEAL HZ MC KORIN\r\n', 'Mek. Packing\r\n', 'Not Moving\r\n', 'PCS\r\n', 15.00, 3, '2017-08-11 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000134', 'PER TARIK SEAL VERTICAL MC KORIN\r\n', 'Mek. Packing\r\n', 'Not Moving\r\n', 'PCS\r\n', 23.00, 3, '2017-08-12 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000135', 'PER TEKAN KERUCUT\r\n', 'Mek. Packing\r\n', 'Slow Moving\r\n', 'PCS\r\n', 5.00, 3, '2017-08-13 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000136', 'PER TEKAN MC TRAY SET\r\n', 'Mek. Packing\r\n', 'Not Moving\r\n', 'SET', 4.00, 3, '2017-08-14 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000137', 'PER TEKAN SEAL HZ MC KORIN\r\n', 'Mek. Packing\r\n', 'Not Moving\r\n', 'PCS', 15.00, 3, '2017-08-15 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000138', 'PIN PUNCH M3 PN 271-3\r\n', 'Produksi\r\n', 'Moving\r\n', 'PCS\r\n', 18.00, 3, '2017-08-16 00:00:00', 3, '2018-11-07 10:41:49'),
	('B000139', 'PIN PUNCH M4 PN 271-4\r\n', 'Produksi\r\n', 'Moving\r\n', 'PCS\r\n', 4.00, 3, '2017-08-17 00:00:00', 3, '2018-11-07 10:41:59'),
	('B000140', 'PIN PUNCH M5 PN 271-5\r\n', 'Produksi\r\n', 'Moving\r\n', 'PCS\r\n', 5.00, 3, '2017-08-18 00:00:00', 3, '2018-11-07 10:42:32'),
	('B000141', 'PISTON RING 1614 4662 00\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-08-19 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000142', 'PISTON VALVE 1613 3221 00\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-08-20 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000143', 'PLUG 1622 3660 00\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-08-21 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000144', 'POTENTIOMETER 38920 - 00550\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 2.00, 3, '2017-08-22 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000145', 'PRESSURE GAUGE 1600 MBAR\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 2.00, 3, '2017-08-23 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000146', 'PRESSURE GAUGE 2 BAR TYPE : 232.50.063\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 4.00, 3, '2017-08-24 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000147', 'PRESSURE PLATE 1 D01308\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-08-25 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000148', 'PRESSURE PLATE 1 D01350\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-08-26 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000149', 'PRESSURE PLATE 1 D01362\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 4.00, 3, '2017-08-27 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000150', 'PRESSURE PLATE 2 D00982\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-08-28 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000151', 'PRESSURE PLATE 2 D01356\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-08-29 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000152', 'PRESSURE PLATE 2 D01358\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 2.00, 3, '2017-08-30 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000153', 'PRESSURE PLATE 3 D00995\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-08-31 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000154', 'PRESSURE PLATE 3 D01353\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-09-01 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000155', 'PRESSURE PLATE 3 D01354\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-09-02 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000156', 'PULLY V - BELT 1613 7569 02\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-09-03 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000157', 'PULLY V - BELT 1613 7570 10\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-09-04 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000158', 'REFILL SIKAT SCRUBBER NILFISK\r\n', 'Produksi\r\n', 'Moving\r\n', 'PCS\r\n', 79.00, 3, '2017-09-05 00:00:00', 3, '2018-11-07 10:47:28'),
	('B000159', 'RELAY 5 KAKI 24V\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 3.00, 3, '2017-09-06 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000160', 'RELAY NAIS 4 KAKI 12V\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 9.00, 3, '2017-09-07 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000161', 'RIBBON TAPE (25X100M)', 'Produksi', 'Moving', 'PCS', 1152.00, 3, '2017-09-08 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000162', 'RIBBON TTO BLACK 25 X 450\r\n', 'Produksi\r\n', 'Moving', 'PCS\r\n', 0.00, 3, '2017-09-09 00:00:00', 3, '2018-11-07 10:48:40'),
	('B000163', 'RING ALUMUNIUM PNEUMATIC CYLINDER\r\n', 'Mek. Packing\r\n', 'Slow Moving\r\n', 'PCS\r\n', 10.00, 3, '2017-09-10 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000164', 'ROLLER NYLON CARTON SEALER EC 705 - 703\r\n', 'Mek. Packing\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-09-11 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000165', 'RUBBER ROLLER CARTON SEALER\r\n', 'Mek. Packing\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-09-12 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000166', 'RUMAH FUSE ALCO 10A - 250VAC', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 7.00, 3, '2017-09-13 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000167', 'RUMAH FUSE TABUNG M5 X 20\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 10.00, 3, '2017-09-14 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000168', 'SAKLAR MK 2 TITIK\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 2.00, 3, '2017-09-15 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000169', 'SAKLAR MK 4 TITIK\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-09-16 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000170', 'SEAL RING K 22232\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-09-17 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000171', 'SEALING BAND HASSIA\r\n', 'Mek. Packing\r\n', 'Slow Moving\r\n', 'PCS\r\n', 9.00, 3, '2017-09-18 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000172', 'SELANG GREASE GUN \r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-09-19 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000173', 'SELANG WATSON MARLOW \r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'MTR', 5.00, 3, '2017-09-20 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000174', 'SHAFT SEAL 148 X 170 X 15\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS', 2.00, 3, '2017-09-21 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000175', 'SHAFT SEAL 160 X 190 X 15\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-09-22 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000176', 'SKUN BULAT 1,5-4MM\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 15.00, 3, '2017-09-23 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000177', 'SKUN BULAT 2-4MM\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 5.00, 3, '2017-09-24 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000178', 'SKUN BULAT 3,5-4MM\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 105.00, 3, '2017-09-25 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000179', 'SKUN FERULLE 2,5MM\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 26.00, 3, '2017-09-26 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000180', 'SKUN GARPU 1-3MM\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 170.00, 3, '2017-09-27 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000181', 'SKUN GARPU 2-4MM\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 180.00, 3, '2017-09-28 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000182', 'SKUN JARUM 5,5MM\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 211.00, 3, '2017-09-29 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000183', 'SNAP RING E6 SS\r\n', 'Mek. Packing\r\n', 'Slow Moving\r\n', 'PCS\r\n', 4.00, 3, '2017-09-30 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000184', 'SNAP RING S15 BAJA\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 28.00, 3, '2017-10-01 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000185', 'SNAP RING S25 BAJA\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 3.00, 3, '2017-10-02 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000186', 'SNAP RING S27 BAJA', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 25.00, 3, '2017-10-03 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000187', 'SNAP RING S35\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 10.00, 3, '2017-10-04 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000188', 'SOCKET RELAY MY4\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-10-05 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000189', 'SOLENOID 24200 - 11711\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-10-06 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000190', 'SOLVENT BASE INK CATRIDGE', 'Produksi', 'Moving', 'PCS', 0.00, 3, '2017-10-07 00:00:00', 3, '2018-11-20 12:35:42'),
	('B000191', 'STATER S10 PHILIPS\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 5.00, 3, '2017-10-08 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000192', 'STATER S2 PHILIPS\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 14.00, 3, '2017-10-09 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000193', 'STATOR HARTO C15017\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-10-10 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000194', 'STECKER 3 PHASE 16A + GROUND \r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 6.00, 3, '2017-10-11 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000195', 'STRAINER KUNINGAN 2"\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-10-12 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000196', 'SWITCH COM DIR 24300 - 27763\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-10-13 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000197', 'TANDEX 595\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'KG', 25.00, 3, '2017-10-14 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000198', 'TANDEX ALKALI 4\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PAIL\r\n', 2.00, 3, '2017-10-15 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000199', 'TANDEX BWS\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PAIL\r\n', 2.00, 3, '2017-10-16 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000200', 'TANDEX BWT 400\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PAIL\r\n', 1.00, 3, '2017-10-17 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000201', 'TEE GALV 1 1/2"\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 2.00, 3, '2017-10-18 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000202', 'TEE GALV 2"\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 2.00, 3, '2017-10-19 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000203', 'TEFLON BELT 750 X 15\r\n', 'Produksi\r\n', 'Moving\r\n', 'PCS\r\n', 0.00, 3, '2017-10-20 00:00:00', 3, '2018-11-07 11:01:14'),
	('B000204', 'TEFLON BELT 770 X 15\r\n', 'Produksi\r\n', 'Moving\r\n', 'PCS\r\n', 0.00, 3, '2017-10-21 00:00:00', 3, '2018-11-07 11:01:22'),
	('B000205', 'TEFLON DIAPHRAM 1/2" 93111\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 4.00, 3, '2017-10-22 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000206', 'TEFLON TAPE 1\' PTFE\r\n', 'Produksi\r\n', 'Moving\r\n', 'ROLL', 42.00, 3, '2017-10-23 00:00:00', 3, '2018-11-07 11:01:41'),
	('B000207', 'TEFLON TAPE 1" TACONIC 6085 - 03 SW\r\n', 'Produksi\r\n', 'Moving', 'PCS\r\n', 12.00, 3, '2017-10-24 00:00:00', 3, '2018-11-07 11:02:11'),
	('B000208', 'TEMPERATURE CONTROLLER OMRON TYPE : ESEM - YR4K\r\n', 'Elektrik\r\n', 'Slow Moving', 'PCS\r\n', 1.00, 3, '2017-10-25 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000209', 'TERMINAL RUSTIN 2,5MM \r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'BTG', 8.00, 3, '2017-10-26 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000210', 'TERMINAL RUSTIN 6MM \r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'BTG', 3.00, 3, '2017-10-27 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000211', 'THERMAL OVERLOAD RELAY FUJI ELECTRIC TYPE : TR-2N/3\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 2.00, 3, '2017-10-28 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000212', 'THERMOCOUPLE PT 100 Ø 4 X 30MM\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 3.00, 3, '2017-10-29 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000213', 'THERMOCOUPLE PT 100 Ø 6 X 20MM\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-10-30 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000214', 'THERMOCOUPLE TYPE K Ø 6 X 1000MM\r\n', 'Elektrik\r\n', 'Slow Moving\r\n', 'PCS\r\n', 4.00, 3, '2017-10-31 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000215', 'TIE ROD TOYOTA\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-11-01 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000216', 'TURBO A C14311D\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 3.00, 3, '2017-11-02 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000217', 'TURBO ADAPTOR C14307\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-11-03 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000218', 'TURBO SCREW C17010\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-11-04 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000219', 'TURBO Z C14071\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-11-05 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000220', 'TURBO Z C14310\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 3.00, 3, '2017-11-06 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000221', 'U - BOLT GALV 2"\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 20.00, 3, '2017-11-07 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000222', 'U CUP Y186 - 51\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-11-08 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000223', 'V - BELT BANDO A-98\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-11-09 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000224', 'V - BELT BANDO B-46\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 5.00, 3, '2017-11-10 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000225', 'V - BELT BANDO B-64\r\n', 'Mek. Proses\r\n', 'Slow Moving\r\n', 'PCS\r\n', 3.00, 3, '2017-11-11 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000226', 'VALVE DRAIN KIT NORGREN M/1338\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-11-12 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000227', 'VIBRATION DAMPER 0392 1100 28\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 4.00, 3, '2017-11-13 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000228', 'WATER MUR GALV 1/2"\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 2.00, 3, '2017-11-14 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000229', 'WATER MUR PVC 1 1/2"\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-11-15 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000230', 'WATER MUR PVC 2"\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-11-16 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000231', 'WIRE HARNESS GA 1613 6897 04\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-11-17 00:00:00', 3, '2018-11-20 15:40:58'),
	('B000232', 'WSD 25 ( 16 BAR ) 1613 8224 80\r\n', 'Utility\r\n', 'Slow Moving\r\n', 'PCS\r\n', 1.00, 3, '2017-11-18 00:00:00', 3, '2018-11-20 15:40:58');
/*!40000 ALTER TABLE `is_part` ENABLE KEYS */;

-- Dumping structure for table partsdb.is_part_level
DROP TABLE IF EXISTS `is_part_level`;
CREATE TABLE IF NOT EXISTS `is_part_level` (
  `kode_part` varchar(7) NOT NULL DEFAULT '',
  `min_stok` decimal(10,2) NOT NULL DEFAULT 0.00,
  `max_stok` decimal(10,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`kode_part`),
  CONSTRAINT `FK_is_part_level_is_part` FOREIGN KEY (`kode_part`) REFERENCES `is_part` (`kode_part`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table partsdb.is_part_level: ~0 rows (approximately)
DELETE FROM `is_part_level`;
/*!40000 ALTER TABLE `is_part_level` DISABLE KEYS */;
INSERT INTO `is_part_level` (`kode_part`, `min_stok`, `max_stok`) VALUES
	('B000003', 50.00, 100.00),
	('B000004', 50.00, 100.00),
	('B000005', 50.00, 100.00),
	('B000027', 15.00, 30.00),
	('B000039', 6.00, 12.00),
	('B000091', 100.00, 200.00),
	('B000092', 1.00, 2.00),
	('B000100', 2.00, 4.00),
	('B000106', 4.00, 8.00),
	('B000108', 6.00, 12.00),
	('B000109', 6.00, 12.00),
	('B000138', 2.00, 4.00),
	('B000139', 2.00, 4.00),
	('B000140', 2.00, 4.00),
	('B000158', 1.00, 2.00),
	('B000161', 1536.00, 3072.00),
	('B000206', 15.00, 30.00),
	('B000207', 15.00, 30.00);
/*!40000 ALTER TABLE `is_part_level` ENABLE KEYS */;

-- Dumping structure for table partsdb.is_part_req
DROP TABLE IF EXISTS `is_part_req`;
CREATE TABLE IF NOT EXISTS `is_part_req` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Kode_request` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `No_PO` varchar(20) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `Tanggal` date NOT NULL,
  `Kode_part` varchar(7) CHARACTER SET utf8 NOT NULL,
  `qty` decimal(10,2) NOT NULL DEFAULT 0.00,
  `remain_receipt` decimal(10,2) NOT NULL DEFAULT 0.00,
  `remain_issue` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `tipe` enum('STOK','CASH','PO') NOT NULL DEFAULT 'PO',
  `created_user` int(3) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `approved_user` int(3) DEFAULT NULL,
  `approved_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Kode_request` (`Kode_request`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

-- Dumping data for table partsdb.is_part_req: ~14 rows (approximately)
DELETE FROM `is_part_req`;
/*!40000 ALTER TABLE `is_part_req` DISABLE KEYS */;
INSERT INTO `is_part_req` (`id`, `Kode_request`, `No_PO`, `Tanggal`, `Kode_part`, `qty`, `remain_receipt`, `remain_issue`, `status`, `tipe`, `created_user`, `created_date`, `approved_user`, `approved_date`) VALUES
	(10, 'STOK/03', '', '2018-11-14', 'B000001', 2.00, 0.00, 0.00, 4, 'STOK', 3, '2018-11-14 15:56:07', NULL, '0000-00-00 00:00:00'),
	(11, 'STOK/03', '', '2018-11-14', 'B000002', 1.00, 0.00, 0.00, 4, 'STOK', 3, '2018-11-14 15:56:07', NULL, '0000-00-00 00:00:00'),
	(13, 'CASH/01', '', '2018-11-14', 'B000001', 2.00, 0.00, 0.00, 4, 'CASH', 3, '2018-11-14 18:40:12', NULL, '0000-00-00 00:00:00'),
	(14, 'CASH/01', '', '2018-11-14', 'B000008', 1.00, 0.00, 0.00, 4, 'CASH', 3, '2018-11-14 18:40:12', NULL, '0000-00-00 00:00:00'),
	(15, 'MR/PO/01', '', '2018-11-16', 'B000005', 10.00, 0.00, 0.00, 4, 'PO', 3, '2018-11-16 09:31:16', NULL, NULL),
	(16, 'MR/PO/01', '', '2018-11-16', 'B000003', 10.00, 10.00, 0.00, 1, 'PO', 3, '2018-11-16 09:31:16', NULL, NULL),
	(17, 'MR/PO/01', '', '2018-11-16', 'B000004', 10.00, 10.00, 0.00, 1, 'PO', 3, '2018-11-16 09:31:16', NULL, NULL),
	(18, 'MR/PO/02', '', '2018-11-16', 'B000095', 10.00, 10.00, 0.00, 1, 'PO', 3, '2018-11-16 09:36:40', NULL, NULL),
	(19, 'MR/PO/02', '', '2018-11-16', 'B000096', 10.00, 10.00, 0.00, 1, 'PO', 3, '2018-11-16 09:36:40', NULL, NULL),
	(20, 'MR/PO/02', '', '2018-11-16', 'B000097', 10.00, 10.00, 0.00, 1, 'PO', 3, '2018-11-16 09:36:40', NULL, NULL),
	(21, 'MR/PO/02', '', '2018-11-16', 'B000098', 5.00, 5.00, 0.00, 1, 'PO', 3, '2018-11-16 09:36:40', NULL, NULL),
	(25, 'PO/10', '', '2018-11-16', 'B000001', 10.00, 0.00, 10.00, 3, 'PO', 3, '2018-11-16 13:43:20', NULL, NULL),
	(26, 'MR-STOK-01', '', '2018-11-19', 'B000003', 100.00, 0.00, 100.00, 3, 'STOK', 3, '2018-11-19 10:18:33', NULL, NULL),
	(27, 'MR-STOK-01', '', '2018-11-19', 'B000004', 100.00, 0.00, 100.00, 3, 'STOK', 3, '2018-11-19 10:18:33', NULL, NULL);
/*!40000 ALTER TABLE `is_part_req` ENABLE KEYS */;

-- Dumping structure for table partsdb.is_part_trans
DROP TABLE IF EXISTS `is_part_trans`;
CREATE TABLE IF NOT EXISTS `is_part_trans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tanggal_transaksi` date NOT NULL,
  `kode_transaksi` varchar(20) NOT NULL,
  `referensi` varchar(7) NOT NULL DEFAULT '',
  `kode_request` varchar(30) NOT NULL DEFAULT '',
  `no_po` varchar(20) NOT NULL DEFAULT '',
  `no_sj` varchar(30) NOT NULL DEFAULT '',
  `kode_part` varchar(7) NOT NULL,
  `qty` decimal(10,0) NOT NULL,
  `harga` decimal(10,0) NOT NULL DEFAULT 0,
  `created_user` int(3) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `id_barang` (`kode_part`),
  KEY `created_user` (`created_user`),
  CONSTRAINT `is_part_Trans_ibfk_1` FOREIGN KEY (`kode_part`) REFERENCES `is_part` (`kode_part`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `is_part_Trans_ibfk_2` FOREIGN KEY (`created_user`) REFERENCES `is_users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=latin1;

-- Dumping data for table partsdb.is_part_trans: ~9 rows (approximately)
DELETE FROM `is_part_trans`;
/*!40000 ALTER TABLE `is_part_trans` DISABLE KEYS */;
INSERT INTO `is_part_trans` (`id`, `tanggal_transaksi`, `kode_transaksi`, `referensi`, `kode_request`, `no_po`, `no_sj`, `kode_part`, `qty`, `harga`, `created_user`, `created_date`) VALUES
	(91, '2018-11-15', 'TR-2018-0000001', 'RECEIPT', 'CASH/01', 'CASH', 'SJ1', 'B000008', 1, 0, 3, '2018-11-15 23:10:49'),
	(92, '2018-11-15', 'TI-2018-0000002', 'ISSUE', 'STOK/03', '', '', 'B000001', -2, 0, 3, '2018-11-16 00:08:44'),
	(93, '2018-11-15', 'TI-2018-0000003', 'ISSUE', 'STOK/03', '', '', 'B000002', -1, 0, 3, '2018-11-16 00:17:28'),
	(94, '2018-11-15', 'TI-2018-0000004', 'ISSUE', 'CASH/01', '', '', 'B000008', -1, 0, 3, '2018-11-16 00:17:56'),
	(95, '2018-11-15', 'TR-2018-0000002', 'RECEIPT', 'CASH/01', 'CASH', 'SJ2', 'B000001', 2, 0, 3, '2018-11-16 00:20:19'),
	(96, '2018-11-15', 'TI-2018-0000005', 'ISSUE', 'CASH/01', '', '', 'B000001', -2, 0, 3, '2018-11-16 00:20:30'),
	(97, '2018-11-16', 'TR-2018-0000003', 'RECEIPT', 'MR/PO/01', 'PO-001', 'SJ-001', 'B000005', 10, 0, 3, '2018-11-16 09:42:07'),
	(98, '2018-11-16', 'TI-2018-0000006', 'ISSUE', 'MR/PO/01', '', '', 'B000005', -10, 0, 3, '2018-11-16 09:45:39'),
	(99, '2018-11-16', 'TR-2018-0000004', 'RECEIPT', 'PO/10', 'PO-10', 'SJ-10', 'B000001', 10, 0, 3, '2018-11-16 13:43:49');
/*!40000 ALTER TABLE `is_part_trans` ENABLE KEYS */;

-- Dumping structure for table partsdb.is_temp_in
DROP TABLE IF EXISTS `is_temp_in`;
CREATE TABLE IF NOT EXISTS `is_temp_in` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `part_req_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `tanggal_transaksi` date NOT NULL,
  `kode_part` varchar(7) NOT NULL,
  `qty` decimal(10,0) NOT NULL,
  `created_user` int(3) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `id_barang` (`kode_part`),
  KEY `created_user` (`created_user`),
  CONSTRAINT `is_temp_in_ibfk_1` FOREIGN KEY (`kode_part`) REFERENCES `is_part` (`kode_part`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `is_temp_in_ibfk_2` FOREIGN KEY (`created_user`) REFERENCES `is_users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=162 DEFAULT CHARSET=latin1;

-- Dumping data for table partsdb.is_temp_in: ~1 rows (approximately)
DELETE FROM `is_temp_in`;
/*!40000 ALTER TABLE `is_temp_in` DISABLE KEYS */;
INSERT INTO `is_temp_in` (`id`, `part_req_id`, `tanggal_transaksi`, `kode_part`, `qty`, `created_user`, `created_date`) VALUES
	(160, 17, '2018-11-19', 'B000004', 10, 3, '2018-11-19 10:20:28');
/*!40000 ALTER TABLE `is_temp_in` ENABLE KEYS */;

-- Dumping structure for table partsdb.is_temp_out
DROP TABLE IF EXISTS `is_temp_out`;
CREATE TABLE IF NOT EXISTS `is_temp_out` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `part_req_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `tanggal_transaksi` date NOT NULL,
  `kode_part` varchar(7) NOT NULL,
  `qty` decimal(10,0) NOT NULL,
  `created_user` int(3) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `id_barang` (`kode_part`),
  KEY `created_user` (`created_user`),
  CONSTRAINT `is_temp_out_ibfk_1` FOREIGN KEY (`kode_part`) REFERENCES `is_part` (`kode_part`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `is_temp_out_ibfk_2` FOREIGN KEY (`created_user`) REFERENCES `is_users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- Dumping data for table partsdb.is_temp_out: ~0 rows (approximately)
DELETE FROM `is_temp_out`;
/*!40000 ALTER TABLE `is_temp_out` DISABLE KEYS */;
INSERT INTO `is_temp_out` (`id`, `part_req_id`, `tanggal_transaksi`, `kode_part`, `qty`, `created_user`, `created_date`) VALUES
	(20, 25, '2018-11-16', 'B000001', 10, 3, '2018-11-16 13:43:55');
/*!40000 ALTER TABLE `is_temp_out` ENABLE KEYS */;

-- Dumping structure for table partsdb.is_temp_req
DROP TABLE IF EXISTS `is_temp_req`;
CREATE TABLE IF NOT EXISTS `is_temp_req` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Kode_request` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `No_PO` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `Tanggal` date NOT NULL,
  `Kode_part` varchar(7) CHARACTER SET utf8 NOT NULL,
  `qty` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `tipe` enum('STOK','CASH','PO') NOT NULL DEFAULT 'PO',
  `created_user` int(3) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `approved_user` int(3) DEFAULT NULL,
  `approved_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Kode_request` (`Kode_request`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

-- Dumping data for table partsdb.is_temp_req: ~0 rows (approximately)
DELETE FROM `is_temp_req`;
/*!40000 ALTER TABLE `is_temp_req` DISABLE KEYS */;
/*!40000 ALTER TABLE `is_temp_req` ENABLE KEYS */;

-- Dumping structure for table partsdb.is_users
DROP TABLE IF EXISTS `is_users`;
CREATE TABLE IF NOT EXISTS `is_users` (
  `id_user` int(3) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `nama_user` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `telepon` varchar(13) DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `hak_akses` enum('Super Admin','Manajer','Gudang') NOT NULL,
  `status` enum('aktif','blokir') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_user`),
  KEY `level` (`hak_akses`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Dumping data for table partsdb.is_users: ~3 rows (approximately)
DELETE FROM `is_users`;
/*!40000 ALTER TABLE `is_users` DISABLE KEYS */;
INSERT INTO `is_users` (`id_user`, `username`, `nama_user`, `password`, `email`, `telepon`, `foto`, `hak_akses`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'bachtiar', 'Bachtiar Yanuari', '9784b7ec358595dbf015f3b7b3fcf603', 'bachtiar@simbaindo.com', '081210923296', 'male.png', 'Super Admin', 'aktif', '2017-04-01 15:15:15', '2018-11-07 14:34:16'),
	(2, 'Apri', 'Aprianto', '9784b7ec358595dbf015f3b7b3fcf603', 'Apri@simbaindo.com', '', 'user-default.png', 'Manajer', 'aktif', '2017-04-01 15:15:15', '2018-11-07 14:34:32'),
	(3, 'santi', 'Santi Riani', '9784b7ec358595dbf015f3b7b3fcf603', 'sim.santi.riani@gmail.com', '', 'female.png', 'Gudang', 'aktif', '2017-04-01 15:15:15', '2018-11-07 13:58:40');
/*!40000 ALTER TABLE `is_users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
