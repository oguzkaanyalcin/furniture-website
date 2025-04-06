<?php
include("../Database/Database.php");
include("../../Admin_func/admin.php");

try {
    if (isset($_GET['category_id']) && isset($_GET['categoryName'])) {
        global $conn;
        $admin->category_update($_GET['category_id'], $_GET['categoryName']);
    }
} catch (PDOException $e) {
    echo "Hata: " . $e->getMessage();
}

$conn = null;
