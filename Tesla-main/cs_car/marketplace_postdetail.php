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

                <link rel="stylesheet" href="./css/marketplace_postdetail.css">
            </head>
            <nav>
                <?php

                if (isset($_SESSION['admin_login'])) {
                    include("./navAdmin.php");
                } else {
                    include("./nav.php");
                }

                ?>
            </nav>

            <body>
                <div id="pc">
                    <br>
                    <br>
                    <br>
                    <div class="container">
                        <div class="post_header">
                            <h1>รายละเอียดโพสต์</h1>
                        </div>
                        <div class="post_container">
                            <div class="post_item">
                                <br>
                                <div class="pc">
                                    <h1 style="text-align: center;">
                                        <?= $post['header'] ?>
                                    </h1>
                                </div>
                                <div class="post_photo">
                                    <!-- รูป -->
                                    <?php
                                    $photo_names = explode(',', $post['photo_names']);
                                    if (!empty($post['photo_names'])) {
                                    ?>
                                        <button class="arrow-button left" onclick="changeImage(-1)">&#9664;</button>
                                        <div class="image-container">
                                            <?php
                                                foreach ($photo_names as $photo_name) {
                                                    echo '<img src="uploads/' . $photo_name . '" alt="รูปภาพ" width="600px" height="450px">';
                                                }
                                            ?>
                                        </div>
                                        <button class="arrow-button right" onclick="changeImage(1)">&#9654;</button>
                                    <?php
                                    
                                    } 
                                    ?>
                                </div>



                                <div class="post_detail">

                                    <h3>฿
                                        <?= $post['price'] ?>
                                    </h3>
                                    <h5>รายละเอียดโพสต์</h5>
                                    <p>
                                        <?= $post['detail'] ?>
                                    </p>
                                    <h5>เบอร์โทรติดต่อ </h5>
                                    <p>
                                        <?= $post['tel'] ?>
                                    </p>
                                    <h5>Line ID : </h5>
                                    <p>
                                        <?= $post['Line'] ?>
                                    </p>
                                    <p>
                                    <h6 style="text-align: right;">โพสต์เมื่อ :
                                        <?= $post['post_dated'] ?>
                                    </h6>


                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                </div>
                <div id="mobile">
                    <br>
                    <br>
                    <br>
                    <div class="container">
                        <div class="post_header">
                            <br>
                            <h1>รายละเอียดโพสต์</h1>
                        </div>
                        <div class="post_container">
                            <div class="post_item">
                                <br>
                                <div class="pc">
                                    <h1 style="text-align: center;">
                                        <?= $post['header'] ?>
                                    </h1>
                                </div>
                                <div class="post_photo">
                                    <!-- รูป -->
                                    <?php
                                    $photo_names = explode(',', $post['photo_names']);
                                    if (!empty($post['photo_names'])) {
                                    ?>
                                        <button class="arrow-button left" onclick="changeImage(-1)">&#9664;</button>
                                        <div class="image-container">
                                            <?php
                                                foreach ($photo_names as $photo_name) {
                                                    echo '<img src="uploads/' . $photo_name . '" alt="รูปภาพ" width="600px" height="450px">';
                                                }
                                            ?>
                                        </div>
                                        <button class="arrow-button right" onclick="changeImage(1)">&#9654;</button>
                                    <?php
                                    
                                    } 
                                    ?>
                                </div>

                                <div class="post_detail">

                                    <h3>฿
                                        <?= $post['price'] ?>
                                    </h3>
                                    <h5>รายละเอียดโพสต์</h5>
                                    <p>
                                        <?= $post['detail'] ?>
                                    </p>
                                    <h5>เบอร์โทรติดต่อ </h5>
                                    <p>
                                        <?= $post['tel'] ?>
                                    </p>
                                    <h5>Line ID : </h5>
                                    <p>
                                        <?= $post['Line'] ?>
                                    </p>
                                    <p>
                                    <h6 style="text-align: right;">โพสต์เมื่อ :
                                        <?= $post['post_dated'] ?>
                                    </h6>


                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
                <?php if (isset($_SESSION['admin_login'])) { ?>
                <form action="DeletePostDB.php?PID=<?php echo $post_id ?>" method="post">
                    <input type="submit" value="ลบโพสต์" class="delete-button">
                <?php } ?>
                <?php if (isset($_SESSION['user_login'])) {
                    $user = $_SESSION['user_login'];
                    if ($post['uid'] == $user) {
                ?>
                <div class="bt">
                <form action="./db/EditPostDB.php?post_id=<?php echo $post_id ?>" method="post">
                            <input type="submit" value="แก้ไขโพสต์" class="edit-button">
                        </form>
                        <form action="./db/DeletePostDB.php?PID=<?php echo $post_id ?>" method="post">
                                <input type="submit" value="ลบโพสต์" class="delete-button">
                        </form>
                </div>
                        
                        <?php }
                } ?>
                
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

<script>
    let currentImageIndex = 0;
    const imageContainer = document.querySelector(".image-container");
    const photoNames = <?= json_encode($photo_names) ?>;

    function showImage(index) {
        const imagePath = "uploads/" + photoNames[index];
        imageContainer.innerHTML = `<img src="${imagePath}" alt="รูปภาพ" width="600px" height="450px">`;
    }

    function changeImage(direction) {
        currentImageIndex += direction;
        if (currentImageIndex < 0) {
            currentImageIndex = photoNames.length - 1;
        } else if (currentImageIndex >= photoNames.length) {
            currentImageIndex = 0;
        }
        showImage(currentImageIndex);
    }

    // เริ่มแสดงรูปภาพแรก
    showImage(currentImageIndex);
</script>

