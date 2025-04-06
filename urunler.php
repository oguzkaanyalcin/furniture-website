<?php
include("Database/Database.php");
include("Function/Product.php");
include("Function/Category.php");

if (!isset($_GET['kategori'])) {
    header("location:index.php");
}
?>

<!DOCTYPE html>
<html lang="en">


<style>

@media only screen and (min-width: 1200px) {
    .filter-container {
    padding: 9px;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    box-sizing: border-box;
    background-color: #f9f9f9;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    width: calc(100% - 40px);
    max-width: 65%;
    margin: 0 auto 20px auto;
    display: flex;
    align-items: center;
    justify-content: center;
}

    .filter-container input[type="number"],
    .filter-container select {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 16px;
        width: 23%;
    }
}

@media only screen and (max-width: 1199px) {
    .filter-container {
    padding: 9px;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    box-sizing: border-box;
    background-color: #f9f9f9;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    width: calc(75% - 40px);
    max-width: 100%;
    margin: 0 auto 20px auto;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
}

    .filter-container input[type="number"],
    .filter-container select {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 16px;
        width: 100%;
    }
}

    .filter-container h1 {
        font-size: 24px;
        color: #333;
        margin: 0 0 10px 0;
        width: 100%;
        text-align: center;
    }

    .filter-container label,
    .filter-container input[type="number"],
    .filter-container select,
    .filter-container button {
        margin-right: 10px;
        margin-bottom: 10px;
    }

    .filter-container label {
        color: #666;
    }

    .filter-container button {
        padding: 10px 20px;
        background-color: #000a37;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    .filter-container button:hover {
        background-color: #000a37;
    }

    .filter-container select {
        width: 130px;
    }

    .filter-separator {
        color: #999;
        display: none;
    }

    @media only screen and (max-width: 1199px) {
        #furnitureList {
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
            max-width: 100%;
            padding: 20px;
            box-sizing: border-box;
        }
    }

    @media only screen and (min-width: 1200px) {
        #furnitureList {
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
            max-width: 72%;
            padding: 20px;
            box-sizing: border-box;
        }
    }

    @media only screen and (max-width: 1199px) {
        #furnitureList {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        }
    }

    @media only screen and (min-width: 1200px) {
        #furnitureList {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            margin: 0 auto;
        }
    }
</style>



<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <title><?= site_adi . " - " . $category->categoryName($_GET['kategori']) ?></title>
</head>

<body>
    <?php
    include("static/ust_menu.php");
    echo '<div class="category-name"><h2>' . $category->categoryName($_GET['kategori']) . '</h2></div>';
    ?>

    <div class="filter-container">
        <form method="post" id="priceForm">
            <label for="minimum-fiyat">Min <?= price ?>:</label>
            <input type="number" id="minimum-fiyat" placeholder="<?= min_price ?>" name="min">
            <label for="max-fiyat">Max <?= price ?>:</label>
            <input type="number" id="max-fiyat" placeholder="<?= max_price ?>" name="max">
            <button type="submit"><?= set ?></button>
        </form>

        <label for="sortOrder"><?= sorting ?>:</label>
        <select id="sortOrder">
            <option value="asc"><?= varsayilan ?></option>
            <option value="asc"><?= price ?>: <?= increasing ?></option>
            <option value="desc"><?= price ?>: <?= decreasing ?></option>
        </select>
        <button onclick="getFurniture()"><?= filter ?></button>
    </div>

    <div id="furnitureList"></div>

    <?php
    $product->findProduct($_GET['kategori']);
    ?>

    <script>
        function getFurniture() {
            const sortOrder = document.getElementById('sortOrder').value;
            const xhr = new XMLHttpRequest();
            xhr.open('GET', `data.php?order=${sortOrder}&kategori=<?= $_GET['kategori'] ?>`, true);
            xhr.onload = function() {
                if (this.status >= 200) {
                    const furniture = JSON.parse(this.responseText);
                    let output = '';

                    furniture.forEach(function(item) {
                        let mesaj = "";
                        let oncekiFiyat = "";

                        if (item.yeni > 0) {
                            mesaj = "<div class='discount-label'><?= yeni ?></div>";
                        } else if (item.indirim > 0) {
                            mesaj = `<div class="discount-label">%${item.indirim_orani} <?= indirim ?></div>`;
                        }

                        if (item.indirim > 0) {
                            oncekiFiyat = `<span class="old-price">${item.onceki_fiyatlar}₺</span>`;
                        }

                        output += `<a href="urun_bakis.php?urun=${item.id}"><div class="product-card">
                            <img src="${item.mobilya_resim}" alt="${item.mobilya_resim}" class="product-image">${mesaj}
                            <div class="product-info">
                                <h3 class="product-title">${item.mobilya_adi}</h3>
                                ${oncekiFiyat}
                                <div class="price-container">
                                    <span class="new-price">${item.fiyatlar} ₺</span>
                                </div>
                            </div>
                        </div></a>`;
                    });

                    output += '';
                    document.getElementById('furnitureList').innerHTML = output;
                }
            }
            xhr.send();
        }

        document.addEventListener('DOMContentLoaded', function() {
            getFurniture();
        });

        document.getElementById('priceForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const minPrice = document.getElementById('minimum-fiyat').value;
            const maxPrice = document.getElementById('max-fiyat').value;

            fetch(`data.php?kategori=<?= $_GET['kategori'] ?>&min=${minPrice}&max=${maxPrice}`)
                .then(response => response.json())
                .then(data => {
                    const filteredFurniture = data.filter(item => item.fiyat >= minPrice && item.fiyat <= maxPrice);
                    const furnitureListDiv = document.getElementById('furnitureList');

                    furnitureListDiv.innerHTML = '';

                    if (filteredFurniture.length > 0) {

                        let output = '';
                        filteredFurniture.forEach(item => {
                            let mesaj = "";
                            let oncekiFiyat = "";

                            if (item.yeni > 0) {
                                mesaj = "<div class='discount-label'>Yeni</div>";
                            } else if (item.indirim > 0) {
                                mesaj = `<div class="discount-label">%${item.indirim_orani} İndirim</div>`;
                            }

                            if (item.indirim > 0) {
                                oncekiFiyat = `<span class="old-price">${item.onceki_fiyatlar}₺</span>`;
                            }

                            output += `<a href="urun_bakis.php?urun=${item.id}"><div class="product-card">
                            <img src="${item.mobilya_resim}" alt="${item.mobilya_resim}" class="product-image">${mesaj}
                            <div class="product-info">
                                <h3 class="product-title">${item.mobilya_adi}</h3>
                                ${oncekiFiyat}
                                <div class="price-container">
                                    <span class="new-price">${item.fiyatlar} ₺</span>
                                </div>
                            </div>
                        </div></a>`;
                        });

                        output += '';
                        document.getElementById('furnitureList').innerHTML = output;

                    } else {
                        furnitureListDiv.textContent = 'Belirtilen fiyat aralığında mobilya bulunmamaktadır.';
                    }
                })
                .catch(error => {
                    document.getElementById('furnitureList').textContent = 'Veriler yüklenirken bir hata oluştu.';
                });
        });
    </script>

    <?php include("static/footer_.php"); ?>
    <script src="./js/main.js"></script>
</body>

</html>