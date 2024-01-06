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

    <link rel="stylesheet" href="./css/Admin_TestDrive.css">
    
</head>
<nav>
    <?php include("./navAdmin.php") ?>
</nav>

<body>
    <div class="Container">
        <br>
        <br>
        <br>
        <?php             
            $stmt = $conn->query("SELECT * FROM users INNER JOIN car_purchases ON users.uid = car_purchases.uid ;");
            $stmt->execute();
            
        ?>
        <div class="table_container">
            <h1>ประวัติ</h1>
            <br>
            <?php if ($stmt->rowCount() > 0) {?>
            <table border="1">
                <thead>
                    <tr>
                        <th>ชื่อสมาชิก</th>
                        <th>นามสกุล</th>
                        <th>อีเมล</th>
                        <th>เบอร์โทรศัพท์</th>
                        <th>Model</th>
                        <th>Model Type</th>
                        <th>car color</th>
                        <th>wheel size</th>
                        <th>car interior</th>
                        <th>software</th>
                        <th>total price</th>
                        <th>purchases date</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php

                    while ($row = $stmt->fetch()):
                        ?>
                        <?php $PID = $row["purchases_id"] ?>
                        <tr>
                            <td><?= $row["firstname"] ?></td>
                            <td><?= $row["lastname"] ?></td>
                            <td><?= $row["email"] ?></td>
                            <td><?= $row["Tel"] ?></td>
                            <td><?= $row["model"] ?></td>
                            <td><?= $row["modelType"] ?></td>
                            <td><?= $row["car_color"] ?></td>
                            <td><?= $row["wheel_size"] ?></td>
                            <td><?= $row["car_interior"] ?></td>
                            <td><?= $row["software"] ?></td>
                            <td><?= $row["total_price"] ?></td>
                            <td><?= $row["purchases_date"] ?></td>
                           
                        </tr>
                    <?php endwhile; 
                } else{
                    echo "<h1>ไม่มีคนยื่นเรื่องขออนุมัติ</h1>";
                }?>
                </tbody>
            </table> 
        </div>
    </div>

</body>

</html>