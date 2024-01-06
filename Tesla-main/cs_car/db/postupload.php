<?php
session_start();
require_once '../config/db.php';

if (isset($_SESSION['user_login'])) {
    $user_id = $_SESSION['user_login'];
    $stmt = $conn->query("SELECT * FROM users WHERE uid = $user_id");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (isset($_POST['submit_post'])) {
        $model = $_POST['model'];
        $model_type = $_POST['model_type'];
        $header = $_POST['post_header'];
        $post_content = $_POST['post_detail'];
        $car_color = $_POST['cars_color'];
        $year = $_POST['year'];
        $price = $_POST['price'];
        $tel = $_POST['tel'];
        $line = $_POST['line'];
        $post_status = 'approve';
        $images = $_FILES['images'];
        // เพิ่มโพสต์ลงในตาราง post
        try {
            $sql = "INSERT INTO post (uid, Model,model_type,header,detail,color,year,price,tel,Line,status) VALUES (:uid, :model,:model_type, :post_header, :post_detail, :cars_color, :year, :price,:tel,:line, :status)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':uid', $row['uid']); 
            $stmt->bindParam(':model', $model);
            $stmt->bindParam(':model_type', $model_type);
            $stmt->bindParam(':post_header', $header);
            $stmt->bindParam(':post_detail', $post_content);
            $stmt->bindParam(':cars_color', $car_color);
            $stmt->bindParam(':year', $year);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':tel', $tel);
            $stmt->bindParam(':line', $line);
            $stmt->bindParam(':status', $post_status);

            $stmt->execute();
            $post_id = $conn->lastInsertId(); // รับ post_id ที่สร้างใหม่

            // ตรวจสอบว่ามีไฟล์รูปภาพถูกอัพโหลดหรือไม่
            if (!empty($images['name'][0])) {
                $uploadDir = '../uploads/';

                $image_count = count($images['name']);
                for ($i = 1; $i < 9; $i++) {
                    $uploadFile = $uploadDir .$post_id."-".$i;
                    if (move_uploaded_file($images['tmp_name'][$i], $uploadFile)) {
                        $image_name = basename($uploadFile);
    
                        try {
                            $sql = "INSERT INTO post_photo (post_id, photo_name) VALUES (:post_id, :image_name)";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
                            $stmt->bindParam(':image_name', $uploadFile);
                            $stmt->execute();
                        } catch (PDOException $e) {
                            echo "เกิดข้อผิดพลาดในการเพิ่มรูปภาพ: " . $e->getMessage();
                        }
                    }
                }
                // อัพโหลดรูปภาพและบันทึกข้อมูลรูปภาพลงในตาราง post_photo
                // $image_count = count($images['name']);
                // for ($i = 0; $i < $image_count; $i++) {
                //     $uploadFile = $uploadDir . basename($images['name'][$i]);
                //     if (move_uploaded_file($images['tmp_name'][$i], $uploadFile)) {
                //         $image_name = basename($images['name'][$i]);
                //         echo "move_uploaded_file"+$images['tmp_name'][$i]+" 2="+$uploadFile;
                //         try {
                //             $sql = "INSERT INTO post_photo (post_id, photo_name) VALUES (:post_id, :image_name)";
                //             $stmt = $conn->prepare($sql);
                //             $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
                //             $stmt->bindParam(':image_name', $image_name);
                //             $stmt->execute();
                //         } catch (PDOException $e) {
                //             echo "เกิดข้อผิดพลาดในการเพิ่มรูปภาพ: " . $e->getMessage();
                //         }
                //     }
                // }
                
                header("location: ../marketplace.php");
                exit; // ออกจากสคริปต์เพื่อหยุดการทำงาน
            }else{
                // header("location: ../marketplace.php");
                exit;
            }
            
        } catch (PDOException $e) {
            die("เกิดข้อผิดพลาดในการเพิ่มโพสต์: " . $e->getMessage());
        }
    }
}
?>
