-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.28-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.7.0.6850
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table healthcenter.patient
CREATE TABLE IF NOT EXISTS `patient` (
  `patientId` int(10) NOT NULL AUTO_INCREMENT,
  `patientName` varchar(250) NOT NULL,
  `patientGender` varchar(10) NOT NULL,
  `patientBloodType` varchar(5) NOT NULL,
  `patientNik` varchar(16) NOT NULL,
  `patientPhoneNumber` varchar(13) NOT NULL,
  `patientDateOfBirth` date NOT NULL,
  `patientPlaceOfBirth` varchar(50) NOT NULL,
  `patientAddress` varchar(250) NOT NULL,
  `patientDelete` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`patientId`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table healthcenter.patient: ~5 rows (approximately)
DELETE FROM `patient`;
INSERT INTO `patient` (`patientId`, `patientName`, `patientGender`, `patientBloodType`, `patientNik`, `patientPhoneNumber`, `patientDateOfBirth`, `patientPlaceOfBirth`, `patientAddress`, `patientDelete`) VALUES
	(1, 'Sulasmi', 'Female', 'B+', '3323200200190021', '0819098782091', '1974-06-19', 'Xamis', 'Xamis Xelasa Xenin', 0),
	(3, 'Tantiyo', 'Male', 'A-', '0001112223334445', '081208120812', '1984-12-28', 'Xenin', 'Xelasa Xabu Xamis', 0),
	(4, 'Jono Suyatmo', 'Male', 'O+', '1112223334445556', '081308130813', '1980-03-12', 'Xelasa', 'Xabu Xamis Xumat', 0),
	(5, 'Semu', 'Female', 'A-', '2223334445556667', '081408140814', '1997-04-09', 'Xabu', 'Xamis Xumat Xabtu', 0),
	(6, 'Axel Rusdiyanto', 'Male', 'O+', '3334445556667778', '081508150815', '2002-08-14', 'Xamis', 'Xumat Xabtu Xinggu', 0);

-- Dumping structure for table healthcenter.polyclinic
CREATE TABLE IF NOT EXISTS `polyclinic` (
  `polyclinicId` int(11) NOT NULL AUTO_INCREMENT,
  `polyclinicName` varchar(50) NOT NULL,
  PRIMARY KEY (`polyclinicId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table healthcenter.polyclinic: ~3 rows (approximately)
DELETE FROM `polyclinic`;
INSERT INTO `polyclinic` (`polyclinicId`, `polyclinicName`) VALUES
	(1, 'Poliklinik Umum'),
	(2, 'Poliklinik Gizi'),
	(3, 'Poliklinik Gigi');

-- Dumping structure for table healthcenter.queues
CREATE TABLE IF NOT EXISTS `queues` (
  `queuesId` int(11) NOT NULL AUTO_INCREMENT,
  `queuesPolyclinicId` int(1) NOT NULL DEFAULT 0,
  `queuesPatientId` int(1) NOT NULL DEFAULT 0,
  `queuesNo` varchar(250) NOT NULL DEFAULT '0',
  `queuesRegTime` datetime NOT NULL,
  `queuesStatus` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`queuesId`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table healthcenter.queues: ~13 rows (approximately)
DELETE FROM `queues`;
INSERT INTO `queues` (`queuesId`, `queuesPolyclinicId`, `queuesPatientId`, `queuesNo`, `queuesRegTime`, `queuesStatus`) VALUES
	(10, 3, 1, 'GI/1213/003', '2024-12-13 11:39:49', 2),
	(11, 3, 1, 'GI/1213/004', '2024-12-13 11:40:11', 2),
	(12, 3, 1, 'GI/1213/005', '2024-12-13 11:40:21', 2),
	(13, 1, 1, 'UM/1213/001', '2024-12-13 11:51:17', 0),
	(14, 3, 1, 'GI/1213/006', '2024-12-13 11:53:10', 2),
	(15, 3, 1, 'GI/1213/007', '2024-12-13 11:53:33', 1),
	(16, 1, 4, 'UM/1213/002', '2024-12-13 13:09:17', 0),
	(17, 1, 3, 'UM/1213/003', '2024-12-13 13:09:32', 0),
	(18, 3, 3, 'GI/1213/008', '2024-12-13 13:09:44', 0),
	(19, 3, 5, 'GI/1213/009', '2024-12-13 13:09:50', 0),
	(20, 2, 3, 'GZ/1213/001', '2024-12-13 13:09:58', 0),
	(21, 2, 4, 'GZ/1213/002', '2024-12-13 13:10:03', 0),
	(22, 2, 1, 'GZ/1213/003', '2024-12-13 13:10:09', 0);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
