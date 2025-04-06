<?php
include("static/left_menu.php");
?>

<div class="container">
        <h1>Yönetim paneline hoş geldin, <?=$session->username;?>.</h1>
        <div class="statistics">
            <div class="statistic red">
                <h2>Kategoriler</h2>
                <p><?php echo $admin->category_num(); ?></p>
            </div>
            <div class="statistic blue">
                <h2>Ürünler</h2>
                <p><?php echo $admin->product_num(); ?></p>
            </div>
            <div class="statistic yellow">
                <h2>Üyeler</h2>
                <p><?php echo $admin->users_num(); ?></p>
            </div>
            <div class="statistic green">
                <h2>Satışlar</h2>
                <p><?php echo 0; ?></p>
            </div>
        </div>
    </div>
    </body>

    <?php include("static/footer_.php"); ?>
</html>