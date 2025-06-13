-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.32-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.10.0.7000
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for 3mien_resfood
CREATE DATABASE IF NOT EXISTS `3mien_resfood` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `3mien_resfood`;

-- Dumping structure for table 3mien_resfood.activity_logs
CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) DEFAULT NULL,
  `action` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `staff_id` (`staff_id`),
  CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table 3mien_resfood.activity_logs: ~0 rows (approximately)
DELETE FROM `activity_logs`;

-- Dumping structure for table 3mien_resfood.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1024 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table 3mien_resfood.categories: ~8 rows (approximately)
DELETE FROM `categories`;
INSERT INTO `categories` (`id`, `name`, `description`) VALUES
	(1, 'Món chính', 'Các món ăn chính trong bữa ăn'),
	(2, 'Khai vị', 'Các món khai vị nhẹ'),
	(3, 'Tráng miệng', 'Món ngọt sau bữa ăn'),
	(4, 'Món nước', 'Các món ăn nước trong bữa ăn hoặc tráng miệng'),
	(5, 'Món Bắc', 'Món ăn truyền thống miền Bắc, thanh đạm, cân bằng'),
	(6, 'Món Trung', 'Món ăn miền Trung, đậm đà, cay nồng'),
	(7, 'Món Nam', 'Món ăn miền Nam, ngọt nhẹ, phong phú rau củ');

-- Dumping structure for table 3mien_resfood.contacts
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table 3mien_resfood.contacts: ~4 rows (approximately)
DELETE FROM `contacts`;
INSERT INTO `contacts` (`id`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
	(1, 'Nguyễn Hoàng Hào', 'nguyenkhoi29112005@gmail.com', 'khen', 'đồ ăn ngon!', '2025-06-11 08:24:39'),
	(2, 'Nguyễn Hoàng Hào', 'nguyenkhoi29112005@gmail.com', 'khen', 'đồ ăn rất ngon!', '2025-06-11 08:25:03'),
	(3, 'Nguyễn Hoàng Hào', 'nguyenkhoi29112005@gmail.com', 'khen', 'đồ ăn rất ngon!', '2025-06-11 08:27:02'),
	(4, 'Lê Hoàng Tú', 'nguyenkhoi29112005@gmail.com', 'khen', 'Phục vụ tốt !', '2025-06-11 08:27:24');

-- Dumping structure for table 3mien_resfood.customers
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(250) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `rank_id` int(11) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `rank_id` (`rank_id`),
  CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`rank_id`) REFERENCES `ranks` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1009 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table 3mien_resfood.customers: ~7 rows (approximately)
DELETE FROM `customers`;
INSERT INTO `customers` (`id`, `fullname`, `username`, `password`, `phone`, `created_at`, `rank_id`) VALUES
	(1001, '0', 'Hoàng Hào', NULL, '0123456789', '2025-05-24 08:04:21', 1),
	(1002, '', '', '$2y$10$UrVy1GjAd9ahOTS4MJEX2eYjz0zX.HKFTiQSo9D1nMKc2lXAaWjPC', '', '2025-06-02 14:22:31', 1),
	(1003, 'Nguyễn Văn Tèo', 'teo1234', '$2y$10$KOueFsgEcmUnboAx7asOS.v/kerE666f1jaZqK7CTEgMOEYK3YrIO', '0123456789', '2025-06-02 14:22:59', 1),
	(1004, 'Nguyễn Văn Tí', 'tidudu', '$2y$10$YbF2YzuuH3QB.ajzZ5ZwbO7.4.E6sQ3nWxYB6afAF5yFXCPXMi7h.', '0123456789', '2025-06-03 13:30:49', 1),
	(1005, 'Nguyễn Hoàng Hào', 'haodepzaiquatroiquadat', '$2y$10$EWZ54WmMtAD4rPi.Vm6WdOJYPTlUvjAPX1dR540fu8WTpyPMDx3UC', '0123456789', '2025-06-03 13:34:53', 1),
	(1006, 'Tú đội', 'Tú lili', '$2y$10$jZ6KdNOj0/pk7.jPj321h.VTFb41bOhAcYGOBuJT2CYw8T3pPUwB6', '0123456789', '2025-06-03 13:39:58', 1),
	(1007, 'uti', 'uti', '$2y$10$EAyLed631YAZssDE9TL3WuItjRwTmy3hNPjE.Gqy.O8vtLmqEhNVG', '1111111111', '2025-06-03 13:48:25', 1),
	(1008, 'Nguyễn Huỳnh Khôi', 'huynh khoi', '$2y$10$8GZS0xjWTYDW2OPkIuz7oOQG/Tp1eFjMXOUqSM8YHa4wjY9w3tDTK', '0792862535', '2025-06-11 01:00:24', 1);

