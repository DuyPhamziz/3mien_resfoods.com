<?php
session_start();
include_once __DIR__ . '/../../../dbconnect.php';

// Lấy danh sách liên hệ từ DB
$sql = "SELECT * FROM contacts ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

$arrContacts = [];
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $arrContacts[] = $row;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Quản lý liên hệ</title>
    <?php include_once __DIR__ . '/../../../layouts/style.php'; ?>
</head>
<body>
    <?php include_once __DIR__ . '/../../layouts/header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <?php include_once __DIR__ . '/../../layouts/sidebar.php'; ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Danh sách liên hệ</h1>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-warning text-center">
                            <tr>
                                <th>#</th>
                                <th>Họ tên</th>
                                <th>Email</th>
                                <th>Tiêu đề</th>
                                <th>Nội dung</th>
                                <th>Thời gian</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($arrContacts as $index => $contact): ?>
                                <tr>
                                    <td class="text-center"><?= $index + 1 ?></td>
                                    <td><?= htmlspecialchars($contact['name']) ?></td>
                                    <td><?= htmlspecialchars($contact['email']) ?></td>
                                    <td><?= htmlspecialchars($contact['subject']) ?></td>
                                    <td><?= nl2br(htmlspecialchars($contact['message'])) ?></td>
                                    <td><?= $contact['created_at'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($arrContacts)): ?>
                                <tr><td colspan="6" class="text-center">Không có liên hệ nào.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </main>
        </div>
    </div>

    <?php include_once __DIR__ . '/../../../layouts/script.php'; ?>
    <script>
        AOS.init({ duration: 1000, easing: 'ease-in-out', once: true });
    </script>
</body>
</html>
