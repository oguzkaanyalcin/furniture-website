<?php
include("./Database/Database.php");


try {
    global $conn;
    $query = $_POST['query'];


    $sql = "SELECT mobilya_adi, id FROM mobilyalar WHERE mobilya_adi LIKE '%$query%'";
    $sorgu = $conn->prepare($sql);
    $sorgu->execute();
    $result = $sorgu->fetchAll(PDO::FETCH_ASSOC);

    $data = [];
    foreach ($result as $calistir) {
        $data[] = [
            'name' => $calistir['mobilya_adi'],
            'url' => 'urun_bakis.php?urun=' . $calistir['id']
        ];
    }

    echo json_encode($data);
} catch (PDOException $e) {
    echo "Veritabanı hatası: " . $e->getMessage();
}

$conn = null;
