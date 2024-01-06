<?php
session_start();
require_once 'config/db.php';


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Design Your Model 3</title>
    <link rel="stylesheet" href="./css/model3.css">
</head>

<nav>
    <?php
    if (isset($_SESSION['admin_login'])) {
        include("./navAdmin.php");
    } else if (isset($_SESSION['user_login'])) {
        $user_id = $_SESSION['user_login'];
        include("./nav.php");
    } else {
        include("./nav.php");
    }
    ?>
</nav>

<body>
    <div class="pc">
        <br><br>
        <div class="container">
            <section class="left-section">
                <div class="pic">
                    <img src="image/pic/black/md3-B-18-B-1.jpg" style="width:100%" id="image">
                    <div class="picbutton">
                        <button class="arrow-button" onclick="changepic(-1)">&#9664;</button>
                        <button class="arrow-button" onclick="changepic(1)">&#9654;</button>
                    </div>
                    <div class="footer">
                        <h3 id="price">฿1,599,000</h3>
                    </div>
                </div>


            </section>

            <section class="right-section">
                <form action="./db/purchases_summary.php?modeltype=model3" method="post">
                    <div class="box1">
                        <h1>Model 3</h1>
                        <div class="spec_car">
                            <ol class="specbox">
                                <li id="range" value="513">
                                    <div>
                                        <span>513</span>
                                        <span>กม</span>
                                    </div>
                                    <span class="test">
                                        <span>ช่วงระยะ</span>
                                        <div>
                                            <span>(มาตรฐาน WLTP)</span>
                                        </div>
                                    </span>
                                </li>
                                <li id="top_speed" value="201">
                                    <div>
                                        <span>201</span>
                                        <span>กม./ชม.</span>
                                    </div>
                                    <span class="test">
                                        <span>ความเร็วสูงสุด</span>
                                    </span>
                                </li>
                                <li id="acc" value="6.1">
                                    <div>
                                        <span>6.1</span>
                                        <span>วินาที</span>
                                    </div>
                                    <span class="test">
                                        <span>0-100 กม./ชม.</span>
                                    </span>
                                </li>
                            </ol>
                        </div>

                        <div class="bt">
                            <div class="bt1">
                                <input type="radio" value="RWD" name="model" checked="" onchange="changeStatus(this.value)">
                                <label>Model 3</label>
                            </div>

                            <div class="bt2">
                                <input type="radio" value="LR" name="model" onchange="changeStatus(this.value)">
                                <label>Model 3 Long Range</label>
                            </div>
                        </div>

                    </div>
                    <hr>

                    <div class="box2">
                        <h1 id="paint">Color</h1>
                        <div class="bt">
                            <div class="bt1">
                                <input id="PAINT1" type="radio" name="PAINT" value="black" onchange="changeimage(this.value, document.querySelector('input[name=\'wheel\']:checked').value, document.querySelector('input[name=\'interior\']:checked').value)" checked="">
                                <label>black</label><br>
                            </div>

                            <div class="bt2">
                                <input id="PAINT2" type="radio" name="PAINT" value="white" onchange="changeimage(this.value, document.querySelector('input[name=\'wheel\']:checked').value, document.querySelector('input[name=\'interior\']:checked').value)">
                                <label>white</label><br>
                            </div>

                            <div class="bt3">
                                <input id="PAINT3" type="radio" name="PAINT" value="blue" onchange="changeimage(this.value, document.querySelector('input[name=\'wheel\']:checked').value, document.querySelector('input[name=\'interior\']:checked').value)">
                                <label>blue</label><br>
                            </div>

                            <div class="bt4">
                                <input id="PAINT4" type="radio" name="PAINT" value="grey" onchange="changeimage(this.value, document.querySelector('input[name=\'wheel\']:checked').value, document.querySelector('input[name=\'interior\']:checked').value)">
                                <label>grey</label><br>
                            </div>

                            <div class="bt5">
                                <input id="PAINT5" type="radio" name="PAINT" value="red" onchange="changeimage(this.value, document.querySelector('input[name=\'wheel\']:checked').value, document.querySelector('input[name=\'interior\']:checked').value)">
                                <label>red</label><br>
                            </div>
                        </div>

                    </div>

                    <hr>

                    <div class="box3">
                        <div class="boxheader">
                            <h1>wheel</h1>
                        </div>

                        <h2 class="bt" id="wheel"></h2>
                        <div class="bt">
                            <div class="bt bt1">
                                <input type="radio" name="wheel" value="18" checked onchange="changeimage(document.querySelector('input[name=\'PAINT\']:checked').value, this.value, document.querySelector('input[name=\'interior\']:checked').value)">
                                <label>18’’ Photon Wheels</label><br>
                            </div>

                            <div class="bt bt2">
                                <input type="radio" name="wheel" value="19" onchange="changeimage(document.querySelector('input[name=\'PAINT\']:checked').value, this.value, document.querySelector('input[name=\'interior\']:checked').value)">
                                <label>19’’ Nova Wheels</label><br>
                            </div>

                        </div>

                    </div>

                    <hr>

                    <div class="box4">
                        <div class="boxheader">
                            <h1> Interior </h1>
                        </div>

                        <div class="bt">
                            <div class="bt1">
                                <input type="radio" name="interior" value="black" onchange="changeimage(document.querySelector('input[name=\'PAINT\']:checked').value, document.querySelector('input[name=\'wheel\']:checked').value, this.value)" checked>
                                <label>black</label>
                            </div>

                            <div class="bt2">
                                <input type="radio" name="interior" value="white" onchange="changeimage(document.querySelector('input[name=\'PAINT\']:checked').value, document.querySelector('input[name=\'wheel\']:checked').value, this.value)">
                                <label>white</label>
                            </div>

                        </div>

                    </div>
                    <hr>
                    <div class="box5">
                        <div class='boxheader'>
                            <h1 id="detial">black 18 black</h1>
                            <h1>Enhanced Autopilot</h1>
                            <h4>฿122,000<br></h4>
                        </div>
                        <div class='boxdetail'>
                            <ul>
                                <li>
                                    <span>Navigate on Autopilot</span>
                                </li>
                                <li>
                                    <span>Auto Lane Change</span>
                                </li>
                            </ul>
                        </div>
                        <div class='boxdetail'>
                            <h4>Upcoming:</h4>
                            <ul>
                                <li>
                                    <span>Autopark</span>
                                </li>
                                <li>
                                    <span>Summon</span>
                                </li>
                                <li>
                                    <span>Smart Summon</span>
                                </li>
                            </ul>
                        </div>
                        <div class='bt'>
                            <input id="ADD_EA" name="EA" type="button" value="ADD" onclick="ADD(this.name)">
                        </div>
                    </div>
                    <hr>
                    <div class="box6">
                        <div class='boxheader'>
                            <h1>Full Self-Driving Capability</h1>
                            <h4>฿244,000<br></h4>
                        </div>
                        <div class='boxdetail'>
                            <ul>
                                <li>All functionality of Basic Autopilot and Enhanced Autopilot</li>
                            </ul>
                        </div>
                        <div class="boxdetail">
                            Upcoming:
                            <ul>
                                <li>Traffic Light and Stop Sign Control</li>
                                <li>Autosteer on city streets</li>
                            </ul>
                        </div>

                        <div class='bt'>
                            <input id="ADD_FSD" name="FSD" type="button" value="ADD" onclick="ADD(this.name)">
                        </div>
                        <hr>
                        <br>
                        <input type="hidden" name="software" id="software" value="">

                        <?php
                        if (isset($_SESSION['user_login'])) {
                            $check_data = $conn->prepare("SELECT Tel, firstname FROM users INNER JOIN tesdrive ON tesdrive.uid = users.uid WHERE users.uid = :uid");
                            $check_data->bindParam(":uid", $user_id);
                            $check_data->execute();
                            $row = $check_data->fetch(PDO::FETCH_ASSOC);
                            if ($check_data->rowCount() <= 0) { ?>
                                <h3>ข้อมูลการติดต่อ</h3>
                                <label>Tel Number:</label>
                                <input type="text" pattern="[\d]{10}" name="Tel"><br><br>
                                <hr>
                        <?php }
                        }
                        ?>
                        <div class="submitbuy">
                            <input id="submitbuy" name='submitbuy' type="submit" value="สั่งซื้อ" onclick="updateSoftwareField()">
                        </div>
                        <br><br>
                    </div>
                    <br>
                </form>
            </section>

        </div>
    </div>

    <div id="mobile">
        <br>
        <img src="image/pic/black/md3-B-18-B-1.jpg" style="width:100%" id="image1">
        <h3 id="pricemo">฿1,599,000</h3>
        <hr>
        <section class="right-section">
            <br><br>
            <div class="box1">
                <h1>Model 3</h1>
                <div class="spec_car">
                    <ol class="specbox">
                        <li id="range" value="513">
                            <div>
                                <span>513</span>
                                <span>กม</span>
                            </div>
                            <span class="test">
                                <span>ช่วงระยะ</span>
                                <div>
                                    <span>(มาตรฐาน WLTP)</span>
                                </div>
                            </span>
                        </li>
                        <li id="top_speed" value="201">
                            <div>
                                <span>201</span>
                                <span>กม./ชม.</span>
                            </div>
                            <span class="test">
                                <span>ความเร็วสูงสุด</span>
                            </span>
                        </li>
                        <li id="acc" value="6.1">
                            <div>
                                <span>6.1</span>
                                <span>วินาที</span>
                            </div>
                            <span class="test">
                                <span>0-100 กม./ชม.</span>
                            </span>
                            </ul>

                </div>

                <div class="specbox">
                    <div class="mini">
                        <div class="bt1">
                            <input type="radio" value="RWD" name="modelmo" checked="" onchange="changeStatus(this.value)">
                            <label>Model 3</label>
                        </div>
                        <div class="bt2">
                            <input type="radio" value="Long Range" name="modelmo" onchange="changeStatus(this.value)">
                            <label>Model 3 Long Range</label>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>
    <hr>

    <div class="box2">
        <img src="image/pic/black/md3-B-18-B-2.jpg" style="width:100%" id="image2">
        <h1 id="paint">Color</h1>
        <div class="specbox">
            <input id="PAINT1" type="radio" name="PAINTmo" value="black" onchange="changeimage(this.value, document.querySelector('input[name=\'wheelmo\']:checked').value, document.querySelector('input[name=\'interiormo\']:checked').value)" checked="">
            <label>black</label><br>
            <input id="PAINT2" type="radio" name="PAINTmo" value="white" onchange="changeimage(this.value, document.querySelector('input[name=\'wheelmo\']:checked').value, document.querySelector('input[name=\'interiormo\']:checked').value)">
            <label>white</label><br>
            <input id="PAINT3" type="radio" name="PAINTmo" value="blue" onchange="changeimage(this.value, document.querySelector('input[name=\'wheelmo\']:checked').value, document.querySelector('input[name=\'interiormo\']:checked').value)">
            <label>blue</label><br>
            <input id="PAINT4" type="radio" name="PAINTmo" value="grey" onchange="changeimage(this.value, document.querySelector('input[name=\'wheelmo\']:checked').value, document.querySelector('input[name=\'interiormo\']:checked').value)">
            <label>grey</label><br>
            <input id="PAINT5" type="radio" name="PAINTmo" value="red" onchange="changeimage(this.value, document.querySelector('input[name=\'wheelmo\']:checked').value, document.querySelector('input[name=\'interiormo\']:checked').value)">
            <label>red</label><br>
        </div>

        <br>
        <hr>
    </div>

    <div class="box3">
        <img src="image/pic/black/md3-B-18-B-4.jpg" style="width:100%" id="image4">
        <h1>wheel</h1>
        <div class="specbox">
            <div class="mini">
                <input type="radio" name="wheelmo" value="18" checked onchange="changeimage(document.querySelector('input[name=\'PAINTmo\']:checked').value, this.value, document.querySelector('input[name=\'interiormo\']:checked').value)">
                <label>18’’ Photon Wheels</label><br>

                <input type="radio" name="wheelmo" value="19" onchange="changeimage(document.querySelector('input[name=\'PAINTmo\']:checked').value, this.value, document.querySelector('input[name=\'interiormo\']:checked').value)">
                <label>19’’ Nova Wheels</label>
            </div>
        </div>

    </div>
    <hr>
    <div class="box4">
        <img src="image/pic/black/md3-B-18-B-5.jpg" style="width:100%" id="image5">
        <h1> Interior </h1>
        <div class="specbox">
            <div class="mini">
                <input type="radio" name="interiormo" value="black" onchange="changeimage(document.querySelector('input[name=\'PAINTmo\']:checked').value, document.querySelector('input[name=\'wheelmo\']:checked').value, this.value)" checked>
                <label>black</label>
                <input type="radio" name="interiormo" value="white" onchange="changeimage(document.querySelector('input[name=\'PAINTmo\']:checked').value, document.querySelector('input[name=\'wheelmo\']:checked').value, this.value)">
                <label>white</label>
            </div>
        </div>

        <br><br>
    </div>

    <hr>
    <div class="box4">
        <h1 id="detial">black 18 black</h1>
        <h1>Enhanced Autopilot</h1>
        <h4>฿122,000<br></h4>
        <div class="specbox">
            <div class="mini">
                <ul>
                    <li>
                        <span>Navigate on Autopilot</span>
                    </li>
                    <li>
                        <span>Auto Lane Change</span>
                    </li>
                </ul>

                <h4>Upcoming:</h4>
                <ul>
                    <li>
                        <span>Autopark</span>
                    </li>
                    <li>
                        <span>Summon</span>
                    </li>
                    <li>
                        <span>Smart Summon</span>
                    </li>
                </ul>
            </div>
        </div>

        <br>
        <input id="ADD_EA_MO" name="EA" type="button" value="ADD" onclick="ADD(this.name)">
        <br><br>
    </div>

    <hr>
    <div class="box5">
        <h1>Full Self-Driving Capability</h1>
        <h4>฿244,000<br></h4>
        <div class="specbox">
            <div class="mini">
                <ul>
                    <li>All functionality of Basic Autopilot and Enhanced Autopilot</li>
                </ul>

                Upcoming:
                <ul>
                    <li>Traffic Light and Stop Sign Control</li>
                    <li>Autosteer on city streets</li>
                </ul>
                <br><br>

                <br>
            </div>
        </div>
        <input id="ADD_FSD_MO" name="FSD" type="button" value="ADD" onclick="ADD(this.name)">
        <br><br>
        <hr><br>
        <input type="hidden" name="software" id="software" value="">

        <?php
        if (isset($_SESSION['user_login'])) {
            $check_data = $conn->prepare("SELECT Tel, firstname FROM users INNER JOIN tesdrive ON tesdrive.uid = users.uid WHERE users.uid = :uid");
            $check_data->bindParam(":uid", $user_id);
            $check_data->execute();
            $row = $check_data->fetch(PDO::FETCH_ASSOC);
            if ($check_data->rowCount() <= 0) { ?>
                <h3>ข้อมูลการติดต่อ</h3>
                <label>Tel Number:</label>
                <input type="text" pattern="[\d]{10}" name="Tel"><br><br>
                <hr>
        <?php }
        }
        ?>
        <div class="submitbuy">
            <input id="submitbuy" name='submitbuy' type="submit" value="สั่งซื้อ" onclick="updateSoftwareField()">
        </div>
        <br><br>
    </div>
    </div>


