<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("Database/Database.php");

class register
{
    function register($conn)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            $password_repeat = trim($_POST['password2']);
            $email = trim($_POST['email']);
            $alert = null;

            if (empty($username) || empty($password) || empty($password_repeat) || empty($email)) {
                $alert = 1;
            } elseif ($password != $password_repeat) {
                $alert = 2;
            } elseif (strlen($password) < 6) {
                $alert = 6;
            } elseif (!preg_match('/[A-Z]+/', $password)) {
                $alert = 7;
            } elseif (preg_match('/[!@#$%^&*(),.?":{}|<>]+/', $username)) {
                $alert = 8;
            } elseif (strlen($username) < 4) {
                $alert = 9;
            } else {
                $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
                $stmt->execute(array(':username' => $username, ':email' => $email));
                $num_rows = $stmt->rowCount();

                if ($num_rows > 0) {
                    $alert = 3;
                } else {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (:username, :password, :email)");
                    $result = $stmt->execute(array(':username' => $username, ':password' => $hashed_password, ':email' => $email));
                    if ($result) {
                        $alert = 4;
                    } else {
                        $alert = 5;
                    }
                }
            }

            if ($alert !== null) {
                echo '<script>
                        window.location.href = "register.php?alert='.$alert.'";
                      </script>';
                exit;
            }
        }
    }

    function error($hata)
    {
        global $status;
        global $write;
        switch ($hata) {
            case 1:
                $status = 'danger-status';
                $write = yildiz;
                break;
            case 2:
                $status = 'danger-status';
                $write = farkli_sifre;
                break;
            case 3:
                $status = 'danger-status';
                $write = kayit_var;
                break;
            case 4:
                $status = 'success-status';
                $write = kayit_oldu;
                break;
            case 5:
                $status = 'danger-status';
                $write = kayit_hata;
                break;
            case 6:
                $status = 'danger-status';
                $write = gecersiz_karakter;
                break;
            case 7:
                $status = 'danger-status';
                $write = buyuk_karakter;
                break;
            case 8:
                $status = 'danger-status';
                $write = ozel_karakter;
                break;
            case 9:
                $status = 'danger-status';
                $write = user_kucuk;
            default:
                break;
        }
    }
}

$register = new Register();
