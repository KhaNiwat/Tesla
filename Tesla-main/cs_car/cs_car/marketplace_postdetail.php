<?php
session_start();
require_once 'config/db.php';

// ตรวจสอบว่ามีการส่งค่า post_id มาหรือไม่
if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];

    try {
        // สร้างคำสั่ง SQL เพื่อดึงข้อมูลโพสต์ที่มี post_id ที่ตรงกับที่ส่งมา
        $sql = "SELECT post.*, GROUP_CONCAT(post_photo.photo_name) AS photo_names, users.firstname 
                FROM post 
                LEFT JOIN post_photo ON post.post_id = post_photo.post_id 
                LEFT JOIN users ON post.uid = users.uid
                WHERE post.post_id = :post_id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->execute();
        $post = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($post) {
            ?>
            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Posted - รายละเอียดโพสต์</title>
                
                <link rel="stylesheet" href="./css/marketplace_detail.css">
            </head>
            <nav>
                <?php 
                
                if(isset($_SESSION['admin_login'])){
                    include("./navAdmin.php");
                  }
                  else{
                    include("./nav.php");
                  }

                ?>
            </nav>

            <body>
                <br>
                <br>
                <div class="container">
                    <div class="post_header">
                        <h1>รายละเอียดโพสต์</h1>
                        <hr>
                    </div>
                    <div class="post_container">
                        <div class="post_item">
                            <div class="post_header">
                                <h1>
                                    <?= $post['header'] ?>
                                </h1>
                            </div>

                            <div class="post_photo">
                                <?php
                                $photo_names = !empty($post['photo_names']) ? explode(',', $post['photo_names']) : array();
                                if (!empty($photo_names)) {
                                    if (count($photo_names) == 1) {
                                        ?>
                                        <img src='uploads/<?php echo $photo_names[0] ?>' alt='รูปภาพ' class='full-width-photo'>
                                        <style>
                                            .full-width-photo {
                                                width: 500px;
                                                height: auto;
                                            }
                                        </style>
                                        <?php
                                    } else {
                                        foreach ($photo_names as $photo_name) {
                                            ?>
                                            <img src='uploads/<?php echo $photo_name ?>' alt='รูปภาพ' width='300' height='300'>
                                            <?php
                                        }
                                    }

                                }
                                ?>
                            </div>
                            <div class="post_detail">
                                <h5>โพสต์โดย
                                    <?= $post['firstname'] ?>
                                </h5>
                                <p>โพสต์เมื่อ
                                    <?= $post['post_dated'] ?>
                                </p>
                                <?php echo "<p>{$post['detail']}</p>"; ?>
                                <?php if (isset($_SESSION['admin_login'])) { ?>
                                    <form action="DeletePostDB.php?PID=<?php echo $post_id ?>" method="post">
                                        <input type="submit" value="ลบโพสต์" class="delete-button">
                                <?php } ?>
                                <?php if (isset($_SESSION['user_login'])) {
                                    $user = $_SESSION['user_login'];
                                    if($post['uid'] == $user){
                                    ?>
                                    <form action="./db/EditPostDB.php?post_id=<?php echo $post_id ?>" method="post">
                                        <input type="submit" value="แก้ไขโพสต์" class="edit-button">
                                    <form action="./db/DeletePostDB.php?PID=<?php echo $post_id ?>" method="post">
                                        <input type="submit" value="ลบโพสต์" class="delete-button">
                                <?php } 
                                }?>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <br>
            </body>

            </html>
            <?php
        } else {
            echo "ไม่พบโพสต์ที่ตรงกับค่า post_id ที่ส่งมา";
        }
    } catch (PDOException $e) {
        echo "เกิดข้อผิดพลาดในการดึงโพสต์: " . $e->getMessage();
    }
} else {
    echo "ไม่ได้รับค่า post_id";
}
?>