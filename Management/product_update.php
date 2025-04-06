<?php
include("static/left_menu.php");
?>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<div class="main-content">
    <h1>Ürün Düzenle</h1>
    <h2>Mevcut Ürünler (<?= $admin->product_num(); ?>)</h2>

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
    </head>

    <body>
        <h1>Ürün Düzenle</h1>
        <table id="urunlerTablosu">
    <thead>
        <tr>
            <th>Ürün adı</th>
            <th>Ürün açıklaması</th>
            <th>Ürün resmi</th>
            <th>Ürün güncel fiyatı</th>
            <th>Ürün önceki fiyatı</th>
            <th>Ürün indirim</th>
            <th>Ürün kategori</th>
            <th>Ürün öne çıkış</th>
            <th>Ürün yeniliği</th>
            <th>İşlemler</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $redirect = false;

        if (isset($_GET['delete_id'])) {
            $admin->product_delete($_GET['delete_id']);
            $redirect = true;
        }

        if ($redirect) {
            echo '<script>
            window.location.href = "product_update.php";
          </script>';
        }

        $categories = $admin->get_categories();
        $sorgu = $conn->prepare("SELECT * FROM mobilyalar ORDER BY id DESC");
        $sorgu->execute();
        $result = $sorgu->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $product) : ?>
            <tr data-id='<?= $product['id'] ?>'>
                <td contenteditable='true'><?= $product['mobilya_adi'] ?></td>
                <td contenteditable='true'><?= $product['mobilya_aciklama'] ?></td>
                <td>
                    <img src='<?= $product['mobilya_resim'] ?>' style='height:100px;'>
                    <input type='file' class='fileInput' accept='image/*' style='display: none;'>
                    <div class='drop-zone' data-id='<?= $product['id'] ?>'>
                        <br>Ürün resmi değiştir
                    </div>
                </td>
                <td contenteditable='true'><?= $product['fiyat'] ?></td>
                <td contenteditable='true'><?= $product['onceki_fiyat'] ?></td>
                <td>
                    <select>
                        <option value='1' <?= $product['indirim'] == '1' ? 'selected' : '' ?>>Evet</option>
                        <option value='0' <?= $product['indirim'] == '0' ? 'selected' : '' ?>>Hayır</option>
                    </select>
                </td>
                <td>
                    <select>
                        <?php foreach ($categories as $category) : ?>
                            <option value='<?= $category['kategori_id'] ?>' <?= $product['kategori_id'] == $category['kategori_id'] ? 'selected' : '' ?>>
                                <?= $category['kategori_name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <select>
                        <option value='1' <?= $product['one_cikan'] == '1' ? 'selected' : '' ?>>Evet</option>
                        <option value='0' <?= $product['one_cikan'] == '0' ? 'selected' : '' ?>>Hayır</option>
                    </select>
                </td>
                <td>
                    <select>
                        <option value='1' <?= $product['yeni'] == '1' ? 'selected' : '' ?>>Evet</option>
                        <option value='0' <?= $product['yeni'] == '0' ? 'selected' : '' ?>>Hayır</option>
                    </select>
                </td>
                <td>
                    <button class='kaydetButonu'>Kaydet</button>
                    <br><br><a href='?delete_id=<?= $product['id'] ?>'><button>Sil</button></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</div>




<script>
    $(document).ready(function() {
        $('.duzenleButonu').on('click', function() {
            $(this).closest('tr').find('td').attr('contenteditable', 'true');
            $(this).closest('tr').find('select').removeAttr('disabled');
        });

        $('.kaydetButonu').on('click', function() {
            var row = $(this).closest('tr');
            var urunVerileri = {
                id: row.data('id'),
                mobilya_adi: row.find('td:eq(0)').text(),
                mobilya_aciklama: row.find('td:eq(1)').text(),
                fiyat: row.find('td:eq(3)').text(),
                onceki_fiyat: row.find('td:eq(4)').text(),
                indirim: row.find('select:eq(0)').val(),
                kategori_id: row.find('select:eq(1)').val(),
                one_cikan: row.find('select:eq(2)').val(),
                yeni: row.find('select:eq(3)').val()
            };

            $.ajax({
                url: 'Database/update_product.php',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(urunVerileri),
                success: function(response) {
                    alert('Ürün başarıyla güncellendi!');
                    row.find('td').attr('contenteditable', 'false');
                    row.find('select').attr('disabled', 'disabled');
                },
                error: function(error) {
                    alert('Ürün güncellenirken bir hata oluştu!');
                }
            });
        });

        $(document).ready(function() {
    $('.drop-zone').on('click', function() {
        var productId = $(this).data('id');
        var fileInput = $(this).siblings('.fileInput');
        fileInput.data('product_id', productId).click();
    });

    $('.fileInput').on('change', function() {
        var files = $(this).prop("files");
        if (files.length === 0) {
            alert('Dosya bulunamadı!');
            return;
        }

        var formData = new FormData();
        formData.append("file", files[0]);

        var productId = $(this).data('product_id');
        formData.append("product_id", productId);

        uploadFile(formData, $(this));
    });

    function uploadFile(formData, fileInput) {
        $.ajax({
            url: 'upload_image.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log('Serverdan gelen yanıt:', response);
                if (response.filePath) {
                    alert('Ürün resmi başarıyla güncellendi!');
                } else {
                    alert('Resim yüklenirken bir hata oluştu!');
                    console.error('Server yanıtı:', response);
                }
                fileInput.val('');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Resim yüklenirken bir hata oluştu!');
                console.error('AJAX hatası:', textStatus, errorThrown);
                fileInput.val('');
            }
        });
    }
});



    });
</script>

</body>

<?php include("static/footer_.php"); ?>
</html>