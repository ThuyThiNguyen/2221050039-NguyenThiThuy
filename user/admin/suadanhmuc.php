<?php
include("connect.php"); 
            if(!empty($_POST["ten-danh-muc"])){
                    $tenDanhMuc = $_POST["ten-danh-muc"];
                    $id = $_GET['id'];
                    $sql = "UPDATE `danh_muc` SET `ten_danh_muc`='$tenDanhMuc' WHERE id = '$id'";
                    mysqli_query($conn,$sql);
                    mysqli_close($conn);
                    header('location: index.php?page_layout=qldanhmuc');
                }else{
                    echo '<p class="warning">Vui lòng nhập đầy đủ thông tin</p>';
                }
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sứa</title>
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
            width:80%;
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
    </style>
</head>
<body>
    <?php
        $id = $_GET['id'];
        $sql = "SELECT * FROM danh_muc WHERE id = '$id'";
        $result = mysqli_query($conn,$sql);
        $danhMuc = mysqli_fetch_assoc($result);
    ?>
    <div class ="container">
    <form action="index.php?page_layout=suadanhmuc&id=<?php echo $id ?>" method="post">   
        <h1>Sửa danh mục</h1>
        <div>
            <p>Tên danh mục</p>
            <input type="text" name="ten-danh-muc" placeholder="Tên danh mục" value="<?php echo $danhMuc['ten_danh_muc']?>">
</div>
        <div><input type="submit" value="Cập nhật"></div>

    </form>
    </div>
    
</body>
</html>