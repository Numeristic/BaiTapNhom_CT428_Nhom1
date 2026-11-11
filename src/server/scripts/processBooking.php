<?php
    require("sqlCredentials.php");

    $mysqli = new mysqli($hostname,$username,$password);

    $GET_KEYS = [
        "ho_ten",
        "so_cccd",
        "loai_hinh",
        "ck",
        "cg",
        "ly_do_kham",
        "ngay_kham",
        "khung_gio"
    ]
    
    function validateBooking($GET_KEYS){
        if ($_POST["loai_hinh"]=="cg"&&!isset($_POST["cg"])) {
            return false;
        }
        for ($x=0;$x<count($GET_KEYS);$x++){
            if ($GET_KEYS[$x]=="cg" || $GET_KEYS[$x]=="ly_do_kham") {
                continue;
            }
            if (!isset($_POST[$GET_KEYS[$x]])) {
                return false;
            }
            if ($GET_KEYS[$x]=="loai_hinh" && $_POST[$GET_KEYS[$x]]=="cg" && !isset($_POST["cg"])) {
                return false;
            }
        }
        return true;
    }

    //Unrelated Idea: Lịch khám liên quan tới bác sĩ trên giao diện BS.
    function processBooking($mysqli) {
        $check_query = "";
        
        $stm = "";
        if ($_POST["loai_hinh"]=="ck") {
            $check_query = "SELECT LichKham.ID from LichKham WHERE ID_ChuyenKhoa = ? AND KhungGio = ? AND NgayKham = ?;";

            $stm = $mysqli->prepare($check_query);
            $stm->bind_param("sis",$_POST["ck"],$_POST["khung_gio"],$_POST["ngay_kham"]);
        } elseif ($_POST["loai_hinh"]=="cg") {
            $check_query = "SELECT LichKham.ID from LichKham WHERE ID_ChuyenKhoa = ? AND ID_BacSi = ? AND KhungGio = ? AND NgayKham = ?;";

            $stm = $mysqli->prepare($check_query);
            $stm->bind_param("ssis",$_POST["ck"],$_POST["cg"],$_POST["khung_gio"],$_POST["ngay_kham"]);
        }
        if ($stm->execute()) {
            $check_result = $stm->get_result();
            if ($check_result->num_rows>0){
                return false,"Lịch không còn trống!";
            }
            $stm2 = $mysqli->prepare("INSERT INTO LichKham(ID,ID_BacSi,ID_BenhNhan,ID_ChuyenKhoa,ID_TrangThai,KhungGio,LyDoKham,NgayKham) VALUES(?,?,?,?,?,?,?,?)");
            $stm2->bind_param("");
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
    if (validateBooking($GET_KEYS)) {
        $query_result, $query_err = processBooking($GET_KEYS,$mysqli);
    }
?>