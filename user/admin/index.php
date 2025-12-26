<?php
include "connect.php";
session_start();

if (!isset($_SESSION['quyen']) || $_SESSION['quyen'] != 2) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bảng thống kê</title>
    <link rel="stylesheet" href="style.css">
     <style>
        body{
            margin: 0;
        }
        nav{
            background-color:white;
            display:flex;
            justify-content: space-between;
        }
        ul{
            display:flex;
            list-style: none;
            margin: 0;
        }
        li{
            padding: 10px;
        }
        a{
            text-decoration: none;
             color: blue;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li class=""><a class="" href="index.php?page_layout=thongke">Thống kê</a></li>
                <li class=""><a class="" href="index.php?page_layout=qldanhmuc">Quản lý danh mục</a></li>
                <li class=""><a class="" href="index.php?page_layout=qlspham">Quản lý sản phẩm</a></li>
                <li class=""><a class="" href="index.php?page_layout=qltintuc">Quản lý khuyến mãi</a></li>
                <li class=""><a class="" href="index.php?page_layout=donhang">Quản lý đơn hàng</a></li>
                <li class=""><a class="" href="index.php?page_layout=nguoidung">Quản lý người dùng</a></li>
                    <li class=""><a class="" href="index.php?page_layout=dangxuat">Đăng xuất</a></li>
                </ul>
        </nav>
        <?php
        if(isset($_GET['page_layout'])){
            switch($_GET['page_layout']){
                case 'thongke':
                include "thongke.php";
                break;
                case 'qldanhmuc':
                include "danhmuc.php";
                break;
                case 'themdanhmuc':
                include "themdanhmuc.php";
                break;
                 case 'suadanhmuc':
                include "suadanhmuc.php";
                break;
                 case 'xoadanhmuc':
                include "xoadanhmuc.php";
                break;
                case 'qlspham':
                include "sanpham.php";
                break;
                case 'themsanpham':
                include "themsanpham.php";
                break;
                 case 'suasanpham':
                include "suasanpham.php";
                break;
                 case 'xoasanpham':
                include "xoasanpham.php";
                break;
                case 'qltintuc':
                include "tintuc.php"; 
                break;
                case 'themtintuc':
                include "themtintuc.php"; 
                break;
                case 'suatintuc':
                include "suatintuc.php"; 
                break;
                case 'xoatintuc':
                include "xoatintuc.php"; 
                break;
                case 'donhang':
                include "donhang.php";
                break;
                case 'chitietdonhang':
                include('chitietdonhang.php');
                break;
                case 'suadonhang':
                include('suadonhang.php');
                break;
                case 'nguoidung':
                include "nguoidung.php";
                break;
                 case 'themnguoidung':
                include "themnguoidung.php";
                break;
                 case 'suanguoidung':
                include "suanguoidung.php";
                break;
                 case 'xoanguoidung':
                include "xoanguoidung.php";
                break;
                case 'dangxuat':
                session_unset();      // Xóa biến session
                session_destroy();    // Hủy session
                header("Location: ../index.php"); // quay về trang chủ user
                exit();

            }
        }else{
            include "thongke.php";
        }
        ?>
        </header>

</body>
</html>
