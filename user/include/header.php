<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Con niêu 3 Miền</title>
    <link rel="stylesheet" href="css/header.css">
</head>
<body>
<header class="navbar">
        <img src="img/logo.png" class="logo" alt="logo cơm niêu 3 miền">
        <nav>
            <ul>
                <li><a href="index.php">Trang chủ</a></li>
                <li><a href="datban.php">Đặt bàn</a></li>
                <li><a href="menu.php">Thực đơn</a></li>
                <li><a href="#">Về chúng tôi</a></li>
                <li><a href="lienhe.php">Liên hệ</a></li>
                <li class="icon"><a href="login.php"><span>👤</span></a></li>
                <li class="icon"><a href="#"><span>🛒</span></a></li>
            </ul>
        </nav>
    </header>
    <script>
  window.addEventListener("scroll", function() {
    const navbar = document.querySelector(".navbar");
    if (window.scrollY > 100) {
      navbar.classList.add("scrolled");
    } else {
      navbar.classList.remove("scrolled");
    } 
  });
</script>
</body>
</html>
