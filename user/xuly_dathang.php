<?php
// 1. SỬA LỖI SESSION: Chỉ start nếu chưa có
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra kết nối
if (!isset($conn)) include "connect.php";

// Kiểm tra dữ liệu đầu vào
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['gio_hang'])) {
    
    // Lấy thông tin khách hàng
    $ho_ten = mysqli_real_escape_string($conn, $_POST['ho_ten']);
    $sdt = mysqli_real_escape_string($conn, $_POST['sdt']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $dia_chi_cu_the = mysqli_real_escape_string($conn, $_POST['dia_chi']);
    
    $tinh = isset($_POST['tinh_thanh_name']) ? $_POST['tinh_thanh_name'] : '';
    $huyen = isset($_POST['quan_huyen_name']) ? $_POST['quan_huyen_name'] : '';
    $xa = isset($_POST['phuong_xa_name']) ? $_POST['phuong_xa_name'] : '';

    $id_nguoi_dung = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

    // --- A. LƯU ĐỊA CHỈ ---
    // (Lưu ý: Nếu database chưa có bảng dia_chi_giao_hang hoặc thiếu cột, bước này có thể báo lỗi. 
    // Nếu lỗi ở đây, hãy comment đoạn này lại và gán $id_dia_chi = 0)
    $sql_dc = "INSERT INTO dia_chi_giao_hang (id_nguoi_dung, dia_chi, phuong_xa, quan_huyen, tinh_thanh) 
               VALUES ('$id_nguoi_dung', '$dia_chi_cu_the', '$xa', '$huyen', '$tinh')";
    
    $id_dia_chi = 0;
    if (mysqli_query($conn, $sql_dc)) {
        $id_dia_chi = mysqli_insert_id($conn);
    }

    // --- B. TÍNH TỔNG TIỀN ---
    $tong_tien = 0;
    foreach ($_SESSION['gio_hang'] as $item) {
        $gia = isset($item['gia']) ? $item['gia'] : 0;
        $sl = isset($item['so_luong']) ? $item['so_luong'] : 1;
        $tong_tien += ($gia * $sl);
    }

    // --- C. TẠO ĐƠN HÀNG ---
    $ngay_dat = date('Y-m-d H:i:s');
    // Lưu ý: Đã bỏ cột 'ghi_chu' để tránh lỗi Unknown column
    $sql_dh = "INSERT INTO don_hang (id_nguoi_dung, id_dia_chi, ngay_dat, tong_tien, id_trang_thai) 
               VALUES ('$id_nguoi_dung', '$id_dia_chi', '$ngay_dat', '$tong_tien', 1)";

    if (mysqli_query($conn, $sql_dh)) {
        $id_don_hang = mysqli_insert_id($conn);

        // --- D. LƯU CHI TIẾT ĐƠN HÀNG (SỬA LỖI KEY ID) ---
        foreach ($_SESSION['gio_hang'] as $key => $item) {
            
            // FIX LỖI: Tìm ID sản phẩm an toàn
            if (isset($item['id']) && !empty($item['id'])) {
                $id_sp = intval($item['id']);
            } else {
                // Nếu item['id'] bị thiếu, cố gắng lấy ID từ key (VD: "15_md5code" -> lấy 15)
                $parts = explode('_', $key);
                $id_sp = intval($parts[0]);
            }

            // Nếu vẫn không có ID hợp lệ thì bỏ qua dòng này để tránh Fatal Error
            if ($id_sp <= 0) continue;

            $sl = intval($item['so_luong']);
            $gia = intval($item['gia']);
            
            $sql_ct = "INSERT INTO chi_tiet_don_hang (id_don_hang, id_san_pham, so_luong, gia) 
                       VALUES ('$id_don_hang', '$id_sp', '$sl', '$gia')";
            mysqli_query($conn, $sql_ct);
        }

        // Xóa giỏ hàng và chuyển hướng
        unset($_SESSION['gio_hang']);
        echo "<script>
                alert('🎉 ĐẶT HÀNG THÀNH CÔNG!\\nMã đơn hàng của bạn là: #$id_don_hang\\nChúng tôi sẽ sớm liên hệ xác nhận.');
                window.location.href = 'index.php?page_layout=lichsu&id=$id_don_hang';
              </script>";
        exit();

    } else {
        die("Lỗi tạo đơn hàng: " . mysqli_error($conn));
    }

} else {
    // Nếu truy cập trực tiếp
    echo "<script>window.location.href='index.php';</script>";
}
?>