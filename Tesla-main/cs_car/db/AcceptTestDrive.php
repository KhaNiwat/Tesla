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
        $tid = $_GET['TID'];
        $stmt = $conn->prepare("UPDATE Tesdrive SET Status=1 WHERE TID=:tid ");
        $stmt->bindParam(':tid', $tid);
        $stmt->execute();
        header ('location: ../Admin_TestDrive.php');
    } catch (PDOException $e) {
        die("เกิดข้อผิดพลาดในการเพิ่มโพสต์: " . $e->getMessage());
    }
    ?>
</body>

</html>