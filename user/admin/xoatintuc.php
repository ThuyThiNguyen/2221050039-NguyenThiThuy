<?php
// Kiểm tra và kết nối CSDL
if (!isset($conn)) {
    include "connect.php";
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // SỬA LỖI: Đổi 'id' thành 'id_tt' cho đúng với bảng tin tức
    $sql = "DELETE FROM tintuc WHERE id_tt = '$id'";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Xóa bài viết thành công!');
                window.location.href = 'index.php?page_layout=qltintuc';
              </script>";
    } else {
        echo "<script>
                alert('Lỗi: Không thể xóa bài viết này. Lỗi SQL: " . mysqli_error($conn) . "');
                window.location.href = 'index.php?page_layout=qltintuc';
              </script>";
    }
} else {
    // Dùng JS chuyển hướng để tránh lỗi Header
    echo "<script>window.location.href = 'index.php?page_layout=qltintuc';</script>";
}
?>