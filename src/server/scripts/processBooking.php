<?php
    require("sqlCredentials.php");
    require("loggedInFunc.php");
    require("initSession.php");

    $mysqli = new mysqli($hostname,$username,$password);
    $mysqli->select_db("htdlkbtt");

    if ($mysqli->connect_errno) {
        exit;
    }

    $POST_KEYS = [
        //"ho_ten",
        //"so_cccd",
        "loai_hinh",
        "ck",
        "cg",
        "ly_do_kham",
        "ngay_kham",
        "khung_gio"
    ];

    if (!is_logged_in($SESSION_KEYS)) {
        $_SESSION["alertMessage"] = "Bạn cần phải đăng nhập để sử dụng chức năng này!";
        header("Location: ../../../index.php");
        exit;
    }
    
    function validateBooking($POST_KEYS,$mysqli){

        if ($_POST["loai_hinh"]=="cg"&&!isset($_POST["cg"])) {
            return false;
        }
        for ($x=0;$x<count($POST_KEYS);$x++){
            if ($POST_KEYS[$x]=="cg" || $POST_KEYS[$x]=="ly_do_kham") {
                continue;
            }
            if (!isset($_POST[$POST_KEYS[$x]])) {
                return false;
            }
            if ($POST_KEYS[$x]=="loai_hinh" && $_POST[$POST_KEYS[$x]]=="cg" && !isset($_POST["cg"])) {
                return false;
            }
        }

        $query = "SELECT BacSi.ID FROM BacSi,KhungGio,LichLamViec 
        WHERE KhungGio.ID = ? AND BacSi.ID_ChuyenKhoa = ? AND BacSi.ID = LichLamViec.ID_BacSi AND KhungGio.ID = LichLamViec.ID_KhungGio";
        $params = "is";
        $arguments = [$_POST["khung_gio"],$_POST["ck"]];

        $available_time_stm = $mysqli->prepare($query);
        $available_time_stm->bind_param($params,...$arguments);

        if (!$available_time_stm->execute()) {
            $_SESSION["alertMessage"] = "Lỗi CSDL! $available_time_stm->error";
            return false;
        }
        $available_result = $available_time_stm->get_result();
        if ($available_result->num_rows<=0) {
            $_SESSION["alertMessage"] = "Không có bác sĩ nào khả dụng ở khung giờ này! Có thể lịch làm việc vừa được cập nhật.";
            return false;
        }

        
        if ($_POST["loai_hinh"]=="cg") {
            $found_cg = false;
            while ($row = $available_result->fetch_assoc()) {
                if ($row["ID"] == $_POST["cg"]) {
                    $found_cg = true;
                } 
            }
            if (!$found_cg) {
                $_SESSION["alertMessage"] = "Bác sĩ không khả dụng ở khung giờ này nữa. Có thể lịch làm việc vừa được cập nhật.";
                return false;
            }
        }

        return $available_result->num_rows;
    }

    function processBooking($POST_KEYS,$mysqli,$limit) {
        $stm = "";

        $check_query = "SELECT LichKham.ID, LichKham.ID_BacSi from LichKham WHERE ID_ChuyenKhoa = ? AND KhungGio = ? AND NgayKham = ?;";
        $stm = $mysqli->prepare($check_query);
        $stm->bind_param("sis",$_POST["ck"],$_POST["khung_gio"],$_POST["ngay_kham"]);

        if ($stm->execute()) {

            $check_result = $stm->get_result();

            //Nếu số lượng lịch khám trong thời điểm đó vượt quá giới hạn đã được tính
            //-> Không tạo lịch khám vì lịch không còn trống.

            //Có dấu bằng vì tạo lịch sẽ thêm một phiếu mới.
            $cg_available = true;
            if ($_POST["loai_hinh"]=="cg") {
                $found_cg = false;
                while ($row = $check_result->fetch_assoc()) {
                    if ($row["ID_BacSi"]==$_POST["cg"]) {
                        $found_cg = true;
                        break;
                    }
                }
                $cg_available = !$found_cg;
            }

            if ($check_result->num_rows>=$limit || !$cg_available) {
                $_SESSION["alertMessage"] = "Lịch không còn trống!";
                header("Location: ../../user/datlichkham.php?");
                exit;
            }

            $stm2 = $mysqli->prepare("INSERT INTO LichKham(ID_BacSi,ID_BenhNhan,ID_ChuyenKhoa,ID_TrangThai,KhungGio,LyDoKham,NgayKham) VALUES(?,?,?,?,?,?,?)");
           
            
            $id_bn = $_SESSION["ID_TaiKhoan"];
            $id_trangthai = 1;

            $id_cg = null;
            if ($_POST["loai_hinh"]=="cg") {
                $id_cg = $_POST["cg"];
            }

            $stm2->bind_param("iisiiss",$id_cg,$id_bn,$_POST["ck"],$id_trangthai,$_POST["khung_gio"],$_POST["ly_do_kham"],$_POST["ngay_kham"]);
            if ($stm2->execute()) {
                //Đặt lịch khám thành công.
                $_SESSION["alertMessage"] = "Đặt lịch khám thành công!";
                header("Location: ../../user/phieukhambenh.php?id=$stm2->insert_id");
            } else {
                $_SESSION["alertMessage"] = "Lỗi CSDL! $stm2->error";
                header("Location: ../../user/datlichkham.php");
                exit;
            }

        } else {

            $_SESSION["alertMessage"] = "Lỗi CSDL! $stm->error";
            header("Location: ../../user/datlichkham.php");
            exit;

        }
    }

    $limit = validateBooking($POST_KEYS,$mysqli);
    if ($limit!=false) {
        $query_result = processBooking($POST_KEYS,$mysqli,$limit);
    } else {
        header("Location: ../../user/datlichkham.php?");
    }
?>