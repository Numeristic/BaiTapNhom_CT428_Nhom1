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

            if ($_SESSION["Admin"]<=0) {
                $_SESSION["alertMessage"] = "Bạn cần có quyền quản trị để xem trang này.";
                header("Location: ../../index.php");
            }

            $load_id = 0;
            if (isset($_GET["id"])) {
                $load_id = $_GET["id"];
            } else {
                $_SESSION["alertMessage"] = "Lỗi đầu vào.";
                header("Location: ../../index.php");
            }

            $mysqli = new mysqli($hostname,$username,$password);
            $mysqli->select_db("htdlkbtt");

            $stm = $mysqli->prepare("SELECT * FROM LichLamViec WHERE ID_BacSi = ?");
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
                    <h2><b>Quản lý lịch làm việc</b></h2>
                    <div>
                        <form action="../server/scripts/updateWorkTimes.php" class="main_form" id="main_form" name="main_form" method="post">
                            <label for="idtk" id="label_email">
                                ID <p class="red_required">*</p>
                            </label>
                            <br>
                            <input class="input_text" type="number" name="idtk" id="input_email" value="<?php echo $load_id; ?>" disabled>
                            <input class="input_text" type="number" name="id" id="input_email" value="<?php echo $load_id; ?>" hidden>
                            <br>

                            <label id="label_khunggio">
                                Khung giờ làm việc <p class="red_required">*</p>
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