<?php

    require_once("../server/scripts/sqlCredentials.php");
    require_once("../server/scripts/loggedInFunc.php");
    require_once("../server/scripts/initSession.php");


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

    $mysqli = new mysqli($hostname,$username,$password);
    $mysqli->select_db("htdlkbtt");

    $idtk = "";
    $hoten = "";
    $socccd = "";
    $ngaysinh = "";
    $is_admin = "";
    $is_bs = "";
    
    if ($load_id != $_SESSION["ID_TaiKhoan"]) {
        if ($logged_in) {
            $query = "SELECT ThongTinTaiKhoan.ID AS ID,ThongTinTaiKhoan.HoTen,ThongTinTaiKhoan.SoCCCD,COUNT(BacSi.ID) as LaBacSi,COUNT(QuanLy.ID) as LaQuanLy, BacSi.ID_ChuyenKhoa as ID_ChuyenKhoa, ThongTinTaiKhoan.SoCCCD as SoCCCD, ThongTinTaiKhoan.NgaySinh as NgaySinh FROM ThongTinTaiKhoan 
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
                $hoten = $data_result["HoTen"];
                $socccd = $data_result["SoCCCD"];
                $ngaysinh = $data_result["NgaySinh"];
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
        $hoten = $_SESSION["HoTen"];
        $socccd = $_SESSION["SoCCCD"];
        $ngaysinh = $_SESSION["NgaySinh"];
        $is_admin = $_SESSION["Admin"];
        $is_bs = $_SESSION["BacSi"];
    }
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
                    <h2><b>Thông tin cá nhân</b></h2>
                    <?php 
                    
                    if ($load_id == $_SESSION["ID_TaiKhoan"] || $_SESSION["Admin"]>0) {
                        include_once "../server/templates/updateUserInfoEditForm.php";
                    }
                    
                    ?>
                    <div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Mã người dùng: </b></h3>
                            <p class="info_content"><?php echo $idtk; ?></p>
                        </div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Họ tên: </b></h3>
                            <p class="info_content"><?php echo $hoten; ?></p>
                        </div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Ngày sinh: </b></h3>
                            <p class="info_content"><?php echo $ngaysinh; ?></p>
                        </div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Số CCCD: </b></h3>
                            <p class="info_content"><?php echo $socccd; ?></p>
                        </div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Mật khẩu: </b></h3>
                            <p>••••••••••</p>
                        </div>
                    </div>
                    <?php
                        if ($is_admin>0){
                            echo "<h2><b>Thông tin bác sĩ</b></h2>
                            <div>
                                <div class=\"info_container\">
                                    <h3 class=\"info_title\"><b>Chuyên khoa: </b></h3>
                                    <p class=\"info_content\"></p>
                                </div>
                            </div>";
                        }
                    ?>
                    
                </div>
                <div class="empty"></div>
            </div>
        </main>
        <?php
            include '../server/templates/footer.php'
        ?>
    </body>
</html>