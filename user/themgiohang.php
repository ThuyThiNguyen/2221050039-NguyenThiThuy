<?php
// session_start(); // Nếu index.php đã có session_start() thì không cần dòng này
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $so_luong = $_POST['so_luong'];

    // Lấy thông tin sản phẩm từ DB
    $sql = "SELECT * FROM san_pham WHERE id = $id";
    $res = mysqli_query($conn, $sql);
    $sp = mysqli_fetch_assoc($res);

    if ($sp) {
        $item = [
            'id' => $sp['id'],
            'ten' => $sp['ten_san_pham'],
            'gia' => $sp['gia'],
            'hinh' => $sp['hinh_anh'],
            'so_luong' => $so_luong
        ];

        if (isset($_SESSION['gio_hang'][$id])) {
            $_SESSION['gio_hang'][$id]['so_luong'] += $so_luong;
        } else {
            $_SESSION['gio_hang'][$id] = $item;
        }
    }
    // Gán một biến session để đánh dấu là vừa thêm thành công -> kích hoạt popup
    $_SESSION['show_cart_popup'] = true;
    $_SESSION['last_added_id'] = $id;

    echo "<script>window.location.href='index.php?page_layout=chitietsanpham&id=$id';</script>";
}
?>