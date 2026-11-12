<?php

    if (!isset($_SESSION["ID_TaiKhoan"])){
        header("Location: dangnhap.php");
    }
   if (!isset($_GET["id"])) {
        exit("No ID specified.");
    }

    include_once("../server/scripts/sqlCredentials.php");
    $mysqli = new mysqli($hostname,$username,$password);
    $mysqli->select_db("htdlkbtt");

    $stm = $mysqli->prepare("SELECT * FROM BenhNhan, BacSi, LichKham
    WHERE ((BenhNhan.ID = ? AND BenhNhan.ID = LichKham.ID_BenhNhan) OR (BacSi.ID = ? AND BacSi.ID = LichKham.ID_BacSi) OR (QuanLy.ID = ?)) AND (LichKham.ID = ?)");
    $stm->bind_param("iiii",$_SESSION["ID_TaiKhoan"],$_SESSION["ID_TaiKhoan"],$_SESSION["ID_TaiKhoan"],$_GET["id"]);

    $result = "";
    if ($stm->execute()) {
        $result = $stm->get_result();
        $result = $result->fetch_assoc();

        if ($result->num_rows<=0) {
            die("You don't have permission to view this.");
        }
    } else {
        die("Error: $stm->error");
    }
?>
<html>
    <head>
        <?php
            include '../server/stylesheets.php'
        ?>
        <link rel="stylesheet" href="../server/styles/booking_info_extra.css">
    </head>
    <body>
        <?php
            include '../server/templates/header.php'
        ?>
        <?php
            //PHP code embed here.
        
        ?>
        <main>
            <div id="flex_div1">
                <div class="empty"></div>
                <div id="login_panel">
                    <h2><b>Phiếu khám bệnh</b></h2>
                    <div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Mã phiếu: </b></h3>
                            <p class="info_content"><?php echo $result["ID"]; ?></p>
                        </div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Chuyên khoa: </b></h3>
                            <p class="info_content"><?php echo $result["ID_ChuyenKhoa"]; ?></p>
                        </div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Chuyên gia lựa chọn: </b></h3>
                            <p class="info_content"><?php echo $result["ID_BacSi"]; ?></p>
                        </div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Ngày khám: </b></h3>
                            <p class="info_content"><?php echo $result["NgayKham"]; ?></p>
                        </div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Khung giờ dự kiến: </b></h3>
                            <p class="info_content"><?php echo $result["KhungGio"]; ?></p>
                        </div>
                    </div>
                </div>
                <div class="empty"></div>
            </div>
        </main>
        <?php
            include '../server/templates/footer.php'
        ?>
    </body>
</html>