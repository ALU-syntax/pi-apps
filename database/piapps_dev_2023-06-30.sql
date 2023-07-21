# ************************************************************
# Sequel Ace SQL dump
# Version 20046
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Host: 127.0.0.1 (MySQL 5.5.5-10.6.5-MariaDB-1:10.6.5+maria~focal)
# Database: piapps_dev
# Generation Time: 2023-06-30 10:31:04 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE='NO_AUTO_VALUE_ON_ZERO', SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table is_invoice
# ------------------------------------------------------------

DROP TABLE IF EXISTS `is_invoice`;

CREATE TABLE `is_invoice` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL DEFAULT current_timestamp(),
  `kode_suplier` varchar(30) NOT NULL DEFAULT '',
  `suplier` varchar(60) NOT NULL DEFAULT '',
  `nomor` varchar(30) NOT NULL,
  `referensi` varchar(30) NOT NULL DEFAULT '',
  `tipe` enum('Sale','Purch','Energi','Gaji','Other','Transport','Promo','Consump','Sewa') NOT NULL,
  `amount` decimal(11,0) NOT NULL,
  `lunas` bit(1) NOT NULL DEFAULT b'1',
  `keterangan` varchar(255) NOT NULL DEFAULT '',
  `lampiran` varchar(255) NOT NULL DEFAULT '',
  `resto` varchar(255) NOT NULL DEFAULT '',
  `createdby` int(11) NOT NULL,
  `createdon` datetime NOT NULL DEFAULT current_timestamp(),
  `bukti` varchar(80) NOT NULL,
  `input_by` enum('Purchasing','Finance') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `is_invoice` WRITE;
/*!40000 ALTER TABLE `is_invoice` DISABLE KEYS */;

INSERT INTO `is_invoice` (`id`, `tanggal`, `kode_suplier`, `suplier`, `nomor`, `referensi`, `tipe`, `amount`, `lunas`, `keterangan`, `lampiran`, `resto`, `createdby`, `createdon`, `bukti`, `input_by`)
VALUES
	(136,'2023-05-11','S00015','Fresh Store','TR-2023-0000001','','Purch',150000,b'1','','','',26,'2023-05-11 11:30:47','','Purchasing');

/*!40000 ALTER TABLE `is_invoice` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table is_part
# ------------------------------------------------------------

DROP TABLE IF EXISTS `is_part`;

CREATE TABLE `is_part` (
  `kode_part` varchar(6) NOT NULL,
  `kode_suplier` varchar(6) DEFAULT NULL,
  `nama_part` varchar(90) NOT NULL,
  `group` varchar(24) NOT NULL DEFAULT '',
  `kategori` varchar(12) NOT NULL DEFAULT '',
  `satuan` varchar(5) NOT NULL,
  `stok` decimal(10,1) NOT NULL DEFAULT 0.0,
  `stok_level` decimal(10,1) NOT NULL,
  `harga` decimal(11,0) NOT NULL,
  `created_user` int(3) DEFAULT 1,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_user` int(3) NOT NULL DEFAULT 1,
  `updated_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`kode_part`),
  KEY `created_user` (`created_user`),
  KEY `updated_user` (`updated_user`),
  CONSTRAINT `is_part_ibfk_1` FOREIGN KEY (`created_user`) REFERENCES `is_users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `is_part_ibfk_2` FOREIGN KEY (`updated_user`) REFERENCES `is_users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `is_part` WRITE;
/*!40000 ALTER TABLE `is_part` DISABLE KEYS */;

INSERT INTO `is_part` (`kode_part`, `kode_suplier`, `nama_part`, `group`, `kategori`, `satuan`, `stok`, `stok_level`, `harga`, `created_user`, `created_date`, `updated_user`, `updated_date`)
VALUES
	('I00001','S00001','es kristal tube','bar','bar cost','Bal',8.0,0.0,20000,26,'2023-03-31 09:26:44',1,'2023-06-06 15:57:52'),
	('I00002','S00058','DRIPP - Yuzu pulp','bar','bar cost','Btl',0.0,0.0,166500,26,'2023-03-31 09:28:32',26,'2023-03-31 09:28:32'),
	('I00003','S00044','kacang mede','kitchen','food cost','Klg',0.0,0.0,160000,26,'2023-03-31 09:29:58',26,'2023-03-31 09:29:58'),
	('I00004','S00002','Telur','Test','Test','Kg',0.0,0.0,15000,26,'2023-05-11 03:06:32',26,'2023-05-11 03:06:32');

