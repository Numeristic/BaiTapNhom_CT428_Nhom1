<?php

    include_once "../server/scripts/initSession.php";

    if (!isset($_SESSION["ID_TaiKhoan"])){
        header("Location: dangnhap.php");
    }
   if (!isset($_GET["id"])) {
        exit("No ID specified.");
    }

    include_once("../server/scripts/sqlCredentials.php");
    $mysqli = new mysqli($hostname,$username,$password);
    $mysqli->select_db("htdlkbtt");

    $stm = "";
    if ($_SESSION["Admin"]<=0) {
        $stm = $mysqli->prepare("SELECT DISTINCT LichKham.ID as ID, LichKham.ID_BenhNhan, TrangThai.ID AS ID_TrangThai, TrangThai.TenTrangThai, NgayKham, bs.HoTen as BacSi, bs.ID as ID_BacSi, bn.HoTen as BenhNhan, bn.ID as ID_BenhNhan, KhungGio.ID as ID_KhungGio, KhungGio.Gio_BD, KhungGio.Gio_KT, ChuyenKhoa.TenChuyenKhoa as ChuyenKhoa, ChuyenKhoa.ID as ID_ChuyenKhoa, LichKham.LyDoKham FROM
        LichKham
        LEFT JOIN ChuyenKhoa ON LichKham.ID_ChuyenKhoa = ChuyenKhoa.ID
        LEFT JOIN BacSi ON LichKham.ID_BacSi = BacSi.ID
        LEFT JOIN ThongTinTaiKhoan bs ON LichKham.ID_BacSi = bs.ID
        LEFT JOIN ThongTinTaiKhoan bn ON LichKham.ID_BenhNhan = bn.ID
        LEFT JOIN KhungGio ON LichKham.KhungGio = KhungGio.ID
        LEFT JOIN TrangThai ON LichKham.ID_TrangThai = TrangThai.ID
        WHERE LichKham.ID = ? AND (LichKham.ID_BenhNhan=? OR (LichKham.ID_BacSi=? OR (LichKham.ID_BacSi IS NULL AND LichKham.ID_ChuyenKhoa = ?)));");
        $stm->bind_param("iiis",$_GET["id"],$_SESSION["ID_TaiKhoan"],$_SESSION["ID_TaiKhoan"],$_SESSION["ChuyenKhoa"]);
    } else {
        $stm = $mysqli->prepare("SELECT DISTINCT LichKham.ID as ID, LichKham.ID_BenhNhan, TrangThai.ID AS ID_TrangThai, TrangThai.TenTrangThai, NgayKham, bs.HoTen as BacSi, bs.ID as ID_BacSi, bn.HoTen as BenhNhan, bn.ID as ID_BenhNhan, KhungGio.ID as ID_KhungGio, KhungGio.Gio_BD, KhungGio.Gio_KT, ChuyenKhoa.TenChuyenKhoa as ChuyenKhoa, ChuyenKhoa.ID as ID_ChuyenKhoa, LichKham.LyDoKham FROM
        LichKham
        LEFT JOIN ChuyenKhoa ON LichKham.ID_ChuyenKhoa = ChuyenKhoa.ID
        LEFT JOIN BacSi ON LichKham.ID_BacSi = BacSi.ID
        LEFT JOIN ThongTinTaiKhoan bs ON LichKham.ID_BacSi = bs.ID
        LEFT JOIN ThongTinTaiKhoan bn ON LichKham.ID_BenhNhan = bn.ID
        LEFT JOIN KhungGio ON LichKham.KhungGio = KhungGio.ID
        LEFT JOIN TrangThai ON LichKham.ID_TrangThai = TrangThai.ID
        WHERE LichKham.ID = ?;");
        $stm->bind_param("i",$_GET["id"]);
    }
    

    $data_result = "";
    if ($stm->execute()) {
        $data_result = $stm->get_result();
        if ($data_result->num_rows<=0) {
            //TODO: Send user back to the viewing page.
            //die("You don't have permission to view this.");
            $_SESSION["alertMessage"] = "Phiếu khám bệnh không tồn tại hoặc bạn không có quyền xem.";
            header("Location: xemyeucaukham.php");
            exit;
        }
        $data_result = $data_result->fetch_assoc();
    } else {
        $_SESSION["alertMessage"] = "Error: $stm->error";
        exit;
    }
?>
<html>
    <head>
        <?php
            include '../server/stylesheets.php';
            include_once '../server/scripts/alert.php';
        ?>
        <link rel="stylesheet" href="../server/styles/booking_info_extra.css">
        <script src="../client/scripts/phieukhambenh.js" defer></script>
    </head>
    <body>
        <?php
            include '../server/templates/header.php';
        ?>
        <?php
            //PHP code embed here.
        
        ?>
        <main>
            <div id="flex_div1">
                <div class="empty"></div>
                
                <div id="login_panel">
                    <h2><b>Phiếu khám bệnh</b></h2>
                    <?php 
                        require_once("../server/templates/update_booking_info_form.php");
                    ?>
                    <div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Mã phiếu: </b></h3>
                            <p class="info_content"><?php echo $data_result["ID"]; ?></p>
                        </div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Tên bệnh nhân: </b></h3>
                            <p class="info_content"><?php echo $data_result["BenhNhan"]; ?></p>
                        </div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Chuyên khoa: </b></h3>
                            <p class="info_content"><?php echo $data_result["ChuyenKhoa"]; ?></p>
                        </div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Chuyên gia lựa chọn: </b></h3>
                            <p class="info_content"><?php echo $data_result["BacSi"]; ?></p>
                        </div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Ngày khám: </b></h3>
                            <p class="info_content"><?php echo $data_result["NgayKham"]; ?></p>
                        </div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Khung giờ dự kiến: </b></h3>
                            <p class="info_content"><?php $gio_bd = $data_result["Gio_BD"]; $gio_kt = $data_result["Gio_KT"]; echo "$gio_bd-$gio_kt"; ?></p>
                        </div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Lý do khám: </b></h3>
                            <p class="info_content"><?php echo $data_result["LyDoKham"]; ?></p>
                        </div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Trạng thái: </b></h3>
                            <p class="info_content"><?php echo $data_result["TenTrangThai"]; ?></p>
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