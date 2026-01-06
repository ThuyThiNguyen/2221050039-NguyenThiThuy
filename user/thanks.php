<?php
$id_don = isset($_GET['id']) ? $_GET['id'] : 0;
?>
<style>
    .thank-you-wrapper {
        text-align: center;
        padding: 80px 20px;
        background: #fff;
        max-width: 600px;
        margin: 50px auto;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    .icon-success {
        color: #28a745;
        font-size: 80px;
        margin-bottom: 20px;
    }
    .thank-title { font-size: 28px; font-weight: bold; color: #333; margin-bottom: 10px; }
    .thank-desc { color: #666; font-size: 16px; margin-bottom: 30px; line-height: 1.5; }
    .order-id { font-weight: bold; color: #338dbc; font-size: 18px; }
    .btn-home {
        display: inline-block;
        background: #338dbc;
        color: white;
        padding: 12px 30px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: 500;
        transition: 0.3s;
    }
    .btn-home:hover { background: #266a91; }
</style>

<div class="thank-you-wrapper">
    <div class="icon-success">✔</div>
    <div class="thank-title">Đặt hàng thành công!</div>
    
    <div class="thank-desc">
        Cảm ơn bạn đã mua hàng tại <b>Gà Rán Otoké</b>.<br>
        Mã đơn hàng của bạn là: <span class="order-id">#<?= $id_don ?></span><br>
        Nhân viên sẽ sớm liên hệ để xác nhận đơn hàng của bạn.
    </div>

    <a href="index.php" class="btn-home">Tiếp tục mua sắm</a>
</div>