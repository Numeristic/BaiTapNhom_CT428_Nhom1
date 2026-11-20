<?php
    require_once("src/server/scripts/sqlCredentials.php");
    require_once("src/server/scripts/initSessionSpecial.php");

    $name = "Khách";
    if (isset($_SESSION["HoTen"])) {
        $name = $_SESSION["HoTen"];
    }

    $title =  "Bệnh nhân";
    $ck = "";
    if (isset($_SESSION["BacSi"]) && $_SESSION["BacSi"]>0) {
        $title = "Bác sĩ";
        if (isset($_SESSION["ChuyenKhoa"]) && $_SESSION["ChuyenKhoa"]!="") {
            $ck_stm = $mysqli->prepare("SELECT * FROM ChuyenKhoa WHERE ID = ?");
            $ck_stm->bind_param("s",$_SESSION["ChuyenKhoa"]);
            if (!$ck_stm->execute()) {
                alert("Đã lỗi khi load chuyên khoa cá nhân.\n\n$ck_stm->error");
            }

            $ck_result = $ck_stm->get_result();
            if ($ck_result->num_rows<=0){
                $ck = "Chuyên khoa: Không xác định";
            } else {
                $ck_result = $ck_result->fetch_assoc();
                $ck = "Chuyên khoa: ".$ck_result["TenChuyenKhoa"];
            } 
        }
    }

    if (isset($_SESSION["Admin"]) && $_SESSION["Admin"]>0) {
        $title = $title." (Admin)";
    }

   

?>
<header class="headerwall">
    <div id="icon"><img src="img/stethoscope.png"></div>
    <div id="title"><h1>Hệ thống đặt lịch phòng khám</h1></div>
    <nav id="navbar">
        <div class="action_button"><a href="index.php">Trang chủ</a></div>
        <?php
        
        if (isset($_SESSION["ID_TaiKhoan"]) && $_SESSION["ID_TaiKhoan"]!=0){
            echo "<div class=\"action_button\"><a href=\"src/user/xemyeucaukham.php\">Xem lịch khám</a></div>
            <div class=\"action_button\"><a href=\"src/user/datlichkham.php\">Đặt lịch khám</a></div>
            <div class=\"action_button\"><a href=\"src/user/thongtincanhan.php\">Thông tin cá nhân</a></div>";
        }
        
        ?>
        
    </nav>
    <div id="account_info_icon">
        <img src="img/profile_picture_default.png" id="user_profile_picture">
        <p id="user_name"><b><?php echo $name; ?></b></p>
        <p id="user_title"><?php echo $title; ?></p>
        <p id="user_specialization"><?php echo $ck; ?></p>
    </div>
    <div id="account_actions">
        <?php

            if (isset($_SESSION["ID_TaiKhoan"]) && $_SESSION["ID_TaiKhoan"]!=0){
                echo "<div class=\"action_button\"><a href=\"src/user/dangxuat.php\">Đăng xuất</a></div>";
            } else {
                echo "<div class=\"action_button\"><a href=\"src/user/dangnhap.php\">Đăng nhập</a></div>
                <div class=\"action_button\"><a href=\"src/user/dangky.php\">Đăng ký</a></div>";
            }

        ?>
    </div>
</header>