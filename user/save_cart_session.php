<?php
session_start();
if (isset($_POST['cart_data'])) {
    $cart = json_decode($_POST['cart_data'], true);
    $_SESSION['gio_hang'] = [];
    foreach ($cart as $item) {
        $_SESSION['gio_hang'][$item['id']] = [
            'ten' => $item['name'],
            'gia' => $item['price'],
            'so_luong' => $item['quantity'],
            'hinh' => $item['img']
        ];
    }
    echo "success";
}
?>