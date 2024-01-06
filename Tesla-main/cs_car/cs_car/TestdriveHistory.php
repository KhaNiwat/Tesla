<?php
session_start();
require_once 'config/db.php';
//เดี๋ยวต้องเพิ่มระบบเช็คว่าเป็นแอดมิน
if(isset($_SESSION['user_login'])){
    header('location: HomeView.php');
}
else if (!isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: signin.php');
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100;300&family=Roboto+Slab:wght@300&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="./css/HomeView.css">
</head>
<nav>
    <?php include("./navAdmin.php") ?>
</nav>

<body>
    <br>
    <Br>
    <br>
    ทดลองขับ
    <?php 
    $user_id = $_SESSION['user_login'];
    $stmt = $conn->query("SELECT * FROM users INNER JOIN Tesdrive ON users.uid = Tesdrive.uid");
    $stmt->execute();
    while ($row = $stmt->fetch()):
        ?>
        ชื่อสมาชิก:
        <?= $row["firstname"] ?><br>
        นามสกุล:
        <?= $row["lastname"] ?><br>
        อีเมล:
        <?= $row["email"] ?><br>
        เบอร์โทรศัพท์:
        <?= $row["Tel"] ?><br>
        Modelรถ:
        <?= $row["Model"] ?><br>
        Model Typeรถ:
        <?= $row["Model_Type"] ?><br>
        
        <input type="submit" name="Submit2" value="ติดต่อแล้ว คุณ<?=$row["firstname"]?> แล้ว" onclick=>
        <hr>
    <?php endwhile; ?>
    


</body>

</html>