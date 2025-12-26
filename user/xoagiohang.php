<?php
session_start();
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Xóa sản phẩm dựa trên ID
    if (isset($_SESSION['gio_hang'][$id])) {
        unset($_SESSION['gio_hang'][$id]);
    }
}
// Quay lại trang giỏ hàng
header("Location: index.php?page_layout=giohang");
exit();
?>