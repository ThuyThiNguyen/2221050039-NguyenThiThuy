<?php
if (!isset($conn)) {
    include "connect.php";
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM danh_muc WHERE id = '$id'";
    
    if (mysqli_query($conn, $sql)) {
     
        echo "<script>
                alert('Xóa danh mục thành công!');
                window.location.href = 'index.php?page_layout=qldanhmuc';
              </script>";
    } else {
        
        echo "<script>
                alert('Lỗi: Không thể xóa danh mục này (có thể do đang chứa sản phẩm).');
                window.location.href = 'index.php?page_layout=qldanhmuc';
              </script>";
    }
} else {
    header('location: index.php?page_layout=qldanhmuc');
}
?>