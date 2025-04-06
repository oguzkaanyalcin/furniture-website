<?php
include("../Function/Session.php");

header('Cache-control: private');

if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
    $_COOKIE['lang'] = $lang;
    setcookie("lang", $lang, time() + (3600 * 24 * 30));
} else if (isset($_COOKIE['lang'])) {
    $lang = $_COOKIE['lang'];
} else if (isset($_COOKIE['lang'])) {
    $lang = $_COOKIE['lang'];
} else {
    $lang = 'tr';
}

switch ($lang) {
    case 'tr':
        $dil_dosya = 'tr.php';
        break;
    case 'en':
        $dil_dosya = 'en.php';
        break;
    default:
        $dil_dosya = 'tr.php';
}

include_once '../Lang/' . $dil_dosya;

$servername = 'localhost';
$database = 'mobilya_tic';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
}
