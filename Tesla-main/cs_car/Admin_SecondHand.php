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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin ApprovePage</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../cs_car/css/Admin_SecondHand.css">
    
</head>
<nav>
    <?php 
    include("./navAdmin.php")
    ?>
</nav>
<body>
    <br>
    <br>
    <div class="container">
        <?php

        try {
            $sql = "SELECT post.*, GROUP_CONCAT(post_photo.photo_name) AS photo_names, users.firstname 
              FROM post 
              LEFT JOIN post_photo ON post.post_id = post_photo.post_id 
              LEFT JOIN users ON post.uid = users.uid
              WHERE status = 0
              GROUP BY post.post_id 
              ORDER BY post.post_id DESC";

            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <div class="post_header">
                <h1>POST ที่รอการอนุมัติ</h1>
                <hr>
                <?php
                if ($posts) {
                    ?>
                </div>
                <div class="post_container">
                    <?php
                    foreach ($posts as $post) {
                        $post_id = $post['post_id'];
                        $post_header = $post['header'];
                        $post_content = $post['detail'];
                        $first_photo = !empty($post['photo_names']) ? explode(',', $post['photo_names'])[0] : '';
                        $user_firstname = $post['firstname'];
                        ?>
                        <div class="post_item">
                            <a href="ApprovePostDetail.php?post_id=<?php echo $post_id; ?>">
                                <div class="post_photo">
                                    <?php
                                    if (!empty($first_photo)) {
                                        ?>
                                        <img src='uploads/<?php echo $first_photo ?>' alt='รูปภาพ' width='00' height='200'>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="post_detail">
                                   
                                    <b>
                                        <?php echo "<p>$post_header</p>"; ?>
                                    </b>
                                    <?php echo "<p>$post_content</p>"; ?>
                                    <p>โพสต์เมื่อ
                                        <?= $post['post_dated'] ?>
                                    </p>
                                    <p>โพสต์โดย
                                        <?= $user_firstname ?>
                                    </p>
                                </div>
                            </a>
                        </div>
                        <?php
                    }
                    ?>

                </div>
                
                <?php
                } else {
                    echo "ไม่พบโพสต์ในฐานข้อมูลที่รออนุมัติ";
                }
        } catch (PDOException $e) {
            echo "เกิดข้อผิดพลาดในการดึงโพสต์: " . $e->getMessage();
        }
        ?>
    </div>
    <br>
    <br>
</body>

</html>