<form action="../server/scripts/updateBooking.php" method="post" id="adjust_form" class="main_form">
    <label for="maphieu_fake" id="label_maphieu">
            Mã phiếu <p class="red_required">*</p>
    </label>
    <br>
    <input class="input_text" type="text" name="maphieu_fake" id="input_maphieu" value=<?php $id = $data_result["ID"]; echo "\"$id\""; ?> required disabled>
    <input type="hidden" name="maphieu" value=<?php $id = $data_result["ID"]; echo "\"$id\""; ?>>
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
        <option value="">Trống (Khám theo chuyên khoa)</option>
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

    <?php 
    
        if ($_SESSION["Admin"]>0) {
            require_once("../server/templates/updateBookingInfoAdminOnly.php");
        }

    ?>

    <div id="form_step_finish" class="form_footer">
        <input id="login_button" for="main_form" type="submit" value="Cập nhật" class="form_button_container">
        <div id="return_button2" class="form_button_container"><button id="rbutton2" type="button" class="form_button">Bỏ thay đổi</button></div>
    </div>
</form>