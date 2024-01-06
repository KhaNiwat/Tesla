<?php
session_start();
require_once 'config/db.php';
if(isset($_SESSION['user_login'])){
    header('location: HomeView.php');
}
else if (!isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: signin.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CS CAR</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100;300&family=Roboto+Slab:wght@300&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="./css/HomeView.css">
  <Style>

  </Style>
</head>
<nav>
  <?php include("./navAdmin.php") ?>
</nav>

<body>
 <main>
 <section class="bg-image1">
  <div class="container">
    <h1>Model Y</h1>
    <section class="button-count">
      <a href="./modely.php" class="btn-1">สั่งทำพิเศษ</a>
      <a href="" class="btn-2">เรียนรู้เพิ่มเติม</a>
    </section>
  </div>
</section>

<section class="bg-image2">
  <div class="container">
    <h1>Model 3</h1>
    <section class="button-count">
      <a href="" class="btn-1">สั่งทำพิเศษ</a>
      <a href="" class="btn-2">เรียนรู้เพิ่มเติม</a>
    </section>
  </div>
</section>
 </main>
</body>

</html>


</script>