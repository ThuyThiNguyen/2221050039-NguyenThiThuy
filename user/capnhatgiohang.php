<?php
// Không cần session_start() nếu index.php đã có
if (isset($_POST['qty'])) {
    foreach ($_POST['qty'] as $id => $new_qty) {
        $id = intval($id);
        $new_qty = intval($new_qty);

        // Nếu người dùng giảm số lượng về 0 hoặc nhỏ hơn, xóa sản phẩm khỏi giỏ
        if ($new_qty <= 0) {
            unset($_SESSION['gio_hang'][$id]);
        } else {
            // Cập nhật số lượng mới vào Session
            $_SESSION['gio_hang'][$id]['so_luong'] = $new_qty;
        }
    }
}

// Sau khi xử lý xong, dùng JavaScript để chuyển hướng về trang giỏ hàng
// Tránh lỗi "Headers already sent" nếu có khoảng trắng trong code
echo "<script>window.location.href='index.php?page_layout=giohang';</script>";
exit();
?>