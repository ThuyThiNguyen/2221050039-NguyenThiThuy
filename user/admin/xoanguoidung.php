<?php
include("connect.php");

$id = $_GET['id'];

$sql = "DELETE FROM nguoi_dung WHERE id = $id";
mysqli_query($conn, $sql);

header("Location: index.php?page_layout=nguoidung");
