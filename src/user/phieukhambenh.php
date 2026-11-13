<?php

    include_once "../server/scripts/initSession.php";

    if (!isset($_SESSION["ID_TaiKhoan"])){
        header("Location: dangnhap.php");
    }
   if (!isset($_GET["id"])) {
        exit("No ID specified.");
    }

    include_once("../server/scripts/sqlCredentials.php");
    $mysqli = new mysqli($hostname,$username,$password);
    $mysqli->select_db("htdlkbtt");

    $stm = $mysqli->prepare("SELECT LichKham.ID as ID, NgayKham, ThongTinTaiKhoan.HoTen as BacSi, KhungGio.Gio_BD, KhungGio.Gio_KT, ChuyenKhoa.TenChuyenKhoa as ChuyenKhoa, LichKham.LyDoKham FROM LichKham,ChuyenKhoa,ThongTinTaiKhoan,BacSi,KhungGio
    WHERE ((LichKham.ID_BenhNhan = ?) OR (LichKham.ID_BacSi = ? AND BacSi.ID = LichKham.ID_BacSi)) AND (LichKham.ID = ?) AND (LichKham.ID_BacSi = BacSi.ID AND BacSi.ID = ThongTinTaiKhoan.ID) AND (LichKham.ID_ChuyenKhoa = ChuyenKhoa.ID) AND (LichKham.KhungGio = KhungGio.ID);");
    $stm->bind_param("iii",$_SESSION["ID_TaiKhoan"],$_SESSION["ID_TaiKhoan"],$_GET["id"]);

    $result = "";
    if ($stm->execute()) {
        $result = $stm->get_result();
        if ($result->num_rows<=0) {
            //TODO: Send user back to the viewing page.
            die("You don't have permission to view this.");
        }
        $result = $result->fetch_assoc();
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
                    <form id="adjust_form" class="main_form">
                        <label for="emailtk" id="label_email">
                                Mã phiếu <p class="red_required">*</p>
                        </label>
                        <br>
                        <input class="input_text" type="email" name="emailtk" id="input_email" required>
                        <br>

                        <label for="emailtk" id="label_email">
                                Chuyên khoa <p class="red_required">*</p>
                        </label>
                        <br>
                        <input class="input_text" type="email" name="emailtk" id="input_email" required>
                        <br>

                        <label for="emailtk" id="label_email">
                                Chuyên gia <p class="red_required">*</p>
                        </label>
                        <br>
                        <input class="input_text" type="email" name="emailtk" id="input_email" required>
                        <br>

                        <label for="emailtk" id="label_email">
                                Ngày khám <p class="red_required">*</p>
                        </label>
                        <br>
                        <input class="input_text" type="email" name="emailtk" id="input_email" required>
                        <br>

                        <label for="emailtk" id="label_email">
                                Khung giờ dự kiến <p class="red_required">*</p>
                        </label>
                        <br>
                        <input class="input_text" type="email" name="emailtk" id="input_email" required>
                        <br>

                    </form>
                    <div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Mã phiếu: </b></h3>
                            <p class="info_content"><?php echo $result["ID"]; ?></p>
                        </div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Chuyên khoa: </b></h3>
                            <p class="info_content"><?php echo $result["ChuyenKhoa"]; ?></p>
                        </div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Chuyên gia lựa chọn: </b></h3>
                            <p class="info_content"><?php echo $result["BacSi"]; ?></p>
                        </div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Ngày khám: </b></h3>
                            <p class="info_content"><?php echo $result["NgayKham"]; ?></p>
                        </div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Khung giờ dự kiến: </b></h3>
                            <p class="info_content"><?php $gio_bd = $result["Gio_BD"]; $gio_kt = $result["Gio_KT"]; echo "$gio_bd-$gio_kt"; ?></p>
                        </div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Lý do khám: </b></h3>
                            <p class="info_content"><?php echo $result["LyDoKham"]; ?></p>
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