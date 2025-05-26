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
) ENGINE=InnoDB AUTO_INCREMENT=1008 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Đang đổ dữ liệu cho bảng 3mien_resfood.categories: ~7 rows (xấp xỉ)
INSERT INTO `categories` (`id`, `name`, `description`) VALUES
	(1, 'Món chính', 'Các món ăn chính trong bữa ăn'),
	(2, 'Khai vị', 'Các món khai vị nhẹ'),
	(3, 'Tráng miệng', 'Món ngọt sau bữa ăn'),
	(4, 'Món nước', 'Các món ăn nước trong bữa ăn hoặc tráng miệng'),
	(5, 'Món Bắc', 'Món ăn truyền thống miền Bắc, thanh đạm, cân bằng'),
	(6, 'Món Trung', 'Món ăn miền Trung, đậm đà, cay nồng'),
	(7, 'Món Nam', 'Món ăn miền Nam, ngọt nhẹ, phong phú rau củ');

-- Dumping structure for bảng 3mien_resfood.customers
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `rank_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rank_id` (`rank_id`),
  CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`rank_id`) REFERENCES `ranks` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1001 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Đang đổ dữ liệu cho bảng 3mien_resfood.customers: ~0 rows (xấp xỉ)

-- Dumping structure for bảng 3mien_resfood.inventory
CREATE TABLE IF NOT EXISTS `inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `unit` varchar(20) DEFAULT NULL,
  `quantity` decimal(10,2) DEFAULT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1024 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Đang đổ dữ liệu cho bảng 3mien_resfood.inventory: ~23 rows (xấp xỉ)
INSERT INTO `inventory` (`id`, `name`, `unit`, `quantity`, `last_updated`) VALUES
	(1, 'Củ cải', 'kg', 10.00, '2025-05-08 10:07:53'),
	(2, 'Cà rốt', 'kg', 15.00, '2025-05-08 10:07:53'),
	(3, 'Hành muối', 'kg', 5.00, '2025-05-08 10:07:53'),
	(4, 'Đậu bắp', 'kg', 20.00, '2025-05-08 10:07:53'),
	(5, 'Bầu', 'kg', 10.00, '2025-05-08 10:07:53'),
	(6, 'Tỏi', 'kg', 5.00, '2025-05-08 10:07:53'),
	(7, 'Bắp ngô', 'cái', 50.00, '2025-05-08 10:07:53'),
	(8, 'Hành lá', 'kg', 20.00, '2025-05-08 10:07:53'),
	(9, 'Cá rô đồng', 'kg', 30.00, '2025-05-08 10:07:53'),
	(10, 'Nước mắm', 'lit', 5.00, '2025-05-08 10:07:53'),
	(11, 'Tiêu', 'kg', 2.00, '2025-05-08 10:07:53'),
	(12, 'Thịt ba chỉ', 'kg', 50.00, '2025-05-08 10:07:53'),
	(13, 'Trứng gà', 'cái', 100.00, '2025-05-08 10:07:53'),
	(14, 'Cà chua', 'kg', 30.00, '2025-05-08 10:07:53'),
	(15, 'Đậu hũ', 'cái', 200.00, '2025-05-08 10:07:53'),
	(16, 'Rau muống', 'kg', 15.00, '2025-05-08 10:07:53'),
	(17, 'Cải', 'kg', 10.00, '2025-05-08 10:07:53'),
	(18, 'Đậu phộng', 'kg', 5.00, '2025-05-08 10:07:53'),
	(19, 'Nếp', 'kg', 50.00, '2025-05-08 10:07:53'),
	(20, 'Khoai lang', 'kg', 40.00, '2025-05-08 10:07:53'),
	(21, 'Chuối', 'kg', 15.00, '2025-05-08 10:07:53'),
	(22, 'Đậu xanh', 'kg', 25.00, '2025-05-08 10:07:53'),
	(23, 'Bắp nếp', 'cái', 50.00, '2025-05-08 10:07:53');

-- Dumping structure for bảng 3mien_resfood.inventory_transactions
CREATE TABLE IF NOT EXISTS `inventory_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inventory_item_id` int(11) DEFAULT NULL,
  `transaction_type` enum('in','out') DEFAULT NULL,
  `quantity` decimal(10,2) DEFAULT NULL,
  `transaction_date` date DEFAULT curdate(),
  `note` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `inventory_item_id` (`inventory_item_id`),
  CONSTRAINT `inventory_transactions_ibfk_1` FOREIGN KEY (`inventory_item_id`) REFERENCES `inventory` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Đang đổ dữ liệu cho bảng 3mien_resfood.inventory_transactions: ~0 rows (xấp xỉ)

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
  `category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `menu_items_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1032 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Đang đổ dữ liệu cho bảng 3mien_resfood.menu_items: ~31 rows (xấp xỉ)
INSERT INTO `menu_items` (`id`, `name`, `description`, `price`, `category_id`) VALUES
	(1, 'Cà phê sữa đá', 'Cà phê pha với sữa đặc, dùng với đá', 25000.00, 4),
	(2, 'Trà đào', 'Trà vị đào thơm mát, kèm lát đào', 30000.00, 4),
	(3, 'Sinh tố bơ', 'Sinh tố từ quả bơ tươi, béo ngậy', 35000.00, 4),
	(4, 'Nước suối', 'Nước khoáng đóng chai', 10000.00, 4),
	(5, 'Coca-Cola', 'Nước ngọt có gas', 15000.00, 4),
	(6, 'Cà phê sữa đá', 'Cà phê pha với sữa đặc, dùng với đá', 25000.00, 4),
	(7, 'Trà đào', 'Trà vị đào thơm mát, kèm lát đào', 30000.00, 4),
	(8, 'Sinh tố bơ', 'Sinh tố từ quả bơ tươi, béo ngậy', 35000.00, 4),
	(9, 'Nước suối', 'Nước khoáng đóng chai', 10000.00, 4),
	(10, 'Coca-Cola', 'Nước ngọt có gas', 15000.00, 4),
	(11, 'Chả cá Lã Vọng', 'Cá nướng nghệ ăn kèm bún, rau thơm', 75000.00, 5),
	(12, 'Thịt đông', 'Thịt heo nấu đông, dùng lạnh, món ăn ngày Tết', 60000.00, 5),
	(13, 'Canh cua mồng tơi', 'Canh cua đồng nấu rau mồng tơi', 45000.00, 5),
	(14, 'Bún bò Huế', 'Món bún nổi tiếng xứ Huế, cay nồng', 55000.00, 6),
	(15, 'Cơm hến', 'Cơm trộn với hến xào, rau thơm, mắm ruốc', 50000.00, 6),
	(16, 'Bánh bột lọc', 'Bánh nhỏ dai dai, nhân tôm thịt, ăn kèm nước mắm', 30000.00, 6),
	(17, 'Cá kho tộ', 'Cá kho với nước màu, tiêu, ăn kèm cơm trắng', 60000.00, 7),
	(18, 'Canh chua cá', 'Canh chua nấu với cá, cà chua, thơm, rau ngò', 50000.00, 7),
	(19, 'Gỏi cuốn', 'Cuốn tôm, thịt, bún, rau chấm mắm nêm', 40000.00, 7),
	(20, 'Dưa món', 'Củ cải, cà rốt, hành muối chua ngọt ăn kèm', 15000.00, 2),
	(21, 'Rau luộc chấm kho quẹt', 'Đậu bắp, bầu, cà rốt... luộc ăn với mắm kho quẹt', 25000.00, 2),
	(22, 'Bắp xào mỡ hành', 'Bắp ngô xào tỏi, hành lá, đậm vị dân quê', 20000.00, 2),
	(23, 'Cá rô kho tộ', 'Cá rô đồng kho với tiêu, nước màu, ăn cùng cơm trắng', 60000.00, 1),
	(24, 'Thịt ba chỉ rang cháy cạnh', 'Ba rọi rang mặn ngọt, cháy cạnh hấp dẫn', 55000.00, 1),
	(25, 'Canh rau tập tàng', 'Canh nấu từ các loại rau vườn tổng hợp', 40000.00, 1),
	(26, 'Trứng chiên hành', 'Món quen thuộc mọi vùng quê, thơm ngon đơn giản', 30000.00, 1),
	(27, 'Đậu hũ sốt cà', 'Đậu hũ chiên sốt cà chua, mộc mạc đậm đà', 35000.00, 1),
	(28, 'Chè bà ba', 'Chè nấu với khoai, đậu, nước cốt dừa – đặc sản Nam Bộ', 25000.00, 3),
	(29, 'Chuối nếp nướng', 'Chuối bọc nếp nướng thơm lừng, chan nước cốt dừa', 30000.00, 3),
	(30, 'Khoai lang luộc', 'Khoai lang quê luộc chín thơm bùi', 20000.00, 3),
	(31, 'Bắp luộc', 'Bắp nếp luộc, mềm dẻo – món quê dân dã', 20000.00, 3);

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
) ENGINE=InnoDB AUTO_INCREMENT=1001 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Đang đổ dữ liệu cho bảng 3mien_resfood.orders: ~0 rows (xấp xỉ)

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
) ENGINE=InnoDB AUTO_INCREMENT=1001 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Đang đổ dữ liệu cho bảng 3mien_resfood.order_items: ~0 rows (xấp xỉ)

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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `status` enum('ordered','received','cancelled') DEFAULT 'ordered',
  PRIMARY KEY (`id`),
  KEY `supplier_id` (`supplier_id`),
  CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1006 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Đang đổ dữ liệu cho bảng 3mien_resfood.purchases: ~5 rows (xấp xỉ)
INSERT INTO `purchases` (`id`, `supplier_id`, `purchase_date`, `total_amount`, `status`) VALUES
	(1, 1, '2025-05-05', 500000.00, 'received'),
	(2, 2, '2025-05-06', 300000.00, 'received'),
	(3, 3, '2025-05-07', 250000.00, 'received'),
	(4, 4, '2025-05-08', 450000.00, 'received'),
	(5, 5, '2025-05-09', 150000.00, 'received');

-- Dumping structure for bảng 3mien_resfood.purchase_items
CREATE TABLE IF NOT EXISTS `purchase_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_id` int(11) DEFAULT NULL,
  `inventory_item_id` int(11) DEFAULT NULL,
  `quantity` decimal(10,2) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `purchase_id` (`purchase_id`),
  KEY `inventory_item_id` (`inventory_item_id`),
  CONSTRAINT `purchase_items_ibfk_1` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`),
  CONSTRAINT `purchase_items_ibfk_2` FOREIGN KEY (`inventory_item_id`) REFERENCES `inventory` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Đang đổ dữ liệu cho bảng 3mien_resfood.purchase_items: ~0 rows (xấp xỉ)

