<?php
include 'include/connect_db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten_nguoi_dat = $_POST['ten_nguoi_dat'] ?? '';
    $so_dien_thoai = $_POST['so_dien_thoai'] ?? '';
    $so_nguoi = (int)($_POST['so_nguoi'] ?? 0);
    $date = $_POST['date'] ?? '';
    $time = $_POST['time'] ?? '';
    $thoi_gian_dat = $date . ' ' . $time;
    $thoi_gian_du_kien = $thoi_gian_dat;
    $ghi_chu = $_POST['ghi_chu'] ?? '';
    $id_chi_nhanh = (int)($_POST['id_chi_nhanh'] ?? 0);
    $trang_thai = 'cho_xac_nhan';

    if ($ten_nguoi_dat && $so_dien_thoai && $so_nguoi > 0 && $date && $time && $id_chi_nhanh) {
        $sql = "INSERT INTO DAT_BAN (ten_nguoi_dat, so_dien_thoai, thoi_gian_dat, thoi_gian_du_kien, so_nguoi, ghi_chu, trang_thai, id_chi_nhanh) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssisssi", $ten_nguoi_dat, $so_dien_thoai, $thoi_gian_dat, $thoi_gian_du_kien, $so_nguoi, $ghi_chu, $trang_thai, $id_chi_nhanh);
        if ($stmt->execute()) {
            $success = "Đặt bàn thành công! Chúng tôi sẽ liên hệ xác nhận.";
        } else {
            $error = "Lỗi đặt bàn: " . $conn->error;
        }
        $stmt->close();
    } else {
        $error = "Vui lòng điền đầy đủ thông tin!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đặt bàn - Cơm Niêu 3 Miền</title>
  <link rel="stylesheet" href="css/datban.css">
</head>
<body>
<header>
  <?php include 'include/header.php'; ?>
</header>

<div class="form-container">
  <p class="intro">
    Bạn đang tìm kiếm một trải nghiệm ẩm thực thú vị đầy hương vị và cảm xúc như ở quê nhà. Không đâu khác ngoài Cơm niêu 3 Miền. Đặt bàn hôm nay tại các chi nhánh của chúng tôi.
  </p>

  <?php if (isset($success)): ?>
    <p style="color: green;"><?= $success ?></p>
  <?php endif; ?>
  <?php if (isset($error)): ?>
    <p style="color: red;"><?= $error ?></p>
  <?php endif; ?>

  <form class="booking-form" method="POST" action="">
    <label for="name">Tên người đặt (*)</label>
    <input type="text" id="name" name="ten_nguoi_dat" placeholder="Tên của bạn ..." required>

    <label for="phone">Số điện thoại (*)</label>
    <input type="tel" id="phone" name="so_dien_thoai" placeholder="Điền số điện thoại..." required>

    <label for="people">Số người đặt (*)</label>
    <input type="number" id="people" name="so_nguoi" placeholder="Số lượng người" required>

    <label for="date">Ngày đặt (*)</label>
    <input type="date" id="date" name="date" required>

    <label for="time">Giờ đặt (*)</label>
    <input type="time" id="time" name="time" required>

    <label for="branch">Chi nhánh (*)</label>
    <select id="branch" name="id_chi_nhanh" required>
      <?php
      $sql = "SELECT id, ten FROM CHI_NHANH WHERE trang_thai = TRUE";
      $result = $conn->query($sql);
      while ($row = $result->fetch_assoc()) {
          echo "<option value='{$row['id']}'>{$row['ten']}</option>";
      }
      ?>
    </select>

    <label for="note">Yêu cầu đặc biệt</label>
    <textarea id="note" name="ghi_chu" rows="4" placeholder="Điền yêu cầu của bạn"></textarea>

    <button type="submit">Đặt bàn ngay</button>
  </form>
</div>

<footer>
  <?php include 'include/footer.php'; ?>
</footer>
</body>
</html>