/*!40000 ALTER TABLE `is_part` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table is_part_consump
# ------------------------------------------------------------

DROP TABLE IF EXISTS `is_part_consump`;

CREATE TABLE `is_part_consump` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode_request` varchar(30) NOT NULL DEFAULT '',
  `keterangan` varchar(30) NOT NULL DEFAULT '',
  `tanggal` date NOT NULL,
  `kode_item` varchar(6) NOT NULL,
  `nama_item` varchar(60) NOT NULL,
  `satuan` varchar(10) NOT NULL,
  `qty` decimal(10,1) NOT NULL DEFAULT 0.0,
  `group` enum('Kitchen','Bar','Pastry') NOT NULL,
  `created_user` int(3) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_approved` enum('-1','0','1') NOT NULL DEFAULT '-1',
  `approved_user` int(3) DEFAULT NULL,
  `approved_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_is_part_req_is_users` (`created_user`) USING BTREE,
  KEY `Kode_request` (`kode_request`) USING BTREE,
  KEY `FK_is_part_req_is_part` (`kode_item`) USING BTREE,
  CONSTRAINT `is_part_consump_ibfk_1` FOREIGN KEY (`created_user`) REFERENCES `is_users` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `is_part_consump` WRITE;
/*!40000 ALTER TABLE `is_part_consump` DISABLE KEYS */;

INSERT INTO `is_part_consump` (`id`, `kode_request`, `keterangan`, `tanggal`, `kode_item`, `nama_item`, `satuan`, `qty`, `group`, `created_user`, `created_date`, `is_approved`, `approved_user`, `approved_date`)
VALUES
	(2406,'RQ-2023-0000001','','2023-05-02','I00001','es kristal tube','',1.0,'Kitchen',1,'2023-05-02 14:52:58','1',1,'2023-05-02 14:53:00'),
	(2410,'RQ-2023-0000002','','2023-05-03','I00001','es kristal tube','',1.0,'Kitchen',1,'2023-05-03 11:53:36','-1',NULL,NULL),
	(2411,'RQ-2023-0000003','','2023-06-06','I00001','es kristal tube','',1.0,'Kitchen',1,'2023-06-06 15:57:50','1',1,'2023-06-06 15:57:52');

/*!40000 ALTER TABLE `is_part_consump` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table is_part_req
# ------------------------------------------------------------

DROP TABLE IF EXISTS `is_part_req`;

CREATE TABLE `is_part_req` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode_request` varchar(30) NOT NULL DEFAULT '',
  `keterangan` varchar(30) NOT NULL DEFAULT '',
  `tanggal` date NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `kode_part` varchar(6) NOT NULL,
  `nama_item` varchar(60) NOT NULL,
  `satuan` varchar(10) NOT NULL,
  `qty` decimal(10,2) NOT NULL DEFAULT 0.00,
  `harga` decimal(10,2) NOT NULL DEFAULT 0.00,
  `diskon` decimal(10,2) NOT NULL,
  `pajak` decimal(10,2) NOT NULL,
  `jumlah` decimal(10,2) NOT NULL,
  `kode_suplier` varchar(6) NOT NULL,
  `suplier` varchar(60) NOT NULL,
  `remain_receipt` decimal(10,0) NOT NULL DEFAULT 0,
  `status` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `tipe` enum('CASH','Tempo') NOT NULL DEFAULT 'Tempo',
  `created_user` int(3) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `approved_user` int(3) DEFAULT NULL,
  `approved_date` timestamp NULL DEFAULT NULL,
  `bukti` varchar(80) NOT NULL,
  `status_bayar` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_is_part_req_is_users` (`created_user`),
  KEY `FK_is_part_req_is_part` (`kode_part`) USING BTREE,
  KEY `Kode_request` (`kode_request`) USING BTREE,
  CONSTRAINT `FK_is_part_req_is_users` FOREIGN KEY (`created_user`) REFERENCES `is_users` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table is_part_trans
# ------------------------------------------------------------

DROP TABLE IF EXISTS `is_part_trans`;

CREATE TABLE `is_part_trans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tanggal_transaksi` date NOT NULL,
  `kode_transaksi` varchar(20) NOT NULL DEFAULT '',
  `referensi` varchar(7) NOT NULL DEFAULT '',
  `kode_request` varchar(30) NOT NULL DEFAULT '',
  `no_sj` varchar(30) NOT NULL DEFAULT '',
  `keterangan` varchar(160) NOT NULL DEFAULT '',
  `kode_part` varchar(6) NOT NULL DEFAULT '',
  `satuan` varchar(20) NOT NULL DEFAULT '',
  `nama` varchar(60) NOT NULL DEFAULT '',
  `resto` varchar(60) DEFAULT '',
  `qty` decimal(10,0) NOT NULL,
  `harga` decimal(10,0) NOT NULL DEFAULT 0,
  `kode_suplier` varchar(20) NOT NULL,
  `created_user` int(3) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `bukti` varchar(80) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_barang` (`kode_part`),
  KEY `created_user` (`created_user`),
  CONSTRAINT `is_part_Trans_ibfk_2` FOREIGN KEY (`created_user`) REFERENCES `is_users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `is_part_trans` WRITE;
/*!40000 ALTER TABLE `is_part_trans` DISABLE KEYS */;

