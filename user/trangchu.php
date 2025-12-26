<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Gà Rán Otoké</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>
.ds-san-pham {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 40px;
}

.san-pham-item {
    border: 1px solid #ddd;
    border-radius: 12px;
    padding: 12px;
    text-align: center;
    background: #fff;
}

.san-pham-item img {
    width: 100%;
    height: 160px;
    object-fit: cover;
    border-radius: 10px;
}

.san-pham-item h4 {
    margin: 10px 0 5px;
    font-size: 16px;
}

.gia {
    color: #e53935;
    font-weight: bold;
}

.san-pham {
    max-width: 1200px;
    margin: 0 auto;
}
</style>
</head>

<body>

<section class="slider-container">
    <div class="slider">
        <div class="slide active" style="background-image:url('/2221050039/image/banner1.png')"></div>
        <div class="slide" style="background-image:url('/2221050039/image/banner2.png')"></div>
        <div class="slide" style="background-image:url('/2221050039/image/banner3.png')"></div>
        <div class="slide" style="background-image:url('/2221050039/image/banner4.png')"></div>
    </div>
</section>

<div class="san-pham">
<?php
include("connect.php");
$sql_dm = "SELECT * FROM danh_muc WHERE ten_danh_muc IN ('OTOKÉ Combo', 'Thức ăn kèm')";
$result_dm = mysqli_query($conn, $sql_dm);

while ($dm = mysqli_fetch_assoc($result_dm)) {
    $danhMucId = $dm['id'];
    $sql_sp = "SELECT * FROM san_pham 
               WHERE id_danh_muc = $danhMucId 
               ORDER BY id DESC 
               LIMIT 8";
    $result_sp = mysqli_query($conn, $sql_sp);
    if (mysqli_num_rows($result_sp) == 0) continue;
?>
    <h2><?= $dm['ten_danh_muc'] ?></h2>

    <div class="ds-san-pham">
        <?php while ($sp = mysqli_fetch_assoc($result_sp)) { ?>
            <div class="san-pham-item">
                <a href="index.php?page_layout=chitietsanpham&id=<?= $sp['id'] ?>"
                   style="text-decoration:none; color:black;">
                    <img src="/2221050039/image/<?= $sp['hinh_anh'] ?>">
                    <h4><?= $sp['ten_san_pham'] ?></h4>
                    <p class="gia"><?= number_format($sp['gia']) ?> đ</p>
                </a>
            </div>
        <?php } ?>
    </div>
<?php } ?>
</div>
<script>
const slides = document.querySelectorAll('.slide');
let index = 0;
setInterval(() => {
    slides[index].classList.remove('active');
    index = (index + 1) % slides.length;
    slides[index].classList.add('active');
}, 3000);
</script>
</body>
</html>
