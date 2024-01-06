<?php
require_once 'config/db.php';

// ตรวจสอบคำค้นหา
if (isset($_GET['search'])) {
  $search = '%' . $_GET['search'] . '%';

  $sql = "SELECT post.*, photo_name, users.firstname
          FROM post
          LEFT JOIN post_photo ON post.post_id = post_photo.post_id
          LEFT JOIN users ON post.uid = users.uid
          WHERE status = 1 AND (post.header LIKE ? OR post.detail LIKE ?)
          GROUP BY post.post_id
          ORDER BY post.post_id DESC";

  $stmt = $conn->prepare($sql);
  $stmt->execute([$search, $search]);
  $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if ($posts) {
    // ส่งผลการค้นหากลับในรูปแบบ JSON
    echo json_encode($posts);
  } else {
    // ถ้าไม่พบผลลัพธ์ให้ส่ง JSON ที่มีข้อความแจ้งเตือน
    echo json_encode(array("message" => "ไม่พบผลการค้นหา"));
  }
} else {
  // ถ้าไม่มีคำค้น, ดึงโพสต์ทั้งหมดออกมา
  $sql = "SELECT post.*, photo_name, users.firstname
          FROM post
          LEFT JOIN post_photo ON post.post_id = post_photo.post_id
          LEFT JOIN users ON post.uid = users.uid
          WHERE status = 1
          GROUP BY post.post_id
          ORDER BY post.post_id DESC";

  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if ($posts) {
    // ส่งผลการค้นหาทั้งหมดกลับในรูปแบบ JSON
    echo json_encode($posts);
  } else {
    // ถ้าไม่พบโพสต์ในฐานข้อมูล
    echo json_encode(array("message" => "ไม่พบโพสต์ในฐานข้อมูล"));
  }
}
?>
