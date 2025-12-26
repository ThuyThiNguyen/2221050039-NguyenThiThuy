<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include "connect.php"; 

$sql_dm = "SELECT * FROM danh_muc";
$query_dm = mysqli_query($conn, $sql_dm);

$sql_sp = "SELECT * FROM san_pham ORDER BY id_danh_muc ASC";
$query_sp = mysqli_query($conn, $sql_sp);

$products_array = [];
while ($row = mysqli_fetch_assoc($query_sp)) {
    $products_array[] = $row;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thực đơn Otoké Chicken</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary-orange: #f4b966; --primary-red: #d32f2f; --bg-gray: #f5f5f5; }
        * { box-sizing: border-box; }
        body { font-family: Arial, sans-serif; margin: 0; background-color: var(--bg-gray); height: 100vh; overflow: hidden; }
        .order-layout { display: flex; height: 100vh; }

        .sidebar-left { width: 250px; background: #fff; border-right: 1px solid #ddd; overflow-y: auto; }
        .cat-item { padding: 15px; border-bottom: 1px solid #eee; cursor: pointer; display: flex; align-items: center; gap: 10px; transition: 0.3s; }
        .cat-item:hover, .cat-item.active { background-color: #ffe0b2; color: var(--primary-red); font-weight: bold; border-left: 5px solid var(--primary-red); }
        
        .main-content { flex: 1; padding: 20px; overflow-y: auto; background: #fafafa; }
        .search-bar { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; margin-bottom: 20px; font-size: 14px; }
        .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px; }
        .product-card { background: #fff; padding: 15px; padding-bottom: 60px; border-radius: 8px; text-align: center; box-shadow: 0 2px 5px rgba(0,0,0,0.05); position: relative; transition: transform 0.2s; cursor: pointer; }
        .pro-img { width: 100%; height: 140px; object-fit: contain; margin-bottom: 10px; }
        .pro-price { color: var(--primary-red); font-weight: bold; font-size: 16px; }
        .add-btn { position: absolute; bottom: 15px; right: 15px; width: 35px; height: 35px; border-radius: 50%; background: #f9a825; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 20px; z-index: 10; }

        .sidebar-right { width: 350px; background: #fff; border-left: 1px solid #ddd; display: flex; flex-direction: column; }
        .cart-header { padding: 20px; border-bottom: 1px solid #eee; }
        
        /* NÚT THANH TOÁN Ở TRÊN */
        .btn-checkout { width: 100%; padding: 15px; background: var(--primary-orange); color: #fff; border: none; font-weight: bold; font-size: 16px; cursor: pointer; text-transform: uppercase; border-radius: 5px; margin: 10px 0; }
        .btn-checkout:hover { background: var(--primary-red); }

        .cart-items { flex: 1; padding: 15px; overflow-y: auto; }
        .cart-item-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; font-size: 14px; border-bottom: 1px dashed #eee; padding-bottom: 10px; }
        .cart-total { padding: 20px; border-top: 1px solid #ddd; font-weight: bold; display: flex; justify-content: space-between; font-size: 18px; color: var(--primary-red); }

        .modal-qv { display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; }
        .modal-qv-content { background: #fff; width: 700px; border-radius: 8px; position: relative; padding: 25px; }
        .qv-body { display: flex; gap: 20px; }
    </style>
</head>
<body>

<div class="order-layout">
    <aside class="sidebar-left">
        <div class="cat-item active" onclick="filterCategory('all', this)"><i class="fa-solid fa-utensils"></i> Tất cả món</div>
        <?php mysqli_data_seek($query_dm, 0); while ($dm = mysqli_fetch_assoc($query_dm)) { ?>
            <div class="cat-item" onclick="filterCategory('<?= $dm['id'] ?>', this)"><i class="fa-solid fa-drumstick-bite"></i> <?= $dm['ten_danh_muc'] ?></div>
        <?php } ?>
    </aside>

    <main class="main-content">
        <input type="text" id="searchInput" class="search-bar" placeholder="Tìm món ăn..." onkeyup="searchProduct()">
        <div class="product-grid" id="productList">
            <?php foreach ($products_array as $sp) { ?>
                <div class="product-card" data-cat-id="<?= $sp['id_danh_muc'] ?>" data-name="<?= strtolower($sp['ten_san_pham']) ?>" 
                     onclick="showQuickView(<?= $sp['id'] ?>, '<?= addslashes($sp['ten_san_pham']) ?>', '<?= $sp['hinh_anh'] ?>', <?= $sp['gia'] ?>)">
                    <img src="../image/<?= $sp['hinh_anh'] ?>" class="pro-img">
                    <div style="font-weight:bold; font-size:15px; min-height:40px;"><?= $sp['ten_san_pham'] ?></div>
                    <div class="pro-price"><?= number_format($sp['gia'], 0, ',', '.') ?>đ</div>
                    <div class="add-btn" onclick="event.stopPropagation(); addToCart(<?= $sp['id'] ?>, '<?= addslashes($sp['ten_san_pham']) ?>', <?= $sp['gia'] ?>, '<?= $sp['hinh_anh'] ?>', 1)">+</div>
                </div>
            <?php } ?>
        </div>
    </main>

    <aside class="sidebar-right">
        <div class="cart-header">
            <h3><i class="fa-solid fa-basket-shopping"></i> Giỏ hàng</h3>
            <button class="btn-checkout" onclick="xuLyThanhToan()">THANH TOÁN</button>
        </div>
        <div class="cart-items" id="cartItems">
            <p style="text-align:center; color:#999; margin-top: 50px;">Chưa có món nào</p>
        </div>
        <div class="cart-total">
            <span>Tổng cộng:</span><span id="totalPrice">0đ</span>
        </div>
    </aside>
</div>

<div id="quickViewModal" class="modal-qv">
    <div class="modal-qv-content">
        <span onclick="closeQuickView()" style="position:absolute; top:10px; right:15px; font-size:24px; cursor:pointer;">&times;</span>
        <div class="qv-body">
            <div style="width:45%;"><img id="qv-img" src="" style="width:100%; border:1px solid #eee;"></div>
            <div style="width:55%;">
                <h2 id="qv-name" style="margin:0;"></h2>
                <div id="qv-price" style="color:#d32f2f; font-size:22px; font-weight:bold; margin:10px 0;"></div>
                <button id="btn-submit-qv" style="width:100%; padding:15px; background:#f9a825; color:#fff; border:none; border-radius:5px; margin-top:30px; cursor:pointer; font-weight:bold;">THÊM VÀO GIỎ</button>
            </div>
        </div>
    </div>
</div>

<script>
    let cart = [];

    function filterCategory(catId, element) {
        // Đổi màu active
        document.querySelectorAll('.cat-item').forEach(el => el.classList.remove('active'));
        element.classList.add('active');

        // Lọc sản phẩm dùng getAttribute để chính xác 100%
        const products = document.querySelectorAll('.product-card');
        products.forEach(p => {
            const pCat = p.getAttribute('data-cat-id');
            if (catId === 'all' || pCat === catId.toString()) {
                p.style.display = 'block';
            } else {
                p.style.display = 'none';
            }
        });
    }

    function searchProduct() {
        const kw = document.getElementById('searchInput').value.toLowerCase();
        document.querySelectorAll('.product-card').forEach(p => {
            const name = p.getAttribute('data-name');
            p.style.display = name.includes(kw) ? 'block' : 'none';
        });
    }

    function addToCart(id, name, price, img, qty = 1) {
        const item = cart.find(i => i.id === id);
        if (item) { item.quantity += qty; } else { cart.push({ id, name, price, img, quantity: qty }); }
        renderCart();
    }

    function updateQuantity(id, change) {
        const item = cart.find(i => i.id === id);
        if (item) {
            item.quantity += change;
            if (item.quantity <= 0) { cart = cart.filter(i => i.id !== id); }
        }
        renderCart();
    }

    function renderCart() {
        const container = document.getElementById('cartItems');
        const totalEl = document.getElementById('totalPrice');
        if (cart.length === 0) {
            container.innerHTML = '<p style="text-align:center; color:#999; margin-top:50px;">Chưa có món nào</p>';
            totalEl.innerText = '0đ';
            return;
        }
        let html = ''; let total = 0;
        cart.forEach(item => {
            total += item.price * item.quantity;
            html += `<div class="cart-item-row">
                <div style="flex:1;"><b>${item.quantity}x</b> ${item.name}</div>
                <div style="color:var(--primary-red); font-weight:bold;">${(item.price * item.quantity).toLocaleString('vi-VN')}đ</div>
                <div style="margin-left:10px;">
                    <button onclick="updateQuantity(${item.id}, -1)">-</button>
                    <button onclick="updateQuantity(${item.id}, 1)">+</button>
                </div>
            </div>`;
        });
        container.innerHTML = html;
        totalEl.innerText = total.toLocaleString('vi-VN') + 'đ';
    }

    function showQuickView(id, name, img, price) {
        document.getElementById('qv-name').innerText = name;
        document.getElementById('qv-img').src = "../image/" + img;
        document.getElementById('qv-price').innerText = price.toLocaleString('vi-VN') + "đ";
        document.getElementById('btn-submit-qv').onclick = () => {
            addToCart(id, name, price, img, 1);
            closeQuickView();
        };
        document.getElementById('quickViewModal').style.display = "flex";
    }

    function closeQuickView() { document.getElementById('quickViewModal').style.display = "none"; }

    function xuLyThanhToan() {
        if (cart.length === 0) { alert("Giỏ hàng trống!"); return; }
        fetch('save_cart_session.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'cart_data=' + encodeURIComponent(JSON.stringify(cart))
        }).then(() => { window.location.href = 'index.php?page_layout=thanhtoan'; });
    }
</script>
</body>
</html>