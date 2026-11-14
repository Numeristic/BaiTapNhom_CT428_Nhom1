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

    $stm = $mysqli->prepare("SELECT LichKham.ID as ID, NgayKham, ThongTinTaiKhoan.HoTen as BacSi, ThongTinTaiKhoan.ID as ID_BacSi, KhungGio.ID as ID_KhungGio, KhungGio.Gio_BD, KhungGio.Gio_KT, ChuyenKhoa.TenChuyenKhoa as ChuyenKhoa, ChuyenKhoa.ID as ID_ChuyenKhoa, LichKham.LyDoKham FROM LichKham,ChuyenKhoa,ThongTinTaiKhoan,BacSi,KhungGio
    WHERE ((LichKham.ID_BenhNhan = ?) OR (LichKham.ID_BacSi = ? AND BacSi.ID = LichKham.ID_BacSi)) AND (LichKham.ID = ?) AND (LichKham.ID_BacSi = BacSi.ID AND BacSi.ID = ThongTinTaiKhoan.ID) AND (LichKham.ID_ChuyenKhoa = ChuyenKhoa.ID) AND (LichKham.KhungGio = KhungGio.ID);");
    $stm->bind_param("iii",$_SESSION["ID_TaiKhoan"],$_SESSION["ID_TaiKhoan"],$_GET["id"]);

    $data_result = "";
    if ($stm->execute()) {
        $data_result = $stm->get_result();
        if ($data_result->num_rows<=0) {
            //TODO: Send user back to the viewing page.
            die("You don't have permission to view this.");
        }
        $data_result = $data_result->fetch_assoc();
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
        <script src="../client/scripts/phieukhambenh.js" defer></script>
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
                        <label for="maphieu" id="label_maphieu">
                                Mã phiếu <p class="red_required">*</p>
                        </label>
                        <br>
                        <input class="input_text" type="text" name="maphieu" id="input_maphieu" value=<?php $id = $data_result["ID"]; echo "\"$id\""; ?> required disabled>
                        <br>

                        <label for="ck" id="label_ck">
                                Chuyên khoa <p class="red_required">*</p>
                        </label>
                        <br>
                        <select id="input_ck" name="ck" class="input_text" required>
                            <?php 
                                require_once("../server/norun/loadCk2.php");
                            ?>
                        </select>
                        <br>

                        <label for="cg" id="label_cg">
                            Chuyên gia <p class="red_required">*</p>
                        </label>
                        <br>
                        <select name="cg" class="input_text" id="input_cg">
                            <?php 
                                $id_ck = $data_result["ID_ChuyenKhoa"];
                                require_once("../server/norun/updateExpertsInfo2.php");
                            ?>
                        </select>
                        <br>

                        <label for="ngay_kham" id="label_ngaykham">
                                Ngày khám <p class="red_required">*</p>
                        </label>
                        <br>
                        <input class="input_text" type="date" name="ngay_kham" id="input_ngaykham" value=<?php $ngay_kham = $data_result["NgayKham"]; echo "\"$ngay_kham\""; ?> required>
                        <br>

                        <label for="khung_gio" id="label_khunggio">
                                Khung giờ dự kiến <p class="red_required">*</p>
                        </label>
                        <br>
                        <div id="timeslots_container">
                            <?php 
                                $id_cg = $data_result["ID_BacSi"];
                                require_once("../server/norun/loadTimeSlots2.php");
                            ?>
                        </div>
                        <br>

                        <label for="lydokham" id="label_lydokham">
                                Lý do khám <p class="red_required">*</p>
                        </label>
                        <br>
                        <textarea name="lydokham" class="input_text" type="text" id="input_lydokham" placeholder="Hãy ghi thêm thông tin về triệu chứng để bác sĩ có thể chẩn đoán hiệu quả hơn"; ?><?php echo $data_result["LyDoKham"]; ?></textarea>
                        <br>

                        <div id="form_step_proceed" class="form_footer">
                            <div id="proceed_button" class="form_button_container"><button id="pbutton" type="button" class="form_button">Cập nhật</button></div>
                            <div id="return_button" class="form_button_container"><button id="rbutton" type="button" class="form_button">Đặt lại</button></div>
                        </div>
                    </form>
                    <div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Mã phiếu: </b></h3>
                            <p class="info_content"><?php echo $data_result["ID"]; ?></p>
                        </div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Chuyên khoa: </b></h3>
                            <p class="info_content"><?php echo $data_result["ChuyenKhoa"]; ?></p>
                        </div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Chuyên gia lựa chọn: </b></h3>
                            <p class="info_content"><?php echo $data_result["BacSi"]; ?></p>
                        </div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Ngày khám: </b></h3>
                            <p class="info_content"><?php echo $data_result["NgayKham"]; ?></p>
                        </div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Khung giờ dự kiến: </b></h3>
                            <p class="info_content"><?php $gio_bd = $data_result["Gio_BD"]; $gio_kt = $data_result["Gio_KT"]; echo "$gio_bd-$gio_kt"; ?></p>
                        </div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Lý do khám: </b></h3>
                            <p class="info_content"><?php echo $data_result["LyDoKham"]; ?></p>
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