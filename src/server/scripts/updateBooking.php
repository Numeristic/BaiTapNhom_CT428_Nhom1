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
        for ($x=0;$x<count($POST_KEYS);$x++){
            if (!isset($_POST[$POST_KEYS[$x]])) {
                return false;
            }
        }
        return true;
    }

    function verify_user_has_access($POST_KEYS,$mysqli){
        $stm = $mysqli->prepare("SELECT ID_BenhNhan, ID_BacSi FROM LichKham,BacSi,QuanLy where ID = ? AND ((ID_BenhNhan = ?) OR (ID_BacSi = ? AND BacSi.ID = ID_BacSi) OR (QuanLy.ID = ?);");
        $stm->bind_param("iii",$_POST["maphieu"],$_SESSION["ID_TaiKhoan"],$_SESSION["ID_TaiKhoan"],$_SESSION["ID_TaiKhoan"]);
        
        if ($stm->execute()) {
            $result = $stm->get_result();
            return $stm->num_rows>0;
        } else {
            return false;
        }
    }
    function update_pkb($POST_KEYS,$mysqli) {
        $stm = $mysqli->prepare("UPDATE LichKham
        SET KhungGio = ?, NgayKham = ?, LyDoKham = ?
        WHERE ID = ?");
        $stm->bind_param("issi",$_POST["khung_gio"],$_POST["ngay_kham"],$_POST["lydokham"]);

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
    $logged_in = is_logged_in();
    $verified = verify_user_has_access($POST_KEYS,$mysqli);

    if ($has_all_keys && $logged_in && $verified) {
        update_pkb($POST_KEYS,$mysqli);
    } else {
        /*$_SESSION["alertMessage"] = "Bạn không có quyền cập nhật thông tin phiếu khám bệnh này.";
        header("");*/
        $error_smg = "Đã gặp các lỗi:";
        if (!$has_all_keys) {
            $error_msg = "$error_msg\nLỗi đầu vào!";
        } elseif (!$logged_in) {
            $error_msg = "$error_msg\nBạn chưa đăng nhập vào tài khoản nào cả!";
        } elseif (!$verified) {
            $error_msg = "$error_msg\nBạn không có quyền cập nhật thông tin phiếu này!";
        }
        $_SESSION["alertMessage"] = $error_msg;
    }
?>