<?php
class Product
{
    function findProduct($getir)
    {
        global $conn;
        $sorgu = $conn->prepare("SELECT * FROM mobilyalar WHERE kategori_id = :getir");
        $sorgu->bindParam(':getir', $getir);
        $sorgu->execute();
        $result = $sorgu->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) == 0 && $getir) {
            echo '<div class="card-ul"><center>Hiç ürün bulunamadı.</center></div>';
        }

        $conn = null;
    }


    function oneCikanUrunler()
    {
        global $conn;
        $sorgu = $conn->prepare("SELECT * FROM mobilyalar WHERE one_cikan > 0");
        $sorgu->execute();
        $result = $sorgu->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $urunler) {
            echo '<div class="card"><a href="urun_bakis.php?urun='.$urunler["id"].'"><div class="recommended-item-photo">';

            if ($urunler['yeni'] > 0) {
                echo '<div class="persona-badge-discount"><span class="persona-badge-discount-text"><span><b>'.yeni.'</b></span></span></div>';
            } else if ($urunler['indirim'] > 0) {
                echo '<div class="persona-badge-discount"><span class="persona-badge-discount-text"><span><b>%' . $this->indirim($urunler["fiyat"], $urunler["onceki_fiyat"]) . '</b> '.indirim.'</span></span></div>';
            }

            echo '<img src="' . $urunler["mobilya_resim"] . '" alt="' . $urunler["mobilya_adi"] . '" style="width:400px; top: 0.1px; position: absolute;"></div>
            <h1>' . $urunler["mobilya_adi"] . '</h1>
            <p class="price">' . number_format($urunler["fiyat"],2,',','.') . '₺ ';

            if ($urunler["indirim"] > 0) {
                echo '<span class="crossed-out">' . number_format($urunler["onceki_fiyat"],2,',','.') . '₺</span>';
            }

            echo '</p></a><p><button id="sepetAdd">'.sepet_ekle.'</button></p></div>';
        }
    }

    function indirim($fiyat, $onceki_fiyat)
    {
        if ($onceki_fiyat <= 0) return 0;
        $indirimMik = $onceki_fiyat - $fiyat;
        $indirimYuz = intval(($indirimMik / $onceki_fiyat) * 100);
        return $indirimYuz;
    }

    function lookProduct($urunID)
    {
        global $conn;
        $data = $conn->prepare("SELECT * FROM mobilyalar WHERE id = :urun_id");
        $data->bindParam(':urun_id', $urunID);
        $data->execute();
        $result = $data->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
  
}   

$product = new Product();
