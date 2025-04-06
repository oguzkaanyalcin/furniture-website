<?php
include("Database/Database.php");
include("Function/Product.php");

try {
    $order = isset($_GET['order']) && $_GET['order'] == 'desc' ? 'DESC' : 'ASC';


    $sql = "SELECT * FROM mobilyalar WHERE kategori_id = '".$_GET['kategori']."' ORDER BY fiyat $order";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $mobilyalar = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($mobilyalar as &$mobilya) {
        $mobilya['fiyatlar'] = number_format($mobilya["fiyat"],2,',','.');
        $mobilya['onceki_fiyatlar'] = number_format($mobilya["onceki_fiyat"],2,',','.');
        if ($mobilya['indirim'] > 0)
        $mobilya['indirim_orani'] = $product->indirim($mobilya['fiyat'], $mobilya['onceki_fiyat']);
    }

    echo json_encode($mobilyalar);

} catch (PDOException $e) {
    echo "Hata: " . $e->getMessage();
}

$conn = null;
?>
