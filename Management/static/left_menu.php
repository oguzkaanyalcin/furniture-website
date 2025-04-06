<?php 
include("Database/Database.php");
include("../Admin_func/admin.php");
session_start();
if (!isset($session->user_id)) {
    header("Location: ../index.php");
    exit;
}

if ($session->perm !== 1) {
    echo "<script>
        alert('Erişim yasak !');
    </script>";
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en/tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/admin.css">
    <title><?= site_adi ?> - Admin Paneli</title>
</head>

<body>
    <div class="sidebar">
        <ul class="menu">
            <div class="images">
                <img src="https://static.ticimax.cloud/12397/customcss/images/logo.svg" alt="Yükleniyor" height="40px">
            </div> 

            <li><a href="index.php">Anasayfa</a></li>
            <li><a href="category_add.php">Kategori Ekle/Düzenle</a></li>
            <li><a href="product_add.php">Ürün Ekle</a></li>
            <li><a href="product_update.php">Ürün Düzenle</a></li>
            <li class="anasayfaDon"><a href="../index.php">Anasayfaya Don</a></li>
        </ul>
    </div>
   
    <div class="menu-toggle">
        <span></span>
        <span></span>
        <span></span>
    </div>

    <script>
        const menuToggle = document.querySelector('.menu-toggle');
        const sidebar = document.querySelector('.sidebar');
        menuToggle.addEventListener('click', (event) => {
            sidebar.classList.toggle('open');
            menuToggle.classList.toggle('open');
            event.stopPropagation();
        });
        document.addEventListener('click', (event) => {
            if(!sidebar.contains(event.target) && !menuToggle.contains(event.target)){
                sidebar.classList.remove('open');
                menuToggle.classList.remove('open');
            }
        });
    </script>
