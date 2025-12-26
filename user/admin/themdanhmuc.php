<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        p{
            font-weight: bold;
            margin:5px 0;
        }
        h1{
            margin: 5px 0;
        }
        .container{
            border: 1px solid black;
            border-radius: 10px;
            width: 35%;
            padding: 20px 0;
            display: flex;
            justify-content: center;
            margin-top : 50px;
            margin-left : 300px;
        }
        form{
            width:60%;
        }
        input{
            width:100%;
            padding: 5px 0;

        }
        .box{
            margin: 10px 0;
        }
        .select{
            width: 100%;
            padding: 5px 0;
        }
        .warning{
            color: red;
            font-weight: bold;
            margin-left : 300px;

        }
        .gui{
            display: flex;
           
        }

    </style>
</head>
<body>
    <div class="container">
    <form action="index.php?page_layout=themdanhmuc" method="post">
        <h1>Thêm danh mục</h1>
         <div>
        <p>Tên danh mục</p>
        <input type = "text" name="ten-danh-muc" placeholder="Tên danh mục">
    </div>

        <div class ="gui">
            <input type="submit" value="Lưu">
            <input type="submit" value="Back"></div>
    </form>
    </div>
    <?php
    include("connect.php");
    if(!empty($_POST["ten-danh-muc"])){
        $tenDanhMuc= $_POST["ten-danh-muc"];
         $sql = "INSERT INTO `danh_muc`(`ten_danh_muc`) VALUES ('$tenDanhMuc')";
        mysqli_query($conn, $sql);
        header('location: index.php?page_layout=qldanhmuc');
       }else{
        echo '<p class="warning">Vui lòng nhập đầy đủ thông tin</p>';
       }

    ?>
</body>
</html>