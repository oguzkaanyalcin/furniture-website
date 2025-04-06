<?php
include("Database/Database.php");
ob_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

$response = [];

try {
    if (isset($_FILES['file']['name']) && isset($_POST['product_id'])) {
        $filename = time() . '_' . basename($_FILES['file']['name']);
        $location = '../uploads/' . $filename;

        if (move_uploaded_file($_FILES['file']['tmp_name'], $location)) {
            $product_id = intval($_POST['product_id']);
            $response['filePath'] = $location;
            global $conn;

            $sorgu = $conn->prepare("UPDATE mobilyalar SET mobilya_resim = '" . $location . "' WHERE id = $product_id");
            $sorgu->execute();
        } else {
            throw new Exception('Resim yüklenirken bir hata oluştu!');
        }
    } else {
        throw new Exception('Dosya veya ürün ID bulunamadı!');
    }
} catch (Exception $e) {
    http_response_code(400);
    $response['message'] = $e->getMessage();
}

$bufferedOutput = ob_get_clean();

if ($bufferedOutput) {
    $response['bufferedOutput'] = $bufferedOutput;
    http_response_code(500);
}

echo json_encode($response);
