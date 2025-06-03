--<!-- # 3mien_resfoods.com
--Web đặt bàn tại nhà hàng cơm quê. Đồ án CP24SCM16 - Lập trình back-end với PHP và MySQL -->
-- --------------------------------------------------------
-- Máy chủ:                      127.0.0.1
-- Phiên bản máy chủ:            10.4.32-MariaDB - mariadb.org binary distribution
-- HĐH máy chủ:                  Win64
-- HeidiSQL Phiên bản:           12.10.0.7000
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

-- Dumping structure for bảng 3mien_resfood.activity_logs
CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) DEFAULT NULL,
  `action` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `staff_id` (`staff_id`),
  CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Đang đổ dữ liệu cho bảng 3mien_resfood.activity_logs: ~0 rows (xấp xỉ)

-- Dumping structure for bảng 3mien_resfood.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1024 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Đang đổ dữ liệu cho bảng 3mien_resfood.categories: ~8 rows (xấp xỉ)
INSERT INTO `categories` (`id`, `name`, `description`) VALUES
	(1, 'Món chính', 'Các món ăn chính trong bữa ăn'),
	(2, 'Khai vị', 'Các món khai vị nhẹ'),
	(3, 'Tráng miệng', 'Món ngọt sau bữa ăn'),
	(4, 'Món nước', 'Các món ăn nước trong bữa ăn hoặc tráng miệng'),
	(5, 'Món Bắc', 'Món ăn truyền thống miền Bắc, thanh đạm, cân bằng'),
	(6, 'Món Trung', 'Món ăn miền Trung, đậm đà, cay nồng'),
	(7, 'Món Nam', 'Món ăn miền Nam, ngọt nhẹ, phong phú rau củ'),
	(1023, 'Món chè trôi nước', 'aaaaaaaaaaaa');

-- Dumping structure for bảng 3mien_resfood.customers
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
) ENGINE=InnoDB AUTO_INCREMENT=1008 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Đang đổ dữ liệu cho bảng 3mien_resfood.customers: ~7 rows (xấp xỉ)
INSERT INTO `customers` (`id`, `fullname`, `username`, `password`, `phone`, `created_at`, `rank_id`) VALUES
	(1001, '0', 'Hoàng Hào', NULL, '0123456789', '2025-05-24 08:04:21', 1),
	(1002, '', '', '$2y$10$UrVy1GjAd9ahOTS4MJEX2eYjz0zX.HKFTiQSo9D1nMKc2lXAaWjPC', '', '2025-06-02 14:22:31', 1),
	(1003, 'Nguyễn Văn Tèo', 'teo1234', '$2y$10$KOueFsgEcmUnboAx7asOS.v/kerE666f1jaZqK7CTEgMOEYK3YrIO', '0123456789', '2025-06-02 14:22:59', 1),
	(1004, 'Nguyễn Văn Tí', 'tidudu', '$2y$10$YbF2YzuuH3QB.ajzZ5ZwbO7.4.E6sQ3nWxYB6afAF5yFXCPXMi7h.', '0123456789', '2025-06-03 13:30:49', 1),
	(1005, 'Nguyễn Hoàng Hào', 'haodepzaiquatroiquadat', '$2y$10$EWZ54WmMtAD4rPi.Vm6WdOJYPTlUvjAPX1dR540fu8WTpyPMDx3UC', '0123456789', '2025-06-03 13:34:53', 1),
	(1006, 'Tú đội', 'Tú lili', '$2y$10$jZ6KdNOj0/pk7.jPj321h.VTFb41bOhAcYGOBuJT2CYw8T3pPUwB6', '0123456789', '2025-06-03 13:39:58', 1),
	(1007, 'uti', 'uti', '$2y$10$EAyLed631YAZssDE9TL3WuItjRwTmy3hNPjE.Gqy.O8vtLmqEhNVG', '1111111111', '2025-06-03 13:48:25', 1);

