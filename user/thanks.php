<?php
$id_dh = intval($_GET['id']);
// Lấy thông tin đơn hàng để hiển thị tên khách
$sql_thanks = "SELECT dh.*, nd.ho_ten FROM don_hang dh 
               JOIN nguoi_dung nd ON dh.id_nguoi_dung = nd.id 
               WHERE dh.id = $id_dh";
$res_thanks = mysqli_query($conn, $sql_thanks);
$order = mysqli_fetch_assoc($res_thanks);
?>

<style>
    .thanks-container {
        max-width: 600px;
        margin: 80px auto;
        text-align: center;
        font-family: sans-serif;
        padding: 40px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }
    .check-icon {
        width: 80px;
        height: 80px;
        background: #4caf50;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        margin: 0 auto 20px;
    }
    .order-id-box {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin: 20px 0;
        border: 1px dashed #ddd;
    }
    .btn-home {
        display: inline-block;
        padding: 12px 30px;
        background: #e53935;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        margin-top: 20px;
    }
</style>

<div class="thanks-container">
    <div class="check-icon">✓</div>
    <h2>ĐẶT HÀNG THÀNH CÔNG!</h2>
    <p>Chào <b><?= $order['ho_ten'] ?></b>, cảm ơn bạn đã lựa chọn Gà Rán Otoké.</p>
    
    <div class="order-id-box">
        Mã đơn hàng của bạn là: <b style="color: #e53935;">#<?= $id_dh ?></b>
    </div>
    
    <p style="color: #666; font-size: 14px;">
        Chúng tôi đã nhận được đơn hàng của bạn và đang tiến hành xử lý. 
        Nhân viên sẽ liên hệ xác nhận trong ít phút.
    </p>

    <a href="index.php?page_layout=trangchu" class="btn-home">TIẾP TỤC MUA SẮM</a>
    <br>
    <a href="index.php?page_layout=lichsu" style="display:block; margin-top:15px; color: #338dbc; text-decoration:none; font-size: 14px;">
        Xem trạng thái đơn hàng của tôi
    </a>
</div>