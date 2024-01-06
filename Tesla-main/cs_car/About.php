<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เกี่ยวกับเรา</title>
    <link rel="stylesheet" href="./css/about.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

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
    <section>
        <main>
            <img src="image\About\About.jpg">
            <div class="about-text">
                <h1>เกี่ยวกับเรา</h1>
                <p>เราคือเว็บไซต์ที่มุ่งมั่นในการให้บริการการซื้อขายรถมือหนึ่งและมือสองที่มีคุณภาพสูง ทางทีมงานของเรามีประสบการณ์และความเชี่ยวชาญในวงการนี้ ซึ่งเป็นการรับรองว่าทุกรถที่เราเสนอได้ผ่านการตรวจสอบและมีคุณภาพที่น่าเชื่อถือ ทั้งนี้เพื่อให้ลูกค้าทุกท่านมั่นใจในการทำธุรกรรมกับเรา ที่เรามุ่งมั่นคือการเป็นที่เชื่อถือและเป็นเสถียรที่สุดในการซื้อขายรถมือหนึ่งและมือสองออนไลน์</p>
                <a href="./EV Charging.php"><button>ค้นหาห้าง</button></a>
                <a href="./maintenance.php"><button>สถานนีซ่อมรถไฟฟ้า</button></a>
            </div>
        </main>ห
    </section>
</body>

</html>