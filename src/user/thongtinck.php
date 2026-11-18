<?php

    require_once("../server/scripts/sqlCredentials.php");
    require_once("../server/scripts/loggedInFunc.php");
    require_once("../server/scripts/initSession.php");


    if (!is_logged_in($SESSION_KEYS)) {
        $_SESSION["alertMessage"] = "Bạn chưa đăng nhập!";
        header("Location: dangnhap.php");
    }
    
    if (!($_SESSION["Admin"]>0)) {
        $_SESSION["alertMessage"] = "Bạn không có quyền xem trang này!";
        header("Location: ../../index.php");
        exit;
    }

    $load_id = 0;
    if (isset($_GET["id"])) {
        $load_id = $_GET["id"];
    } else {
        
    }

    $mysqli = new mysqli($hostname,$username,$password);
    $mysqli->select_db("htdlkbtt");

    /*$idtk = "";
    $hoten = "";
    $socccd = "";
    $ngaysinh = "";
    $is_admin = "";
    $is_bs = "";
    $id_ck = "";*/

    
?>
<html>
    <head>
        <?php
            include '../server/stylesheets.php';
            require_once("../server/scripts/alert.php");
        ?>
    </head>
    <body>
        <?php
            include '../server/templates/header.php'
        ?>
        <link rel="stylesheet" href="../server/styles/booking_info_extra.css">
        <script src="../client/scripts/thongtincanhan.js" defer></script>
        <main>
            <div id="flex_div1">
                <div class="empty"></div>
                <div id="login_panel">
                    <h2><b>Thông tin chuyên khoa</b></h2>
                    <div>
                        <form action="../server/scripts/login.php" class="main_form" id="main_form" name="main_form" method="post">
                            <label for="mack" id="label_mack">
                                Mã chuyên khoa <p class="red_required">*</p>
                            </label>
                            <br>
                            <input class="input_text" type="text" name="mack" id="input_email" disabled>
                            <input class="input_text" type="hidden" name="ma_ck" id="input_email" required>
                            <br>


                            <label for="ten_ck" id="label_tenck">
                                Tên chuyên khoa <p class="red_required">*</p>
                            </label>
                            <br>
                            <input class="input_text" type="text" name="ten_ckz" id="input_tenck" required>
                            <br>


                            <div id="form_step_finish" class="form_footer">
                                <input id="login_button" for="main_form" type="submit" value="Cập nhật" class="form_button_container">
                                
                                <div id="return_button2" class="form_button_container"><button id="rbutton2" type="button" class="form_button">Bỏ thay đổi</button></div>
                            
                                <div id="return_button3" class="form_delete_container"><button id="delete_button" type="button" class="delete_button">Xóa chuyên khoa</button></div>
                            </div>
                        </form>
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