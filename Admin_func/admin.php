<?php
class Admin
{
    function category_list()
    {
        global $conn;
        $sorgu = $conn->prepare("SELECT * FROM kategoriler");
        $sorgu->execute();
        $result = $sorgu->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $category) {
            echo '<tr>
                <td>
                    <div class="kategoriDuzenleme" id="kategoriDuzenleme_' . $category['kategori_id'] . '">
                        <span id="categoryName_' . $category['kategori_id'] . '">' . $category['kategori_name'] . '</span>
                        <input type="text" id="input_' . $category['kategori_id'] . '" style="display:none; border: 1px solid #000a37; padding: 10px 15px; border-radius: 7px;" placeholder="' . $category['kategori_name'] . '">
                        <button onclick="duzenleFunc(' . $category['kategori_id'] . ')" style="float:right;">Düzenle</button>
                        <button onclick="kaydetFunc(' . $category['kategori_id'] . ')" style="float:right; display:none;">Kaydet</button>
                    </div>
                </td>
                <td>
                    <a href="?delete_id=' . $category["kategori_id"] . '"><button>Sil</button></a>
                </td>
            </tr>';
        }
    }
    function get_categories()
    {
        global $conn;
        $sorgu = $conn->prepare("SELECT * FROM kategoriler");
        $sorgu->execute();
        return $sorgu->fetchAll(PDO::FETCH_ASSOC);
    }

    public function product_list()
    {
        global $conn;
        $categories = $this->get_categories();
        $sorgu = $conn->prepare("SELECT * FROM mobilyalar ORDER BY id DESC");
        $sorgu->execute();
        $result = $sorgu->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $products) {

            echo "<tr data-id='{$products['id']}'>
        <td contenteditable='true'>{$products['mobilya_adi']}</td>
        <td contenteditable='true'>{$products['mobilya_aciklama']}</td>
        <td>
                <img src='{$products['mobilya_resim']}' style='height:100px;'>
                <div class='drop-zone' data-id='{$products['id']}' onclick='openFileUploader()'>
                <br>Ürün resmi değiştir
                <input type='file' id='fileInput' accept='image/*'>
            </div>

        </td>
        <td contenteditable='true'>{$products['fiyat']}</td>
        <td contenteditable='true'>{$products['onceki_fiyat']}</td>
        <td>
            <select>
                <option value='1' " . ($products['indirim'] == '1' ? 'selected' : '') . ">Evet</option>
                <option value='0' " . ($products['indirim'] == '0' ? 'selected' : '') . ">Hayır</option>
            </select>
        </td>
        <td>
            <select>";
            foreach ($categories as $category) {
                echo "<option value='{$category['kategori_id']}' " . ($products['kategori_id'] == $category['kategori_id'] ? 'selected' : '') . ">{$category['kategori_name']}</option>";
            }
            echo "</select>
        </td>
        <td>
        <select>
        <option value='1' " . ($products['one_cikan'] == '1' ? 'selected' : '') . ">Evet</option>
        <option value='0' " . ($products['one_cikan'] == '0' ? 'selected' : '') . ">Hayır</option>
    </select>
        </td>
        <td>
        <select>
                <option value='1' " . ($products['yeni'] == '1' ? 'selected' : '') . ">Evet</option>
                <option value='0' " . ($products['yeni'] == '0' ? 'selected' : '') . ">Hayır</option>
        </select>
        </td>
        <td> 
            <button class='kaydetButonu'>Kaydet</button>
            <br><br><a href='?delete_id=" . $products['id'] . "'><button>Sil</button></a>
        </td>
      </tr>";
        }
    }

    function getCategory($category_id)
    {
        global $conn;
        $sorgu = $conn->prepare("SELECT * FROM kategoriler WHERE kategori_id = $category_id");
        $sorgu->execute();
        $result = $sorgu->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $row) {
            $category = $row['kategori_name'];
        }

        return $category;
    }

    function category_num()
    {
        global $conn;
        $sorgu = $conn->prepare("SELECT * FROM kategoriler");
        $sorgu->execute();
        $result = $sorgu->fetchAll(PDO::FETCH_ASSOC);

        return count($result);
    }

    function product_num()
    {
        global $conn;
        $sorgu = $conn->prepare("SELECT * FROM mobilyalar");
        $sorgu->execute();
        $result = $sorgu->fetchAll(PDO::FETCH_ASSOC);

        return count($result);
    }

    function users_num()
    {
        global $conn;
        $sorgu = $conn->prepare("SELECT * FROM users");
        $sorgu->execute();
        $result = $sorgu->fetchAll(PDO::FETCH_ASSOC);

        return count($result);
    }

    function category_add($category_name)
    {
        global $conn;
        $sorgu = $conn->prepare("INSERT INTO kategoriler(kategori_name) VALUES ('" . ucwords($category_name) . "')");
        $result = $sorgu->execute();
        return $result;
    }

    function category_delete($category_id)
    {
        global $conn;
        $sorgu = $conn->prepare("DELETE FROM kategoriler WHERE kategori_id = $category_id");
        $result = $sorgu->execute();
        return $result;
    }

    function category_update($categoryID, $categoryName)
    {
        global $conn;
        $sorgu = $conn->prepare("UPDATE kategoriler SET `kategori_name` = '" . $categoryName . "' WHERE kategori_id = $categoryID");
        $result = $sorgu->execute();
        return $result;
    }

    function product_add($product_name, $product_aciklama, $product_img, $product_fiyat, $product_onceki_fiyat, $indirim, $categoryId, $one_cikan, $product_yeni)
    {
        global $conn;

        try {
            $sorgu = $conn->prepare("INSERT INTO mobilyalar (mobilya_adi, mobilya_aciklama, mobilya_resim, fiyat, onceki_fiyat, indirim, kategori_id, one_cikan, yeni) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $sorgu->bindValue(1, $product_name, PDO::PARAM_STR);
            $sorgu->bindValue(2, $product_aciklama, PDO::PARAM_STR);
            $sorgu->bindValue(3, $product_img, PDO::PARAM_STR);
            $sorgu->bindValue(4, $product_fiyat, PDO::PARAM_STR);
            $sorgu->bindValue(5, $product_onceki_fiyat, PDO::PARAM_STR);
            $sorgu->bindValue(6, $indirim, PDO::PARAM_INT);
            $sorgu->bindValue(7, $categoryId, PDO::PARAM_INT);
            $sorgu->bindValue(8, $one_cikan, PDO::PARAM_INT);
            $sorgu->bindValue(9, $product_yeni, PDO::PARAM_INT);

            $result = $sorgu->execute();

            return $result;
        } catch (PDOException $e) {
            error_log("Product add error: " . $e->getMessage());
            return false;
        }
    }

    function product_delete($product_id)
    {
        global $conn;
        $sorgu = $conn->prepare("DELETE FROM mobilyalar WHERE id = $product_id");
        $result = $sorgu->execute();
        return $result;
    }
}

