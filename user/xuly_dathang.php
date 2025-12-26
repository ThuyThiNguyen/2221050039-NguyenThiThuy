<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("connect.php");

// 1. Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Vui lòng đăng nhập!'); window.location.href='index.php?page_layout=dangnhap';</script>";
    exit();
}

$id_nguoi_dung = $_SESSION['user_id'];

// 2. Kiểm tra giỏ hàng
if (!isset($_SESSION['gio_hang']) || empty($_SESSION['gio_hang'])) {
    echo "<script>alert('Giỏ hàng trống!'); window.location.href='index.php?page_layout=menu';</script>";
    exit();
}

// 3. Lấy dữ liệu địa chỉ từ các thẻ INPUT ẨN (Lấy tên thay vì mã code)
$dia_chi    = mysqli_real_escape_string($conn, $_POST['dia_chi']);
$tinh_thanh = mysqli_real_escape_string($conn, $_POST['tinh_thanh_name']); // Lấy từ input ẩn
$quan_huyen = mysqli_real_escape_string($conn, $_POST['quan_huyen_name']); // Lấy từ input ẩn
$phuong_xa  = mysqli_real_escape_string($conn, $_POST['phuong_xa_name']);  // Lấy từ input ẩn

// 4. Lưu địa chỉ mới vào bảng dia_chi_giao_hang
$sql_insert_dc = "INSERT INTO dia_chi_giao_hang (id_nguoi_dung, dia_chi, phuong_xa, quan_huyen, tinh_thanh) 
                  VALUES ($id_nguoi_dung, '$dia_chi', '$phuong_xa', '$quan_huyen', '$tinh_thanh')";

if (mysqli_query($conn, $sql_insert_dc)) {
    $id_dia_chi = mysqli_insert_id($conn);

    // 5. Tính tổng tiền & Áp dụng mã giảm giá (nếu có)
    $tong_tien = 0;
    foreach ($_SESSION['gio_hang'] as $item) {
        $tong_tien += ($item['gia'] * $item['so_luong']);
    }

    // Nếu bạn đã lưu số tiền giảm vào session ở file xuly_magiamgia.php
    if (isset($_SESSION['discount_amount'])) {
        $tong_tien -= $_SESSION['discount_amount'];
        if ($tong_tien < 0) $tong_tien = 0;
    }

    // 6. Lưu đơn hàng (id_trang_thai 1 = Đang xử lý)
    $sql_donhang = "INSERT INTO don_hang (id_nguoi_dung, tong_tien, id_trang_thai, id_dia_chi, ngay_dat) 
                    VALUES ($id_nguoi_dung, $tong_tien, 1, $id_dia_chi, NOW())";

    if (mysqli_query($conn, $sql_donhang)) {
        $id_don_hang = mysqli_insert_id($conn);

        // 7. Lưu chi tiết đơn hàng
        foreach ($_SESSION['gio_hang'] as $id_sp => $item) {
            $gia = $item['gia'];
            $sl = $item['so_luong'];
            $sql_ct = "INSERT INTO chi_tiet_don_hang (id_don_hang, id_san_pham, so_luong, gia) 
                       VALUES ($id_don_hang, $id_sp, $sl, $gia)";
            mysqli_query($conn, $sql_ct);
        }

        // 8. Dọn dẹp Session
        unset($_SESSION['gio_hang']);
        unset($_SESSION['discount_amount']); // Xóa mã giảm giá sau khi dùng xong
        
        // Chuyển hướng sang trang HOÀN TẤT ĐƠN HÀNG
        echo "<script>alert('Đặt hàng thành công!'); window.location.href='index.php?page_layout=thanks&id=$id_don_hang';</script>";
    } else {
        echo "Lỗi lưu đơn hàng: " . mysqli_error($conn);
    }
} else {
    echo "Lỗi lưu địa chỉ: " . mysqli_error($conn);
}
?>