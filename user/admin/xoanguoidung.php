<?php
include("connect.php");
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "DELETE FROM nguoi_dung WHERE id = $id";
    if(mysqli_query($conn, $sql)){
        echo "<script>alert('Đã xóa thành công!'); window.location.href='index.php?page_layout=nguoidung';</script>";
    } else {
        echo "<script>alert('Lỗi khi xóa!'); window.location.href='index.php?page_layout=nguoidung';</script>";
    }
} else {
    echo "<script>window.location.href='index.php?page_layout=nguoidung';</script>";
}
?>