INSERT INTO `is_part_trans` (`id`, `tanggal_transaksi`, `kode_transaksi`, `referensi`, `kode_request`, `no_sj`, `keterangan`, `kode_part`, `satuan`, `nama`, `resto`, `qty`, `harga`, `kode_suplier`, `created_user`, `created_date`, `bukti`)
VALUES
	(5079,'2023-05-11','TR-2023-0000001','RECEIPT','PO-20230318003','','','I00004','Kg','Telur','',10,15000,'S00002',26,'2023-05-11 04:30:47',''),
	(5080,'2023-06-06','RQ-2023-0000003','ISSUE','','','','I00001','Bal','es kristal tube','',-1,0,'',1,'2023-06-06 15:57:50','');

/*!40000 ALTER TABLE `is_part_trans` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table is_produk
# ------------------------------------------------------------

DROP TABLE IF EXISTS `is_produk`;

CREATE TABLE `is_produk` (
  `kode_produk` varchar(6) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `created_user` int(3) NOT NULL DEFAULT 1,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_user` int(3) NOT NULL DEFAULT 1,
  `updated_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`kode_produk`),
  KEY `created_user` (`created_user`),
  KEY `updated_user` (`updated_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `is_produk` WRITE;
/*!40000 ALTER TABLE `is_produk` DISABLE KEYS */;

INSERT INTO `is_produk` (`kode_produk`, `nama_produk`, `created_user`, `created_date`, `updated_user`, `updated_date`)
VALUES
	('P00001','Kodok Test',26,'2023-06-30 10:19:59',1,'2023-06-30 10:19:59');

/*!40000 ALTER TABLE `is_produk` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table is_produk_part
# ------------------------------------------------------------

DROP TABLE IF EXISTS `is_produk_part`;

CREATE TABLE `is_produk_part` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `kode_produk` varchar(6) NOT NULL,
  `kode_part` varchar(6) NOT NULL,
  `qty` decimal(10,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `is_produk_part` WRITE;
/*!40000 ALTER TABLE `is_produk_part` DISABLE KEYS */;

INSERT INTO `is_produk_part` (`id`, `kode_produk`, `kode_part`, `qty`)
VALUES
	(1,'P00001','I00001',1.00),
	(2,'P00001','I00003',1.00);

/*!40000 ALTER TABLE `is_produk_part` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table is_sales
# ------------------------------------------------------------

DROP TABLE IF EXISTS `is_sales`;

CREATE TABLE `is_sales` (
  `no` varchar(50) DEFAULT NULL,
  `resto` varchar(50) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `value` decimal(10,2) DEFAULT NULL,
  `bill_total` decimal(10,2) DEFAULT NULL,
  `customer` decimal(10,2) DEFAULT NULL,
  `disc` decimal(10,2) DEFAULT NULL,
  `sub_total` decimal(10,2) DEFAULT NULL,
  `service_charge_total` decimal(10,2) DEFAULT NULL,
  `total_sale` decimal(10,2) DEFAULT NULL,
  `tax_total` decimal(10,2) DEFAULT NULL,
  `vat_total` decimal(10,2) DEFAULT NULL,
  `delivery_cost` decimal(10,2) DEFAULT NULL,
  `rounding` decimal(10,2) DEFAULT NULL,
  `net_sales` decimal(10,2) DEFAULT NULL,
  `grand_total` decimal(10,2) DEFAULT NULL,
  `total_payment` decimal(10,2) DEFAULT NULL,
  `diff_payment` decimal(10,2) DEFAULT NULL,
  `cash` decimal(10,2) DEFAULT NULL,
  `credit_card` decimal(10,2) DEFAULT NULL,
  `debit_card` decimal(10,2) DEFAULT NULL,
  `member_deposit` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table is_salesss
# ------------------------------------------------------------

DROP TABLE IF EXISTS `is_salesss`;

CREATE TABLE `is_salesss` (
  `no` varchar(50) DEFAULT NULL,
  `resto` varchar(50) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `value` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `is_salesss` WRITE;
/*!40000 ALTER TABLE `is_salesss` DISABLE KEYS */;

INSERT INTO `is_salesss` (`no`, `resto`, `tanggal`, `value`)
VALUES
	('S00001','Libero','2022-08-09',22333);

