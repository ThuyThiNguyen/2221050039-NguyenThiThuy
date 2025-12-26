<?php
$id = $_GET['id'];
$sql = "DELETE FROM tintuc WHERE id_tt = $id";
mysqli_query($conn, $sql);
header('location: index.php?page_layout=qltintuc');
?>