$admin = new Admin();
?>

<script>
    function duzenleFunc(id) {
        var input = document.getElementById(`input_${id}`);
        var span = document.getElementById(`categoryName_${id}`);
        var duzenleButton = document.querySelector(`#kategoriDuzenleme_${id} button:nth-of-type(1)`);
        var kaydetButton = document.querySelector(`#kategoriDuzenleme_${id} button:nth-of-type(2)`);

        input.value = span.innerText;
        input.style.display = "inline-block";
        span.style.display = "none";
        duzenleButton.style.display = "none";
        kaydetButton.style.display = "inline-block";
    }

    function kaydetFunc(id) {
        var input = document.getElementById(`input_${id}`);
        var span = document.getElementById(`categoryName_${id}`);
        var duzenleButton = document.querySelector(`#kategoriDuzenleme_${id} button:nth-of-type(1)`);
        var kaydetButton = document.querySelector(`#kategoriDuzenleme_${id} button:nth-of-type(2)`);

        if (input.value.trim() === "") {
            alert("Kategori adını boş bıraktınız!");
        } else {
            var newCategoryName = input.value;
            var xhr = new XMLHttpRequest();
            var url = `../Management/Database/category_data.php?category_id=${id}&categoryName=${encodeURIComponent(newCategoryName)}`;
            xhr.open('GET', url, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status >= 200) {
                        span.innerText = input.value;
                        input.style.display = "none";
                        span.style.display = "inline-block";
                        duzenleButton.style.display = "inline-block";
                        kaydetButton.style.display = "none";
                    } else {
                        console.error('Error: ' + xhr.status);
                    }
                }
            };
            xhr.send();
        }
    }

    document.addEventListener("keydown", function(event) {
        if (event.key === "Escape") {
            var confirmation = confirm("İşlemi iptal etmek istediğinize emin misiniz?");
            if (confirmation) {
                alert("İşlem başarılı")
            } else {
                return;
            }
            var activeInput = document.querySelector("input:focus");
            if (activeInput) {
                var id = activeInput.id.split("_")[1];
                var span = document.getElementById(`categoryName_${id}`);
                var duzenleButton = document.querySelector(`#kategoriDuzenleme_${id} button:nth-of-type(1)`);
                var kaydetButton = document.querySelector(`#kategoriDuzenleme_${id} button:nth-of-type(2)`);

                activeInput.style.display = "none";
                span.style.display = "inline-block";
                duzenleButton.style.display = "inline-block";
                kaydetButton.style.display = "none";
            }
        }
    });
</script>
