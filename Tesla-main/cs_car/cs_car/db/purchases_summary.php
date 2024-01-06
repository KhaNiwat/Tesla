<?php
session_start();
require_once '../config/db.php';

if (isset($_SESSION['user_login'])) {
    $modeltype = $_GET['modeltype'];
    $user_id = $_SESSION['user_login'];
    $stmt = $conn->query("SELECT * FROM users WHERE uid = $user_id");
    $stmt->execute();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitbuy'])) {
        try {
            // ดึงค่าจากฟอร์ม
            $model = $_POST['model'];
            $car_color = $_POST['PAINT'];
            $wheel_Size = $_POST['wheel'];
            $car_interior = $_POST['interior'];
            $software = $_POST['software'];
            if(isset($_POST['Tel'])){
                $tel = $_POST['Tel'];
            }
            else {
                $stmt2 = $conn->query("SELECT Tel FROM users INNER JOIN tesdrive ON tesdrive.uid = users.uid WHERE users.uid = $user_id GROUP BY Tel");
                $stmt2->execute();
                $telquery = $stmt2->fetch(PDO::FETCH_ASSOC);
                $tel = $telquery['Tel'];
            }

            $status = 0;

            // คำนวณราคาตาม option ที่เลือก
            if ($modeltype === 'model3') {
                // นี่คือรุ่นรถยนต์ Model 3
                $models = [
                    'RWD' => 1599000,
                    'LR' => 1899000
                ];
            } elseif ($modeltype === 'modely') {
                // นี่คือรุ่นรถยนต์ Model Y
                $models = [
                    'RWD' => 1699000,
                    'LR' => 1999000,
                    'PFM' => 2299000
                ];
            } else {
                // รุ่นรถยนต์ไม่ถูกต้อง
                // คุณอาจต้องจัดการข้อผิดพลาดในที่นี้
            };
            if ($modeltype === 'model3') {
                // นี่คือรุ่นรถยนต์ Model 3
                $car_colors = [
                    'black' => 0,
                    'white' => 50000,
                    'blue' => 50000,
                    'grey' => 75000,
                    'red' => 85000
                ];
            } elseif ($modeltype === 'modely') {
                // นี่คือรุ่นรถยนต์ Model Y
                $car_colors = [
                    'black' => 0,
                    'white' => 50000,
                    'blue' => 50000,
                    'grey' => 50000,
                    'red' => 80000
                ];
            } else {
                // รุ่นรถยนต์ไม่ถูกต้อง
                // คุณอาจต้องจัดการข้อผิดพลาดในที่นี้
            };
            if ($modeltype === 'model3') {
                // นี่คือรุ่นรถยนต์ Model 3
                $car_wheels = [
                    '18' => 0,
                    '19' => 50000
                ];
            } elseif ($modeltype === 'modely') {
                // นี่คือรุ่นรถยนต์ Model Y
                $car_wheels = [
                    '19' => 0,
                    '20' => 80000
                ];
            } else {
                // รุ่นรถยนต์ไม่ถูกต้อง
                // คุณอาจต้องจัดการข้อผิดพลาดในที่นี้
            };

            $car_interiors = [
                'black' => 0,
                'white' => 50000
            ];
            $auto_pilot = [
                'no' => 0,
                'EA' => 122000,
                'FSD' => 244000
            ];

            $total_price = $models[$model] + $car_colors[$car_color] + $car_wheels[$wheel_Size] + $car_interiors[$car_interior] + $auto_pilot[$software];
            // เตรียมคำสั่ง SQL เพื่อเพิ่มข้อมูลลงในฐานข้อมูล
            $stmt = $conn->prepare("INSERT INTO car_purchases (uid,Tel,model,modelType, car_color, wheel_size, car_interior, software, total_price, status) VALUES (:uid, :tel, :model, :modelType, :car_color, :wheel_size, :car_interior, :software, :total_price, :status)");
            $stmt->bindParam(':uid', $user_id);
            $stmt->bindParam(':tel', $tel);
            $stmt->bindParam(':model', $modeltype); 
            $stmt->bindParam(':modelType', $model); 
            $stmt->bindParam(':car_color', $car_color);
            $stmt->bindParam(':wheel_size', $wheel_Size);
            $stmt->bindParam(':car_interior', $car_interior);
            $stmt->bindParam(':software', $software);
            $stmt->bindParam(':total_price', $total_price);
            $stmt->bindParam(':status', $status);
            $stmt->execute();

            header('Location: ../HomeView.php');

        } catch (PDOException $e) {
            die("เกิดข้อผิดพลาดในการเพิ่มข้อมูล: " . $e->getMessage());
        }
    }
} else {
    $_SESSION['error'] = "โปรดลงชื่อเข้าใช้ก่อนทำการสั่งซื้อ";
    echo "login ก่อนน";
    header('Location: ../signin.php');
}

?>
