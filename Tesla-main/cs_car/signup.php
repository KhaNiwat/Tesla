<?php
    session_start();
    require_once 'config/db.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/signin.css">
</head>


<nav>
    <?php include("./nav.php") ?>
</nav>

<body>
    <main>
        <div class="container">
            <form action="./db/signup_db.php" method="post">
                <?php if (isset($_SESSION['error'])) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                        ?>
                    </div>
                <?php } ?>
                <?php if (isset($_SESSION['success'])) { ?>
                    <div class="alert alert-success" role="alert">
                        <?php
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                        ?>
                    </div>
                <?php } ?>
                <?php if (isset($_SESSION['warning'])) { ?>
                    <div class="alert alert-warning" role="alert">
                        <?php
                        echo $_SESSION['warning'];
                        unset($_SESSION['warning']);
                        ?>
                    </div>
                <?php } ?>
                <h1>สร้างบัญชี</h1>
                <label for="firstname">ชื่อจริง</label><br>
                <input type="text" name="firstname" class="custom-input"><br>
                <label for="lastname">นามสกุล</label><br>
                <input type="text" name="lastname" class="custom-input"><br>
                <label for="email">อีเมล์</label><br>
                <input type="email" name="email" class="custom-input"><br>
                <label for="password">รหัสผ่าน</label><br>
                <input type="password" name="password" class="custom-input"><br>
                <label for="c_password">ยืนยันรหัสผ่าน</label><br>
                <input type="password" name="c_password" class="custom-input"><br>
                <br>
                <button type="submit" class="custom-button" name="signup">ยืนยัน</button>
            </form>
            <br>
            <hr style="border: 2px;">
            <p>เป็นสมาชิกแล้วใช่ไหม? คลิ๊กที่นี่เพื่อ <a href="signin.php">เข้าสู่ระบบ</a></p>
        </div>
        </div>
    </main>
</body>

</html>