-- Dumping structure for bảng 3mien_resfood.exports
CREATE TABLE IF NOT EXISTS `exports` (
  `exp_id` int(11) NOT NULL AUTO_INCREMENT,
  `exp_ngay` date NOT NULL,
  `exp_ghichu` text DEFAULT NULL,
  PRIMARY KEY (`exp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Đang đổ dữ liệu cho bảng 3mien_resfood.exports: ~2 rows (xấp xỉ)
INSERT INTO `exports` (`exp_id`, `exp_ngay`, `exp_ghichu`) VALUES
	(1, '2025-05-27', 'Phiếu xuất ngày 2025-05-27'),
	(2, '2025-06-03', 'Phiếu xuất ngày 2025-06-03');

-- Dumping structure for bảng 3mien_resfood.inventory
CREATE TABLE IF NOT EXISTS `inventory` (
  `inv_id` int(11) NOT NULL AUTO_INCREMENT,
  `inv_name` varchar(100) NOT NULL,
  `inv_donvi` varchar(20) NOT NULL,
  `inv_ton_kho` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`inv_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Đang đổ dữ liệu cho bảng 3mien_resfood.inventory: ~5 rows (xấp xỉ)
INSERT INTO `inventory` (`inv_id`, `inv_name`, `inv_donvi`, `inv_ton_kho`) VALUES
	(1, 'Paracetamol 500mg', 'vỉ', 0),
	(2, 'Vitamin C 1000mg', 'hộp', 0),
	(3, 'Khẩu trang y tế', 'hộp', 0),
	(4, 'Găng tay cao su', 'đôi', 0),
	(5, 'aaaaaaa', 'kg', 1141);

-- Dumping structure for bảng 3mien_resfood.inventory_transactions
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

-- Đang đổ dữ liệu cho bảng 3mien_resfood.inventory_transactions: ~20 rows (xấp xỉ)
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

-- Dumping structure for bảng 3mien_resfood.kitchen_orders
CREATE TABLE IF NOT EXISTS `kitchen_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_item_id` int(11) DEFAULT NULL,
  `status` enum('waiting','cooking','ready') DEFAULT 'waiting',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `order_item_id` (`order_item_id`),
  CONSTRAINT `kitchen_orders_ibfk_1` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Đang đổ dữ liệu cho bảng 3mien_resfood.kitchen_orders: ~0 rows (xấp xỉ)

-- Dumping structure for bảng 3mien_resfood.menu_items
CREATE TABLE IF NOT EXISTS `menu_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `img` text NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `menu_items_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1040 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Đang đổ dữ liệu cho bảng 3mien_resfood.menu_items: ~1 rows (xấp xỉ)
INSERT INTO `menu_items` (`id`, `name`, `description`, `price`, `img`, `category_id`) VALUES
	(1037, 'Cá rô kho tộ', 'Cá rô không đồng', 22000.00, '/3mien_resfoods.com/admin/upload/img/ca-ro-kho-to-ngon-lam-nha-20250524_094505.jpg', 1);

-- Dumping structure for bảng 3mien_resfood.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `table_id` int(11) DEFAULT NULL,
  `order_time` datetime DEFAULT current_timestamp(),
  `status` enum('pending','preparing','served','paid') DEFAULT 'pending',
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `table_id` (`table_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1002 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Đang đổ dữ liệu cho bảng 3mien_resfood.orders: ~1 rows (xấp xỉ)
INSERT INTO `orders` (`id`, `customer_id`, `table_id`, `order_time`, `status`) VALUES
	(1001, 1001, 1, '2025-05-24 15:05:56', 'pending');

-- Dumping structure for bảng 3mien_resfood.order_items
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `menu_item_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `menu_item_id` (`menu_item_id`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1003 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Đang đổ dữ liệu cho bảng 3mien_resfood.order_items: ~2 rows (xấp xỉ)
INSERT INTO `order_items` (`id`, `order_id`, `menu_item_id`, `quantity`, `price`) VALUES
	(1001, 1001, 1037, 1, NULL),
	(1002, 1001, 1037, 2, NULL);

-- Dumping structure for bảng 3mien_resfood.payments
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

-- Đang đổ dữ liệu cho bảng 3mien_resfood.payments: ~0 rows (xấp xỉ)

-- Dumping structure for bảng 3mien_resfood.promotions
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

-- Đang đổ dữ liệu cho bảng 3mien_resfood.promotions: ~0 rows (xấp xỉ)

-- Dumping structure for bảng 3mien_resfood.promotion_items
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

-- Đang đổ dữ liệu cho bảng 3mien_resfood.promotion_items: ~0 rows (xấp xỉ)

-- Dumping structure for bảng 3mien_resfood.purchases
CREATE TABLE IF NOT EXISTS `purchases` (
  `pur_id` int(11) NOT NULL AUTO_INCREMENT,
  `pur_sup_id` int(11) NOT NULL,
  `pur_ngay` date NOT NULL,
  PRIMARY KEY (`pur_id`),
  KEY `pur_sup_id` (`pur_sup_id`),
  CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`pur_sup_id`) REFERENCES `suppliers` (`sup_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Đang đổ dữ liệu cho bảng 3mien_resfood.purchases: ~12 rows (xấp xỉ)
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

-- Dumping structure for bảng 3mien_resfood.purchase_detail
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

-- Đang đổ dữ liệu cho bảng 3mien_resfood.purchase_detail: ~15 rows (xấp xỉ)
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

-- Dumping structure for bảng 3mien_resfood.ranks
CREATE TABLE IF NOT EXISTS `ranks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `min_spent` decimal(10,2) DEFAULT NULL,
  `benefits` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=372 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Đang đổ dữ liệu cho bảng 3mien_resfood.ranks: ~1 rows (xấp xỉ)
INSERT INTO `ranks` (`id`, `name`, `min_spent`, `benefits`) VALUES
	(1, 'Bạc', 3000000.00, 'Miễn phí nước lọc');

-- Dumping structure for bảng 3mien_resfood.reservations
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `table_id` int(11) DEFAULT NULL,
  `reservation_time` datetime DEFAULT NULL,
  `number_of_guests` int(11) DEFAULT NULL,
  `status` enum('pending','confirmed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `table_id` (`table_id`),
  CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Đang đổ dữ liệu cho bảng 3mien_resfood.reservations: ~0 rows (xấp xỉ)

-- Dumping structure for bảng 3mien_resfood.reviews
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

-- Đang đổ dữ liệu cho bảng 3mien_resfood.reviews: ~0 rows (xấp xỉ)

-- Dumping structure for bảng 3mien_resfood.staff
CREATE TABLE IF NOT EXISTS `staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `note` varchar(50) DEFAULT NULL,
  `img` varchar(50) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1007 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Đang đổ dữ liệu cho bảng 3mien_resfood.staff: ~6 rows (xấp xỉ)
INSERT INTO `staff` (`id`, `name`, `role`, `note`, `img`, `phone`) VALUES
	(1, 'Nguyễn Hoàng Hào', 'Chủ', NULL, NULL, NULL),
	(2, 'Phan Gia Đạt', 'Quản lí', NULL, NULL, NULL),
	(3, 'Gordon James Ramsay', 'chef', 'Đầu bếp', 'Gordon-james-ramsay.jpg', NULL),
	(4, 'Wolfgang Puck', 'chef', 'Phụ bếp', 'Wolfgang-Puck.jpeg', NULL),
	(5, 'Lê Văn Tèo', 'Nhân viên phục vụ', NULL, NULL, NULL),
	(6, 'Trần Thị Mị Nương', 'Nhân viên phục vụ', NULL, NULL, NULL);

-- Dumping structure for bảng 3mien_resfood.status_tables
CREATE TABLE IF NOT EXISTS `status_tables` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `statu` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Trạng thái của Đặt bàn';

-- Đang đổ dữ liệu cho bảng 3mien_resfood.status_tables: ~3 rows (xấp xỉ)
INSERT INTO `status_tables` (`id`, `statu`) VALUES
	(1, 'Trống'),
	(2, 'Đã đặt'),
	(3, 'Đã lấy');

-- Dumping structure for bảng 3mien_resfood.suppliers
CREATE TABLE IF NOT EXISTS `suppliers` (
  `sup_id` int(11) NOT NULL AUTO_INCREMENT,
  `sup_ten` varchar(100) NOT NULL,
  `sup_phone` tinytext DEFAULT NULL,
  PRIMARY KEY (`sup_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Đang đổ dữ liệu cho bảng 3mien_resfood.suppliers: ~3 rows (xấp xỉ)
INSERT INTO `suppliers` (`sup_id`, `sup_ten`, `sup_phone`) VALUES
	(1, 'Công ty ABC', NULL),
	(2, 'Công ty Bách Khoa', NULL),
	(3, 'Công ty Dược phẩm Sài Gòn', NULL);

-- Dumping structure for bảng 3mien_resfood.tables
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

-- Đang đổ dữ liệu cho bảng 3mien_resfood.tables: ~7 rows (xấp xỉ)
INSERT INTO `tables` (`id`, `table_number`, `capacity`, `img`, `status`) VALUES
	(1, 'A01', '10', 'table-10.png', 3),
	(2, 'A02', '10', 'table-10.png', 1),
	(3, 'B01', '10', 'table-10.png', 1),
	(4, 'C01', '4', 'table-4.png', 1),
	(1023, 'D01', '2', 'table-2.png', 1),
	(1024, 'D02', '2', 'table-2.png', 1),
	(1025, 'D03', '2', 'table-2.png', 3);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

