<?php
session_start();
include "connect.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gà Rán Otoké</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <ul class="menu" style="font-family: Times New Roman;">
                    <li><img src="/2221050039/image/1718855452958-Logo-01-01.jpg" alt=""></li>
                    <li><a href="index.php?page_layout=trangchu"><b>TRANG CHỦ</b></a></li>
                    <li><a href="index.php?page_layout=gioithieu"><b>GIỚI THIỆU</b></a></li>
                    <li><a href="index.php?page_layout=menu"><b>MENU</b></a></li>
                    <li><a href="index.php?page_layout=khuyenmai"><b>KHUYẾN MẠI</b></a></li>
                    <li><a href="index.php?page_layout=hethongtiec"><b></b>HỆ THỐNG TIỆC</b></a></li> 
                </ul>
            </nav>
             <div class="header-icons">
    <a href="index.php?page_layout=giohang">
    <p style="border: 2px solid gray; border-radius: 5px; background-color: white; padding: 5px;">
        <i class="fas fa-shopping-bag"></i>
    </p>
</a>

    <?php if(isset($_SESSION['user'])){ ?>
    <p style="border: 2px solid gray; border-radius: 5px; background-color: white; padding: 5px;">
        Xin chào, <b><?php echo $_SESSION['user']; ?></b>
        |
        <a href="index.php?page_layout=lichsu" style="text-decoration:none; color: blue;">
            <i class="fas fa-history"></i> Đơn hàng của tôi
        </a>
        |
        <a href="index.php?page_layout=dangxuat" style="text-decoration:none;color:red;">
            Đăng xuất
        </a>
    </p>
<?php  } else { ?>
        <!-- CHƯA ĐĂNG NHẬP -->
        <a href="index.php?page_layout=dangnhap" style="text-decoration:none;">
            <p style="border: 2px solid gray; border-radius: 5px; background-color: white; padding: 5px;">
                Đăng nhập
            </p>
        </a>
    <?php } ?>
</div>
        </div>
        </div>
</header>
 <?php
         if(isset($_GET['page_layout'])){
            switch($_GET['page_layout']){
               case 'trangchu':
                  include "trangchu.php";
                  break;
               case 'gioithieu':
                  include "gioithieu.php";
                  break;
               case 'menu':
                  include "menu.php";
                  break;
                case 'khuyenmai':
                include "khuyenmai.php"; 
                break;
                case 'chitiet':
                include 'chitiettintuc.php';
                break;
                case 'chitietsanpham':
                include "chitietsanpham.php";
                break;
               case 'hethongtiec':
                  include "hethongtiec.php";
                  break;
                case 'giohang':
                include "giohang.php";
                break;
                case 'themgiohang':
                include "themgiohang.php";
                break;
                case 'xoagiohang':
                include "xoagiohang.php";
                break;
                case 'capnhatgiohang':
                include "capnhatgiohang.php";
                break;
                case 'thanhtoan': 
                include "thanhtoan.php"; 
                break;
                case 'xuly_dathang': 
                include "xuly_dathang.php"; 
                break;
                case 'lichsu':
                include "lichsu_donhang.php";
                break;
                case 'chitiet_lichsu':
                include "chitiet_lichsu.php";
                 break;
                 case 'thanks':
                 include "thanks.php";
                 break;
                 case 'viet_danh_gia':
                 include "viet_danh_gia.php";
                 break;
                 case 'hdmuahang':
                    include "hdmuahang.php";
                    break;
                case 'dangnhap':
                    include "login.php";
                    break;
               case 'dangxuat':
                    session_unset();
                    session_destroy();
                    header("Location: index.php");
                    break;

            }
         }else{
                include "trangchu.php";
         }
      
      ?>
    <footer>
        <div class="container">
            <div class="footer-col">
                <h4>VỀ CHÚNG TÔI</h4>
                <p>Khởi nguồn từ sự đam mê với những miếng gà giòn ngon đậm vị của Hàn Quốc, Gà rán Otoké ra đời với mong muốn mang đến cho thực khách Việt những trải nghiệm thật “wow” về ẩm thực gà rán của xứ sở Kim Chi.</p>
                <p>DA GIÒN ĐẬM VỊ - miếng gà mềm mọng nước bên trong, giòn đậm vị bên ngoài là tiêu chí Gà rán Otoké lựa chọn để tạo ra món ăn, với 05 vị xốt được nghiên cứu làm từ 100% đậu nành tươi, ủ lên men thủ công tạo nên miếng gà thơm ngon đậm đà không đâu có được.</p>
            </div>
            <div class="footer-col">
                <h4>CÁC CHÍNH SÁCH</h4>
                <ul>
                    <li><a href="index.php?page_layout=hdmuahang">Hướng dẫn mua hàng</a></li>
                    <li><a href="#">Hướng dẫn thanh toán</a></li>
                    <li><a href="#">Chính sách đổi trả</a></li>
                    <li><a href="#">Chính sách bảo mật</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>THÔNG TIN LIÊN HỆ</h4>
                <p><i class="fas fa-map-marker-alt"></i> Địa chỉ: 665 Quốc Lộ 13, Khu phố 3, P. Hiệp Bình Phước, TP. Thủ Đức</p>
                <p><i class="fas fa-phone-alt"></i> Hotline: 1900 9480</p>
                <p><i class="fas fa-envelope"></i> Email: callcenter@otokechicken.vn</p>
            </div>
            <div class="footer-col">
                <h4>FANPAGE</h4>
            </div>
        </div>
    </footer>
</body>

</html>