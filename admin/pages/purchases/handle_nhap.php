<?php
include_once __DIR__ . '/../../../dbconnect.php'; // kết nối mysqli

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $supplier_id = $_POST['supplier'] ?? null;
    $ngay_nhap = $_POST['ngayNhap'] ?? null;
    $ten = $_POST['ten'] ?? [];
    $soluong = $_POST['soluong'] ?? [];
    $dongia = $_POST['dongia'] ?? [];

    if (!$supplier_id || !$ngay_nhap || empty($ten)) {
        die('Thiếu thông tin!');
    }

    $conn->begin_transaction();

    try {
        // Bước 1: Thêm phiếu nhập
        $stmt = $conn->prepare("INSERT INTO purchases (pur_sup_id, pur_ngay) VALUES (?, ?)");
        $stmt->bind_param("is", $supplier_id, $ngay_nhap);
        $stmt->execute();
        $pur_id = $conn->insert_id;
        $stmt->close();

        // Bước 2: Lặp qua từng nguyên liệu
        for ($i = 0; $i < count($ten); $i++) {
            $tenNL = trim($ten[$i]);
            $soLuong = (int) $soluong[$i];
            $donGia = (float) $dongia[$i];

            if ($tenNL == '' || $soLuong <= 0) continue;

            // Kiểm tra nguyên liệu có tồn tại chưa
            $stmt = $conn->prepare("SELECT inv_id FROM inventory WHERE inv_name = ?");
            $stmt->bind_param("s", $tenNL);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();

            if ($row) {
                $inv_id = $row['inv_id'];
            } else {
                // Thêm mới nguyên liệu
                $donvi = 'kg'; // mặc định đơn vị
                $stmt = $conn->prepare("INSERT INTO inventory (inv_name, inv_donvi, inv_ton_kho) VALUES (?, ?, 0)");
                $stmt->bind_param("ss", $tenNL, $donvi);
                $stmt->execute();
                $inv_id = $conn->insert_id;
                $stmt->close();
            }

            // Ghi vào bảng purchase_detail
            $stmt = $conn->prepare("INSERT INTO purchase_detail (pur_item_pur_id, pur_item_inv_id, pur_item_soluong, pur_item_dongia) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiid", $pur_id, $inv_id, $soLuong, $donGia);
            $stmt->execute();
            $stmt->close();

            // Ghi vào bảng inventory_transactions
            $ghichu = "Phiếu nhập #" . $pur_id;
            $loai = 'nhap';
            $stmt = $conn->prepare("INSERT INTO inventory_transactions (inv_trans_inv_id, inv_trans_loai, inv_trans_soluong, inv_trans_ngay, inv_trans_ghichu) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("isiss", $inv_id, $loai, $soLuong, $ngay_nhap, $ghichu);
            $stmt->execute();
            $stmt->close();

            // ✅ Cập nhật tồn kho
            $stmt = $conn->prepare("UPDATE inventory SET inv_ton_kho = inv_ton_kho + ? WHERE inv_id = ?");
            $stmt->bind_param("ii", $soLuong, $inv_id);
            $stmt->execute();
            $stmt->close();
        }

        $conn->commit();
        header('Location: index.php');
    } catch (Exception $e) {
        $conn->rollback();
        die("Lỗi khi lưu phiếu nhập: " . $e->getMessage());
    }
}
