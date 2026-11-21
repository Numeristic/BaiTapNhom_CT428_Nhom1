<?php
    require_once("../server/scripts/sqlCredentials.php");
    require_once("../server/scripts/loggedInFunc.php");
    require_once("../server/scripts/initSession.php");
    require_once("../server/scripts/alert.php");

    $load_id = 0;
    $logged_in = is_logged_in($SESSION_KEYS);

    if (!isset($_GET["id"])) {
        if (!$logged_in) {
            $_SESSION["alertMessage"] = "Bạn chưa đăng nhập.";
            header("Location: dangnhap.php");
            exit;
        }
        $load_id = $_SESSION["ID_TaiKhoan"];
    } else {
        $load_id = $_GET["id"];
    }

    $idtk = "";
    $is_admin = "";
    $is_bs = "";
    if ($load_id != $_SESSION["ID_TaiKhoan"]) {
        if ($logged_in) {
            $query = "SELECT ThongTinTaiKhoan.ID AS ID,COUNT(BacSi.ID) as LaBacSi,COUNT(QuanLy.ID) as LaQuanLy FROM ThongTinTaiKhoan,BacSi,QuanLy 
            LEFT JOIN BacSi ON BacSi.ID = ThongTinTaiKhoan.ID
            LEFT JOIN QuanLy ON QuanLy.ID = ThongTinTaiKhoan.ID
            WHERE ThongTinTaiKhoan.ID = ?";
            $stm = $mysqli->prepare($query);
            $stm->bind_param("i",$load_id);

            if ($stm->execute()) {
                $data_result = $stm->get_result();
                if ($data_result->num_rows<=0) {
                    $_SESSION["alertMessage"] = "Tài khoản không tồn tại!";
                    exit;
                }
                $data_result = $data_result->fetch_assoc();

                $idtk = $data_result["ID"];
                $is_admin = $data_result["LaQuanLy"];
                $is_bs = $data_result["LaBacSi"];

                if ($data_result["LaBacSi"]<=0 && ($_SESSION["BacSi"]<=0 && $_SESSION["Admin"]<=0)) {
                    //Bệnh nhân không được xem thông tin của bệnh nhân khác. Chỉ có thể xem của Bác Sĩ.
                    //Bác sĩ và Admin có thể xem thông tin của bệnh nhân. Riêng Admin và bệnh nhân đó thì được chỉnh sửa.
                    $_SESSION["alertMessage"] = "Bạn không có quyền xem thông tin tài khoản này!";
                    header("Location: ../../index.php");
                    exit;
                }
            }
        }
    } else {
        //Tất nhiên là mình được phép xem thông tin của chính mình.
        $idtk = $_SESSION["ID_TaiKhoan"];
        $is_admin = $_SESSION["Admin"];
        $is_bs = $_SESSION["BacSi"];
    }
?>
<html>
    <head>
        <?php
            include '../server/stylesheets.php';
            include_once '../server/scripts/alert.php';
            include_once '../server/scripts/initSession.php';
        ?>
        <script src="../client/scripts/changepassword.js" defer></script>
    </head>
    <body>
        <?php
            include '../server/templates/header.php'
        ?>
        <main>
            <div id="flex_div1">
                <div class="empty"></div>
                <div id="login_panel">
                    <h2><b>Đổi mật khẩu</b></h2>
                    <div>
                        <form action="../server/scripts/changePassword.php" class="main_form" id="main_form" name="main_form" method="post">
                            <label for="id_tk" id="label_idtk">
                                ID Tài Khoản <p class="red_required">*</p>
                            </label>
                            <br>
                            <input class="input_text" type="number" name="id_tk" id="input_idtk" value=<?php echo $idtk; ?> disabled>
                            <input class="input_text" type="number" name="idtk" id="input_idtk" value=<?php echo $idtk; ?> hidden>
                            <br>


                            <label for="oldmk" id="label_oldmk">
                                Mật khẩu cũ <p class="red_required">*</p>
                            </label>
                            <br>
                            <input class="input_text" type="password" name="oldmk" id="input_oldmk" required>
                            <br>

                            <label for="mk" id="label_mk">
                                Mật khẩu mới <p class="red_required">*</p>
                            </label>
                            <br>
                            <input class="input_text" type="password" name="mk" id="input_mk" required>
                            <br>

                            <label for="rptmk" id="label_rptmk">
                                Lặp lại mật khẩu mới <p class="red_required">*</p>
                            </label>
                            <br>
                            <input class="input_text" type="password" name="rptmk" id="input_rptmk" required>
                            <br>


                            <div id="form_step_finish" class="form_footer">
                                <input id="login_button" for="main_form" type="submit" value="Đổi mật khẩu" class="form_button_container">
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