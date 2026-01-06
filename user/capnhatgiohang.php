<?php
// session_start(); // Nếu file này được include vào index thì bỏ comment dòng này
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['qty'])) {
    
    foreach ($_POST['qty'] as $cart_id => $new_qty) {
        // Ép kiểu cart_id về string để tránh lỗi
        $cart_id = (string)$cart_id;
        $sl_moi = intval($new_qty);

        // Nếu số lượng <= 0 thì xóa khỏi giỏ
        if ($sl_moi <= 0) {
            unset($_SESSION['gio_hang'][$cart_id]);
        } else {
            // Nếu tồn tại thì cập nhật số lượng mới
            if (isset($_SESSION['gio_hang'][$cart_id])) {
                $_SESSION['gio_hang'][$cart_id]['so_luong'] = $sl_moi;
            }
        }
    }
}

// Quay lại trang giỏ hàng
echo "<script>window.location.href='index.php?page_layout=giohang';</script>";
exit();
?>