<style>
    .cart-container { max-width: 1000px; margin: 40px auto; padding: 0 15px; font-family: Arial, sans-serif; }
    .cart-header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #eee; padding-bottom: 20px; }
    .cart-header h2 { margin: 0 0 10px; color: #333; }
    
    .cart-item { display: flex; align-items: center; padding: 20px 0; border-bottom: 1px solid #eee; position: relative; }
    .cart-thumb { width: 90px; height: 90px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd; margin-right: 20px; }
    
    .item-info { flex: 1; }
    .item-name { margin: 0 0 5px; font-size: 16px; color: #333; font-weight: bold; }
    .item-meta { font-size: 13px; color: #666; margin-bottom: 5px; }
    .item-price { color: #d32f2f; font-weight: bold; font-size: 15px; }
    
    /* Bộ điều khiển số lượng */
    .qty-box { display: flex; align-items: center; border: 1px solid #ccc; border-radius: 4px; width: fit-content; margin-top: 10px; }
    .qty-btn { width: 30px; height: 30px; background: #f9f9f9; border: none; cursor: pointer; font-weight: bold; font-size: 16px; }
    .qty-btn:hover { background: #eee; }
    .qty-input { width: 40px; text-align: center; border: none; border-left: 1px solid #ccc; border-right: 1px solid #ccc; height: 30px; outline: none; }
    
    .item-subtotal { font-weight: bold; font-size: 16px; color: #333; min-width: 100px; text-align: right; }
    .btn-remove { position: absolute; top: 20px; right: 0; color: #999; text-decoration: none; font-size: 20px; padding: 5px; }
    .btn-remove:hover { color: #d32f2f; }

    /* Footer giỏ hàng */
    .cart-footer { margin-top: 30px; display: flex; justify-content: flex-end; align-items: flex-end; flex-direction: column; }
    .total-row { font-size: 20px; font-weight: bold; margin-bottom: 20px; }
    .total-price { color: #d32f2f; font-size: 24px; margin-left: 10px; }
    
    .btn-group { display: flex; gap: 10px; }
    .btn { padding: 12px 25px; border-radius: 5px; text-decoration: none; font-weight: bold; font-size: 14px; border: none; cursor: pointer; text-transform: uppercase; }
    .btn-update { background: #333; color: white; }
    .btn-checkout { background: #d32f2f; color: white; }
    .btn:hover { opacity: 0.9; }
</style>

<div class="cart-container">
    <?php
    // Kiểm tra giỏ hàng trống
    if (!isset($_SESSION['gio_hang']) || empty($_SESSION['gio_hang'])) {
        echo "<div style='text-align:center; padding:50px;'>
                <img src='https://cdn-icons-png.flaticon.com/512/2038/2038854.png' width='100' style='opacity:0.5'>
                <h3>Giỏ hàng đang trống</h3>
                <a href='index.php?page_layout=menu' style='color:#d32f2f; text-decoration:none; font-weight:bold;'>← Tiếp tục mua sắm</a>
              </div>";
    } else {
        $tong_so_luong = count($_SESSION['gio_hang']);
    ?>

    <div class="cart-header">
        <h2>Giỏ hàng của bạn</h2>
        <p>Đang có <?= $tong_so_luong ?> sản phẩm</p>
    </div>

    <form action="index.php?page_layout=capnhatgiohang" method="post">
        <?php 
        $tong_tien_don = 0;
        foreach ($_SESSION['gio_hang'] as $cart_id => $item): 
            // Kiểm tra kỹ các key để tránh lỗi Undefined
            $ten = isset($item['ten']) ? $item['ten'] : 'Sản phẩm lỗi';
            $hinh = isset($item['hinh']) ? $item['hinh'] : 'no-image.png';
            $gia = isset($item['gia']) ? $item['gia'] : 0;
            $so_luong = isset($item['so_luong']) ? $item['so_luong'] : 1;
            $ghi_chu = isset($item['ghi_chu']) ? $item['ghi_chu'] : '';

            $thanh_tien = $gia * $so_luong;
            $tong_tien_don += $thanh_tien;
        ?>
        <div class="cart-item">
            <img src="/2221050039/image/<?= $hinh ?>" alt="<?= $ten ?>" class="cart-thumb">
            
            <div class="item-info">
                <div class="item-name"><?= $ten ?></div>
                <?php if(!empty($ghi_chu)): ?>
                    <div class="item-meta">Ghi chú: <?= $ghi_chu ?></div>
                <?php endif; ?>
                <div class="item-price"><?= number_format($gia) ?>₫</div>
                
                <div class="qty-box">
                    <button type="button" class="qty-btn" onclick="changeQty('<?= $cart_id ?>', -1)">-</button>
                    <input type="text" name="qty[<?= $cart_id ?>]" id="qty_<?= $cart_id ?>" value="<?= $so_luong ?>" class="qty-input" readonly>
                    <button type="button" class="qty-btn" onclick="changeQty('<?= $cart_id ?>', 1)">+</button>
                </div>
            </div>

            <div class="item-subtotal">
                <?= number_format($thanh_tien) ?>₫
            </div>

            <a href="xoagiohang.php?id=<?= $cart_id ?>" class="btn-remove" onclick="return confirm('Xóa món này?')">×</a>
        </div>
        <?php endforeach; ?>

        <div class="cart-footer">
            <div class="total-row">
                Tổng thanh toán: <span class="total-price"><?= number_format($tong_tien_don) ?>₫</span>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn btn-update">Cập nhật giỏ</button>
                <a href="index.php?page_layout=thanhtoan" class="btn btn-checkout">Thanh toán</a>
            </div>
        </div>
    </form>

    <?php } ?>
</div>

<script>
// Hàm JS tăng giảm số lượng
function changeQty(id, amount) {
    var input = document.getElementById('qty_' + id);
    var currentVal = parseInt(input.value);
    var newVal = currentVal + amount;
    
    if (newVal >= 1) {
        input.value = newVal;
    }
}
</script>