<?php
include("Database/Database.php");

class Login
{
    public function login($conn)
    {
        global $session;
        if (isset($_POST["login"])) {
            $usernameOrEmail = trim($_POST["username_or_email"]);
            $password = trim($_POST["password"]);
            $alert = null;

            if (empty($usernameOrEmail) || empty($password)) {
                $alert = 1;
                return;
            }

            $stmt = $conn->prepare("SELECT * FROM users WHERE username = :usernameOrEmail OR email = :usernameOrEmail LIMIT 1");
            $stmt->bindParam(':usernameOrEmail', $usernameOrEmail);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $hashed_password = $result['password'];

                if (password_verify($password, $hashed_password)) {
                    $session->user_id = $result['id'];
                    $session->username = $result['username'];
                    $session->email = $result['email'];
                    $session->perm = $result['perm'];
                    $alert = 5;
                } else {
                    $alert = 2;
                }
            } else {
                $alert = 3;
            }
        }

        if ($alert !== null) {
            echo '<script>
                    window.location.href = "login.php?alert=' . $alert . '";
                  </script>';
            exit;
        }
    }

    public function error($hata)
    {
        global $status, $write;
        switch ($hata) {
            case 1:
                $status = 'danger-status';
                $write = eksik_bilgi;
                break;
            case 2:
                $status = 'danger-status';
                $write = hatali_giris;
                break;
            case 3:
                $status = 'danger-status';
                $write = kullanici_yok;
                break;
            case 4:
                $status = 'danger-status';
                $write = sistem_hatasi;
                break;
            case 5:
                $status = 'success-status';
                $write = giris_yapti;
                break;
            default:
                break;
        }
    }
}

$login = new Login();
