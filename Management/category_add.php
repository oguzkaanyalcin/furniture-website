<?php
include("static/left_menu.php");
?>

<div class="main-content">
    <h1>Kategori Ekle</h1>
    <form id="main-form" method="POST">
        <label>Kategori Adı:</label>
        <input type="text" id="category-name" name="category-name" required>
        <button type="submit">Ekle</button>
    </form>
    <?php
    $redirect = false;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["category-name"])) {
            $category_name = trim($_POST["category-name"]);
            if ($category_name === '') {
                echo "Kategori adı boş olamaz!";
            } elseif (strpos($category_name, ' ') === 0) {
                echo "Kategori adı boşlukla başlayamaz!";
            } else {
                $admin->category_add($category_name);
                $redirect = true;
            }
        }
    } else if (isset($_GET['delete_id'])) {
        $admin->category_delete($_GET['delete_id']);
        $redirect = true;
    }

    if ($redirect) {
        echo '<script>
        window.location.href = "category_add.php";
      </script>';
    }
    
    ?>
    <h2>Mevcut Kategoriler (<?= $admin->category_num(); ?>)</h2>
    <table id="main-table">
        <thead>
            <tr>
                <th>Kategori Adı</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $admin->category_list();
            ?>
        </tbody>
    </table>
</div>
</body>
<?php include("static/footer_.php"); ?>
</html>