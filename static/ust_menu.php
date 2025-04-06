<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Title</title>
    <link rel="stylesheet" href="css/genel.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>

<body>
    <header>
        <div class="top-navbar">
            <div class="contact-info">
                <ul>
                    <li><i class="fas fa-phone"></i> +90 555 555 55 55</li>
                    <li><a href="?lang=tr">TR</a> | <a href="?lang=en">EN</a></li>
                </ul>
            </div>
        </div>

        <div class="main-container">
            <div class="logo-container">
                <h1>
                    <a href="/" style="text-decoration: none; color: #000a37; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
                        BoraKi Mobilya
                    </a>
                </h1>
            </div>

            <nav class="navbar">
                <ul>
                    <li><a href="/"><?= anasayfa ?></a></li>
                    <li><a href="#"><?= hakkimizda ?></a></li>
                    <li><a href="#"><?= iletisim ?></a></li>
                    <?php if (isset($session->user_id)) { ?>
                        <li id="has-submenu">
                            <a href="#"><?= htmlspecialchars($session->username); ?></a>
                            <ul class="customMenu">
                                <?php
                                if ($session->perm > 0) {
                                    echo '<li><a href="/Management" target="_blank" style="color: #000a37;">Admin Paneli</a></li>';
                                }
                                ?>
                                <li><a href="#" style="color: #000a37;">Ayarlar</a></li>
                                <li><a href="#" style="color: #000a37;">Şifre Sıfırlama</a></li>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
            </nav>
            <div class="search-container">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="searchBox" placeholder="<?= urun_ara ?>">
                <div id="results"></div>
            </div>

            <div class="actions">
                <div class="sepet" id="sepetAdd">
                    <i class="fas fa-cart-plus"></i>
                    <span id="sepetSayi" class="sepetUrunSayisi">0</span>
                </div>

                <?php if (!isset($session->user_id)) { ?>
                    <div class="uyelik">
                        <a href="login.php"><i class="fas fa-user"></i></a>
                    </div>
                <?php } else { ?>
                    <div class="logoutIcon" style="margin-left: 17px; font-size: 20px; color: #000a37;">
                        <a href="logout.php"><i class="fas fa-sign-out-alt"></i></a>
                    </div>
                <?php } ?>

                <div class="heartsClick">
                    <i class="fas fa-heart"></i>
                </div>
            </div>
        </div>
        <nav class="category-navbar">
            <ul>
                <?php
                $kategori_check = $conn->prepare("SELECT * FROM kategoriler");
                $kategori_check->execute();
                $res = $kategori_check->fetchAll(PDO::FETCH_ASSOC);
                foreach ($res as $categories) {
                    echo '<li><a href="urunler.php?kategori=' . $categories["kategori_id"] . '">' . $categories["kategori_name"] . '</a></li>';
                }
                ?>
            </ul>
        </nav>
    </header>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var customMenuToggle = document.querySelector('.navbar #has-submenu');
            var customMenu = customMenuToggle ? customMenuToggle.querySelector('.customMenu') : null;
            var timer;

            if (customMenuToggle && customMenu) {
                customMenu.style.display = 'none';

                customMenuToggle.addEventListener('mouseover', function() {
                    clearTimeout(timer);
                    customMenu.style.display = 'block';
                });

                customMenuToggle.addEventListener('mouseleave', function() {
                    timer = setTimeout(function() {
                        customMenu.style.display = 'none';
                    }, 300);
                });

                customMenu.addEventListener('mouseenter', function() {
                    clearTimeout(timer);
                });

                customMenu.addEventListener('mouseleave', function() {
                    timer = setTimeout(function() {
                        customMenu.style.display = 'none';
                    }, 300);
                });
            }

            // Arama İşlemleri
            var searchIcon = document.querySelector('.search-icon');
            var searchBox = document.getElementById('searchBox');
            var resultsContainer = document.getElementById('results');

            if (searchIcon && searchBox && resultsContainer) {
                searchIcon.addEventListener('click', function() {
                    searchBox.focus();
                });

                searchBox.addEventListener('input', function() {
                    var query = searchBox.value.trim();
                    if (query.length > 0) {
                        showResults(query);
                        resultsContainer.style.display = 'block';
                    } else {
                        resultsContainer.style.display = 'none';
                    }
                });

                function showResults(query) {
                    var xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === XMLHttpRequest.DONE) {
                            if (xhr.status === 200) {
                                var response = JSON.parse(xhr.responseText);
                                resultsContainer.innerHTML = '';
                                response.forEach(function(item) {
                                    var resultItem = document.createElement('div');
                                    resultItem.className = 'result-item';
                                    resultItem.textContent = item.name;
                                    resultItem.addEventListener('click', function() {
                                        window.location.href = item.url;
                                    });
                                    resultsContainer.appendChild(resultItem);
                                });
                            } else {
                                console.error('AJAX hatası:', xhr.status);
                            }
                        }
                    };
                    xhr.open('POST', 'fetch_data_search.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.send('query=' + encodeURIComponent(query));
                }

                document.addEventListener('click', function(e) {
                    if (!resultsContainer.contains(e.target) && e.target !== searchBox) {
                        resultsContainer.style.display = 'none';
                    }
                });
            }

            var sepetSayi = 0;

            function updateSepetSayi() {
                var spanSepetUrunSayisi = document.getElementById('sepetSayi');
                if (spanSepetUrunSayisi) {
                    spanSepetUrunSayisi.textContent = sepetSayi;
                }
            }

            function artirSepetSayi() {
                sepetSayi++;
                updateSepetSayi();
            }

            var sepetButon = document.getElementById('sepetAdd');
            if (sepetButon) {
                sepetButon.addEventListener('click', function() {
                    artirSepetSayi();
                });
            }
        });
    </script>


    <?php include("static/loading_.php"); ?>

</body>

</html>