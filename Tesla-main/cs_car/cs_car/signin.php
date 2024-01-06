<?php 
    session_start();
    require_once 'config/db.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/signin.css">
</head>
<nav>
    <?php include("./nav.php") ?>
</nav>

<body>
    <main>
        <div class="container">
            <form action="./db/signin_db.php" method="post">
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

                <h1>ลงชื่อเข้าใช้</h1>
                <label for="email">อีเมล์</label><br>
                <input type="email" name="email" class="custom-input" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}" title="Please enter a valid email address"><br>
                <label for="password">รหัสผ่าน</label><br>
                <input type="password" name="password" class="custom-input" ><br>
                <br>
                <button type="submit" class="custom-button" name="signin">ยืนยัน</button>
            </form>
            <br>
            <hr style="border: 2px;">
            <p>ยังไม่เป็นสมาชิกใช่ไหม? คลิ๊กที่นี่เพื่อ <a href="signup.php">ลงทะเบียน</a></p>
        </div>
    </main>
</body>
</html>