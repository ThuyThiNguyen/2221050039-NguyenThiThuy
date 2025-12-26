<?php
// session_start(); 
include("connect.php");
$id = intval($_GET['id']);

/* 1. XỬ LÝ LƯU ĐÁNH GIÁ */
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_danh_gia'])) {
    if (isset($_SESSION['user_id'])) {
        $id_user = $_SESSION['user_id'];
        $id_sp_post = intval($_POST['id_san_pham']);
        $stars = intval($_POST['so_sao']);
        $content = mysqli_real_escape_string($conn, $_POST['noi_dung']);

        $sql_add = "INSERT INTO danh_gia (id_nguoi_dung, id_san_pham, so_sao, noi_dung) 
                    VALUES ($id_user, $id_sp_post, $stars, '$content')";
        
        if (mysqli_query($conn, $sql_add)) {
            echo "<script>alert('Gửi thành công!'); window.location.href='index.php?page_layout=chitietsanpham&id=$id_sp_post';</script>";
            exit();
        }
    }
}

/* 2. XỬ LÝ THÊM GIỎ HÀNG */
$vua_them = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_them'])) {
    $id_sp_cart = intval($_POST['id']);
    $sl_mua = intval($_POST['so_luong']);
    
    // Lấy các tickbox đã chọn
    $options_selected = isset($_POST['lua_chon']) ? $_POST['lua_chon'] : [];
    $chuoi_lua_chon = implode(" / ", $options_selected);

    $sql_sp_check = "SELECT * FROM san_pham WHERE id = $id_sp_cart";
    $res_check = mysqli_query($conn, $sql_sp_check);
    $info_sp = mysqli_fetch_assoc($res_check);

    if ($info_sp) {
        // Tạo ID duy nhất cho giỏ hàng dựa trên sản phẩm + lựa chọn
        $cart_id = $id_sp_cart . "_" . md5($chuoi_lua_chon);

        if (isset($_SESSION['gio_hang'][$cart_id])) {
            $_SESSION['gio_hang'][$cart_id]['so_luong'] += $sl_mua;
        } else {
            $_SESSION['gio_hang'][$cart_id] = [
                'id' => $id_sp_cart,
                'ten' => $info_sp['ten_san_pham'],
                'gia' => $info_sp['gia'],
                'hinh' => $info_sp['hinh_anh'],
                'so_luong' => $sl_mua,
                'ghi_chu_lua_chon' => $chuoi_lua_chon
            ];
        }
        $vua_them = true;
    }
}

/* 3. LẤY DỮ LIỆU HIỂN THỊ */
$sp = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM san_pham WHERE id=$id"));
$sp_lq = mysqli_query($conn, "SELECT * FROM san_pham WHERE id_danh_muc = {$sp['id_danh_muc']} AND id != $id LIMIT 4");

$sql_dg = "SELECT dg.*, nd.ho_ten FROM danh_gia dg LEFT JOIN nguoi_dung nd ON dg.id_nguoi_dung = nd.id WHERE dg.id_san_pham = $id ORDER BY dg.ngay_danh_gia DESC";
$ds_dg = mysqli_query($conn, $sql_dg);
?>

<style>
.chi-tiet{display:grid;grid-template-columns:1fr 1fr;gap:40px;max-width:1200px;margin:40px auto}
.chi-tiet img{width:100%;border-radius:12px}
.gia{color:#e53935;font-size:26px;font-weight:bold}
.so-luong{display:flex;gap:10px;align-items:center;margin:15px 0}
.so-luong button{width:35px;height:35px; cursor:pointer}
.them-gio{background:#e53935;color:#fff;padding:14px;border:none;width:100%;font-size:16px;border-radius:6px; cursor:pointer; margin-top: 10px;}
.cart-preview {border: 1px solid #ddd; padding: 20px; background: #fff; max-width: 400px; margin-top: 20px;}
.section{max-width:1200px;margin:60px auto}
.review{border-bottom:1px solid #ddd;padding:10px 0}
.related-item img{width:100%;height:150px;object-fit:cover}
.lua-chon-box { margin: 15px 0; border-top: 1px solid #eee; padding-top: 10px; }
.lua-chon-box label { display: block; margin-bottom: 5px; cursor: pointer; transition: 0.2s; }
</style>

<div class="chi-tiet">
    <div><img src="/2221050039/image/<?= $sp['hinh_anh'] ?>"></div>
    <div>
        <h2><?= $sp['ten_san_pham'] ?></h2>
        <p class="gia"><?= number_format($sp['gia']) ?> đ</p>

        <?php if ($vua_them == false): ?>
            <p><?= $sp['mo_ta'] ?></p>
            
            <form action="" method="post">
                <input type="hidden" name="id" value="<?= $sp['id'] ?>">
                <input type="hidden" name="so_luong" id="so_luong_hidden" value="1">

                <div class="lua-chon-box">
                    <p><b>Chọn tối đa 2 vị:</b></p>
                    <?php 
                    if(!empty($sp['lua_chon_them'])){
                        $options = explode(',', $sp['lua_chon_them']);
                        foreach($options as $opt): 
                            $opt = trim($opt);
                    ?>
                        <label>
                            <input type="checkbox" name="lua_chon[]" value="<?= $opt ?>"> <?= $opt ?>
                        </label>
                    <?php endforeach; } ?>
                </div>

                <div class="so-luong">
                    <button type="button" onclick="giam()">-</button>
                    <input id="sl" type="text" value="1" readonly style="width:40px;text-align:center">
                    <button type="button" onclick="tang()">+</button>
                </div>

                <button type="submit" name="btn_them" class="them-gio">THÊM VÀO GIỎ</button>
            </form>
        <?php else: ?>
            <div class="cart-preview">
                <h3>ĐÃ THÊM VÀO GIỎ</h3>
                <p><?= $sp['ten_san_pham'] ?></p>
                <div class="cart-preview-btns">
                    <a href="index.php?page_layout=giohang" class="btn-action" style="background: #000; color: #fff; padding: 10px; text-decoration: none; display: inline-block; margin-top: 10px;">XEM GIỎ HÀNG</a>
                    <a href="index.php?page_layout=thanhtoan" class="btn-action" style="background: #e53935; color: #fff; padding: 10px; text-decoration: none; display: inline-block;">THANH TOÁN</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function tang(){
    let sl = document.getElementById("sl");
    sl.value = parseInt(sl.value) + 1;
    document.getElementById("so_luong_hidden").value = sl.value;
}
function giam(){
    let sl = document.getElementById("sl");
    if(sl.value > 1){
        sl.value = parseInt(sl.value) - 1;
        document.getElementById("so_luong_hidden").value = sl.value;
    }
}

// FIX LỖI GIỚI HẠN 2 TICKBOX
const checkboxes = document.querySelectorAll('input[name="lua_chon[]"]');
const maxAllowed = 2;

checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const checkedBoxes = document.querySelectorAll('input[name="lua_chon[]"]:checked');
        
        if (checkedBoxes.length >= maxAllowed) {
            checkboxes.forEach(box => {
                if (!box.checked) {
                    box.disabled = true;
                    box.parentElement.style.opacity = "0.5";
                }
            });
        } else {
            checkboxes.forEach(box => {
                box.disabled = false;
                box.parentElement.style.opacity = "1";
            });
        }
    });
});
</script>