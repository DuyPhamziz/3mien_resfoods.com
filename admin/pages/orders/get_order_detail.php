<?php
include_once __DIR__ . '/../../../dbconnect.php';

$orderId = $_GET['order_id'];

$sqlItems = "SELECT 
                menu.`name` AS menu_name,
                menu.img AS menu_img,
                menu.price AS menu_price,
                SUM(ot.quantity) AS quantity
            FROM order_items ot
            JOIN menu_items menu ON ot.menu_item_id = menu.id
            WHERE ot.order_id = 1001
            GROUP BY menu.id, menu.name, menu.img, menu.price;";

$resultItems = mysqli_query($conn, $sqlItems);

$grandTotal = 0;
$html = '<table class="table table-striped"><thead>
    <th>#</th><th>Tên món</th><th>Hình</th><th>Giá</th><th>Số lượng</th><th>Tổng</th>
</thead><tbody>';

$i = 1;
while ($item = mysqli_fetch_array($resultItems, MYSQLI_ASSOC)) {
    $total = $item['menu_price'] * $item['quantity'];
    $grandTotal += $total;
    $html .= "<tr>
        <td>$i</td>
        <td>{$item['menu_name']}</td>
        <td><img src='{$item['menu_img']}' class='img-fluid' width='60'></td>
        <td>{$item['menu_price']}</td>
        <td>{$item['quantity']}</td>
        <td>$total</td>
    </tr>";
    $i++;
}
$html .= "<tr><td colspan='5' class='text-end'><strong>Tổng cộng:</strong></td><td><strong>$grandTotal</strong></td></tr>";
$html .= '</tbody></table>';

echo $html;
