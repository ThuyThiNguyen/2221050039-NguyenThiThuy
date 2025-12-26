<?php
// Kiểm tra giỏ hàng
if (!isset($_SESSION['gio_hang']) || empty($_SESSION['gio_hang'])) {
    echo "<script>alert('Giỏ hàng trống!'); window.location.href='index.php?page_layout=menu';</script>";
    exit();
}
?>

<style>
    .checkout-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        min-height: 100vh;
    }

    /* CỘT TRÁI: THÔNG TIN GIAO HÀNG */
    .checkout-left {
        flex: 1;
        padding: 40px;
        border-right: 1px solid #e1e1e1;
    }
    .checkout-left h2 { font-size: 24px; margin-bottom: 5px; }
    .breadcrumb { font-size: 12px; color: #737373; margin-bottom: 30px; }
    .breadcrumb a { color: #338dbc; text-decoration: none; }

    .section-title { font-size: 18px; margin-bottom: 15px; font-weight: 500; }
    .login-hint { font-size: 14px; margin-bottom: 20px; }
    .login-hint a { color: #338dbc; text-decoration: none; }

    .form-group { margin-bottom: 12px; display: flex; gap: 10px; }
    .input-control {
        width: 100%;
        padding: 12px;
        border: 1px solid #d9d9d9;
        border-radius: 4px;
        font-size: 14px;
        box-sizing: border-box;
    }
    .select-control {
        flex: 1;
        padding: 12px;
        border: 1px solid #d9d9d9;
        border-radius: 4px;
        background-color: #fff;
    }

    .footer-links {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
    }
    .btn-continue {
        background-color: #338dbc;
        color: white;
        padding: 15px 25px;
        border: none;
        border-radius: 4px;
        font-weight: 500;
        cursor: pointer;
        font-size: 14px;
    }
    .btn-continue:hover { background-color: #2b78a0; }

    /* CỘT PHẢI: TÓM TẮT ĐƠN HÀNG */
    .checkout-right {
        width: 450px;
        background-color: #fafafa;
        padding: 40px;
    }
    .product-list { margin-bottom: 20px; }
    .product-item {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
    }
    .product-img-wrapper {
        position: relative;
        width: 64px;
        height: 64px;
        background: #fff;
        border: 1px solid #e1e1e1;
        border-radius: 8px;
    }
    .product-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 8px;
    }
    .product-qty-circle {
        position: absolute;
        top: -10px;
        right: -10px;
        background-color: rgba(153,153,153,0.9);
        color: white;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
    }
    .product-info { flex: 1; }
    .product-name { font-size: 14px; font-weight: 500; }
    .product-desc { font-size: 12px; color: #737373; }
    .product-price { font-size: 14px; color: #4b4b4b; }

    .discount-box {
        display: flex;
        gap: 10px;
        padding: 20px 0;
        border-top: 1px solid #e1e1e1;
        border-bottom: 1px solid #e1e1e1;
    }
    .btn-apply {
        background-color: #c8c8c8;
        color: white;
        border: none;
        padding: 0 20px;
        border-radius: 4px;
        cursor: not-allowed;
    }

    .summary-line {
        display: flex;
        justify-content: space-between;
        margin: 15px 0;
        font-size: 14px;
        color: #717171;
    }
    .total-line {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #e1e1e1;
        font-size: 18px;
        color: #4b4b4b;
    }
    .total-price { font-size: 24px; color: #4b4b4b; font-weight: 500; }
</style>

<div class="checkout-wrapper">
    <div class="checkout-left">
        <h2>Gà Rán Otoké</h2>
        <div class="breadcrumb">
            <a href="index.php?page_layout=giohang">Giỏ hàng</a> &gt; Thông tin giao hàng &gt; Phương thức thanh toán
        </div>

        <form action="index.php?page_layout=xuly_dathang" method="post">
            <div class="section-title">Thông tin giao hàng</div>

            <div class="form-group">
                <input type="text" name="ho_ten" class="input-control" placeholder="Họ và tên" required>
            </div>

            <div class="form-group">
                <input type="email" name="email" class="input-control" placeholder="Email" style="flex: 2;">
                <input type="text" name="sdt" class="input-control" placeholder="Số điện thoại" required style="flex: 1.2;">
            </div>

            <div class="form-group">
                <input type="text" name="dia_chi" class="input-control" placeholder="Địa chỉ cụ thể (Số nhà, tên đường...)" required>
            </div>

            <div class="form-group">
    <select name="tinh_thanh" id="province" class="select-control" required>
        <option value="">Chọn tỉnh / thành</option>
    </select>
    
    <select name="quan_huyen" id="district" class="select-control" required disabled>
        <option value="">Chọn quận / huyện</option>
    </select>
    
    <select name="phuong_xa" id="ward" class="select-control" required disabled>
        <option value="">Chọn phường / xã</option>
    </select>
</div>

<input type="hidden" name="tinh_thanh_name" id="province_name">
<input type="hidden" name="quan_huyen_name" id="district_name">
<input type="hidden" name="phuong_xa_name" id="ward_name">

            <div class="footer-links">
                <a href="index.php?page_layout=giohang" style="color: #338dbc; text-decoration: none; font-size: 14px;">Giỏ hàng</a>
                <button type="submit" class="btn-continue">Tiếp tục đến phương thức thanh toán</button>
            </div>
        </form>
    </div>

    <div class="checkout-right">
        <div class="product-list">
            <?php 
            $tong_tien = 0;
            foreach ($_SESSION['gio_hang'] as $item): 
                $tong_tien += ($item['gia'] * $item['so_luong']);
            ?>
            <div class="product-item">
                <div class="product-img-wrapper">
                    <img src="/2221050039/image/<?= $item['hinh'] ?>" alt="">
                    <div class="product-qty-circle"><?= $item['so_luong'] ?></div>
                </div>
                <div class="product-info">
                    <div class="product-name"><?= $item['ten'] ?></div>
                    <div class="product-desc">Mirinda / Burger gà kim chi</div>
                </div>
                <div class="product-price"><?= number_format($item['gia'] * $item['so_luong']) ?>₫</div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="discount-box">
    <input type="text" id="coupon_code" class="input-control" placeholder="Mã giảm giá">
    <button type="button" onclick="applyCoupon()" class="btn-apply" 
            style="background-color: #338dbc; cursor: pointer;">Sử dụng</button>
</div>
<div id="coupon_message" style="font-size: 13px; margin-top: 5px;"></div>

<script>
function applyCoupon() {
    let code = document.getElementById('coupon_code').value;
    if(code == "") return;

    // Gửi yêu cầu kiểm tra mã (Bạn cần tạo file xuly_magiamgia.php)
    fetch('xuly_magiamgia.php?code=' + code)
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            document.getElementById('coupon_message').innerHTML = "<span style='color:green'>Áp dụng mã thành công!</span>";
            location.reload(); // Load lại để tính lại tổng tiền trong session
        } else {
            document.getElementById('coupon_message').innerHTML = "<span style='color:red'>" + data.message + "</span>";
        }
    });
}
</script>
        <div class="summary-line">
            <span>Tạm tính</span>
            <span><?= number_format($tong_tien) ?>₫</span>
        </div>
        <div class="summary-line">
            <span>Phí vận chuyển</span>
            <span style="font-size: 12px;">Hotline sẽ liên hệ báo phí</span>
        </div>
        <script>
const host = "https://provinces.open-api.vn/api/";

// 1. Lấy danh sách Tỉnh
fetch(host + "?depth=1")
    .then(response => response.json())
    .then(data => {
        data.forEach(item => {
            document.getElementById("province").innerHTML += `<option value="${item.code}">${item.name}</option>`;
        });
    });

// 2. Khi chọn Tỉnh -> Lấy Huyện
document.getElementById("province").addEventListener("change", function() {
    let provinceCode = this.value;
    let provinceName = this.options[this.selectedIndex].text;
    document.getElementById("province_name").value = provinceName; // Lưu tên tỉnh

    if (provinceCode !== "") {
        fetch(host + "p/" + provinceCode + "?depth=2")
            .then(response => response.json())
            .then(data => {
                let districtSelect = document.getElementById("district");
                districtSelect.disabled = false;
                districtSelect.innerHTML = '<option value="">Chọn quận / huyện</option>';
                data.districts.forEach(item => {
                    districtSelect.innerHTML += `<option value="${item.code}">${item.name}</option>`;
                });
                // Reset xã
                document.getElementById("ward").innerHTML = '<option value="">Chọn phường / xã</option>';
                document.getElementById("ward").disabled = true;
            });
    }
});

// 3. Khi chọn Huyện -> Lấy Xã
document.getElementById("district").addEventListener("change", function() {
    let districtCode = this.value;
    let districtName = this.options[this.selectedIndex].text;
    document.getElementById("district_name").value = districtName; // Lưu tên huyện

    if (districtCode !== "") {
        fetch(host + "d/" + districtCode + "?depth=2")
            .then(response => response.json())
            .then(data => {
                let wardSelect = document.getElementById("ward");
                wardSelect.disabled = false;
                wardSelect.innerHTML = '<option value="">Chọn phường / xã</option>';
                data.wards.forEach(item => {
                    wardSelect.innerHTML += `<option value="${item.code}">${item.name}</option>`;
                });
            });
    }
});

// 4. Khi chọn Xã -> Lưu tên xã
document.getElementById("ward").addEventListener("change", function() {
    document.getElementById("ward_name").value = this.options[this.selectedIndex].text;
});
</script>

        <div class="total-line">
            <span>Tổng cộng</span>
            <div style="text-align: right;">
                <span style="font-size: 12px; color: #737373;">VND</span>
                <span class="total-price"><?= number_format($tong_tien) ?>₫</span>
            </div>
        </div>
    </div>
</div>