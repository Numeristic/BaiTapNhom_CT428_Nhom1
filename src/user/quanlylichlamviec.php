<html>
    <head>
        <?php
            include_once '../server/stylesheets.php';
            include_once '../server/scripts/alert.php';
            require_once "../server/scripts/loggedInFunc.php";
            require_once "../server/scripts/sqlCredentials.php";
            include_once '../server/scripts/initSession.php';

            if (!is_logged_in($SESSION_KEYS)) {
                $_SESSION["alertMessage"] = "Bạn chưa đăng nhập!";
                header("Location: dangnhap.php");
            }

            $load_id = 0;
            if (isset($_GET["id"])) {
                $load_id = $_GET["id"];
            } else {
                /*$_SESSION["alertMessage"] = "Lỗi đầu vào.";
                header("Location: ../../index.php");*/
                $load_id = $_SESSION["ID_TaiKhoan"];
            }

            if ($_SESSION["Admin"]<=0 && $load_id!=$_SESSION["ID_TaiKhoan"]) {
                $_SESSION["alertMessage"] = "Bạn cần có quyền quản trị để xem trang này.";
                header("Location: ../../index.php");
            }

            $mysqli = new mysqli($hostname,$username,$password);
            $mysqli->select_db("htdlkbtt");

            $check_stm = $mysqli->prepare("SELECT ThongTinTaiKhoan.HoTen FROM BacSi,ThongTinTaiKhoan WHERE BacSi.ID = ? AND BacSi.ID = ThongTinTaiKhoan.ID");
            $check_stm->bind_param("i",$load_id);

            if (!$check_stm->execute()) { 
                $_SESSION["alertMessage"] = "Lỗi CSDL! $check_stm->error";
                header("Location: ../../index.php");
            }

            $bs_info_result = $check_stm->get_result();
            $ht_bs = "";

            if ($bs_info_result->num_rows>0){
                $bs_info_result = $bs_info_result->fetch_assoc();
                $ht_bs = $bs_info_result["HoTen"];   
            }

            $stm = $mysqli->prepare("SELECT LichLamViec.ID_BacSi, LichLamViec.ID_KhungGio FROM LichLamViec, BacSi WHERE ID_BacSi = ? AND ID_BacSi = BacSi.ID");
            $stm->bind_param("i",$load_id);

            if (!$stm->execute()) {
                $_SESSION["alertMessage"] = "Lỗi CSDL! $stm->error";
                header("Location: ../../index.php");
            }
            $result = $stm->get_result();

            $khung_gio = [];

            if ($result->num_rows>0) {
                while ($row=$result->fetch_assoc()) {
                    $khung_gio[] = $row["ID_KhungGio"];
                }
            }

        ?>
        <link rel="stylesheet" href="../server/styles/booking_info_extra.css">
        <script src="" defer></script>
    </head>
    <body>
        <?php
            include_once '../server/templates/header.php';
        ?>
        <?php
            //PHP code embed here.
        
        ?>
        <main>
            <div id="flex_div1">
                <div class="empty"></div>
                <div id="login_panel">
                    <h2><b>Lịch làm việc</b></h2>
                    <div>
                        <form action="../server/scripts/updateWorkTimes.php" class="main_form" id="main_form" name="main_form" method="post">
                            <label for="idtk" id="label_idtkfake">
                                ID Bác Sĩ
                            </label>
                            <br>
                            <input class="input_text" type="number" name="idtk" id="input_idtkfake" value="<?php echo $load_id; ?>" disabled>
                            <input class="input_text" type="number" name="id" id="input_idtk" value="<?php echo $load_id; ?>" hidden>
                            <br>

                            <label for="hoten_bs" id="label_hotenbs">
                                Họ tên
                            </label>
                            <br>
                            <input class="input_text" type="text" name="hoten_bs" id="input_hotenbs" value="<?php echo $ht_bs; ?>" disabled>

                            <label id="label_khunggio">
                                Khung giờ làm việc
                            </label>
                            <div class="khung_gio_list">

                                <?php
                                    require_once('../server/norun/loadAllTimeSlots.php');
                                ?>


                            </div>

                            <div id="form_step_finish" class="form_footer">
                                <input id="login_button" for="main_form" type="submit" value="Cập nhật" class="form_button_container">
                                <div id="return_button2" class="form_button_container"><button id="rbutton2" type="button" class="form_button">Bỏ thay đổi</button></div>
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