-- Dumping structure for bảng 3mien_resfood.ranks
CREATE TABLE IF NOT EXISTS `ranks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `min_spent` decimal(10,2) DEFAULT NULL,
  `benefits` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=371 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Đang đổ dữ liệu cho bảng 3mien_resfood.ranks: ~0 rows (xấp xỉ)

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
  `phone` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1007 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Đang đổ dữ liệu cho bảng 3mien_resfood.staff: ~6 rows (xấp xỉ)
INSERT INTO `staff` (`id`, `name`, `role`, `phone`) VALUES
	(1, 'Nguyễn Hoàng Hào', 'Chủ', NULL),
	(2, 'Phan Gia Đạt', 'Quản lí', NULL),
	(3, 'Gordon James Ramsay', 'Đầu bếp', NULL),
	(4, 'Wolfgang Puck', 'Phụ bếp', NULL),
	(5, 'Lê Văn Tèo', 'Nhân viên phục vụ', NULL),
	(6, 'Trần Thị Mị Nương', 'Nhân viên phục vụ', NULL);

-- Dumping structure for bảng 3mien_resfood.suppliers
CREATE TABLE IF NOT EXISTS `suppliers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `contact_name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1006 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Đang đổ dữ liệu cho bảng 3mien_resfood.suppliers: ~5 rows (xấp xỉ)
INSERT INTO `suppliers` (`id`, `name`, `contact_name`, `phone`, `email`, `address`, `created_at`) VALUES
	(1, 'Công ty Thực phẩm An Bình', 'Nguyễn Văn An', '0912345678', 'anbinh@food.com', 'Số 10, Đường 3/2, TP.HCM', '2025-04-30 17:00:00'),
	(2, 'Nhà cung cấp Rau Quả Xanh', 'Lê Thị Bình', '0923456789', 'rauqua@green.com', 'Số 20, Đường Lê Duẩn, TP.HCM', '2025-05-01 17:00:00'),
	(3, 'Thực phẩm sạch CleanBest', 'Trần Minh Hiếu', '0934567890', 'thucpham123@clean.com', 'Số 30, Đường Cách mạng tháng tám, Hà Nội', '2025-05-02 17:00:00'),
	(4, 'Công ty Nông Sản Dũng', 'Phạm Văn Dũng', '0945678901', 'nongsan@dung.com', 'Số 5, Đường Nguyễn Văn Linh, Đà Nẵng', '2025-05-03 17:00:00'),
	(5, 'Nhà cung cấp Gia Vị Việt', 'Nguyễn Minh Mẫn', '0956789012', 'giaviviet@spices.com', 'Số 15, Đường Nguyễn Trung Trực, TP.HCM', '2025-05-04 17:00:00');

-- Dumping structure for bảng 3mien_resfood.tables
CREATE TABLE IF NOT EXISTS `tables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `table_number` varchar(10) NOT NULL,
  `capacity` int(11) DEFAULT NULL,
  `status` enum('available','occupied','reserved') DEFAULT 'available',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1017 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Đang đổ dữ liệu cho bảng 3mien_resfood.tables: ~0 rows (xấp xỉ)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
