<form action="../server/scripts/updateUserInfo.php" id="main_form" method="post" id="adjust_form" class="main_form">
    <label for="id_tk">Mã tài khoản:</label>
    <br>
    <input name="id_tk" id="input_idtk" type="number" value=<?php echo $idtk; ?> class="input_text" disabled>
    <input name="idtk" type="hidden" value=<?php echo $idtk; ?>>
    <br>

    <label for="hoten">Họ tên:</label>
    <br>
    <input name="hoten" id="input_hoten" type="text" value="<?php echo $hoten; ?>" class="input_text">
    <br>

    <label for="socccd">Số CCCD:</label>
    <br>
    <input name="socccd" id="input_socccd" type="number" value=<?php echo $socccd ?> class="input_text">
    <br>

    <label for="ngaysinh">Số CCCD:</label>
    <br>
    <input name="ngaysinh" id="input_ngaysinh" type="date" value=<?php echo $ngaysinh ?> class="input_text">
    <br>

    <label for="mk">Mật khẩu:</label>
    <br>
    <input name="mk" type="button" value="Đổi mật khẩu">
    <br>
    <?php 
        //If the user is an admin then let they change the doctor's ChuyenKhoa, and permission levels as well.
        if ($_SESSION["Admin"]>0) {
            require_once("../server/templates/updateUserInfoAdminOnly.php");
        }
    ?>

    <div id="form_step_finish" class="form_footer">
        <input id="login_button" for="main_form" type="submit" value="Cập nhật" class="form_button_container">
        <div id="return_button2" class="form_button_container"><button id="rbutton2" type="button" class="form_button">Bỏ thay đổi</button></div>
    </div>
</form>