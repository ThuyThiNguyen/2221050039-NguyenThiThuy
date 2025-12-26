<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Dịch vụ tiệc | Gà rán Otoké</title>

<style>
body{
    margin:0;
    font-family: Arial, sans-serif;
}

/* ========= PHẦN 1 - HỒNG ========= */
.section-pink{
    background:#fde2e2;
    padding:60px 0;
}

.pink-content{
    max-width:1200px;
    margin:auto;
    display:flex;
    align-items:center;
    gap:40px;
    padding:0 20px;
}

.pink-text{
    width:55%;
    font-size:18px;
    line-height:1.7;
}

.pink-text strong{
    color:#e53935;
}

.pink-img{
    width:45%;
    text-align:center;
}

.pink-img img{
    max-width:100%;
}
.section-yellow{
    background:#ffcc33;
    padding:40px 0;
}

.vang-wrapper{
    width:70%;
    margin:auto;
    overflow:hidden;
    background:#fff;
    border-radius:25px;
    padding:20px 10px;
}

.vang-track{
    display:flex;
    transition:0.5s;
}

/* MỖI SLIDE */
.vang-slide{
    min-width:100%;
    display:flex;
}

/* 3 ẢNH / SLIDE */
.vang-item{
    width:33.333%;
    padding:0 10px;
}

.vang-item img{
    width:100%;
    border-radius:15px;
}

.vang-btn{ 
    text-align:center; 
    margin-top:15px; }
.vang-btn button{
    width:40px;
    height:40px;
    border-radius:50%;
    border:none;
    background:#c61f33;
    color:#fff;
    font-size:20px;
    margin:0 8px;
    cursor:pointer;
}


/* ========= PHẦN 3 - ĐỎ ========= */
.section-red{
    background:#e53935;
    color:white;
    text-align:center;
    padding:60px 20px;
}

.section-red h2{
    font-size:30px;
    margin-bottom:20px;
}

.section-red p{
    font-size:18px;
}

.hotline{
    font-size:28px;
    font-weight:bold;
    margin-top:15px;
}
</style>
</head>

<body>

<!-- ===== PHẦN 1: HỒNG ===== -->
<section class="section-pink">
    <div class="pink-content">
        <div class="pink-text">
            <p>
                Cùng Gà rán Otoké mang đến một bữa tiệc sinh nhật thật đáng nhớ
                và nhiều kỷ niệm dành cho các bé yêu.
            </p>

            <p>
                Mời bố mẹ khám phá những ưu đãi bên dưới và nhấc máy liên hệ
                Gà rán Otoké qua Hotline
                <strong>091 920 4848</strong>
                để chọn cửa hàng, gói trang trí tiệc và phần ăn phù hợp cho các bé.
            </p>

            <p>Mọi thứ hãy để Otoké lo!</p>
        </div>

        <div class="pink-img">
            <img src="/2221050039/image/anhlogohappy.png">
        </div>
    </div>
</section>

<section class="section-yellow">
    <div class="vang-wrapper">
        <div class="vang-track" id="vangTrack">
            <div class="vang-slide">
                <div class="vang-item"><img src="/2221050039/image/49k.png"></div>
                <div class="vang-item"><img src="/2221050039/image/49_1.png"></div>
                <div class="vang-item"><img src="/2221050039/image/99k.png"></div>
            </div>
            <div class="vang-slide">
                <div class="vang-item"><img src="/2221050039/image/79k.png"></div>
                <div class="vang-item"><img src="/2221050039/image/79_1.png"></div>
                <div class="vang-item"><img src="/2221050039/image/94k.png"></div>
            </div>
            <div class="vang-slide">
                <div class="vang-item"><img src="/2221050039/image/ảnh1.png"></div>
                <div class="vang-item"><img src="/2221050039/image/ảnh2.png"></div>
                <div class="vang-item"><img src="/2221050039/image/ảnh3.png"></div>
            </div>
            <div class="vang-slide">
                <div class="vang-item"><img src="/2221050039/image/ảnh4.png"></div>
                <div class="vang-item"><img src="/2221050039/image/ảnh5.png"></div>
                <div class="vang-item"><img src="/2221050039/image/ảnh7.png"></div>
            </div>

        </div>
    </div>

    <div class="vang-btn">
        <button onclick="prev()">‹</button>
        <button onclick="next()">›</button>
    </div>
</section>

<!-- ===== PHẦN 3: ĐỎ ===== -->
<section class="section-red">
    <h2>ĐẶT TIỆC NGAY</h2>
    <p>Liên hệ để được tư vấn nhanh chóng</p>
    <div class="hotline">📞 091 920 4848</div>
</section>
<script>
let index = 0;
const track = document.getElementById("vangTrack");
const total = document.querySelectorAll(".vang-slide").length;

function next(){
    index++;
    if(index >= total) index = 0;
    track.style.transform = `translateX(-${index * 100}%)`;
}

function prev(){
    index--;
    if(index < 0) index = total - 1;
    track.style.transform = `translateX(-${index * 100}%)`;
}
</script>


</body>
</html>
