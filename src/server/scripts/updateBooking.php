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
    function update_pkb($POST_KEYS,$mysqli) {
        $stm = $mysqli->prepare("UPDATE LichKham
        SET KhungGio = ?, NgayKham = ?, LyDoKham = ?
        WHERE ID = ?");
        $stm->bind_param("issi",$_POST["khung_gio"],$_POST["ngay_kham"],$_POST["lydokham"],$_POST["maphieu"]);

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

    if ($has_all_keys && $logged_in && $verified) {
        update_pkb($POST_KEYS,$mysqli);
    } else {
        /*$_SESSION["alertMessage"] = "Bạn không có quyền cập nhật thông tin phiếu khám bệnh này.";
        header("");*/
        $error_msg = "Đã gặp các lỗi:";
        if (!$has_all_keys) {
            $error_msg = "$error_msg\nLỗi đầu vào!";
        } elseif (!$logged_in) {
            $error_msg = "$error_msg\nBạn chưa đăng nhập vào tài khoản nào cả!";
        } elseif (!$verified) {
            $error_msg = "$error_msg\nBạn không có quyền cập nhật thông tin phiếu này!";
        }
        $_SESSION["alertMessage"] = $error_msg;
        $maphieu = $_POST["maphieu"];
        //header("Location: ../../user/phieukhambenh.php?id=$maphieu");
        echo $error_msg;
    }
?>