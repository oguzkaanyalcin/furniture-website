<?php
class Category 
{

function sepet($id, $sepetTutar)
{
    global $conn;
    $sorgu = $conn->prepare("SELECT fiyat FROM mobilyalar WHERE id =$id");
    $sorgu->execute();

    $fiyat = $sorgu->fetchAll(PDO::FETCH_ASSOC);
    $sepetTutar += $fiyat['fiyat'];
    
    return $sepetTutar;
}

function kategori() 
{
    global $conn;
    $sorgu = $conn->prepare('SELECT kategori_name FROM kategoriler WHERE kategori_id > 0');
    $sorgu->execute();
    
    $result = $sorgu->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $row) {
        echo $row['kategori_name'] . "<br>";
    }
}

function findCategory() 
{
    global $conn;
    $sorgu = $conn->prepare("SELECT * FROM kategoriler WHERE kategori_id > 0");
    $sorgu->execute();
    $result = $sorgu->fetchAll(PDO::FETCH_ASSOC);

    foreach($result as $row) 
    {
        ?>
        <div class="container">
                    <div class="overlay">
                        <h2><?=$row['kategori_name']?></h2>
                        <p><?=$row['kategori_aciklama']?></p>
                        <a href="urunler.php?kategori=<?=$row['kategori_id']?>">Ürünleri Görüntüle</a>
                    </div>
                    <img src="<?=$row['kategori_resim']?>" alt="<?=$row['kategori_name']?>">
                </div>
                <?php
    }
    $sorgu = null;
}

function categoryName($category)
{
    global $conn;
    $sorgu = $conn->prepare("SELECT * FROM kategoriler WHERE kategori_id = :category");
    $sorgu->bindParam(':category', $category);
    $sorgu->execute();
    $result = $sorgu->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($result))
    {
        return $result[0]['kategori_name'];
    }
    else
    {    
        return 'Ürünler';     
    }
}


}

$category = new Category();
?>