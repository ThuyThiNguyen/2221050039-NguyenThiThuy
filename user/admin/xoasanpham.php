<?php
include "connect.php";
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "DELETE FROM san_pham WHERE id = '$id'";
    if(mysqli_query($conn, $sql)){
        echo "<script>alert('Xóa thành công!'); window.location.href='index.php?page_layout=qlspham';</script>";
    } else {
        echo "<script>alert('Lỗi xóa sản phẩm!'); window.location.href='index.php?page_layout=qlspham';</script>";
    }
} else {
    header('location: index.php?page_layout=qlspham');
}
?>