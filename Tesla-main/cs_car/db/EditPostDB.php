<?php
session_start();
require_once '../config/db.php';

if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];

    try {
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
            $header = $post['header'];
            $detail = $post['detail'];
        } else {
            echo "ไม่พบโพสต์ที่ตรงกับค่า post_id ที่ส่งมา";
            exit;
        }
    } catch (PDOException $e) {
        echo "เกิดข้อผิดพลาดในการดึงโพสต์: " . $e->getMessage();
    }
} else {
    echo "ไม่ได้รับค่า post_id";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['post_id'], $_POST['header'], $_POST['detail'])) {
        $post_id = $_POST['post_id'];
        $header = $_POST['header'];
        $detail = $_POST['detail'];

        try {
            // โค้ดอัปเดตข้อมูลโพสต์ในฐานข้อมูล
            $sql = "UPDATE post SET header = :header, detail = :detail WHERE post_id = :post_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
            $stmt->bindParam(':header', $header, PDO::PARAM_STR);
            $stmt->bindParam(':detail', $detail, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $_SESSION['success'] = "การแก้ไขโพสต์เสร็จสมบูรณ์";
                header("Location: ../marketplace_postdetail.php?post_id=$post_id"); // กลับไปยังหน้ารายละเอียดโพสต์
                exit;
            } else {
                $_SESSION['error'] = "เกิดข้อผิดพลาดในการแก้ไขโพสต์";
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = "เกิดข้อผิดพลาดในการดึงโพสต์: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/user_page.css">
</head>

<body>
    <!-- โค้ดส่วนเนื้อหา -->

    <main>
        <div class="container">
            <h1>แก้ไขโพสต์</h1>
            <hr>
            <form method="POST" action="">
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
                <input type="hidden" name="post_id" value="<?= $post_id ?>">
                <div class="mb-3">
                    <label for="header" class="form-label">หัวข้อ:</label>
                    <input type="text" class="form-control" id="header" name="header" value="<?= $header ?>">
                </div>
                <div class="mb-3">
                    <label for="detail" class="form-label">เนื้อหา:</label>
                    <textarea class="form-control" id="detail" name="detail"><?= $detail ?></textarea>
                </div>
                <input class="btn btn-primary" type="submit" value="บันทึกการแก้ไข">
                <a href="../marketplace_postdetail.php?post_id=<?= $post_id ?>" class="btn btn-primary">ย้อนกลับ</a>
            </form>
        </div>
    </main>
</body>

</html>