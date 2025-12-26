<style>
    .cart-sidebar {
        width: 350px;
        background: #fff;
        padding: 20px;
        border: 1px solid #ddd;
        font-family: Arial, sans-serif;
    }
    .cart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
    }
    .cart-item {
        display: flex;
        gap: 15px;
        margin-top: 20px;
        position: relative;
    }
    .cart-item img {
        width: 70px;
        height: 70px;
        object-fit: cover;
    }
    .cart-item-info h4 {
        margin: 0;
        font-size: 14px;
        text-transform: uppercase;
    }
    .cart-item-info p {
        margin: 5px 0;
        color: #666;
        font-size: 12px;
    }
    .cart-price {
        font-weight: bold;
        color: #333;
    }
    .cart-total {
        margin-top: 30px;
        border-top: 2px solid #000;
        padding-top: 15px;
        display: flex;
        justify-content: space-between;
        font-weight: bold;
    }
    .cart-buttons {
        margin-top: 20px;
        display: flex;
        gap: 10px;
    }
    .btn {
        flex: 1;
        padding: 12px;
        border: none;
        color: white;
        font-weight: bold;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
    }
    .btn-view { background: #e53935; }
    .btn-pay { background: #e53935; }
    .remove-item {
        position: absolute;
        right: 0;
        top: 0;
        cursor: pointer;
        color: #333;
    }
</style>

<div class="cart-sidebar">
    <div class="cart-header">
        <span>GIỎ HÀNG</span>
        <span style="font-size: 24px; cursor: pointer;">&times;</span>
    </div>

    <?php 
    $tong_tien = 0;
    if (isset($_SESSION['gio_hang']) && !empty($_SESSION['gio_hang'])): 
        foreach ($_SESSION['gio_hang'] as $item): 
            $thanh_tien = $item['gia'] * $item['so_luong'];
            $tong_tien += $thanh_tien;
    ?>
    <div class="cart-item">
        <img src="/2221050039/image/<?= $item['hinh'] ?>">
        <div class="cart-item-info">
            <h4><?= $item['ten'] ?></h4>
            <p>MIRINDA / BURGER GÀ KIM CHI</p> <div style="display:flex; gap: 20px;">
                <span style="background:#eee; padding: 2px 8px;"><?= $item['so_luong'] ?></span>
                <span class="cart-price"><?= number_format($item['gia']) ?>đ</span>
            </div>
        </div>
        <a href="xoagiohang.php?id=<?= $item['id'] ?>" class="remove-item">&times;</a>
    </div>
    <?php 
        endforeach; 
    endif; 
    ?>

    <div class="cart-total">
        <span>TỔNG TIỀN:</span>
        <span><?= number_format($tong_tien) ?>đ</span>
    </div>

    <div class="cart-buttons">
        <a href="index.php?page_layout=giohang" class="btn btn-view">XEM GIỎ HÀNG</a>
        <a href="index.php?page_layout=thanhtoan" class="btn btn-pay">THANH TOÁN</a>
    </div>
</div>