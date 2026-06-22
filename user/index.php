<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nhà Hàng 3 Miền</title>
  <link rel="stylesheet" href="css/index.css">
</head>
<body>
  <header>
    <?php include 'include/header.php'; ?>
  </header>
 <section class="hero">
        <div class="overlay">
            <img src="img/comnieu3mien-text.png" class="text" alt="chữ cơm niêu 3 miền">
            <img src="img/map-vn.png" alt="Vietnam map" class="vietnam-map">
            <div class="mission">
                <h2>Sứ mệnh</h2>
                <p>mệnh nâng tầm món ăn Việt vươn ra với thế giới</p>
            </div>
        </div>
  </section>
  <?php include 'about-us.php'; ?>
  <footer>
    <?php include 'include/footer.php'; ?>
  </footer>
</body>
</html>