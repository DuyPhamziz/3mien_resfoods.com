<?php
session_start();
include_once __DIR__ . '/dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $table_id = $_POST['table_id'] ?? null;
}

$sqlSelectMenu = "SELECT 
                    m.id AS menu_id,
                    m.menu_name,
                    m.price,
                    m.img,
                    m.description,
                    c.name AS category_name
                FROM menu_items m
                JOIN menu_item_categories mc ON mc.menu_item_id = m.id
                JOIN categories c ON mc.category_id = c.id
                ";
$resultMenu = mysqli_query($conn, $sqlSelectMenu);
$arrMenu = [];
while ($row = mysqli_fetch_array($resultMenu, MYSQLI_ASSOC)) {
    $arrMenu[] = array(
        'menu_id'    => $row['menu_id'],
        'menu_name'  => $row['menu_name'],
        'menu_price' => $row['price'],
        'menu_img'   => $row['img'],
        'menu_cat'   => $row['category_name'],
        'menu_des'   => $row['description'],
    );
}
$customer_id = $_SESSION['customer_id'] ?? null;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Trang đặt bàn</title>
    <?php include_once __DIR__ . '/layouts/style.php'; ?>
    <link rel="stylesheet" type="text/css" href="/3mien_resfoods.com/assets/css/main.css">
</head>

