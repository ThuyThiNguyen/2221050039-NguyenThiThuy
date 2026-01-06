<?php
session_start();
// Kiểm tra đăng nhập (giữ nguyên logic của bạn)
if (!isset($_SESSION['quyen']) || $_SESSION['quyen'] != 2) {
    header("Location: login.php");
    exit();
}

// Lấy trang hiện tại để active menu
$page = isset($_GET['page_layout']) ? $_GET['page_layout'] : 'thongke';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Quản Trị - Admin</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --main-color: #3b82f6; /* Xanh dương cơ bản */
            --dark-bg: #2d3748;     /* Màu menu tối */
            --light-bg: #f7fafc;    /* Nền web sáng */
            --text-color: #2d3748;
            --white: #ffffff;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--light-bg);
            color: var(--text-color);
            display: flex;
            min-height: 100vh;
        }

        /* --- SIDEBAR (Menu trái) --- */
        .sidebar {
            width: 250px;
            background-color: var(--dark-bg);
            color: var(--white);
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100%;
            z-index: 100;
        }

        .logo {
            padding: 20px;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            background: #1a202c;
        }

        .menu {
            list-style: none;
            padding: 15px 10px;
            flex-grow: 1;
        }

        .menu li { margin-bottom: 5px; }

        .menu a {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: #cbd5e0;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
            transition: 0.3s;
        }

        .menu a i { width: 25px; text-align: center; margin-right: 10px; }

        .menu a:hover, .menu a.active {
            background-color: var(--main-color);
            color: white;
        }

        .logout {
            padding: 15px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        .logout a {
            color: #fc8181; /* Màu đỏ nhạt */
            text-decoration: none;
            display: flex;
            align-items: center;
            font-size: 14px;
        }

        /* --- MAIN CONTENT (Nội dung phải) --- */
        .main-content {
            flex: 1;
            margin-left: 250px;
            display: flex;
            flex-direction: column;
        }

        /* Header trên cùng */
        .top-nav {
            height: 60px;
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
        }

        .user-info {
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .avatar {
            width: 35px; height: 35px;
            background: #e2e8f0;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #4a5568;
        }

        /* Khu vực hiển thị nội dung các trang con */
        .content-body {
            padding: 30px;
        }

        /* Nút bấm chung */
        .btn {
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            font-size: 13px;
            display: inline-block;
        }
        .btn-blue { background: #3182ce; }
        .btn-red { background: #e53e3e; }

    </style>
</head>
<body>

    <nav class="sidebar">
        <div class="logo">
            <i class="fas fa-laptop-code"></i> ADMIN
        </div>
        <ul class="menu">
            <li><a href="index.php?page_layout=thongke" class="<?= ($page=='thongke')?'active':'' ?>"><i class="fas fa-chart-bar"></i> Thống kê</a></li>
            <li><a href="index.php?page_layout=qldanhmuc" class="<?= ($page=='qldanhmuc')?'active':'' ?>"><i class="fas fa-list"></i> Danh mục</a></li>
            <li><a href="index.php?page_layout=qlspham" class="<?= ($page=='qlspham')?'active':'' ?>"><i class="fas fa-box"></i> Sản phẩm</a></li>
            <li><a href="index.php?page_layout=qltintuc" class="<?= ($page=='qltintuc')?'active':'' ?>"><i class="fas fa-newspaper"></i> Tin tức / KM</a></li>
            <li><a href="index.php?page_layout=donhang" class="<?= ($page=='donhang')?'active':'' ?>"><i class="fas fa-shopping-cart"></i> Đơn hàng</a></li>
            <li><a href="index.php?page_layout=nguoidung" class="<?= ($page=='nguoidung')?'active':'' ?>"><i class="fas fa-users"></i> Người dùng</a></li>
        </ul>
        <div class="logout">
            <a href="index.php?page_layout=dangxuat"><i class="fas fa-sign-out-alt" style="margin-right: 10px;"></i> Đăng xuất</a>
        </div>
    </nav>

    <main class="main-content">
        <header class="top-nav">
            <div style="font-size: 18px; font-weight: bold;">Hệ thống quản lý bán hàng</div>
            <div class="user-info">
                <span>Xin chào, Admin</span>
                <div class="avatar"><i class="fas fa-user"></i></div>
            </div>
        </header>

        <div class="content-body">
            <?php
            // Logic chuyển trang
            if(isset($_GET['page_layout'])){
                switch($_GET['page_layout']){
                    case 'thongke': include "thongke.php"; break;
                    
                    case 'qldanhmuc': include "danhmuc.php"; break;
                    case 'themdanhmuc': include "themdanhmuc.php"; break;
                    case 'suadanhmuc': include "suadanhmuc.php"; break;
                    case 'xoadanhmuc': include "xoadanhmuc.php"; break;

                    case 'qlspham': include "sanpham.php"; break;
                    case 'themsanpham': include "themsanpham.php"; break;
                    case 'suasanpham': include "suasanpham.php"; break;
                    case 'xoasanpham': include "xoasanpham.php"; break;

                    case 'qltintuc': include "tintuc.php"; break;
                    case 'themtintuc': include "themtintuc.php"; break;
                    case 'suatintuc': include "suatintuc.php"; break;
                    case 'xoatintuc': include "xoatintuc.php"; break;

                    case 'donhang': include "donhang.php"; break;
                    case 'chitietdonhang': include('chitietdonhang.php'); break;
                    case 'suadonhang': include('suadonhang.php'); break;

                    case 'nguoidung': include "nguoidung.php"; break;
                    case 'themnguoidung': include "themnguoidung.php"; break;
                    case 'suanguoidung': include "suanguoidung.php"; break;
                    case 'xoanguoidung': include "xoanguoidung.php"; break;
                   case 'dangxuat':
                    session_unset();
                    session_destroy();
                     echo "<script>window.location.href='../index.php';</script>";
                     exit();
                }
            } else {
                include "thongke.php";
            }
            ?>
        </div>
    </main>
</body>
</html>