<?php
    require("sqlCredentials.php");

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
    
    function validateBooking($POST_KEYS){
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
        return true;
    }

    //Unrelated Idea: Lịch khám liên quan tới bác sĩ trên giao diện BS.
    function processBooking($POST_KEYS,$mysqli) {
        $check_query = "";
        
        $stm = "";
        if ($_POST["loai_hinh"]=="ck") {
            $check_query = "SELECT LichKham.ID from LichKham WHERE ID_ChuyenKhoa = ? AND KhungGio = ? AND NgayKham = ?;";

            $stm = $mysqli->prepare($check_query);
            $stm->bind_param("sis",$_POST["ck"],$_POST["khung_gio"],$_POST["ngay_kham"]);
        } elseif ($_POST["loai_hinh"]=="cg") {
            $check_query = "SELECT LichKham.ID from LichKham WHERE ID_ChuyenKhoa = ? AND ID_BacSi = ? AND KhungGio = ? AND NgayKham = ?;";

            $stm = $mysqli->prepare($check_query);
            $stm->bind_param("siis",$_POST["ck"],$_POST["cg"],$_POST["khung_gio"],$_POST["ngay_kham"]);
        }
        if ($stm->execute()) {
            $check_result = $stm->get_result();
            if ($check_result->num_rows>0){
                return [false,"Lịch không còn trống!"];
            }
            $stm2 = $mysqli->prepare("INSERT INTO LichKham(ID_BacSi,ID_BenhNhan,ID_ChuyenKhoa,ID_TrangThai,KhungGio,LyDoKham,NgayKham) VALUES(?,?,?,?,?,?,?)");
           
            $id_cg = null;
            $id_bn = 1;
            $id_trangthai = 1;
            if ($_POST["loai_hinh"]=="cg") {
                $id_cg = $_POST["cg"];
            }

            //Replace third argument with session-logged UserId later on.
            $stm2->bind_param("iisiiss",$id_cg,$id_bn,$_POST["ck"],$id_trangthai,$_POST["khung_gio"],$_POST["ly_do_kham"],$_POST["ngay_kham"]);
            if ($stm2->execute()) {
                //Đặt lịch khám thành công.
            } else {
                die("Error while inserting data: $stm2->error");
            }
        } else {
            die("Error: $stm->error");
            exit;
        }
    }
    if (validateBooking($POST_KEYS)) {
        $query_result = processBooking($POST_KEYS,$mysqli);
    }
?>