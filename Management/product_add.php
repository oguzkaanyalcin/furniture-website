<?php
include("static/left_menu.php");
?>

<div class="container">
    <h1>Ürün Ekle</h1>
    <form id="main-form" method="POST">
        <table>
            <tr>
                <th><label for="product-name">Ürün Adı:</label></th>
                <td><input type="text" id="product-name" name="product-name" required></td>
            </tr>
            <tr>
                <th><label for="product-aciklama">Ürün Açıklaması:</label></th>
                <td><input type="text" id="product-aciklama" name="product-aciklama"></td>
            </tr>
            <tr>
                <th><label for="product-img">Ürün Resmi:</label></th>
                <td><input type="text" id="product-img" name="product-img" required></td>
            </tr>
            <tr>
                <th><label for="product-fiyat">Ürün Fiyatı (güncel fiyat):</label></th>
                <td><input type="text" id="product-fiyat" name="product-fiyat" required></td>
            </tr>
            <tr>
                <th><label for="product-onceki_fiyat">Üründe indirim olacaksa eski fiyat:</label></th>
                <td><input type="number" id="product-onceki_fiyat" name="product-onceki_fiyat" value="0" required></td>
            </tr>
            <tr>
                <th><label for="product-yeni">Ürün yeni mi?:</label></th>
                <td>
                    <select name="product-yeni">
                        <option value="0">Yeni değil</option>
                        <option value="1">Yeni</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="one-cikan">Ürün öne çıksın mı?</label></th>
                <td>
                    <select name="one-cikan">
                        <option value="0">Öne çıkmasın</option>
                        <option value="1">Öne çıksın</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="indirim">Üründe indirim olacak mı?:</label></th>
                <td>
                    <select name="indirim">
                        <option value="0">İndirim yok</option>
                        <option value="1">İndirim var</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="categoryId">Ürün kategorisi:</label></th>
                <td>
                    <select name="categoryId">
                        <?php
                        $sorgu = $conn->prepare("SELECT * FROM kategoriler");
                        $sorgu->execute();
                        $result = $sorgu->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($result as $row) : ?>
                            <option value="<?= $row["kategori_id"] ?>"><?= $row["kategori_name"] ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
        </table>
        <button type="submit">Ekle</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $redirect = false;
        $product_name = $_POST["product-name"];
        $product_aciklama = $_POST["product-aciklama"];
        $product_img = $_POST["product-img"];
        $product_fiyat = $_POST["product-fiyat"];
        $product_onceki_fiyat = $_POST["product-onceki_fiyat"];
        $product_yeni = $_POST["product-yeni"];
        $product_one_cikan = $_POST["one-cikan"];
        $product_indirim = $_POST["indirim"];
        $categoryId = $_POST["categoryId"];

        if (isset($_POST["product-name"])) {
            if (strpos($product_name, ' ') === 0) {
                echo "Ürün adı boşlukla başlayamaz!";
            } else {
                $admin->product_add($product_name, $product_aciklama, $product_img, $product_fiyat, $product_onceki_fiyat, $product_indirim, $categoryId, $product_one_cikan, $product_yeni);
                header("product_add.php");
                $redirect = true;
                echo $product_name . " başarıyla eklendi.";
            }
        }
    }

    if ($redirect)
    {
        echo '<script>
        setTimeout(function(){   
            window.location.assign ("product_add.php");
            }, 2000);
            </script>';
    }
    ?>
</div>
</body>
<?php include("static/footer_.php"); ?>
</html>
</div>
</body>

</html>