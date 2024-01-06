<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: signin.php');
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/TestDriveform.css">
</head>

<nav>
    <?php 
    $icon_color = 'white';
    include("./nav.php") ?>
</nav>

<body>
    
<?php

        if (isset($_SESSION['user_login'])) {
            $user_id = $_SESSION['user_login'];
            $stmt = $conn->query("SELECT * FROM users WHERE uid = $user_id");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        ?>
    <div class="left-section">
        <!-- img in css -->
    </div>
    <div class="right-section">
        <div class="form-container">
            <h2>Form</h2>
            <form action="./db/TestDriveDB.php" method="post" enctype="multipart/form-data">
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
                <h4>ทดลองขับ</h4>
                <select id="car-model" name="model" >
                    <option value="model3">Model 3</option>
                    <option value="modely">Model Y</option>
                </select>
                <!-- อย่าลบ -->
                <h4>เลือกประเภทของโมเดล</h4>
                <select id="car-type" name="model_type">
                    <!-- ตัวเลือกจะถูกเพิ่มโดย JavaScript -->
                </select>
                <h4>เบอร์โทรติดต่อกลับ</h4>
                <input type="text" class="Tel" name="Tel" pattern="[0][8-9][0-9]{8}" required>
                
                <input type="submit" class="btn btn-primary" name="submit_testdrive" value="ส่ง" pattern="[0-9]{10}" style="margin-top: 20px;">
            </form>
        </div>
    </div>
</body>


<script>
        // รายการของโมเดลรถและประเภทของโมเดล
        const carModels = {
            model3: ["Model 3", "Model 3 Long Range", "Model 3 Performance"],
    
            modely: ["Model Y", "Model Y Long Range", "Model Y Performance"]
          
        };

        // รับอ้างอิงถึง dropdown ทั้งสอง
        const modelDropdown = document.getElementById("car-model");
        const typeDropdown = document.getElementById("car-type");

        // เมื่อ dropdown โมเดลรถเปลี่ยน
        modelDropdown.addEventListener("change", function () {
            const selectedModel = modelDropdown.value;
            const carTypes = carModels[selectedModel];

            // เคลียร์ dropdown ประเภทของโมเดลเดิม
            typeDropdown.innerHTML = "";

            // เพิ่มตัวเลือกใหม่ใน dropdown ประเภทของโมเดล
            carTypes.forEach(function (type) {
                const option = document.createElement("option");
                option.value = type;
                option.text = type;
                typeDropdown.appendChild(option);
            });
        });

        // เรียกฟังก์ชันที่เลือกโมเดลเริ่มต้น
        modelDropdown.dispatchEvent(new Event("change"));
    </script>

</html>