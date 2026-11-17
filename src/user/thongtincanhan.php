<?php

    require_once("../server/scripts/sqlCredentials.php");
    require_once("../server/scripts/loggedInFunc.php");
    require_once("../server/scripts/initSession.php");


    $load_id = 0;
    $logged_in = is_logged_in($SESSION_KEYS);

    if (!$logged_in) {
        $_SESSION["alertMessage"] = "Bạn chưa đăng nhập.";
        header("Location: dangnhap.php");
        exit;
    }

    if (!isset($_GET["id"])) {
        $load_id = $_SESSION["ID_TaiKhoan"];
    } else {
        $load_id = $_GET["id"];
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

    $data_result = [];
    
    if ($load_id != $_SESSION["ID_TaiKhoan"]) {
        $query = "SELECT ThongTinTaiKhoan.ID AS ID,ThongTinTaiKhoan.HoTen,ThongTinTaiKhoan.SoCCCD,COUNT(BacSi.ID) as LaBacSi,COUNT(QuanLy.ID) as LaQuanLy, BacSi.ID_ChuyenKhoa as ID_ChuyenKhoa, ThongTinTaiKhoan.SoCCCD as SoCCCD, ThongTinTaiKhoan.NgaySinh as NgaySinh FROM ThongTinTaiKhoan 
        LEFT JOIN BacSi ON BacSi.ID = ThongTinTaiKhoan.ID
        LEFT JOIN QuanLy ON QuanLy.ID = ThongTinTaiKhoan.ID
        WHERE ThongTinTaiKhoan.ID = ?";
        $stm = $mysqli->prepare($query);
        $stm->bind_param("i",$load_id);

        if ($stm->execute()) {
            $data_result = $stm->get_result();
            $data_result = $data_result->fetch_assoc();
            
            if ($data_result["ID"]==null) {
                $_SESSION["alertMessage"] = "Tài khoản không tồn tại!";
                header("Location: ../../index.php");
                exit;
            }
            
            /*$idtk = $data_result["ID"];
            $hoten = $data_result["HoTen"];
            $socccd = $data_result["SoCCCD"];
            $ngaysinh = $data_result["NgaySinh"];
            $is_admin = $data_result["LaQuanLy"];
            $is_bs = $data_result["LaBacSi"];
            $id_ck = $data_result["ID_ChuyenKhoa"];*/

            if ($data_result["LaBacSi"]<=0 && ($_SESSION["BacSi"]<=0 && $_SESSION["Admin"]<=0)) {
                //Bệnh nhân không được xem thông tin của bệnh nhân khác. Chỉ có thể xem của Bác Sĩ.
                //Bác sĩ và Admin có thể xem thông tin của bệnh nhân. Riêng Admin và bệnh nhân đó thì được chỉnh sửa.
                $_SESSION["alertMessage"] = "Bạn không có quyền xem thông tin tài khoản này!";
                header("Location: ../../index.php");
                exit;
            }
        }
    } else {
        //Tất nhiên là mình được phép xem thông tin của chính mình.
        $data_result["ID"] = $_SESSION["ID_TaiKhoan"];
        $data_result["HoTen"] = $_SESSION["HoTen"];
        $data_result["SoCCCD"] = $_SESSION["SoCCCD"];
        $data_result["NgaySinh"] = $_SESSION["NgaySinh"];
        $data_result["LaQuanLy"] = $_SESSION["Admin"];
        $data_result["LaBacSi"] = $_SESSION["BacSi"];
        $data_result["ID_ChuyenKhoa"] = $_SESSION["ChuyenKhoa"];
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
                        include_once "../server/templates/update_user_info_form.php";
                    }
                    
                    ?>
                    <div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Mã người dùng: </b></h3>
                            <p class="info_content"><?php echo $data_result["ID"]; ?></p>
                        </div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Họ tên: </b></h3>
                            <p class="info_content"><?php echo $data_result["HoTen"]; ?></p>
                        </div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Ngày sinh: </b></h3>
                            <p class="info_content"><?php echo $data_result["NgaySinh"]; ?></p>
                        </div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Số CCCD: </b></h3>
                            <p class="info_content"><?php echo $data_result["SoCCCD"]; ?></p>
                        </div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Mật khẩu: </b></h3>
                            <p>••••••••••</p>
                        </div>
                    </div>
                    <?php
                        if ($data_result["LaBacSi"]>0){
                            echo "<h2><b>Thông tin bác sĩ</b></h2>
                            <div>
                                <div class=\"info_container\">
                                    <h3 class=\"info_title\"><b>Chuyên khoa: ".$data_result["ID_ChuyenKhoa"]."</b></h3>
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