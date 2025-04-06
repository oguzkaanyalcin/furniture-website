<?php
include("Function/Register.php");

if (isset($session->user_id)) {
    header("location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en/tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=site_adi. " - ". kayit_ol?></title>
    <link rel="icon" href="#">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>
<?php include("static/ust_menu.php"); ?>
    <div class="register">
        <h2><?=kayit_ol?></h2>
        <br><br>
        <form method="POST">
            <div class="input">
                <label for="username"><?=kullanici_adi?> </label>
                <input type="text" id="username" name="username" required>
                <br><br>
                <label for="password"><?=sifre?> </label>
                <input type="password" id="password" name="password" required>
                <br><br>
                <label for="password2"><?=sifre_tekrar?> </label>
                <input type="password" id="password2" name="password2" required>
                <br><br>
                <label for="email"><?=email?> </label>
                <input type="email" id="email" name="email" required>
                <?php $register->register($conn); 
                if (isset($_GET['alert'])) { 
                    ?>
                    <div class="alert <?php echo $register->error($_GET['alert']); echo $status; ?>"><?php echo $write; ?></div>
                    <?php }
                    
                    if ($_GET['alert'] == 4) {
                        echo '<script>
                setTimeout(function(){   
                    window.location.assign ("login.php");
                    }, 3000);
                    </script>';
                    }
                    ?>
               
             </div>
             <br>
             <div class="button-container">
             <button class="registeryBtn" type="submit" name="register"><?=kayit_ol?></button>
             <button type="button" onclick="geriDon()"><?=geri_don?></button>
            </div>
        </form>
        
    </div>

    <?php include("static/footer_.php"); ?>
</body>
<script>
    function geriDon() {
        window.location.href = "login.php";
    }
</script>
</html>

