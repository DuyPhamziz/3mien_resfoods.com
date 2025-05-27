<?php
session_start();
include_once __DIR__ . '/../../../dbconnect.php'; // kết nối mysqli

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $ngayXuat = $_POST['ngayXuat'] ?? '';
    $tenArr = $_POST['ten'] ?? [];
    $soluongArr = $_POST['soluong'] ?? [];
    $ghichuArr = $_POST['ghichu'] ?? [];

    if (!$ngayXuat || empty($tenArr)) {
        die('Thiếu dữ liệu ngày xuất hoặc nguyên liệu');
    }

    // Tạo danh sách tên nguyên liệu duy nhất
    $tenNguyenLieuUnique = array_unique(array_filter(array_map('trim', $tenArr)));
    if (empty($tenNguyenLieuUnique)) {
        die('Không có nguyên liệu hợp lệ để xuất.');
    }

    $placeholders = implode(',', array_fill(0, count($tenNguyenLieuUnique), '?'));
    $types = str_repeat('s', count($tenNguyenLieuUnique));

    // Lấy tồn kho động từ inventory_transactions
    $sql = "
        SELECT 
            i.inv_name, i.inv_id,
            COALESCE(SUM(CASE 
                WHEN t.inv_trans_loai = 'nhap' THEN t.inv_trans_soluong
                WHEN t.inv_trans_loai = 'xuat' THEN -t.inv_trans_soluong
                ELSE 0 END), 0) AS ton_kho
        FROM inventory i
        LEFT JOIN inventory_transactions t ON i.inv_id = t.inv_trans_inv_id
        WHERE i.inv_name IN ($placeholders)
        GROUP BY i.inv_id, i.inv_name
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$tenNguyenLieuUnique);
    $stmt->execute();
    $result = $stmt->get_result();

    $tonKhoTam = [];
    while ($row = $result->fetch_assoc()) {
        $tonKhoTam[$row['inv_name']] = [
            'inv_id' => $row['inv_id'],
            'ton_kho' => (int)$row['ton_kho']
        ];
    }
    $stmt->close();

    $conn->begin_transaction();

    try {
        // Ghi phiếu xuất vào bảng exports
        $ghiChuTong = "Phiếu xuất ngày $ngayXuat";
        $stmt = $conn->prepare("INSERT INTO exports (exp_ngay, exp_ghichu) VALUES (?, ?)");
        $stmt->bind_param("ss", $ngayXuat, $ghiChuTong);
        $stmt->execute();
        $exp_id = $stmt->insert_id;
        $stmt->close();

        // Ghi từng dòng giao dịch xuất
        for ($i = 0; $i < count($tenArr); $i++) {
            $ten = trim($tenArr[$i]);
            $soluong = (int)$soluongArr[$i];
            $ghichu = $ghichuArr[$i];

            if ($ten === '' || $soluong <= 0) continue;

            if (!isset($tonKhoTam[$ten])) {
                throw new Exception("Nguyên liệu '$ten' không tồn tại trong kho.");
            }

            if ($tonKhoTam[$ten]['ton_kho'] < $soluong) {
                throw new Exception("Nguyên liệu '$ten' không đủ tồn kho để xuất.");
            }

            $inv_id = $tonKhoTam[$ten]['inv_id'];
            $loai = 'xuat';

            // Ghi giao dịch kèm exp_id
            $stmt = $conn->prepare("INSERT INTO inventory_transactions 
                (inv_trans_inv_id, inv_trans_loai, inv_trans_soluong, inv_trans_ngay, inv_trans_ghichu, inv_trans_exp_id) 
                VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isissi", $inv_id, $loai, $soluong, $ngayXuat, $ghichu, $exp_id);
            $stmt->execute();
            $stmt->close();

            // Cập nhật tồn kho tạm
            $tonKhoTam[$ten]['ton_kho'] -= $soluong;
        }

        $conn->commit();
        $_SESSION['flash_msg'] = "Lưu phiếu xuất thành công!";
        $_SESSION['flash_context'] = "success";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        die("Lỗi khi lưu phiếu xuất: " . $e->getMessage());
    }
}
