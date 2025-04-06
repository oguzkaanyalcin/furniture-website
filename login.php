<?php
include("Function/Login.php");
session_start();

if (isset($session->user_id) && $_GET['alert'] != 5) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en/tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= site_adi . " - " . giris_yap ?></title>
    <link rel="icon" href="#">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>
    <?php include("static/ust_menu.php"); ?>
    <div class="login" id="loginForm">
        <h2><?= giris_yap ?></h2>
        <br><br>
        <form method="POST">
            <div class="input">
                <label for="email"><?= emailOrKadi ?></label>
                <input type="text" id="email" name="username_or_email" required>
                <br><br>
                <label for="password"><?= sifre ?> </label>
                <input type="password" id="password" name="password" required>
                <br><br>
            </div>

            <?php
            $login->login($conn);
            if (isset($_GET['alert'])) {
            ?>
                <div class="alert <?php echo $login->error($_GET['alert']);
                                    echo $status; ?>"><?php echo $write; ?></div>
            <?php }

            if ($_GET['alert'] == 5) {
                echo '<script>
                setTimeout(function(){   
                    window.location.assign ("index.php");
                    }, 2000);
                    </script>';
            }

            ?>
            <br>
            <div class="button-container">
                <button id="cwLoginBtn" type="submit" name="login"><?= giris_yap ?></button>
                <button type="button" onclick="geriDon()"><?= kayit_ol ?></button>
            </div>
        </form>
    </div>

    <?php include("static/footer_.php"); ?>
</body>
<script>
    function geriDon() {
        window.location.href = "register.php";
    }
</script>

</html>