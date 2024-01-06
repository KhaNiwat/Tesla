<?php
    session_start();
    require_once 'config/db.php';
    include("./nav.php");
    
if (isset($_SESSION['user_login'])) {
    $user_id = $_SESSION['user_login'];
    
    // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
    try {
        $sql = "SELECT * FROM users WHERE uid = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            $firstname = $user['firstname'];
            $lastname = $user['lastname'];
            $email = $user['email'];
            
            // ตรวจสอบการส่งค่า POST
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $firstname = $_POST['firstname'];
                $lastname = $_POST['lastname'];
                $email = $_POST['email'];
                $password = $_POST['password'];

                // ตรวจสอบว่ามีการป้อนรหัสผ่านใหม่
                if (!empty($password)) {
                    // ทำการแฮชรหัสผ่าน
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    
                    // อัปเดตข้อมูลผู้ใช้และรหัสผ่าน
                    try {
                        $sql = "UPDATE users SET firstname = :firstname, lastname = :lastname, email = :email, password = :password WHERE uid = :user_id";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':firstname', $firstname);
                        $stmt->bindParam(':lastname', $lastname);
                        $stmt->bindParam(':email', $email);
                        $stmt->bindParam(':password', $hashed_password);
                        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                        
                        if ($stmt->execute()) {
                            $_SESSION['success'] ="อัปเดตข้อมูลผู้ใช้เรียบร้อยแล้ว";
                        } else {
                            $_SESSION['error'] = "เกิดข้อผิดพลาดในการอัปเดตข้อมูลผู้ใช้";
                        }
                    } catch (PDOException $e) {
                        echo "เกิดข้อผิดพลาด: " . $e->getMessage();
                    }
                } else {
                    // อัปเดตข้อมูลผู้ใช้โดยไม่รวมรหัสผ่าน
                    try {
                        $sql = "UPDATE users SET firstname = :firstname, lastname = :lastname, email = :email WHERE uid = :user_id";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':firstname', $firstname);
                        $stmt->bindParam(':lastname', $lastname);
                        $stmt->bindParam(':email', $email);
                        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                        
                        if ($stmt->execute()) {
                            $_SESSION['success'] = "อัปเดตข้อมูลผู้ใช้เรียบร้อยแล้ว";
                        } else {
                            $_SESSION['error'] = "เกิดข้อผิดพลาดในการอัปเดตข้อมูลผู้ใช้";
                        }
                    } catch (PDOException $e) {
                        echo "เกิดข้อผิดพลาด: " . $e->getMessage();
                    }
                }
            }

            // แสดงฟอร์มแก้ไขข้อมูลผู้ใช้
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Edit</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
                <link rel="stylesheet" href="./css/user_page.css">
            </head>
            <body>
                <main>
                <div class="container">
                    <h3 class="mt-3">แก้ไขข้อมูลผู้ใช้</h3>
                    <hr>

                    <form method="post" action="">
                        <?php if(isset($_SESSION['error'])) {?>
                            <div class="alert alert-danger" role="alert">
                                <?php
                                    echo $_SESSION['error'];
                                    unset($_SESSION['error']);
                                ?>
                            </div>
                        <?php }?>
                        <?php if(isset($_SESSION['success'])) {?>
                                <div class="alert alert-success" role="alert">
                                    <?php
                                        echo $_SESSION['success'];
                                        unset($_SESSION['success']);
                                    ?>
                                </div>
                        <?php }?>
                        <div class="mb-3">
                            <label for="firstname" class="form-label">ชื่อ:</label>
                            <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $firstname; ?>" required>
                        <br>
                        </div>
                        <div class="mb-3">
                            <label for="lastname" class="form-label">นามสกุล:</label>
                            <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $lastname; ?>" required>
                        <br>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">อีเมล์:</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
                        <br>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">รหัสผ่านใหม่ (เว้นว่างหากไม่ต้องการเปลี่ยน):</label>
                            <input type="password" class="form-control" id="password" name="password">
                        <br>
                        </div>

                        <input class="btn btn-primary" type="submit" value="บันทึก">
                        <a href="user.php" class="btn btn-primary" >ย้อนกลับ</a>
                    </form>
                </div>
                </main>
                
            </body>
            </html>
            <?php
        } else {
            $_SESSION['error'] = "ไม่พบข้อมูลผู้ใช้";
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "เกิดข้อผิดพลาด: " . $e->getMessage();
    }
} else {
    $_SESSION['error'] = "กรุณาเข้าสู่ระบบก่อนเข้าถึงหน้านี้";
}
?>
