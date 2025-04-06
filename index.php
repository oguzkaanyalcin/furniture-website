<?php
include("Database/Database.php");
include("Function/Product.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <title><?= site_adi ?></title>
</head>

<body>
    <?php include("static/ust_menu.php"); ?>
    <div class="slider">
        <div class="list">
            <div class="item">
                <img src="https://www.normod.com/cdn/shop/files/08_-_Website_-_Klem_Slim_240_x_171_Uzanmali_kose_fitilli_kadife_kemik_silindir_ahsap_ayak_mese-Styling_2400x.jpg?v=1708012958" alt="">
            </div>
            <div class="item">
                <img src="https://www.normod.com/cdn/shop/files/1_1__1_1400x.jpg?v=1667315322" alt="">
            </div>
            <div class="item">
                <img src="https://www.normod.com/cdn/shop/files/1_8879c6a7-122f-4eb7-aadb-0ea7ab9bfa08_1_1.webp?v=1701698089" alt="">
            </div>
            <div class="item">
                <img src="https://www.normod.com/cdn/shop/files/2-feff7dd2-f003-4092-abd4-9e15f0fc30ac.webp?v=1701698330" alt="">
            </div>
            <div class="item">
                <img src="https://akn-enza.a-cdn.akinoncloud.com/cms/2024/03/08/f6e5964f-b61b-4ca5-ad4b-2e9f59187891.jpg" alt="">
            </div>
        </div>
        <div class="buttons">
            <button id="prev"><i class="fa-solid fa-arrow-left"></i></button>
            <button id="next"><i class="fa-solid fa-arrow-right"></i></button>
        </div>
        <ul class="dots">
            <li class="active"></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
    </div>

    <div class="bannerContainer">
        <div class="mobilya-title"><?=one_cikan?></div>
        <div class="card-container">
            <?php
            $product->oneCikanUrunler();
            ?>
        </div>

    </div>

    <!-- <section class="hero">
        <?php
        //$category->findCategory();
        ?>
    </section> -->

    <?php include("static/footer_.php"); ?>

    <script src="./js/main.js"></script>
    <script>
        let items = document.querySelectorAll('.slider .list .item');
        let next = document.getElementById('next');
        let prev = document.getElementById('prev');
        let thumbnails = document.querySelectorAll('.thumbnail .item');

        let countItem = items.length;
        let itemActive = 0;
        next.onclick = function() {
            itemActive = itemActive + 1;
            if (itemActive >= countItem) {
                itemActive = 0;
            }
            showSlider();
        }
        prev.onclick = function() {
            itemActive = itemActive - 1;
            if (itemActive < 0) {
                itemActive = countItem - 1;
            }
            showSlider();
        }

        let refreshInterval = setInterval(() => {
            next.click();
        }, 5000)

        function showSlider() {
            let itemActiveOld = document.querySelector('.slider .list .item.active');
            let thumbnailActiveOld = document.querySelector('.thumbnail .item.active');
            itemActiveOld.classList.remove('active');
            thumbnailActiveOld.classList.remove('active');

            items[itemActive].classList.add('active');
            thumbnails[itemActive].classList.add('active');

            clearInterval(refreshInterval);
            refreshInterval = setInterval(() => {
                next.click();
            }, 5000)
        }

        thumbnails.forEach((thumbnail, index) => {
            thumbnail.addEventListener('click', () => {
                itemActive = index;
                showSlider();
            })
        })
    </script>
</body>

</html>