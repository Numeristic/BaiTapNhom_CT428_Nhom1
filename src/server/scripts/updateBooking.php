<?php
    require_once "sqlCredentials.php";
    require_once "initSession.php";
    require_once "loggedInFunc.php";

    $mysqli = new mysqli($hostname,$username,$password);
    $mysqli->select_db("htdlkbtt");

    $POST_KEYS = [
        "maphieu",
        "ck",
        "cg",
        "ngay_kham",
        "khung_gio",
        "lydokham"
    ];

    function validate($POST_KEYS){
        $returned_value = true;
        for ($x=0;$x<count($POST_KEYS);$x++){
            if (!isset($_POST[$POST_KEYS[$x]])) {
                echo $POST_KEYS[$x]."\n";
                $returned_value = false;
            }
        }
        return $returned_value;
    }

    function verify_user_has_access($POST_KEYS,$mysqli){
        $stm = $mysqli->prepare("SELECT DISTINCT LichKham.ID, LichKham.ID_BenhNhan, LichKham.ID_BacSi FROM LichKham,BacSi WHERE (LichKham.ID = ?) AND ((LichKham.ID_BenhNhan = ?) OR (LichKham.ID_BacSi = ? AND LichKham.ID_BacSi = BacSi.ID));");
        $stm->bind_param("iii",$_POST["maphieu"],$_SESSION["ID_TaiKhoan"],$_SESSION["ID_TaiKhoan"]);
        
        if ($stm->execute()) {
            $result = $stm->get_result();
            return $result->num_rows>0;
        } else {
            echo "\n$stm->error";
            return false;
        }
    }
    
    function verify_inputs($mysqli){
        $stm = "";
        if ($_POST["cg"]!="") {
            $query = "SELECT LichLamViec.ID_KhungGio
            FROM ChuyenKhoa,BacSi,LichLamViec 
            WHERE BacSi.ID = ? AND BacSi.ID_ChuyenKhoa = ChuyenKhoa.ID AND ChuyenKhoa.ID = ? AND BacSi.ID = LichLamViec.ID_BacSi AND LichLamViec.ID_KhungGio = ?;";
            $stm = $mysqli->prepare($query);
            $stm->bind_param("isi",$_POST["cg"],$_POST["ck"],$_POST["khung_gio"]);
        } else {
            $query = "SELECT DISTINCT LichLamViec.ID_KhungGio
            FROM ChuyenKhoa,BacSi,LichLamViec 
            WHERE BacSi.ID_ChuyenKhoa = ChuyenKhoa.ID AND ChuyenKhoa.ID = ? AND BacSi.ID = LichLamViec.ID_BacSi AND LichLamViec.ID_KhungGio = ?;";
            $stm = $mysqli->prepare($query);
            $stm->bind_param("si",$_POST["ck"],$_POST["khung_gio"]);
        }
       
        if (!$stm->execute()) {
            $_SESSION["alertMessage"] = "Lỗi CSDL! $stm->error";
            header("Location: ../../user/phieukhambenh.php?id=$maphieu");
            exit;
        }
        $input_result = $stm->get_result();

        if ($input_result->num_rows<=0) {
            return false;
        }
        return true;
    }

    function update_pkb($POST_KEYS,$mysqli) {
        $stm = "";
        $check_stm = "";

        $cg_val = $_POST["cg"];
        if ($cg_val==""){
            $cg_val = null;
        }

        if ($cg_val!=null) {
            $check_stm = $mysqli->prepare("SELECT LichKham.ID from LichKham WHERE ID_ChuyenKhoa = ? AND ID_BacSi = ? AND KhungGio = ? AND NgayKham = ?;");
            $check_stm->bind_param("siis",$_POST["ck"],$_POST["cg"],$_POST["khung_gio"],$_POST["ngay_kham"]);
        } else {
            $check_stm = $mysqli->prepare("SELECT LichKham.ID from LichKham WHERE ID_ChuyenKhoa = ? AND KhungGio = ? AND NgayKham = ?;");
            $check_stm->bind_param("sis",$_POST["ck"],$_POST["khung_gio"],$_POST["ngay_kham"]);
        }

        if ($_SESSION["Admin"]>0 && isset($_POST["tt"])) {
            $stm = $mysqli->prepare("UPDATE LichKham
            SET KhungGio = ?, NgayKham = ?, LyDoKham = ?, ID_TrangThai = ?, ID_BacSi = ?, ID_ChuyenKhoa = ?
            WHERE ID = ?");
            $stm->bind_param("issiisi",$_POST["khung_gio"],$_POST["ngay_kham"],$_POST["lydokham"],$_POST["tt"],$cg_val,$_POST["ck"],$_POST["maphieu"]);
        } else {
            $stm = $mysqli->prepare("UPDATE LichKham
            SET KhungGio = ?, NgayKham = ?, LyDoKham = ?, ID_BacSi = ?, ID_ChuyenKhoa = ?
            WHERE ID = ?");
            $stm->bind_param("issisi",$_POST["khung_gio"],$_POST["ngay_kham"],$_POST["lydokham"],$cg_val,$_POST["ck"],$_POST["maphieu"]);
        }

        if (!$check_stm->execute()) {
            $_SESSION["alertMessage"] = "Lỗi truy vấn CSDL.\n$stm->error";
            header("Location: ../../user/phieukhambenh.php?id=$maphieu");
            exit;
        }
        

        if ($stm->execute()) {
            $_SESSION["alertMessage"] = "Cập nhật thành công.";
            $maphieu = $_POST["maphieu"];
            header("Location: ../../user/phieukhambenh.php?id=$maphieu");
        } else {
            $_SESSION["alertMessage"] = "Lỗi truy vấn CSDL.\n$stm->error";
            $maphieu = $_POST["maphieu"];
            header("Location: ../../user/phieukhambenh.php?id=$maphieu");
        }
    }

    $has_all_keys = validate($POST_KEYS);
    $logged_in = is_logged_in($SESSION_KEYS);
    $verified = verify_user_has_access($POST_KEYS,$mysqli);
    $input_verified = verify_inputs($mysqli);

    if ($has_all_keys && $logged_in && $verified && $input_verified) {
        update_pkb($POST_KEYS,$mysqli);
    } else {
        
        $error_msg = "Đã gặp các lỗi:";
        if (!$has_all_keys) {
            $error_msg = "$error_msg\nLỗi đầu vào!";
        } elseif (!$logged_in) {
            $error_msg = "$error_msg\nBạn chưa đăng nhập vào tài khoản nào cả!";
        } elseif (!$verified) {
            $error_msg = "$error_msg\nBạn không có quyền cập nhật thông tin phiếu này!";
        } elseif (!$input_verified){ 
            $error_msg = "$error_msg\nDữ liệu đầu vào không hợp lệ.";
        }
        
        $_SESSION["alertMessage"] = $error_msg;
        $maphieu = $_POST["maphieu"];
        header("Location: ../../user/phieukhambenh.php?id=$maphieu");
        echo $error_msg;
    }
?>