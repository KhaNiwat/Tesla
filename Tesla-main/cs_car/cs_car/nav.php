<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="./css/nav.css">

</head>

<?php
if (isset($_SESSION['user_login'])) {
  $user_id = $_SESSION['user_login'];
  $stmt = $conn->query("SELECT * FROM users WHERE uid = $user_id");
  $stmt->execute();
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<nav>
  <div class="nav-container">
    <div id="logo">
      <a href="HomeView.php">CS CAR</a>
    </div>
      <ul class="BarMenu">
        <li><a href="./HomeView.php">รถ</a></li>
        <li><a href="./marketplace.php">ตลาดซื้อขายมือสอง</a></li>
        <li><a href="./TestDriveForm.php">ลงทะเบียนทดลองขับ</a></li>
        <li><a href="#">เกี่ยวกับ</a></li>
      </ul>
      
    <?php if (isset($_SESSION['user_login'])) { ?>
      <div class="LoginIcon">
        <ul class="BarMenu">
          <a href="./user_page.php">
            <li><?php echo $row['firstname'] ?>&nbsp;&nbsp;</li>
          </a>
          <a href="./logout.php"><i class="fa fa-sign-out"   aria-hidden="true" style="hover:#0000,color: <?php echo isset($icon_color) ? $icon_color : 'black'; ?> "></i></a>
        <?php } else { ?>
          <a href="./signin.php"><i class="fa fa-user-circle-o" id="fa-user-circle-o" aria-hidden="true" style="color: black;"></i></a>
          <button class="mobile-menu-button" id="showmenu">เมนู</button>
        <?php } ?>
        </ul>
      </div>

      <?php if (isset($_SESSION['user_login'])) { ?>
        <button class="mobile-menu-button" id="showmenu">เมนู</button>
      <?php } ?>
      <!-- เพิ่มเมนูโทรศัพท์มือถือ -->
      <div class="mobile-menu" id="mobileMenu">
        <a href="./HomeView.php">รถ</a>
        <a href="./marketplace.php">ตลาดซื้อขายมือสอง</a>
        <a href="./TestDriveForm.php">ลงทะเบียนทดลองขับ</a>

        <?php if (isset($_SESSION['user_login'])) { ?>
          <a href="./user_page.php">แก้ไขข้อมูล</a>
          <a href="./logout.php">ออกจากระบบ</a>
        <?php } else { ?>
          <a href="./signin.php">เข้าสู่ระบบ</a>
        <?php } ?>
      </div>
  </div>
</nav>

<script>
  const mobileMenuButton = document.getElementById('showmenu');
  const mobileMenu = document.getElementById('mobileMenu');

  mobileMenuButton.addEventListener('click', function() {
    if (mobileMenu.style.display === 'none' || mobileMenu.style.display === '') {
      mobileMenu.style.display = 'block';
      mobileMenuButton.innerHTML = '<i class="fa fa-times"></i>';
      console.log("เปิดเมนู");
    } else {
      mobileMenu.style.display = 'none';
      mobileMenuButton.innerHTML = 'เมนู';
      console.log(" ! ปิดเมนู");
    }
  });
</script>


</html>