<?php session_start();
require_once '../config/db.php'; ?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    try {
        $pid = $_GET['PID'];
        $stmt = $conn->prepare("UPDATE car_purchases SET status=1 WHERE purchases_id=:pid ");
        $stmt->bindParam(':pid', $pid);
        $stmt->execute();
        header ('location: ../Admin_car.php');
    } catch (PDOException $e) {
        die("เกิดข้อผิดพลาดในการเพิ่มโพสต์: " . $e->getMessage());
    }
    ?>
</body>

</html>