-- Dumping structure for table 3mien_resfood.exports
CREATE TABLE IF NOT EXISTS `exports` (
  `exp_id` int(11) NOT NULL AUTO_INCREMENT,
  `exp_ngay` date NOT NULL,
  `exp_ghichu` text DEFAULT NULL,
  PRIMARY KEY (`exp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table 3mien_resfood.exports: ~2 rows (approximately)
DELETE FROM `exports`;
INSERT INTO `exports` (`exp_id`, `exp_ngay`, `exp_ghichu`) VALUES
	(1, '2025-05-27', 'Phiếu xuất ngày 2025-05-27'),
	(2, '2025-06-03', 'Phiếu xuất ngày 2025-06-03');

-- Dumping structure for table 3mien_resfood.inventory
CREATE TABLE IF NOT EXISTS `inventory` (
  `inv_id` int(11) NOT NULL AUTO_INCREMENT,
  `inv_name` varchar(100) NOT NULL,
  `inv_donvi` varchar(20) NOT NULL,
  `inv_ton_kho` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`inv_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table 3mien_resfood.inventory: ~5 rows (approximately)
DELETE FROM `inventory`;
INSERT INTO `inventory` (`inv_id`, `inv_name`, `inv_donvi`, `inv_ton_kho`) VALUES
	(1, 'Paracetamol 500mg', 'vỉ', 0),
	(2, 'Vitamin C 1000mg', 'hộp', 0),
	(3, 'Khẩu trang y tế', 'hộp', 0),
	(4, 'Găng tay cao su', 'đôi', 0),
	(5, 'aaaaaaa', 'kg', 1141);

-- Dumping structure for table 3mien_resfood.inventory_transactions
CREATE TABLE IF NOT EXISTS `inventory_transactions` (
  `inv_trans_id` int(11) NOT NULL AUTO_INCREMENT,
  `inv_trans_inv_id` int(11) NOT NULL,
  `inv_trans_loai` varchar(10) NOT NULL,
  `inv_trans_soluong` int(11) NOT NULL,
  `inv_trans_ngay` date NOT NULL,
  `inv_trans_ghichu` text DEFAULT NULL,
  `inv_trans_exp_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`inv_trans_id`),
  KEY `inv_trans_inv_id` (`inv_trans_inv_id`),
  KEY `inv_trans_exp_id` (`inv_trans_exp_id`),
  CONSTRAINT `inventory_transactions_ibfk_1` FOREIGN KEY (`inv_trans_inv_id`) REFERENCES `inventory` (`inv_id`),
  CONSTRAINT `inventory_transactions_ibfk_2` FOREIGN KEY (`inv_trans_exp_id`) REFERENCES `exports` (`exp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table 3mien_resfood.inventory_transactions: ~20 rows (approximately)
DELETE FROM `inventory_transactions`;
INSERT INTO `inventory_transactions` (`inv_trans_id`, `inv_trans_inv_id`, `inv_trans_loai`, `inv_trans_soluong`, `inv_trans_ngay`, `inv_trans_ghichu`, `inv_trans_exp_id`) VALUES
	(1, 1, 'nhap', 100, '2024-05-01', 'Nhập từ NCC ABC', NULL),
	(2, 3, 'nhap', 50, '2024-05-01', 'Nhập từ NCC ABC', NULL),
	(3, 2, 'nhap', 200, '2024-05-02', 'Nhập từ NCC Bách Khoa', NULL),
	(4, 4, 'nhap', 100, '2024-05-02', 'Nhập từ NCC Bách Khoa', NULL),
	(5, 1, 'nhap', 50, '2024-05-05', 'Nhập từ NCC SG', NULL),
	(6, 4, 'nhap', 150, '2024-05-05', 'Nhập từ NCC SG', NULL),
	(7, 1, 'xuat', 30, '2024-05-06', 'Xuất cho khách hàng A', NULL),
	(8, 4, 'xuat', 50, '2024-05-06', 'Xuất cho khách hàng B', NULL),
	(9, 5, 'nhap', 22, '2025-05-27', 'Phiếu nhập #4', NULL),
	(10, 5, 'nhap', 22, '2025-05-27', 'Phiếu nhập #5', NULL),
	(11, 5, 'nhap', 22, '2025-05-27', 'Phiếu nhập #6', NULL),
	(12, 5, 'nhap', 22, '2025-05-27', 'Phiếu nhập #7', NULL),
	(13, 5, 'nhap', 22, '2025-05-27', 'Phiếu nhập #8', NULL),
	(14, 5, 'nhap', 10, '2025-05-27', 'Phiếu nhập #9', NULL),
	(18, 5, 'nhap', 22, '2025-05-27', 'Phiếu nhập #13', NULL),
	(19, 5, 'nhap', 8, '2025-05-27', 'Phiếu nhập #14', NULL),
	(20, 5, 'xuat', 44, '2025-05-27', 'xóa 44', NULL),
	(21, 5, 'xuat', 44, '2025-05-27', 'xuất 44', 1),
	(22, 5, 'nhap', 1111, '2025-06-03', 'Phiếu nhập #15', NULL),
	(23, 5, 'xuat', 1000, '2025-06-03', 'xuất a', 2);

-- Dumping structure for table 3mien_resfood.kitchen_orders
CREATE TABLE IF NOT EXISTS `kitchen_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_item_id` int(11) DEFAULT NULL,
  `status` enum('waiting','cooking','ready') DEFAULT 'waiting',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `order_item_id` (`order_item_id`),
  CONSTRAINT `kitchen_orders_ibfk_1` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table 3mien_resfood.kitchen_orders: ~0 rows (approximately)
DELETE FROM `kitchen_orders`;

-- Dumping structure for table 3mien_resfood.menu_items
CREATE TABLE IF NOT EXISTS `menu_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `img` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1103 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table 3mien_resfood.menu_items: ~48 rows (approximately)
DELETE FROM `menu_items`;
INSERT INTO `menu_items` (`id`, `menu_name`, `description`, `price`, `img`) VALUES
	(1056, 'Bánh cuốn', 'Bánh cuốn chả', 30000.00, '/3mien_resfoods.com/admin/upload/img/banh-cuon-20250610_144225.jpg'),
	(1057, 'Bánh canh cá lóc', 'Bánh canh cá lóc phi lê', 35000.00, '/3mien_resfoods.com/admin/upload/img/banh canh ca loc-20250610_144408.jpg'),
	(1058, 'Bánh khọt', 'Bánh khọt tôm đậu xanh', 30000.00, '/3mien_resfoods.com/admin/upload/img/banh-khot-20250610_144457.jpg'),
	(1059, 'Bánh xèo', 'Bánh xèo Nam bộ', 30000.00, '/3mien_resfoods.com/admin/upload/img/banh-xeo-20250610_144553.jpg'),
	(1060, 'Bò kho', 'Bò kho với cà rốt khoai tây', 39000.00, '/3mien_resfoods.com/admin/upload/img/bo-kho-20250610_144643.jpg'),
	(1061, 'Bò lá lốt', 'Bò lá lốt nướng ', 39000.00, '/3mien_resfoods.com/admin/upload/img/bo-la-lot-20250610_144728.jpg'),
	(1062, 'Bò lúc lắc', 'Bò lúc lắc với khoai tây chiên giòn', 39000.00, '/3mien_resfoods.com/admin/upload/img/bo-luc-lac-20250610_144822.jpg'),
	(1063, 'Bò né', 'Bò né dùng với bánh mì và rau sống', 39000.00, '/3mien_resfoods.com/admin/upload/img/bo-ne-20250610_144917.jpg'),
	(1064, 'Bột chiên', 'Bột chiên ngoài giòn trong dẻo', 25000.00, '/3mien_resfoods.com/admin/upload/img/bot-chien-20250610_145016.jpg'),
	(1065, 'Bún bò Huế', 'Đặc sản xứ Huế', 39000.00, '/3mien_resfoods.com/admin/upload/img/bun-bo-hue-20250610_145140.webp'),
	(1066, 'Bún bò Nam Bộ', 'Đậm đà hương vị Nam Bộ', 39000.00, '/3mien_resfoods.com/admin/upload/img/bun-bo-nam-bo-20250610_145400.jpg'),
	(1067, 'Bún đậu mắm tôm', 'Đặc sẳn Miền Bắc', 39000.00, '/3mien_resfoods.com/admin/upload/img/bun-dau-mam-tom-20250610_145505.jpg'),
	(1068, 'Bún riêu', 'Bún riêu cua', 35000.00, '/3mien_resfoods.com/admin/upload/img/bun-rieu-20250610_145539.jpg'),
	(1069, 'Cá lóc kho tộ', 'Cá lóc đồng', 39000.00, '/3mien_resfoods.com/admin/upload/img/ca-loc-20250610_145619.jpg'),
	(1070, 'Canh chua cá lóc', 'Canh chua cá lóc đồng', 35000.00, '/3mien_resfoods.com/admin/upload/img/canh-chua-20250610_145701.jpg'),
	(1071, 'Cao lầu', 'Đặc sản Hội An', 39000.00, '/3mien_resfoods.com/admin/upload/img/cao-lau-20250610_145742.jpg'),
	(1072, 'Cà phê sữa đá', 'Cà phê sữa đậm đà', 20000.00, '/3mien_resfoods.com/admin/upload/img/ca-phe-sua-20250610_145843.jpg'),
	(1073, 'Cà phê trứng', 'Cà phê trứng béo ngậy', 20000.00, '/3mien_resfoods.com/admin/upload/img/ca-phe-trung-20250610_145931.jpg'),
	(1074, 'Chè bắp', 'Chè bắp', 25000.00, '/3mien_resfoods.com/admin/upload/img/che-bap-20250610_150012.jpg'),
	(1075, 'Chè bưởi', 'Chè bưởi', 25000.00, '/3mien_resfoods.com/admin/upload/img/che-buoi-20250610_150046.jpg'),
	(1076, 'Chè chuối', 'Chè chuối', 25000.00, '/3mien_resfoods.com/admin/upload/img/che-chuoi-20250610_150118.jpg'),
	(1077, 'Chè khoai dẻo', 'Chè khoai dẻo', 25000.00, '/3mien_resfoods.com/admin/upload/img/che-khoai-deo-20250610_150151.jpg'),
	(1078, 'Chè khúc bạch', 'Chè khúc bạch', 25000.00, '/3mien_resfoods.com/admin/upload/img/che-khuc-bach-20250610_150250.jpg'),
	(1079, 'Chè mít đác', 'Chè mít đác', 25000.00, '/3mien_resfoods.com/admin/upload/img/che-mit-dac-20250610_150327.jpg'),
	(1080, 'Cơm hến', 'Đặc sản Phú Quốc', 30000.00, '/3mien_resfoods.com/admin/upload/img/com-hen-20250610_150413.jpg'),
	(1081, 'Nước dừa', 'Nước dừa thanh mát', 20000.00, '/3mien_resfoods.com/admin/upload/img/dua-20250610_150519.webp'),
	(1082, 'Đuông dừa tắm mắm', 'Đặc sản Nam bộ', 59000.00, '/3mien_resfoods.com/admin/upload/img/duong-dua-tam-mam-20250610_150731.jpg'),
	(1083, 'Nước ép chanh', 'Giải khát', 20000.00, '/3mien_resfoods.com/admin/upload/img/ep-chanh-20250610_150901.jpg'),
	(1084, 'Gà nướng', 'Gà nồi thả vườn', 79000.00, '/3mien_resfoods.com/admin/upload/img/ga-nuong-20250610_150943.jpg'),
	(1085, 'Gỏi cá trích', 'Gỏi cá trích đặc sản Nha Trang', 39000.00, '/3mien_resfoods.com/admin/upload/img/goi-ca-trich-20250610_151258.jpg'),
	(1086, 'Gỏi cuốn', 'Gỏi cuốn tôm thịt ba chỉ', 39000.00, '/3mien_resfoods.com/admin/upload/img/goi-cuon-20250610_153106.jpg'),
	(1087, 'Gỏi xoài', 'Gỏi xoài khô cá lóc', 39000.00, '/3mien_resfoods.com/admin/upload/img/goi-xoai-20250610_153231.jpg'),
	(1088, 'Hủ tiếu', 'Hủ tiếu xương', 30000.00, '/3mien_resfoods.com/admin/upload/img/hu-tieu-20250610_153322.jpg'),
	(1089, 'Mì Quảng', 'Đặc sản Quảng Nam', 39000.00, '/3mien_resfoods.com/admin/upload/img/mi-quang-20250610_153439.jpg'),
	(1090, 'Nem rán (chả giò)', 'Nem rán giòn', 35000.00, '/3mien_resfoods.com/admin/upload/img/nem-ran-20250610_153522.jpg'),
	(1091, 'Nộm đu đủ', 'Gỏi đu đủ xoài xanh giòn ngon', 39000.00, '/3mien_resfoods.com/admin/upload/img/nom-du-du-20250610_155435.jpg'),
	(1092, 'Nộm hoa chuối', 'Nộm hoa chuối mộc mạc nhưng ngon', 39000.00, '/3mien_resfoods.com/admin/upload/img/nom-hoa-chuoi-20250610_155520.jpg'),
	(1093, 'Ốc bưu nướng tiêu', 'Ốc bưu đen nướng tiêu xanh', 49000.00, '/3mien_resfoods.com/admin/upload/img/oc-buu-nuong-20250610_155607.jpg'),
	(1094, 'Phở bò', 'Đặc sản Hà Nội', 39000.00, '/3mien_resfoods.com/admin/upload/img/p-20250610_155654.jpg'),
	(1095, 'Rau muống xào tỏi', 'Rau muống xào giòn ngon', 29000.00, '/3mien_resfoods.com/admin/upload/img/rau-20250610_155824.jpg'),
	(1096, 'Soda', 'Giải khát', 20000.00, '/3mien_resfoods.com/admin/upload/img/soda-20250610_160810.jpg'),
	(1097, 'Sườn xào chua ngọt ', 'Sườn heo xào chua ngọt', 39000.00, '/3mien_resfoods.com/admin/upload/img/suon-kho-20250610_160849.jpg'),
	(1098, 'Súp cua', 'Súp cua', 25000.00, '/3mien_resfoods.com/admin/upload/img/sup-cua-20250610_160930.jpg'),
	(1099, 'Thịt heo kho tộ', 'Thịt heo kho tộ', 39000.00, '/3mien_resfoods.com/admin/upload/img/thit-heo-kho-20250610_161012.jpg'),
	(1100, 'Trà trái cây', 'Trà trái cây nhiệt đới', 25000.00, '/3mien_resfoods.com/admin/upload/img/tra-trai-cay-20250610_161055.jpg'),
	(1101, 'Vịt quay', 'Vịt quay', 89000.00, '/3mien_resfoods.com/admin/upload/img/vit-quay-20250610_161141.jpg'),
	(1102, 'Xôi', 'Xôi', 25000.00, '/3mien_resfoods.com/admin/upload/img/xoi-20250610_161204.jpg');

-- Dumping structure for table 3mien_resfood.menu_item_categories
CREATE TABLE IF NOT EXISTS `menu_item_categories` (
  `menu_item_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`menu_item_id`,`category_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `menu_item_categories_ibfk_1` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `menu_item_categories_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table 3mien_resfood.menu_item_categories: ~81 rows (approximately)
DELETE FROM `menu_item_categories`;
INSERT INTO `menu_item_categories` (`menu_item_id`, `category_id`) VALUES
	(1056, 2),
	(1057, 1),
	(1057, 4),
	(1057, 7),
	(1058, 1),
	(1058, 2),
	(1058, 7),
	(1059, 1),
	(1059, 2),
	(1059, 7),
	(1060, 1),
	(1060, 4),
	(1060, 7),
	(1061, 1),
	(1061, 2),
	(1062, 1),
	(1062, 2),
	(1063, 1),
	(1063, 2),
	(1063, 7),
	(1064, 2),
	(1065, 1),
	(1065, 4),
	(1065, 6),
	(1066, 4),
	(1066, 7),
	(1067, 1),
	(1067, 5),
	(1068, 4),
	(1068, 7),
	(1069, 1),
	(1069, 7),
	(1070, 1),
	(1070, 4),
	(1070, 7),
	(1071, 1),
	(1071, 4),
	(1071, 6),
	(1072, 3),
	(1073, 3),
	(1074, 3),
	(1075, 3),
	(1076, 3),
	(1077, 3),
	(1078, 3),
	(1079, 3),
	(1080, 1),
	(1080, 7),
	(1081, 3),
	(1082, 1),
	(1082, 2),
	(1082, 7),
	(1083, 3),
	(1084, 1),
	(1085, 2),
	(1085, 7),
	(1086, 1),
	(1086, 2),
	(1087, 2),
	(1087, 7),
	(1088, 1),
	(1088, 4),
	(1089, 1),
	(1089, 4),
	(1089, 6),
	(1090, 1),
	(1090, 2),
	(1091, 2),
	(1091, 7),
	(1092, 2),
	(1093, 1),
	(1093, 2),
	(1093, 7),
	(1094, 1),
	(1094, 4),
	(1094, 5),
	(1095, 1),
	(1096, 3),
	(1097, 1),
	(1098, 2),
	(1099, 1),
	(1100, 3),
	(1101, 1),
	(1102, 2);

-- Dumping structure for table 3mien_resfood.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `table_id` int(11) DEFAULT NULL,
  `booking_time` datetime DEFAULT NULL,
  `note` varchar(250) DEFAULT NULL,
  `order_time` datetime DEFAULT current_timestamp(),
  `status` int(11) unsigned DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `table_id` (`table_id`),
  KEY `FK_orders_order_status` (`status`),
  CONSTRAINT `FK_orders_order_status` FOREIGN KEY (`status`) REFERENCES `order_status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1032 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table 3mien_resfood.orders: ~19 rows (approximately)
DELETE FROM `orders`;
INSERT INTO `orders` (`id`, `customer_id`, `table_id`, `booking_time`, `note`, `order_time`, `status`) VALUES
	(1001, 1001, 1, NULL, NULL, '2025-05-24 15:05:56', 1),
	(1009, 1007, 1, '2025-07-12 22:07:00', '', '2025-06-04 22:07:10', 1),
	(1010, 1007, 1, '2025-07-12 22:07:00', '', '2025-06-04 22:10:10', 1),
	(1011, 1007, 1, '2025-07-12 22:07:00', '', '2025-06-04 22:11:00', 1),
	(1012, 1007, 1, '2025-07-12 22:07:00', '', '2025-06-04 22:12:21', 1),
	(1013, 1007, 1, '2025-07-12 22:07:00', '', '2025-06-04 22:12:40', 1),
	(1014, 1007, 1, '2025-07-12 22:07:00', '', '2025-06-04 22:13:26', 1),
	(1015, 1007, 1, '2025-07-12 22:07:00', '', '2025-06-04 22:13:48', 1),
	(1016, 1007, 1, '2025-07-12 22:07:00', '', '2025-06-04 22:16:45', 1),
	(1017, 1007, 1, '2025-06-04 14:17:00', '', '2025-06-04 22:17:44', 1),
	(1018, 1007, 1, '2025-06-04 14:17:00', '', '2025-06-04 22:21:15', 1),
	(1019, 1007, 1, '2025-06-04 14:17:00', '', '2025-06-04 22:21:36', 1),
	(1020, 1007, 1, '2025-06-04 14:17:00', '', '2025-06-04 22:22:38', 1),
	(1021, 1007, 1, '2025-06-05 00:25:00', '', '2025-06-04 22:23:16', 1),
	(1026, 1007, NULL, '0000-00-00 00:00:00', '', '2025-06-04 22:42:14', 1),
	(1027, 1007, NULL, '0000-00-00 00:00:00', '', '2025-06-04 22:44:02', 1),
	(1028, 1007, NULL, '0000-00-00 00:00:00', '', '2025-06-04 22:47:28', 1),
	(1030, 1007, 4, '2025-07-11 22:56:00', 'â', '2025-06-04 22:56:39', 1),
	(1031, 1007, 1025, '2025-06-26 22:59:00', 'adu', '2025-06-04 22:59:15', 1);

-- Dumping structure for table 3mien_resfood.order_items
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `menu_item_id` int(11) DEFAULT NULL,
  `note` varchar(250) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `price` decimal(20,6) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `menu_item_id` (`menu_item_id`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1022 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table 3mien_resfood.order_items: ~0 rows (approximately)
DELETE FROM `order_items`;

-- Dumping structure for table 3mien_resfood.order_status
CREATE TABLE IF NOT EXISTS `order_status` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table 3mien_resfood.order_status: ~4 rows (approximately)
DELETE FROM `order_status`;
INSERT INTO `order_status` (`id`, `status`) VALUES
	(1, 'Đang chờ'),
	(2, 'Đang chuẩn bị'),
	(3, 'Đã phục vụ'),
	(4, 'Đã thanh toán');

-- Dumping structure for table 3mien_resfood.payments
CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `payment_time` datetime DEFAULT current_timestamp(),
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_method` enum('cash','card','e-wallet') DEFAULT 'cash',
  `status` enum('paid','unpaid') DEFAULT 'unpaid',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table 3mien_resfood.payments: ~0 rows (approximately)
DELETE FROM `payments`;

-- Dumping structure for table 3mien_resfood.promotions
CREATE TABLE IF NOT EXISTS `promotions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `discount_percent` decimal(5,2) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1001 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table 3mien_resfood.promotions: ~0 rows (approximately)
DELETE FROM `promotions`;

-- Dumping structure for table 3mien_resfood.promotion_items
CREATE TABLE IF NOT EXISTS `promotion_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `promotion_id` int(11) DEFAULT NULL,
  `menu_item_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `promotion_id` (`promotion_id`),
  KEY `menu_item_id` (`menu_item_id`),
  CONSTRAINT `promotion_items_ibfk_1` FOREIGN KEY (`promotion_id`) REFERENCES `promotions` (`id`),
  CONSTRAINT `promotion_items_ibfk_2` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table 3mien_resfood.promotion_items: ~0 rows (approximately)
DELETE FROM `promotion_items`;

-- Dumping structure for table 3mien_resfood.purchases
CREATE TABLE IF NOT EXISTS `purchases` (
  `pur_id` int(11) NOT NULL AUTO_INCREMENT,
  `pur_sup_id` int(11) NOT NULL,
  `pur_ngay` date NOT NULL,
  PRIMARY KEY (`pur_id`),
  KEY `pur_sup_id` (`pur_sup_id`),
  CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`pur_sup_id`) REFERENCES `suppliers` (`sup_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table 3mien_resfood.purchases: ~12 rows (approximately)
DELETE FROM `purchases`;
INSERT INTO `purchases` (`pur_id`, `pur_sup_id`, `pur_ngay`) VALUES
	(1, 1, '2024-05-01'),
	(2, 2, '2024-05-02'),
	(3, 3, '2024-05-05'),
	(4, 1, '2025-05-27'),
	(5, 1, '2025-05-27'),
	(6, 1, '2025-05-27'),
	(7, 1, '2025-05-27'),
	(8, 1, '2025-05-27'),
	(9, 2, '2025-05-27'),
	(13, 1, '2025-05-27'),
	(14, 1, '2025-05-27'),
	(15, 1, '2025-06-03');

-- Dumping structure for table 3mien_resfood.purchase_detail
CREATE TABLE IF NOT EXISTS `purchase_detail` (
  `pur_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `pur_item_pur_id` int(11) NOT NULL,
  `pur_item_inv_id` int(11) NOT NULL,
  `pur_item_soluong` int(11) NOT NULL,
  `pur_item_dongia` decimal(12,2) NOT NULL,
  PRIMARY KEY (`pur_item_id`),
  KEY `pur_item_pur_id` (`pur_item_pur_id`),
  KEY `pur_item_inv_id` (`pur_item_inv_id`),
  CONSTRAINT `purchase_detail_ibfk_1` FOREIGN KEY (`pur_item_pur_id`) REFERENCES `purchases` (`pur_id`),
  CONSTRAINT `purchase_detail_ibfk_2` FOREIGN KEY (`pur_item_inv_id`) REFERENCES `inventory` (`inv_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table 3mien_resfood.purchase_detail: ~15 rows (approximately)
DELETE FROM `purchase_detail`;
INSERT INTO `purchase_detail` (`pur_item_id`, `pur_item_pur_id`, `pur_item_inv_id`, `pur_item_soluong`, `pur_item_dongia`) VALUES
	(1, 1, 1, 100, 1200.00),
	(2, 1, 3, 50, 10000.00),
	(3, 2, 2, 200, 15000.00),
	(4, 2, 4, 100, 5000.00),
	(5, 3, 1, 50, 1300.00),
	(6, 3, 4, 150, 4800.00),
	(7, 4, 5, 22, 10.00),
	(8, 5, 5, 22, 10.00),
	(9, 6, 5, 22, 10.00),
	(10, 7, 5, 22, 10.00),
	(11, 8, 5, 22, 10.00),
	(12, 9, 5, 10, 100.00),
	(16, 13, 5, 22, 444.00),
	(17, 14, 5, 8, 333.00),
	(18, 15, 5, 1111, 20000.00);

-- Dumping structure for table 3mien_resfood.ranks
CREATE TABLE IF NOT EXISTS `ranks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `min_spent` decimal(10,2) DEFAULT NULL,
  `benefits` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=372 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table 3mien_resfood.ranks: ~0 rows (approximately)
DELETE FROM `ranks`;
INSERT INTO `ranks` (`id`, `name`, `min_spent`, `benefits`) VALUES
	(1, 'Bạc', 3000000.00, 'Miễn phí nước lọc');

-- Dumping structure for table 3mien_resfood.reservations
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reservation_time` datetime DEFAULT NULL,
  `order_id` int(11) NOT NULL,
  `status` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `FK_reservations_reservations_status` (`status`),
  KEY `FK_reservations_menu_items` (`order_id`) USING BTREE,
  CONSTRAINT `FK_reservations_order_items` FOREIGN KEY (`order_id`) REFERENCES `order_items` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_reservations_reservations_status` FOREIGN KEY (`status`) REFERENCES `reservations_status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table 3mien_resfood.reservations: ~0 rows (approximately)
DELETE FROM `reservations`;

-- Dumping structure for table 3mien_resfood.reservations_status
CREATE TABLE IF NOT EXISTS `reservations_status` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table 3mien_resfood.reservations_status: ~3 rows (approximately)
DELETE FROM `reservations_status`;
INSERT INTO `reservations_status` (`id`, `status`) VALUES
	(1, 'Đang chờ'),
	(2, 'Đã xác nhận'),
	(3, 'Đã hủy');

-- Dumping structure for table 3mien_resfood.reviews
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `menu_item_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `menu_item_id` (`menu_item_id`),
  CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table 3mien_resfood.reviews: ~0 rows (approximately)
DELETE FROM `reviews`;

-- Dumping structure for table 3mien_resfood.staff
CREATE TABLE IF NOT EXISTS `staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `note` varchar(50) DEFAULT NULL,
  `img` varchar(50) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1007 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table 3mien_resfood.staff: ~6 rows (approximately)
DELETE FROM `staff`;
INSERT INTO `staff` (`id`, `name`, `role`, `note`, `img`, `phone`) VALUES
	(1, 'Nguyễn Hoàng Hào', 'Chủ', NULL, NULL, NULL),
	(2, 'Phan Gia Đạt', 'Quản lí', NULL, NULL, NULL),
	(3, 'Gordon James Ramsay', 'chef', 'Đầu bếp', 'Gordon-james-ramsay.jpg', NULL),
	(4, 'Wolfgang Puck', 'chef', 'Phụ bếp', 'Wolfgang-Puck.jpeg', NULL),
	(5, 'Lê Văn Tèo', 'Nhân viên phục vụ', NULL, NULL, NULL),
	(6, 'Trần Thị Mị Nương', 'Nhân viên phục vụ', NULL, NULL, NULL);

-- Dumping structure for table 3mien_resfood.status_tables
CREATE TABLE IF NOT EXISTS `status_tables` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `statu` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Trạng thái của Đặt bàn';

-- Dumping data for table 3mien_resfood.status_tables: ~3 rows (approximately)
DELETE FROM `status_tables`;
INSERT INTO `status_tables` (`id`, `statu`) VALUES
	(1, 'Trống'),
	(2, 'Đã đặt'),
	(3, 'Đã lấy');

-- Dumping structure for table 3mien_resfood.suppliers
CREATE TABLE IF NOT EXISTS `suppliers` (
  `sup_id` int(11) NOT NULL AUTO_INCREMENT,
  `sup_ten` varchar(100) NOT NULL,
  `sup_phone` tinytext DEFAULT NULL,
  PRIMARY KEY (`sup_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table 3mien_resfood.suppliers: ~3 rows (approximately)
DELETE FROM `suppliers`;
INSERT INTO `suppliers` (`sup_id`, `sup_ten`, `sup_phone`) VALUES
	(1, 'Công ty ABC', NULL),
	(2, 'Công ty Bách Khoa', NULL),
	(3, 'Công ty Dược phẩm Sài Gòn', NULL);

-- Dumping structure for table 3mien_resfood.tables
CREATE TABLE IF NOT EXISTS `tables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `table_number` varchar(10) NOT NULL,
  `capacity` varchar(50) DEFAULT NULL,
  `img` varchar(100) DEFAULT NULL,
  `status` int(10) unsigned DEFAULT 3,
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  CONSTRAINT `FK_tables_status_tables` FOREIGN KEY (`status`) REFERENCES `status_tables` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1026 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table 3mien_resfood.tables: ~7 rows (approximately)
DELETE FROM `tables`;
INSERT INTO `tables` (`id`, `table_number`, `capacity`, `img`, `status`) VALUES
	(1, 'A01', '10', 'table-10.png', 3),
	(2, 'A02', '10', 'table-10.png', 1),
	(3, 'B01', '10', 'table-10.png', 1),
	(4, 'C01', '4', 'table-4.png', 1),
	(1023, 'D01', '2', 'table-2.png', 1),
	(1024, 'D02', '2', 'table-2.png', 1),
	(1025, 'D03', '2', 'table-2.png', 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;