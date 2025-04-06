<?php
include("Database/Database.php");
include("Function/Product.php");
include("Function/Category.php");

if (!isset($_GET['urun'])) {
    header("location:index.php");
}
$urunler = $product->lookProduct($_GET['urun']);
?>

<!DOCTYPE html>
<html lang="en">

<style>
    .urun_wrapper {
        max-width: 1400px;
        margin: 0 auto;
        margin-top: 20px;
        padding: 20px;
        display: grid;
        grid-template-columns: 1fr;
        gap: 40px;
        align-items: start;
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        border: 1px solid #000a37;
        box-sizing: border-box;
    }

    @media only screen and (min-width: 768px) {
        .urun_wrapper {
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        }
    }

    .urun_wrapper img {
        width: 100%;
        border-radius: 8px;
    }

    .urun_adi {
        font-size: 28px;
        color: #333;
        margin-bottom: 10px;
    }

    .urun_info {
        font-size: 24px;
        color: #666;
        margin-bottom: 20px;
    }

    .indirim_fiyat {
        font-size: 22px;
        color: #999999;
        margin-bottom: 10px;
        text-decoration: line-through;
    }

    .normal_fiyat {
        font-size: 22px;
        color: #000;
        margin-bottom: 20px;
    }

    button {
        padding: 10px 20px;
        background-color: transparent;
        border: 1px solid #000a37;
        color: #000a37;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #000129;
        color: #fff;
    }

    .urun_detay {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .urun_detay div {
        margin-bottom: 20px;
    }

    .urun_detay h4 {
        font-size: 30px;
        margin-bottom: 10px;
        font-weight: bold;
        font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
    }

    .urun_detay p {
        font-size: 17px;
        color: #ff0000;
    }
</style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <title><?= site_adi . " - " . $urunler['mobilya_adi'] ?></title>
</head>

<body>
    <?php
    include("static/ust_menu.php");

    /*

                        if (item.yeni > 0) {
                            mesaj = "<div class='discount-label'><?= yeni ?></div>";
                        } else if (item.indirim > 0) {
                            mesaj = `<div class="discount-label">%${item.indirim_orani} <?= indirim ?></div>`;
                        }

                        if (item.indirim > 0) {
                            oncekiFiyat = `<span class="old-price">${item.onceki_fiyatlar}TL</span>`;
                        }

    */


    ?>

    <div class="urun_wrapper">
        <img src="<?= $urunler['mobilya_resim']; ?>" alt="<?= $urunler['mobilya_adi'] ?>">
        <div class="urun_detay">
            <h4 class="urun_adi"><?= $urunler['mobilya_adi'] ?></h4>
            <div class="urun_info"><?= $urunler['mobilya_aciklama']; ?></div>
            <?php if ($urunler['indirim'] > 0) : ?>
                <p class="indirim_yüdesi">%<?= $product->indirim($urunler["fiyat"], $urunler["onceki_fiyat"]) . ' ' . indirim . ''; ?></p>
                <div class="indirim_fiyat"><?= number_format($urunler["onceki_fiyat"], 2, ',', '.') ?> TL</div>
            <?php endif; ?>
            <div class="normal_fiyat"><?= number_format($urunler["fiyat"], 2, ',', '.') ?> TL</div><br>
            <button onclick="sepetEkle()"><?= sepet_ekle ?></button>
        </div>
    </div>

    <?php include("static/footer_.php"); ?>
    <script src="./js/main.js"></script>
</body>

</html>