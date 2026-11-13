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
                        <label for="maphieu" id="label_email">
                                Mã phiếu <p class="red_required">*</p>
                        </label>
                        <br>
                        <input class="input_text" type="text" name="maphieu" id="input_email" required>
                        <br>

                        <label for="ck" id="label_email">
                                Chuyên khoa <p class="red_required">*</p>
                        </label>
                        <br>
                        <select id="ck_selection" name="ck" class="input_text" required>
                            <?php 
                                require_once("../server/scripts/loadCk.php");
                            ?>
                        </select>
                        <br>

                        <label for="cg" id="label_email">
                                Chuyên gia <p class="red_required">*</p>
                        </label>
                        <br>
                        <select name="cg" class="input_text" id="prof_selection">
                                        
                        </select>
                        <br>

                        <label for="ngay_kham" id="label_email">
                                Ngày khám <p class="red_required">*</p>
                        </label>
                        <br>
                        <input class="input_text" type="date" name="ngay_kham" id="input_email" required>
                        <br>

                        <label for="khung_gio" id="label_email">
                                Khung giờ dự kiến <p class="red_required">*</p>
                        </label>
                        <br>
                        <div id="timeslots_container">
                            <div id="morning_container">
                                <p><i>Sáng</i></p>

                                <input type="radio" value="time_id1" name="khung_gio" id="timeslot_id1">
                                <label for="timeslot_id1">07:00-08:00</label>

                                <br>
                                <input type="radio" value="time_id2" name="khung_gio" id="timeslot_id2">
                                <label for="timeslot_id2">08:00-09:00</label>

                                <br>
                                <input type="radio" value="time_id3" name="khung_gio" id="timeslot_id3">
                                <label for="timeslot_id2">09:00-10:00</label>

                                <br>
                                <input type="radio" value="time_id4" name="khung_gio" id="timeslot_id4">
                                <label for="timeslot_id2">10:00-11:00</label>

                                <br>
                                <input type="radio" value="time_id5" name="khung_gio" id="timeslot_id5">
                                <label for="timeslot_id2">11:00-12:00</label>
                            </div>
                            <div id="night_container">
                                <p><i>Chiều</i></p>

                                <input type="radio" value="time_id1" name="khung_gio" id="timeslot_id6">
                                <label for="timeslot_id1">13:30-14:00</label>

                                <br>
                                <input type="radio" value="time_id2" name="khung_gio" id="timeslot_id7">
                                <label for="timeslot_id2">14:00-15:00</label>

                                <br>
                                <input type="radio" value="time_id3" name="khung_gio" id="timeslot_id8">
                                <label for="timeslot_id2">15:00-16:00</label>

                                <br>
                                <input type="radio" value="time_id4" name="khung_gio" id="timeslot_id9">
                                <label for="timeslot_id2">16:00-17:00</label>
                            </div>
                        </div>
                        <br>

                        <label for="lydokham" id="label_email">
                                Lý do khám <p class="red_required">*</p>
                        </label>
                        <br>
                        <textarea name="lydokham" class="input_text" type="text" id="lydokham" placeholder="Hãy ghi thêm thông tin về triệu chứng để bác sĩ có thể chẩn đoán hiệu quả hơn"></textarea>
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