</body>

<script>
    let car_color = "black";
    let wheel_Size = "18";
    let car_interior = "black";
    let software = "no";
    let model = "RWD"
    let animationInterval;
    let animationValue = 500;
    let animationValue2 = 3.0;
    const animationSpeed = 5; // ความเร็วของอนิเมชั่น (ลองลดความเร็ว)
    let maxAnimationValue;

    function startAnimation() {
        clearInterval(animationInterval);
        animationValue2 = 0.0; // เริ่มค่า animationValue2 ที่ 0 ทุกครั้งที่เริ่มอนิเมชันใหม่
        animationInterval = setInterval(function() {
            if (animationValue < maxAnimationValue || animationValue2 < maxAnimationValue2) {
                if (animationValue < maxAnimationValue) {
                    animationValue += 1;
                    document.querySelector("#range span").innerHTML = animationValue;
                }
                if (animationValue2 < maxAnimationValue2) {
                    animationValue2 += 0.1;
                    document.querySelector("#acc span").innerHTML = animationValue2.toFixed(1);
                    console.log(animationValue2);
                }
            } else {
                // เมื่อค่าถึง 100 ให้อนิเมชันหยุด
                clearInterval(animationInterval);
            }
        }, animationSpeed);
    }

    function changeStatus(selectedModel) {
        clearInterval(animationInterval);
        startAnimation();

        if (selectedModel === 'RWD') {
            animationValue = 480;
            maxAnimationValue = 513;
            animationValue2 = 0.0; // เริ่มค่า animationValue2 ที่ 0.0 สำหรับ 'RWD'
            maxAnimationValue2 = 6.0;
            document.querySelector("#range span").innerHTML = '513';
            document.querySelector("#top_speed span").innerHTML = '201';
            document.querySelector("#acc span").innerHTML = '6.1';
            document.querySelector("#acc span").nextElementSibling.innerHTML = 'วินาที';
            model = "RWD";

        } else {
            animationValue = 590;
            maxAnimationValue = 629;
            animationValue2 = 0.0; // เริ่มค่า animationValue2 ที่ 0.0 สำหรับ 'LR'
            maxAnimationValue2 = 4.4;
            document.querySelector("#range span").innerHTML = '629';
            document.querySelector("#top_speed span").innerHTML = '201';
            document.querySelector("#acc span").innerHTML = '4.4';
            document.querySelector("#acc span").nextElementSibling.innerHTML = 'วินาที';
            model = "LR";
        }
        price();
        changepic(0);
    }


    function changeimage(color, size, interior) {
        changecolor(color);
        changewheel(size);
        changeInterior(interior);
        document.getElementById("detial").innerHTML = car_color + " " + wheel_Size + " " + car_interior;
        price()
        changepic(0)
    }

    function changecolor(color) {
        const carImages = {
            black: "black",
            white: "white",
            blue: "blue",
            grey: "grey",
            red: "red"
        };

        const carImage = document.getElementById("paint");
        carImage.innerHTML = color;
        car_color = color;
    }

    function changewheel(size) {
        const carImage = document.getElementById("wheel");
        carImage.innerHTML = size;
        wheel_Size = size;
    }

    function changeInterior(interior) {
        const interiors = {
            black: "black",
            white: "white"
        };

        car_interior = interiors[interior];
    }

    // function ADD(system) {

    //     if (software == "no") {
    //         software = system;
    //         console.log(software);
    //         document.getElementById("ADD_" + software).value = "Remove";
    //     } else if (software == "FSD") {
    //         software = "no";
    //         document.getElementById("ADD_FSD").value = "ADD";
    //     } else if (software == "EA") {
    //         software = "no";
    //         document.getElementById("ADD_EA").value = "ADD";
    //     }
    //     price()
    // }
    function ADD(system) {
        if (software === system) {
            software = "no";
            document.getElementById("ADD_" + system).value = "ADD";
            document.getElementById("ADD_" + system + "_MO").value = "ADD";
        } else if (software === "no") {
            software = system;
            document.getElementById("ADD_" + system).value = "Remove";
            document.getElementById("ADD_" + system + "_MO").value = "Remove";
        } else {
            // สลับระหว่าง "EA" และ "FSD"
            const otherSystem = (system === "EA") ? "FSD" : "EA";
            software = system;
            document.getElementById("ADD_" + system).value = "Remove";
            document.getElementById("ADD_" + system + "_MO").value = "Remove";
            document.getElementById("ADD_" + otherSystem).value = "ADD";
            document.getElementById("ADD_" + otherSystem + "_MO").value = "ADD";
        }
        price();
    }


    function updateSoftwareField() {
        document.querySelector("#software").value = software;
    }



    function price() {
        const models = {
            RWD: 1599000,
            LR: 1899000
        }
        const car_colors = {
            black: 0,
            white: 50000,
            blue: 50000,
            grey: 75000,
            red: 85000
        };
        const car_wheel = {
            18: 0,
            19: 50000
        };

        const car_interiors = {
            black: 0,
            white: 50000
        };
        const Auto_pilot = {
            no: 0,
            EA: 122000,
            FSD: 244000
        };

        const totalPrice = models[model] + car_colors[car_color] + car_wheel[wheel_Size] + car_interiors[car_interior] + Auto_pilot[software];
        let Prices = totalPrice.toLocaleString();
        // console.log(formattedNumber); // ผลลัพธ์จะเป็น "1,599,000"

        document.getElementById("price").innerHTML = "฿" + Prices;
        document.getElementById("pricemo").innerHTML = "฿" + Prices;
    }

    function changepicture() {
        const models = {
            RWD: "md3",
            LR: "md3lr"
        }
        const car_colors = {
            black: "B",
            white: "W",
            blue: "BL",
            grey: "G",
            red: "R"
        };
        const car_wheel = {
            18: "18",
            19: "19"
        };

        const car_interiors = {
            black: "B",
            white: "W"
        };
        const totalPrice = models[model] + car_colors[car_color] + car_wheel[wheel_Size] + car_interiors[car_interior]
        for (let i = 1; i < 6; i++) {
            console.log(totalPrice + i + ".jpeg")
            path = "image/" + totalPrice + i + ".jpeg"
            document.getElementById("image").src = path;
        }

    }
</script>

<script>
    let k = 1

    function changepic(n) {
        const models = {
            RWD: "md3",
            LR: "md3lr"
        }
        const car_colors = {
            black: "B",
            white: "W",
            blue: "BL",
            grey: "G",
            red: "R"
        };
        const car_wheel = {
            18: "18",
            19: "19"
        };

        const car_interiors = {
            black: "B",
            white: "W"
        };
        const pic = "md3" + "-" + car_colors[car_color] + "-" + car_wheel[wheel_Size] + "-" + car_interiors[car_interior]
        // console.log(pic + ".jpeg")

        // for (let i = 1; i <script 6; i++) {
        //     path = "image/"+"pic/"+car_color+"/"+ pic + i + ".jpeg"
        //     document.getElementById("image" + i).src = path;
        // }
        if (n == -1 && k == 1) {
            k = 5
        } else if (k == 5 && n == 1) {
            k = 1
        } else if (n == 1 || n == -1) {
            k = k + n
        } else {

        }
        // console.log(k)
        path = "image/" + "pic/" + car_color + "/" + pic + "-" + k + ".jpg"
        console.log(path)
        document.getElementById("image").src = path


    }
</script>

</html>