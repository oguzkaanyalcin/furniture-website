<?php
include("../Database/Database.php");
include("../../Admin_func/admin.php");

try {
    global $conn;
    $data = json_decode(file_get_contents('php://input'), true);

    $id = $data['id'];
    $urun_adi = $data['mobilya_adi'];
    $urun_aciklamasi = $data['mobilya_aciklama'];
    $urun_resim = $data['mobilya_resim'];
    $urun_guncel_fiyati = $data['fiyat'];
    $urun_onceki_fiyati = $data['onceki_fiyat'];
    $urun_indirim = $data['indirim'];
    $urun_kategori = $data['kategori_id'];
    $urun_one_cikis = $data['one_cikan'];
    $urun_yeniligi = $data['yeni'];

    $sql = "UPDATE mobilyalar SET 
            mobilya_adi='$urun_adi', 
            mobilya_aciklama='$urun_aciklamasi',
            fiyat='$urun_guncel_fiyati', 
            onceki_fiyat='$urun_onceki_fiyati', 
            indirim='$urun_indirim', 
            kategori_id='$urun_kategori', 
            one_cikan='$urun_one_cikis', 
            yeni='$urun_yeniligi' 
        WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Ürün başarıyla güncellendi!"]);
    }
} catch (Exception $e) {
    echo json_encode(["error" => "Hata: " . $e->getMessage()]);
}

$conn = null;