<body>
    <?php include_once __DIR__ . '/layouts/navbar.php'; ?>
    <main class="container-fluid main">
        <div class="container my-5" style="background-color: rgba(0, 0, 0, 0.5); border-radius: 10px;">
            <div class="container-fluid">
                <img src="assets/img/banner_2.jpg" alt="" />
            </div>
            <div class="row">
                <!-- Thực đơn -->
                <div class="col-lg-8" id="menu-scrollspy" data-bs-spy="scroll" data-bs-target="#menu-nav" data-bs-offset="0" tabindex="0" style="height: 600px; overflow-y: auto; scroll-behavior: smooth;">
                    <h2 class="mb-4 text-white">Thực đơn 3 miền</h2>
                    <div class="row g-4 mt-3" id="menu-container">
                        <?php foreach ($arrMenu as $menu): ?>
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="card h-100 shadow-sm menu-item" id="menu-item-<?= $menu['menu_id'] ?>" data-menu-id="<?= $menu['menu_id'] ?>">
                                    <img src="<?= $menu['menu_img'] ?>" class="card-img-top img-fluid" alt="<?= $menu['menu_name'] ?>" style="height: 150px; object-fit: cover;">
                                    <div class="card-body d-flex flex-column justify-content-between bg-light">
                                        <h6 class="card-title fw-bold text-truncate"><?= htmlspecialchars($menu['menu_name']) ?></h6>
                                        <p class="small text-muted mb-1"><?= htmlspecialchars($menu['menu_cat']) ?></p>
                                        <p class="text-danger fw-bold mb-2"><?= number_format($menu['menu_price'], 0, ',', '.') ?> đ</p>
                                        <button class="btn btn-sm btn-outline-primary w-100 add-to-cart"> Thêm món</button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <!-- Danh sách đã đặt -->
                <div class="col-lg-4">
                    <div style="max-height: 600px; overflow-y: auto;">
                        <div class="card shadow" style="height: 100%;">
                            <div class="card-header bg-primary text-white">Món đã chọn</div>
                            <form id="order-form" method="POST" action="payment.php">
                                <input type="hidden" name="table_id" value="<?= $table_id ?>" />
                                <input type="hidden" name="customer_id" value="<?= $customer_id ?>" />
                                <ul id="cart-list" class="list-group">
                                    <li class="list-group-item text-center text-muted" style="height: 20vh;">Chưa có món nào</li>
                                </ul>
                                <div class="px-4 py-2 border-top d-flex justify-content-between">
                                    <p class="mb-1">Tổng số món: <span id="total-items">0</span></p>
                                    <p class="mb-1">Tổng tiền: <span id="total-price">0</span> đ</p>
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text">Thời gian đặt</span>
                                    <input type="datetime-local" name="booking_time" class="form-control" required>
                                </div>
                                <button type="submit" id="btn-order" class="btn btn-primary mt-3 w-100">Đặt món</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include_once __DIR__ . '/layouts/footer.php'; ?>

    <script src="/3mien_resfoods.com/assets/js/main.js"></script>
    <?php include_once __DIR__ . '/layouts/script.php'; ?>
    <script>
        AOS.init({
            duration: 1000,
            easing: 'ease-in-out',
            once: true
        });

        document.addEventListener('DOMContentLoaded', function() {
            const cartList = document.getElementById('cart-list');

            function addToCart(menuCard) {
                const menuId = menuCard.dataset.menuId;

                const existingItem = document.getElementById('cart-' + menuId);
                if (existingItem) {
                    const qtyInput = existingItem.querySelector('.quantity');
                    qtyInput.value = parseInt(qtyInput.value) + 1;
                    updateCartSummary();
                    return;
                }
                const clone = menuCard.cloneNode(true);
                clone.id = 'cart-' + menuId;
                clone.classList.add('mb-2');

                // Xóa nút thêm món
                const addBtn = clone.querySelector('.add-to-cart');
                if (addBtn) addBtn.remove();

                // Tạo phần nhập số lượng + ghi chú
                const formDiv = document.createElement('div');
                formDiv.className = 'mt-2';
                formDiv.innerHTML = `
                <input type="hidden" name="menu_id[]" value="${menuId}">
                <div class="input-group mb-2">
                    <span class="input-group-text">Số lượng</span>
                    <input type="number" class="form-control quantity" name="quantity[]" min="1" value="1" required oninput="updateCartSummary()">
                </div>
                <textarea class="form-control note" rows="2" name="note[]" placeholder="Ghi chú món..."></textarea>`;

                clone.querySelector('.card-body').appendChild(formDiv);

                // Nút xóa món
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'btn btn-sm btn-danger w-100 mt-2';
                removeBtn.textContent = '❌ Xóa món';
                removeBtn.addEventListener('click', function() {
                    clone.closest('li').remove();
                    if (cartList.children.length === 0) {
                        const empty = document.createElement('li');
                        empty.className = 'list-group-item text-center text-muted';
                        empty.textContent = 'Chưa có món nào';
                        cartList.appendChild(empty);


                    }
                    updateCartSummary();
                });
                clone.querySelector('.card-body').appendChild(removeBtn);

                const emptyItem = cartList.querySelector('.list-group-item.text-muted');
                if (emptyItem) emptyItem.remove();

                const li = document.createElement('li');
                li.className = 'list-group-item';
                li.appendChild(clone);
                cartList.appendChild(li);
                updateCartSummary();
            }



            document.querySelectorAll('.add-to-cart').forEach(btn => {
                btn.addEventListener('click', function() {
                    const card = this.closest('.menu-item');
                    addToCart(card);
                });
            });


            document.querySelectorAll('.menu-item').forEach(item => {
                item.setAttribute('draggable', true);
                item.addEventListener('dragstart', function(e) {
                    e.dataTransfer.setData('text/plain', e.target.id);
                });
            });


            cartList.addEventListener('dragover', function(e) {
                e.preventDefault();
            });

            cartList.addEventListener('drop', function(e) {
                e.preventDefault();
                const menuId = e.dataTransfer.getData('text/plain');
                const menuCard = document.getElementById(menuId);
                if (menuCard) {
                    addToCart(menuCard);
                }
            });


            document.getElementById('order-form').addEventListener('submit', function(e) {
                const cartItems = document.querySelectorAll('#cart-list .menu-item');
                if (cartItems.length === 0) {
                    e.preventDefault();
                    alert('Bạn chưa chọn món nào!');
                    return;
                }

                const order = [];
                cartItems.forEach(item => {
                    const name = item.querySelector('.card-title')?.textContent.trim();
                    const price = item.querySelector('.text-danger')?.textContent.trim();
                    const quantity = item.querySelector('.quantity')?.value || 1;
                    const note = item.querySelector('.note')?.value || '';
                    order.push({
                        name,
                        price,
                        quantity: parseInt(quantity),
                        note
                    });
                });

                console.log(order);

            });


            dragula([document.getElementById('menu-container'), cartList], {
                copy: function(el, source) {
                    return source.id === 'menu-container';
                },
                accepts: function(el, target) {
                    return target.id === 'cart-list';
                },
                removeOnSpill: true
            }).on('drop', function(el, target) {
                if (target.id === 'cart-list') {

                    const menuCard = el.querySelector('.menu-item');
                    if (!menuCard) {
                        el.remove();
                        return;
                    }
                    const menuId = menuCard.id;
                    el.remove();
                    const realMenuItem = document.getElementById(menuId);
                    if (realMenuItem) {
                        addToCart(realMenuItem);
                    }
                }
            });

        });

        function updateCartSummary() {
            const cartItems = document.querySelectorAll('#cart-list .menu-item');
            let totalItems = 0;
            let totalPrice = 0;

            cartItems.forEach(item => {
                const quantity = parseInt(item.querySelector('.quantity')?.value || 1);
                const priceText = item.querySelector('.text-danger')?.textContent || '0';
                const price = parseInt(priceText.replace(/\D/g, ''));

                totalItems += quantity;
                totalPrice += quantity * price;
            });

            document.getElementById('total-items').textContent = totalItems;
            document.getElementById('total-price').textContent = totalPrice.toLocaleString('vi-VN');
        }
    </script>

</body>

</html>