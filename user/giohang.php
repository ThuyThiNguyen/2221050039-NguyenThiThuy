<?php
if (isset($_POST['btn_them'])) {
    $id_sp = intval($_POST['id']);
    $sl = intval($_POST['so_luong']);
    
    // Lấy mảng các tickbox đã chọn
    $options_selected = isset($_POST['lua_chon']) ? $_POST['lua_chon'] : [];
    $chuoi_lua_chon = implode(" / ", $options_selected); // Chuyển thành chuỗi: "Phô mai / Cay"

    // Tạo ID giỏ hàng đặc biệt để phân biệt cùng 1 món nhưng khác vị
    $cart_id = $id_sp . "_" . md5($chuoi_lua_chon);

    // Truy vấn thông tin sản phẩm... (code cũ của bạn)
    
    if (isset($_SESSION['gio_hang'][$cart_id])) {
        $_SESSION['gio_hang'][$cart_id]['so_luong'] += $sl;
    } else {
        $_SESSION['gio_hang'][$cart_id] = [
            'id' => $id_sp,
            'ten' => $info_sp['ten_san_pham'],
            'gia' => $info_sp['gia'],
            'hinh' => $info_sp['hinh_anh'],
            'so_luong' => $sl,
            'ghi_chu_lua_chon' => $chuoi_lua_chon // LƯU VÀO ĐÂY
        ];
    }
}
// Kiểm tra nếu giỏ hàng trống
if (!isset($_SESSION['gio_hang']) || empty($_SESSION['gio_hang'])) {
    echo "<div style='text-align:center; padding: 100px 20px;'>
            <h2>Giỏ hàng của bạn đang trống</h2>
            <p>Có 0 sản phẩm trong giỏ hàng</p>
            <hr style='width:50px; border:2px solid #000; margin: 20px auto;'>
            <a href='index.php?page_layout=menu' style='color: red; text-decoration:none;'>QUAY LẠI CỬA HÀNG</a>
          </div>";
} else {
    $tong_so_sp = count($_SESSION['gio_hang']);
?>

<style>
    .cart-container { max-width: 1100px; margin: 50px auto; font-family: sans-serif; padding: 0 15px; }
    .cart-title { text-align: center; margin-bottom: 40px; }
    .cart-title h2 { font-size: 28px; margin-bottom: 5px; }
    .cart-title p { color: #666; font-size: 14px; }
    .cart-title hr { width: 50px; border: 1.5px solid #000; margin-top: 15px; }

    /* Danh sách sản phẩm */
    .cart-item { display: flex; align-items: center; border-bottom: 1px solid #eee; padding: 20px 0; position: relative; }
    .cart-item img { width: 100px; height: 100px; object-fit: cover; margin-right: 20px; }
    .cart-item-info { flex-grow: 1; }
    .cart-item-info h4 { margin: 0; font-size: 16px; }
    .cart-item-info .price { color: #333; font-size: 14px; margin: 5px 0; }
    .cart-item-info .note { color: #888; font-size: 12px; }

    /* Điều chỉnh số lượng */
    .qty-control { display: flex; border: 1px solid #ddd; width: fit-content; margin-top: 10px; }
    .qty-control button { border: none; background: #f9f9f9; width: 25px; height: 25px; cursor: pointer; }
    .qty-control input { width: 35px; border: none; text-align: center; font-size: 13px; outline: none; }

    .item-total-price { font-weight: bold; font-size: 16px; }
    .remove-btn { position: absolute; right: 0; top: 20px; cursor: pointer; font-size: 20px; color: #000; text-decoration: none; }

    /* Phần ghi chú và tổng tiền */
    .cart-footer { display: flex; justify-content: space-between; margin-top: 30px; align-items: flex-start; }
    .cart-note { background: #f1f1f1; padding: 20px; width: 45%; height: 120px; color: #777; font-size: 13px; }
    .cart-checkout-box { width: 50%; text-align: right; }
    .total-amount { font-size: 18px; margin-bottom: 25px; }
    .total-amount b { font-size: 24px; margin-left: 10px; }

    /* Nút bấm */
    .btn-group { display: flex; justify-content: flex-end; gap: 5px; }
    .btn-cart { 
        padding: 12px 20px; color: #fff; text-decoration: none; font-size: 12px; 
        font-weight: bold; border: none; cursor: pointer; text-transform: uppercase;
    }
    .btn-red { background: #e53935; }
    .btn-dark-red { background: #cc0000; }
</style>

<div class="cart-container">
    <div class="cart-title">
        <h2>Giỏ hàng của bạn</h2>
        <p>Có <?= $tong_so_sp ?> sản phẩm trong giỏ hàng</p>
        <hr>
    </div>

    <form action="index.php?page_layout=capnhatgiohang" method="post">
        <?php 
        $tong_tien_gh = 0;
        foreach ($_SESSION['gio_hang'] as $id_sp => $item): 
            $thanh_tien = $item['gia'] * $item['so_luong'];
            $tong_tien_gh += $thanh_tien;
        ?>
        <div class="cart-item">
            <img src="/2221050039/image/<?= $item['hinh'] ?>" alt="<?= $item['ten'] ?>">
            
            <div class="cart-item-info">
                <h4><?= $item['ten'] ?></h4>
                <p class="price"><?= number_format($item['gia']) ?>₫</p>
                <p class="note">
    <?= !empty($item['ghi_chu_lua_chon']) ? $item['ghi_chu_lua_chon'] : 'Mặc định' ?>
</p>
                
                <div class="qty-control">
                    <button type="button" onclick="changeQty(<?= $id_sp ?>, -1)">-</button>
                    <input type="text" name="qty[<?= $id_sp ?>]" id="qty_<?= $id_sp ?>" value="<?= $item['so_luong'] ?>" readonly>
                    <button type="button" onclick="changeQty(<?= $id_sp ?>, 1)">+</button>
                </div>
            </div>

            <div class="item-total-price">
                <?= number_format($thanh_tien) ?>₫
            </div>

            <a href="xoagiohang.php?id=<?= $id_sp ?>" class="remove-btn" onclick="return confirm('Xóa sản phẩm này?')">&times;</a>
        </div>
        <?php endforeach; ?>

        <div class="cart-footer">
            <div class="cart-note">
                Ghi chú
            </div>

            <div class="cart-checkout-box">
                <div class="total-amount">
                    Tổng tiền: <b><?= number_format($tong_tien_gh) ?>₫</b>
                </div>

                <div class="btn-group">
                    <a href="index.php?page_layout=menu" class="btn-cart btn-red">
                        <i class="fas fa-reply"></i> TIẾP TỤC MUA HÀNG
                    </a>
                    <button type="submit" class="btn-cart btn-dark-red">CẬP NHẬT</button>
                    <a href="index.php?page_layout=thanhtoan" class="btn-cart btn-dark-red">THANH TOÁN</a>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function changeQty(id, delta) {
    let input = document.getElementById('qty_' + id);
    let currentVal = parseInt(input.value);
    let newVal = currentVal + delta;
    if (newVal >= 1) {
        input.value = newVal;
    }
}
</script>

<?php } ?>