/*!40000 ALTER TABLE `is_salesss` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table is_suplier
# ------------------------------------------------------------

DROP TABLE IF EXISTS `is_suplier`;

CREATE TABLE `is_suplier` (
  `kode` varchar(6) NOT NULL DEFAULT '',
  `nama` varchar(160) NOT NULL DEFAULT '',
  `alamat` varchar(255) NOT NULL DEFAULT '',
  `group` varchar(20) NOT NULL DEFAULT '',
  `telepon` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `no_rekening` varchar(50) NOT NULL,
  `pic` varchar(50) NOT NULL,
  `top` int(11) NOT NULL,
  `createdBy` int(11) NOT NULL DEFAULT 0,
  `updatedBy` int(11) NOT NULL DEFAULT 0,
  `createdOn` datetime NOT NULL,
  `updatedOn` datetime NOT NULL,
  PRIMARY KEY (`kode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `is_suplier` WRITE;
/*!40000 ALTER TABLE `is_suplier` DISABLE KEYS */;

INSERT INTO `is_suplier` (`kode`, `nama`, `alamat`, `group`, `telepon`, `email`, `no_rekening`, `pic`, `top`, `createdBy`, `updatedBy`, `createdOn`, `updatedOn`)
VALUES
	('S00001','Acong ice tube','Grogol','Toko','087785245748','NA','NA','NA',30,26,26,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00002','Agus Telur','Grogol','Toko','085867745546','NA','BCA : 5370091406  an Dwi Agus Suyono','NA',7,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00003','Bursa Selaras Bersama','Ruko Green Garden Blok A14 No. 21','Toko','089508739711','NA','BCA : 2538897979 an Bursa Selaras Bersama','Eka Isna',1,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00004','Baccara Sejahtera Abadi','Jl. Tanjung Duren Utara IIIA No. 337','Toko','081219699070 / 08121','ptbaccara.sa@gmail.com / jonathan.tanudjaja@baccar','NA','Voni - Jonathan',7,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00005','Anak Mas Indah','NA','CV','0895348736240','NA','BCA : 8660302388 an Anak Mas indah','Lestari',1,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00006','Artemis Adhi Tirta','Jl. Pangeran Jayakarta No. 95-95A Mangga Dua, Sawah Besar','NA','085211539707','admin@spivawater.com','BCA : 0838888880 an Artemis Adhi Tirta','Mba Cory',7,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00007','Australindo Makmur Bersama','NA','NA','NA','NA','NA','NA',1,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00008','BERKAH DWI MEGA','Jl. Menara II No.90, RT.4/RW.5, Meruya Sel., Kec. Kembangan, Kota Jakarta Barat 11610','NA','08991981207','NA','BCA : 8870902019 an BERKAH DWI MEGA','Sephian',14,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00009','Red Cherry Blossom','Ruko Mega Sunter Blok A11 Jakarta Utara 14360','NA','08161111631','NA','BCA : 4850398840','Pak Budiman',14,26,26,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00010','Dagsap Endura Eatore','Jl. Cahaya Raya Kav H3, Kawasan Industri Sentul','NA','085692157071','NA','BCA : 5660-42-9800 an DAGSAP ENDURA EATOR','Bpk. Idier',7,26,26,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00011','Delisari Nusantara','Komp Puri Mutiara Blok A 23-25, Jl. Griya Utama Raya Sunter','NA','08118678966','NA','BCA : 008500001 an Delisari Nusantara','Bpk. Slamet Hadi',7,26,26,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00012','DRIPP PERSADA INTERNASIONAL','Jl. Imam Bonjol No. 9, Karawaci 15139, Indonesia','NA','081219182860','faramita.putri@rasagroup.co.id, purchasing@drippfl','BCA : 2068882929  an Dripp Persada Internasional','Mas Bram',1,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00013','Eugene Food','NA','NA','08112727377','NA','BCA : 8710176991 an Liau Christian Kurniawan','Kariena',14,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00014','Food Suplly','NA','NA','081210800930','NA','BCA : 4136641972 an wison valentino','Wison',7,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00015','Fresh Store','NA','NA','082118438272','NA','BCA : 4140322089 an KUSNI YASIN','NA',7,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00016','GHIBAM JASEENA MANDIRI','Jl. Pertengahan No. 7 Rt 06 Rw. 07 Cijantung Kec. Ps Rebo','NA','081218342695','NA','BCA : 1653009422 an GHIBAM JASEENA MANDIRI','Dini',3,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00017','Greenfields Dairy Indonesia','Green Office Park I Bulilding South Tower Grand Boulevard Lt. 3','NA','081382366395','NA','BCA : 0053061777 an Greenfields Dairy Indonesia','Bapak Reynold',14,26,26,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00018','JATE AIR','Tanjung Duren Timur no 39','NA','082129563336','NA','BCA 0841281631 a/n Samsudin','Samsudin',7,26,26,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00019','Jaya Gas Indonesia','Jl. Kramat Raya No. 144 Jakarta 10430','NA','083892572326','NA','BCA : 6340046062 Jaya Gas Indonesia','MULIN',14,26,26,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00020','Jaya Sakti offset','NA','NA','NA','NA','NA','NA',1,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00021','Juragan Inti Makmur PT','Krendang Raya No. 16 Rt 04/01','NA','082111535101','NA','BCA : 7630613838 an Juragan Inti Makmur PT','NA',2,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00022','Karunia Sukses Gemilang','Jembatan Dua Raya No. 6 Pejagalan, Jakarta Utara','NA','0895322278692','NA','BCA : 7100317677 an Karunia Sukses Gemilang','INTAN',1,26,26,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00023','Kreasi Cipta Megatama','Jl. Hasyim Ashari Gg. Kancil No. 06 Tangerang','NA','081291567616','NA','BCA : 4870470733 an Suriyana','Ci yana',14,26,26,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00024','Mitra Sarana Purnama','NA','NA','NA','NA','BCA : 2863006775 an Mitra Sarana Purnama','Hoerudin',1,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00025','macrosentra niagaboga','NA','NA','NA','NA','BCA : 2173100035 an macrosentra niagaboga','NA',1,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00026','Mandiri Gemilang CV','Jl. Bhakti No. 38 Rt. 01 Rw. 07, Kel. Ciputat Tangsel','NA','0817711975','NA','BCA : 0678182888 an Mandiri Gemilang CV','Ibu Handa',7,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00027','Masuya Graha Trikencana','Jl. Agung Karya IV B No. 22 Papanggo Tj Priuk','NA','08551159222','NA','BCA : 4281281717 an Masuya Graha Trikencana','Pak Wonny',1,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00028','Minantu Sefood','Jl. Bantar Kemang No. 56 Baranangsiang Bogor Timur 16143','NA','087786255737','NA','BCA : 5735345084 an Rezsha Apriliyani Ilham','Pak Rizal',14,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00029','Mulia Raya Agrijaya','Jl. Peternakan Raya (Jembatan Genit Gg. Semut) No. 12 Rt. 007/004 Jakarta Barat','NA','082117682267','NA','BCA : 4663008989 an Mulia Raya Agrijaya','Ibu Nurul',7,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00030','Mutiara Gading','Jl. Rawa Selatan IV No. 30 Jak-Pus','NA','082114155556','NA','BCA : 7000355938 an Wahyudi','IRA',7,26,26,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00031','Niaga Buana Solusi Utama, PT','Jl. Raya Poncol No. 24, Ciracas, Jakarta Timur 13740','NA','085872381136','NA','BCA : 1660592055 an Niaga Buana Solusi Utama, PT','Bp Ferlians',7,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00032','Pangan Lestari','NA','NA','081219200158','NA','BCA 1683006495 a/n PANGAN LESTARI','RAMDONI',1,26,26,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00033','Pangan Makmur Sembada','Pasar Induk Beras Cipinang Blok E No. 2, Jakarta Timur','NA','08561489092,08129212','NA','BCA : 8810577771 an PT. Pangan Makmur Sembada','Joseph',7,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00034','Prambanan Kencana','NA','NA','082122739163','NA','BCA : 2613191119 an Prambanan Kencana','Novita',1,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00035','Sarana Kulina Intisejahtera','Jl. Taruna No.5, RT.1/RW.4, Cipinang Melayu, Kec. Makasar, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13620, Indonesia','NA','0817110748','NA','DANAMON 000004090734','ITA',7,26,26,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00036','Sahrul - Grogol','Pasar Grogol','NA','082112405595','NA','BCA : 7020593479 an Sahrul Ramdan','Sahrul',3,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00037','Sukanda Djaya-Ancol DIAMOND','Jl. Pasir Putih Raya Kav. 1 Ancol Pademangan 14430','NA','081223278431','NA','VA BCA 075050001411325','Bp Aris',14,26,26,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00038','Sukanda Djaya - Cibitung','Jl. Irian V Blok MM No. 3/5, Cibitung','NA','081999905055','NA','VA BCA 075050001411325','Ibu Vanlen',14,26,26,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00039','Techno Clean','Jl. Pademangan IV Gg. 20 No. 47G Jakarta Utara','NA','021 - 64711009 / 081','NA','NA','Bp Axel',14,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00040','Titan Food Solution','No. 24 D, Jl. RS. Fatmawati Raya, RT.1/RW.10, Cilandak Bar., Kec. Cilandak, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12430, Indonesia','NA','08176784826','NA','BCA : 2188184826 an TITAN INTIGOURMET SUMBER JAYA','CICILIA',7,26,26,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00041','Toffin Indonesia','Jl. Pluit Permai No. 4 Rt. 20/02 Jakarta Utara','NA','082323328888','info@toffin.id','5290675555','Novy',7,26,26,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00043','Toko Acin','Jl Dr.muwardi raya no 41 A grogol','NA','081311336883','NA','+62 4281271665','Ci Lily',10,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00044','Toko Lenny Pasar Grogol','Toko Lenny Pasar Grogol','NA','085833056353','NA','BCA : 2684106138 an Robby A/ANG LIAN GIOK','LENNY',7,26,26,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00045','Wijaya Promotion','Jl. Muwardi Raya No. 5b Grogol','NA','081932508999, 081297','NA','NA','NA',1,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00046','Daesang Agung Indonesia','Jl. Perintis Kemerdekaan No. 1 Rt 007/002 Pulogadung','NA','081514178882','NA','BCA : 2273009515 an Daesang Agung Indonesia','Bayu',7,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00047','Dairyfood Internusa','NA','NA','081381790370','NA','BCA 0743142737','Event',15,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00048','Agen Telor JARWO','GROGOL','Distributor','085730191339','NA','BCA 5610318764','Siswo Riyanto',14,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00049','PT. BINTANG GRAHA MAKMUR','NA','supplier','089635178901','NA','BCA 4582229281 BINTANG GRAHA MAKMUR, PT','FUAD',14,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00050','PT. CAHAYA MAJU BERSAMA','NA','supplier','081210113502','NA','BCA 6460183390 CAHAYA MAJU BERSAMA, PT','TEGUH',7,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00051','PT. CAKRAWALA CITYPRODUCTS','NA','supplier','085691758471','NA','BCA 8650501218 PT. CAKRAWALA CITYPRODUCTS','-',1,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00052','PT. CITRA DAMAI SEJAHTERA','NA','supplier','082121210680','NA','BCA 0653040919 CHRISTIAN','KEVIN',1,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00053','PT. DAIRYFOOD INTERNUSA','NA','supplier','081381790370','NA','BCA 0743142737','EVAN',7,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00054','CV. GOLDEN CLEAN','NA','agen','087868538750','NA','BCA 8350225111 USAHA SELALU CUAN','STEFEN',1,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00055','CV. HARAPAN INDAH','NA','supplier','081288253751','NA','BCA 5370362035 NURHAYATI','MUSLIM',30,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00056','PT. HORECABA JAYA MAKMUR','NA','supplier','081389896598','NA','BCA 6460183390 PT. HORECABA JAYA MAKMUR','LERRY',1,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00057','PT. INDOGAL AGRO TRADING','NA','supplier','081389896598','NA','CIMB 800176987100 INDOGAL AGRO TRADING','RINALDI',7,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00058','PT. KIWIANA PANAGIA INTERNAS','NA','supplier','081219182860','NA','BCA 0653125272 KIWIANA PANAGIA','BRAM',7,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00059','ORCHID MANTIS','NA','vendor','NA','NA','BCA 6040677877 ORCHID MANTIS','NA',30,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00060','CV. PRIMA INDO','NA','supplier','081295370993','NA','BCA 7670476388 PRIMA INDO, CV','NISA',1,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00061','SINAR MAS','NA','supplier','081806840865','NA','BCA 4790123200 ALBERT LUKMAN','ALBERT LUKMAN',7,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	('S00062','PT. SUMBER TIRTA SENTOSA','NA','supplier','088212257120','NA','BCA 2293217777 SUMBER TIRTA SENTOSA','KIM',14,26,0,'0000-00-00 00:00:00','0000-00-00 00:00:00');

/*!40000 ALTER TABLE `is_suplier` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table is_temp_in
# ------------------------------------------------------------

DROP TABLE IF EXISTS `is_temp_in`;

CREATE TABLE `is_temp_in` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `part_req_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `tanggal_transaksi` date NOT NULL,
  `kode_part` varchar(6) NOT NULL,
  `nama` varchar(60) NOT NULL DEFAULT '',
  `tipe` enum('PO','CASH') NOT NULL DEFAULT 'PO',
  `qty` decimal(10,0) NOT NULL DEFAULT 0,
  `satuan` varchar(30) NOT NULL DEFAULT '',
  `harga` decimal(10,0) NOT NULL DEFAULT 0,
  `kode_suplier` varchar(20) NOT NULL,
  `created_user` int(3) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `id_barang` (`kode_part`),
  KEY `created_user` (`created_user`),
  CONSTRAINT `is_temp_in_ibfk_2` FOREIGN KEY (`created_user`) REFERENCES `is_users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `is_temp_in` WRITE;
/*!40000 ALTER TABLE `is_temp_in` DISABLE KEYS */;

INSERT INTO `is_temp_in` (`id`, `part_req_id`, `tanggal_transaksi`, `kode_part`, `nama`, `tipe`, `qty`, `satuan`, `harga`, `kode_suplier`, `created_user`, `created_date`)
VALUES
	(2653,2530,'2022-08-04','I00083','Daun Pisang','',2,'Ikt',15000,'S00015',37,'2022-08-04 08:38:49'),
	(2654,2531,'2022-08-04','I00025','Alpukat Mentega','',1,'Kg',35000,'S00015',37,'2022-08-04 08:38:49'),
	(2655,2532,'2022-08-04','I00304','Sereh','',2,'Kg',15000,'S00015',37,'2022-08-04 08:38:49'),
	(2656,2533,'2022-08-04','I00183','Kunyit','',1,'Kg',12000,'S00015',37,'2022-08-04 08:38:49'),
	(2657,2534,'2022-08-04','I00192','Lengkuas','',1,'Kg',15000,'S00015',37,'2022-08-04 08:38:49'),
	(2658,2535,'2022-08-04','I00298','Tahu Jepang','',6,'Pcs',6000,'S00015',37,'2022-08-04 08:38:49'),
	(2659,2536,'2022-08-04','I00258','Pear Korea','',1,'Kg',45000,'S00015',37,'2022-08-04 08:38:49'),
	(2660,2537,'2022-08-04','I00280','Romain Lettuce','',1,'Kg',35000,'S00015',37,'2022-08-04 08:38:49'),
	(2661,2538,'2022-08-04','I00167','Kentang Besar','',20,'Kg',15000,'S00015',37,'2022-08-04 08:38:49'),
	(2662,2539,'2022-08-04','I00051','Cabe Hijau Besar','',3,'Kg',45000,'S00015',37,'2022-08-04 08:38:49'),
	(2663,2540,'2022-08-04','I00148','Jamur Enoki','',10,'Pcs',6000,'S00015',37,'2022-08-04 08:38:49'),
	(2664,2541,'2022-08-04','I00147','Jamur Champignon','',10,'Kg',43000,'S00015',37,'2022-08-04 08:38:49');

/*!40000 ALTER TABLE `is_temp_in` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table is_temp_inv
# ------------------------------------------------------------

DROP TABLE IF EXISTS `is_temp_inv`;

CREATE TABLE `is_temp_inv` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `nomor` varchar(30) NOT NULL,
  `resto` varchar(30) NOT NULL,
  `tipe` enum('Sale','Purch','Energi','Gaji','Other','Transport','Promo','Consump','Sewa') NOT NULL,
  `amount` decimal(11,0) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `createdby` int(11) NOT NULL,
  `createdon` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `is_temp_inv` WRITE;
/*!40000 ALTER TABLE `is_temp_inv` DISABLE KEYS */;

INSERT INTO `is_temp_inv` (`id`, `tanggal`, `nomor`, `resto`, `tipe`, `amount`, `keterangan`, `createdby`, `createdon`)
VALUES
	(25,'2023-05-02','INV-20230502001','3','Energi',3,'33',1,'0000-00-00 00:00:00');

/*!40000 ALTER TABLE `is_temp_inv` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table is_temp_out
# ------------------------------------------------------------

DROP TABLE IF EXISTS `is_temp_out`;

CREATE TABLE `is_temp_out` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `part_req_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `tanggal_transaksi` date NOT NULL,
  `kode_part` varchar(6) NOT NULL,
  `qty` decimal(10,0) NOT NULL,
  `created_user` int(3) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `id_barang` (`kode_part`),
  KEY `created_user` (`created_user`),
  CONSTRAINT `is_temp_out_ibfk_2` FOREIGN KEY (`created_user`) REFERENCES `is_users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table is_temp_produk
# ------------------------------------------------------------

DROP TABLE IF EXISTS `is_temp_produk`;

CREATE TABLE `is_temp_produk` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `kode_produk` varchar(6) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `kode_part` varchar(6) NOT NULL,
  `nama_part` varchar(90) NOT NULL,
  `qty` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_user` int(3) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table is_temp_req
# ------------------------------------------------------------

DROP TABLE IF EXISTS `is_temp_req`;

CREATE TABLE `is_temp_req` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode_request` varchar(30) NOT NULL DEFAULT '',
  `keterangan` varchar(30) NOT NULL DEFAULT '',
  `tanggal` date NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `kode_part` varchar(6) NOT NULL,
  `nama_item` varchar(60) NOT NULL,
  `satuan` varchar(10) NOT NULL,
  `qty` decimal(10,2) NOT NULL DEFAULT 0.00,
  `harga` decimal(10,2) NOT NULL DEFAULT 0.00,
  `diskon` decimal(10,2) NOT NULL,
  `pajak` decimal(10,2) NOT NULL,
  `jumlah` decimal(10,2) NOT NULL,
  `kode_suplier` varchar(6) NOT NULL,
  `suplier` varchar(60) NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `tipe` enum('CASH','Tempo') NOT NULL DEFAULT 'Tempo',
  `status_bayar` varchar(100) NOT NULL,
  `created_user` int(3) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `is_temp_req` WRITE;
/*!40000 ALTER TABLE `is_temp_req` DISABLE KEYS */;

INSERT INTO `is_temp_req` (`id`, `kode_request`, `keterangan`, `tanggal`, `jatuh_tempo`, `kode_part`, `nama_item`, `satuan`, `qty`, `harga`, `diskon`, `pajak`, `jumlah`, `kode_suplier`, `suplier`, `status`, `tipe`, `status_bayar`, `created_user`, `created_date`)
VALUES
	(1,'PO-20230630001','','2023-06-30','2023-06-30','I00002','DRIPP - Yuzu pulp','Btl',10.00,166500.00,0.00,0.00,1665000.00,'S00058','PT. KIWIANA PANAGIA INTERNAS',1,'CASH','Unpaid',26,'2023-06-30 08:12:35');

/*!40000 ALTER TABLE `is_temp_req` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table is_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `is_users`;

CREATE TABLE `is_users` (
  `id_user` int(3) NOT NULL AUTO_INCREMENT,
  `resto` varchar(50) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `nama_user` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `telepon` varchar(13) DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `hak_akses` enum('Super Admin','Manajer','Gudang','Finance','Purchasing') NOT NULL,
  `hari_reminder` int(11) NOT NULL DEFAULT 0,
  `status` enum('aktif','blokir') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_user`),
  KEY `level` (`hak_akses`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `is_users` WRITE;
/*!40000 ALTER TABLE `is_users` DISABLE KEYS */;

INSERT INTO `is_users` (`id_user`, `resto`, `username`, `nama_user`, `password`, `email`, `telepon`, `foto`, `hak_akses`, `hari_reminder`, `status`, `created_at`, `updated_at`)
VALUES
	(1,NULL,'Administrator','Administrator','9784b7ec358595dbf015f3b7b3fcf603','','','male.png','Super Admin',5,'aktif','2022-07-18 03:25:57','2022-07-18 03:25:57'),
	(3,NULL,'gudang','Admin Gudang','9784b7ec358595dbf015f3b7b3fcf603','','','female.png','Gudang',0,'aktif','2022-07-11 05:56:36','2022-07-11 05:56:36'),
	(8,NULL,'sasi','Nuansasi','35d8abc890af13dbedaa3f08ebac13fb',NULL,NULL,NULL,'Super Admin',0,'blokir','2019-09-21 01:37:05','2022-06-24 23:51:48'),
	(9,NULL,'opop','Popo Budiarjo','f0605836c5e879b905a455b1df6af875',NULL,NULL,NULL,'Super Admin',0,'blokir','2019-09-21 01:38:39','2022-06-24 23:51:30'),
	(10,NULL,'dewi','Dewi','fde0b737496c53bb85d07b31a02985a3',NULL,NULL,NULL,'Super Admin',0,'blokir','2019-09-21 01:39:11','2022-06-24 23:51:32'),
	(11,NULL,'Onno','Onno','0192023a7bbd73250516f069df18b500',NULL,NULL,NULL,'Super Admin',0,'aktif','2022-06-23 23:30:37','2022-07-06 21:25:36'),
	(12,NULL,'Susi','Susi','cbb7449d78314665f9e7c7dd0a18a68a',NULL,NULL,NULL,'Gudang',0,'aktif','2023-03-29 09:48:19','2023-03-29 09:48:19'),
	(26,NULL,'admin','admin','0192023a7bbd73250516f069df18b500',NULL,NULL,NULL,'Super Admin',0,'aktif','2022-07-11 01:58:36','0000-00-00 00:00:00'),
	(30,NULL,'gudang','gudang','cbb7449d78314665f9e7c7dd0a18a68a',NULL,NULL,NULL,'Gudang',0,'aktif','2022-07-11 02:15:04','0000-00-00 00:00:00'),
	(31,NULL,'manager','manager','0795151defba7a4b5dfa89170de46277','','',NULL,'Manajer',0,'aktif','2022-07-11 03:28:21','2022-07-11 03:28:21'),
	(33,NULL,'test','test','81dc9bdb52d04dc20036dbd8313ed055','','',NULL,'Super Admin',5,'aktif','2022-07-18 03:13:37','2022-07-18 03:13:37'),
	(34,NULL,'finance','finance','9784b7ec358595dbf015f3b7b3fcf603',NULL,NULL,NULL,'Finance',0,'aktif','2022-07-19 15:06:51',NULL),
	(35,NULL,'purchasing','purchasing','9784b7ec358595dbf015f3b7b3fcf603',NULL,NULL,NULL,'Purchasing',0,'aktif','2022-07-19 15:07:07',NULL),
	(36,NULL,'finance','finance','b9c9b331a8a5007cb2b766c6cd293372',NULL,NULL,NULL,'Finance',0,'aktif','2022-07-20 01:42:36',NULL),
	(37,NULL,'purchasing','purchasing','7dac69f13cbe222beee0d130c65d2222',NULL,NULL,NULL,'Purchasing',0,'aktif','2023-06-23 17:17:54','2023-06-23 17:17:54');

/*!40000 ALTER TABLE `is_users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
