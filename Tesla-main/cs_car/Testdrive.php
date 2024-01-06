<?php
session_start();
require_once 'config/db.php';


if (isset($_POST['submit_testdrive'])) {
  try {
    $user_id = $_SESSION['user_login'];
    $Model = $_POST['model'];
    $Model_Type = $_POST['model_type'];
    $Tel = $_POST['Tel'];



    $sql = "INSERT INTO `Tesdrive`(`uid`, `Model`, `Model_Type`, `Tel`, `Status`) 
    VALUES (:Uid,:Model,:Model_type,:Tel,'0')";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':Uid', $user_id);
    $stmt->bindParam(':Model', $Model);
    $stmt->bindParam(':Model_type', $Model_Type);
    $stmt->bindParam(':Tel', $Tel);

    $stmt->execute();

    $_SESSION['success'] = "ลงทะเบียนเรียบร้อยโปรดรอการติดต่อกลับจากทีมงาน";
    header("location: TestDriveform.php");
  } catch (PDOException $e) {
    die("เกิดข้อผิดพลาดในการเพิ่มโพสต์: " . $e->getMessage());
  }
}
?>