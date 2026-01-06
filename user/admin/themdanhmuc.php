<?php
include "connect.php";
// Xử lý Thêm mới ngay đầu file
$error_message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tenDanhMuc = trim($_POST["ten-danh-muc"]); // Trim để cắt khoảng trắng thừa

    if (!empty($tenDanhMuc)) {
        $sql = "INSERT INTO `danh_muc`(`ten_danh_muc`) VALUES ('$tenDanhMuc')";
        if (mysqli_query($conn, $sql)) {
            // Dùng javascript chuyển hướng để tránh lỗi header
            echo "<script>window.location.href='index.php?page_layout=qldanhmuc';</script>";
            exit();
        } else {
            $error_message = "Lỗi truy vấn: " . mysqli_error($conn);
        }
    } else {
        $error_message = "Vui lòng nhập tên danh mục!";
    }
}
?>

<style>
    /* CSS Form chuẩn đẹp */
    .form-container {
        max-width: 500px;
        margin: 30px auto; /* Căn giữa */
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    
    .form-title {
        text-align: center;
        margin-bottom: 25px;
        color: #333;
        font-size: 22px;
        font-weight: bold;
    }

    .form-group { margin-bottom: 20px; }
    
    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #555;
    }
    
    .form-control {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
        transition: 0.3s;
        box-sizing: border-box; /* Quan trọng để không bị vỡ khung */
    }
    
    .form-control:focus {
        border-color: #3b82f6;
        outline: none;
        box-shadow: 0 0 5px rgba(59, 130, 246, 0.3);
    }

    .btn-group {
        display: flex;
        gap: 10px;
        margin-top: 10px;
    }

    .btn {
        flex: 1;
        padding: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        text-align: center;
        text-decoration: none;
        font-size: 14px;
        transition: 0.2s;
    }

    .btn-submit { background-color: #38a169; color: white; }
    .btn-submit:hover { background-color: #2f855a; }

    .btn-back { background-color: #718096; color: white; }
    .btn-back:hover { background-color: #4a5568; }

    .alert-error {
        color: #e53e3e;
        background-color: #fff5f5;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 15px;
        border: 1px solid #fed7d7;
        font-size: 13px;
        text-align: center;
    }
</style>

<div class="form-container">
    <h2 class="form-title">Thêm Danh Mục Mới</h2>
    
    <?php if (!empty($error_message)): ?>
        <div class="alert-error"><?= $error_message ?></div>
    <?php endif; ?>

    <form action="" method="post">
        <div class="form-group">
            <label class="form-label">Tên danh mục</label>
            <input type="text" name="ten-danh-muc" class="form-control" placeholder="Ví dụ: Điện thoại, Laptop...">
        </div>

        <div class="btn-group">
            <button type="submit" class="btn btn-submit">Lưu lại</button>
            <a href="index.php?page_layout=qldanhmuc" class="btn btn-back">Quay lại</a>
        </div>
    </form>
</div>