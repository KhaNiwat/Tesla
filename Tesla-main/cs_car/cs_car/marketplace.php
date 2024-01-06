<?php
session_start();
require_once 'config/db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Posted</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="./css/marketplace.css">
  <script src="marketplace.js"></script>
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
  <br>
  <br>
  <div class="container">

    <?php
    // Your PHP code
    try {
      $sql = "SELECT post.*,photo_name, users.firstname 
              FROM post 
              LEFT JOIN post_photo ON post.post_id = post_photo.post_id 
              LEFT JOIN users ON post.uid = users.uid
              WHERE status = 1
              GROUP BY post.post_id 
              ORDER BY post.post_id DESC";

      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $allPosts = $posts;

    ?>
      <div class="post_header">
        <h1>POSTED</h1>
        <hr>
        <?php
        if (isset($_SESSION['user_login'])) {
        ?>
          <div class="pos">
            <p>อยากขายรถ ? ตั้งโพสต์ของคุณ </p><a href="./post_create.php" class="btn btn-primary">ที่นี่</a>
          </div>
          <div class="search-container">
            <input type="text" id="searchInput" placeholder="ค้นหา..." onkeyup="searchPosts()">
          </div>
        <?php
        }
        if ($posts) {
        ?>
      </div>
      <div class="post_container">

        <?php

          foreach ($posts as $post) {
            $post_id = $post['post_id'];
            $post_header = $post['header'];
            $post_content = $post['detail'];

            $first_photo = !empty($post['photo_name']) ? explode(',', $post['photo_name'])[0] : '';
            $user_firstname = $post['firstname'];
        ?>
          <div class="post_item">
            <a href="marketplace_postdetail.php?post_id=<?php echo $post_id; ?>">
              <div class="post_photo">
                <?php
                if (!empty($first_photo)) {
                ?>
                  <img src='uploads/<?php echo $first_photo ?>' alt='รูปภาพ' width='200' height='200'>
                <?php
                }
                ?>
              </div>
              <div class="post_detail">
                <h1><?php echo "$post_header"; ?></h1>
                <?php echo "<h3>$post_content</h3>"; ?>
                <p>โพสต์เมื่อ :<?= $post['post_dated'] ?></p>
                <p>โพสต์โดย :<?= $user_firstname ?></p>
              </div>
            </a>
          </div>


        <?php

          }
        ?>

      </div>
  <?php
        } else {
          echo "ไม่พบโพสต์ในฐานข้อมูล";
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