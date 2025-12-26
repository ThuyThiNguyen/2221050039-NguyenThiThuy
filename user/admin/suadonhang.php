<?php
include("connect.php");
$id = $_GET['id'];

$donhang = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT * FROM don_hang WHERE id=$id"
));

if(isset($_POST['submit'])){
    $id_trang_thai = $_POST['id_trang_thai'];
    mysqli_query($conn,
        "UPDATE don_hang SET id_trang_thai=$id_trang_thai WHERE id=$id"
    );
    header("Location: index.php?page_layout=donhang");
}
?>

<h2>Cập nhật trạng thái đơn hàng #<?= $id ?></h2>

<form method="post">
    <select name="id_trang_thai">
        <?php
        $q = mysqli_query($conn,"SELECT * FROM trang_thai");
        while($r = mysqli_fetch_assoc($q)){
            $selected = ($r['id'] == $donhang['id_trang_thai']) ? "selected" : "";
            echo "<option value='{$r['id']}' $selected>{$r['ten_trang_thai']}</option>";
        }
        ?>
    </select>
    <br><br>
    <button type="submit" name="submit">Cập nhật</button>
</form>

<a href="index.php?page_layout=donhang">⬅ Quay lại</a>
