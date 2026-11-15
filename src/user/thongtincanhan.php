<?php

    require_once("../server/scripts/sqlCredentials.php");
    require_once("../server/scripts/loggedInFunc.php");
    require_once("../server/scripts/initSession.php");
    require_once("../server/scripts/alert.php");

    if (!is_logged_in($SESSION_KEYS)) {
        $_SESSION["alertMessage"] = "Bạn chưa đăng nhập.";
        header("Location: dangnhap.php");
        exit;
    }

    $mysqli = new mysqli($hostname,$username,$password);
    $mysqli->select_db("htdlkbtt");

    /*$stm = $mysqli->prepare("SELECT ThongTinTaiKhoan.ID AS ID,ThongTinTaiKhoan.HoTen,ThongTinTaiKhoan.SoCCCD,COUNT(BacSi.ID) AS LaBacSi, COUNT(QuanLy.ID) AS LaQuanLy FROM ThongTinTaiKhoan,BacSi,QuanLy WHERE (ThongTinTaiKhoan.Email = ?) AND BacSi.ID = ThongTinTaiKhoan.ID AND QuanLy.ID = ThongTinTaiKhoan.ID GROUP BY ThongTinTaiKhoan.ID;");*/
?>
<html>
    <head>
        <?php
            include '../server/stylesheets.php'
        ?>
    </head>
    <body>
        <?php
            include '../server/templates/header.php'
        ?>
        <link rel="stylesheet" href="../server/styles/booking_info_extra.css">
        <main>
            <div id="flex_div1">
                <div class="empty"></div>
                <div id="login_panel">
                    <h2><b>Thông tin cá nhân</b></h2>
                    <form action="../server/scripts/updateBooking.php" method="post" id="adjust_form" class="main_form">
                        

                        <div id="form_step_finish" class="form_footer">
                            <input id="login_button" for="main_form" type="submit" value="Cập nhật" class="form_button_container">
                            <div id="return_button2" class="form_button_container"><button id="rbutton2" type="button" class="form_button">Bỏ thay đổi</button></div>
                        </div>
                    </form>
                    <div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Mã người dùng: </b></h3>
                            <p class="info_content"><?php echo $_SESSION["ID_TaiKhoan"]; ?></p>
                        </div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Họ tên: </b></h3>
                            <p class="info_content"><?php echo $_SESSION["HoTen"]; ?></p>
                        </div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Ngày sinh: </b></h3>
                            <p class="info_content"><?php echo $data_result["BacSi"]; ?></p>
                        </div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Số CCCD: </b></h3>
                            <p class="info_content"><?php echo $data_result["NgayKham"]; ?></p>
                        </div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Mật khẩu: </b></h3>
                            <p class="info_content"><?php $gio_bd = $data_result["Gio_BD"]; $gio_kt = $data_result["Gio_KT"]; echo "$gio_bd-$gio_kt"; ?></p>
                        </div>
                    </div>
                    <h2><b>Thông tin bác sĩ</b></h2>
                    <div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Chuyên khoa: </b></h3>
                            <p class="info_content"><?php echo $data_result["ID"]; ?></p>
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