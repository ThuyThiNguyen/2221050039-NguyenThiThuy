<?php
session_start();
include "connect.php";

if (isset($_POST['id'])) {
    $id_sp = intval($_POST['id']);
    // Lấy số lượng từ form, mặc định là 1
    $sl_them = isset($_POST['so_luong']) ? intval($_POST['so_luong']) : 1;
    
    // Xử lý Option/Topping (Quan trọng để tạo ID giỏ hàng duy nhất)
    $options_selected = isset($_POST['lua_chon']) ? $_POST['lua_chon'] : [];
    
    // Sắp xếp mảng option để đảm bảo thứ tự không ảnh hưởng (VD: "Cay, Phô mai" giống "Phô mai, Cay")
    sort($options_selected); 
    $chuoi_lua_chon = implode(" / ", $options_selected); 

    // TẠO KEY GIỎ HÀNG: ID + Mã hóa chuỗi lựa chọn
    // Ví dụ: 15_a8f93... (Nếu không có option thì md5 chuỗi rỗng vẫn ra mã hash, đảm bảo logic nhất quán)
    $cart_id = $id_sp . "_" . md5($chuoi_lua_chon);

    // Truy vấn lấy thông tin gốc
    $sql = "SELECT * FROM san_pham WHERE id = $id_sp";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($query);

    if ($row) {
        // Kiểm tra xem món này (với option này) đã có trong giỏ chưa
        if (isset($_SESSION['gio_hang'][$cart_id])) {
            // CÓ RỒI -> CỘNG DỒN SỐ LƯỢNG
            $_SESSION['gio_hang'][$cart_id]['so_luong'] += $sl_them;
        } else {
            // CHƯA CÓ -> THÊM MỚI
            $_SESSION['gio_hang'][$cart_id] = [
                'id' => $row['id'],
                'ten' => $row['ten_san_pham'],
                'hinh' => $row['hinh_anh'],
                'gia' => $row['gia'],
                'so_luong' => $sl_them,
                'ghi_chu' => $chuoi_lua_chon
            ];
        }
    }
    
    // JS quay lại trang trước và reload để thấy số lượng mới
    echo "<script>
            alert('Đã thêm vào giỏ hàng!'); 
            window.location.href = document.referrer;
          </script>";
}
?>