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
    <link rel="stylesheet" href="./css/post_create.css">
</head>
<nav>
    <?php include("./nav.php") ?>
</nav>

<body>
    <main>
    <div class="container p-5 my-5">
        <?php
        if (isset($_SESSION['user_login'])) {
            $user_id = $_SESSION['user_login'];
            $stmt = $conn->query("SELECT * FROM users WHERE uid = $user_id");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        ?>
        <h4 class="mt-4">Welcome, <?php echo $row['uid'] . ' ' . $row['firstname'] ?></h4>

        <hr>
        <div class="container">
            <form action="./db/postupload.php" method="post" enctype="multipart/form-data">
                <h4 class="mb-3">เลือกรุ่นรถของคุณ:</h4>
                <select id="car-model" name="model">
                    <option value="model3">Model 3</option>
                    <option value="modely">Model Y</option>
                    <option value="models">Model S</option>
                    <option value="modelx">Model X</option>
                </select>

                <h4 class="mb-3">เลือกประเภทของโมเดล</h4>
                <select id="car-type" name="model_type">
                    
                </select><br><br>
                
                <h4 class="bm-3">หัวข้อประกาศ</h4>
                <input type="text" name="post_header" required>
                <h4 class="mb-3">รายละเอียดรถของคุณ</h4>
                <textarea name="post_detail" placeholder="เขียนโพสต์ของคุณที่นี่" required class="form-control" required></textarea>
                <br>

                <h4 class="mb-3">สีรถของคุณ</h4>
                <select name="cars_color" id="cars">
                    <option value="Solid Black">Solid Black</option>
                    <option value="Pearl White Multi-Coat">Pearl White Multi-Coat</option>
                    <option value="Midnight Silver Metallic">Midnight Silver Metallic</option>
                    <option value="Deep Blue Metallic">Deep Blue Metallic</option>
                    <option value="Red Multi-Coat">Red Multi-Coat</option>
                    <option value="Other">Other</option>
                </select>
                <h4 class="mb-3">ปีจดทะเบียน</h4>
                <select class="form-select" id="year" name="year">
                    <option value="2007">2007</option>
                    <option value="2008">2008</option>
                    <option value="2009">2009</option>
                    <option value="2010">2010</option>
                    <option value="2011">2011</option>
                    <option value="2012">2012</option>
                    <option value="2013">2013</option>
                    <option value="2014">2014</option>
                    <option value="2015">2015</option>
                    <option value="2016">2016</option>
                    <option value="2017">2017</option>
                    <option value="2018">2018</option>
                    <option value="2019">2019</option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                </select>
 
                <h4 class="bm-3"> ราคาที่ต้องการขาย</h4><br>
                <input type="number"pattern="[\d]{0,8}" name="price" required>
                <br>
                <h4 class="mb-3">เพิ่มรูปภาพ?</h4>
                <input type="file" name="images[]" accept="image/*" multiple>
                <br>
                <br>
                <h4 class="mb-3">เบอร์โทรติดต่อ : </h4>
                <input type="text" name="tel" required>
                <br><br><h4 class="mb-3">Line : </h4>
                <input type="text" name="line" required>
                <br><br>
                <input type="submit" class="btn btn-primary" name="submit_post" value="โพสต์">
                <br><br>
            </form>
        </div>
    </div>
    </main>

</body>


<script>
        // รายการของโมเดลรถและประเภทของโมเดล
        const carModels = {
            model3: ["Model 3", "Model 3 Long Range", "Model 3 Performance"],
            models: ["Model s", "Model s Long Range", "Model s Performance"],
            modely: ["Model y", "Model y Long Range", "Model y Performance"], 
            modelx: ["Model x", "Model x Long Range", "Model x Performance"],
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