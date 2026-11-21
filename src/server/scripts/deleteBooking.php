<?php 

    require_once("sqlCredentials.php");
    require_once("loggedInFunc.php");

    $mysqli = new mysqli($hostname,$username,$password);
    $mysqli->select_db("htdlkbtt");

    if (!isset($_POST["id"])) {
        $_SESSION["alertMessage"] = "Lỗi đầu vào!";
        header("Location: ");
        exit;
    }

    function verify_user_has_access($mysqli) {
        $check_stm = $mysqli->prepare("SELECT * FROM LichKham WHERE ID = ?");
        $check_stm->bind_param("i",$_POST["id"]);

        if (!$check_stm->execute()) {
            $_SESSION["alertMessage"] = "Lỗi CSDL! $check_stm->error";
            header("Location: ");
        }

        $check_result = $check_stm->get_result();
        $creator_id = -1;
        if ($check_result->num_rows>0) {
            $check_result = $check_result->fetch_assoc();
            $creator_id = $check_result["ID_BenhNhan"];
        }
        
        if ($_SESSION["Admin"]>0 || ($_SESSION["ID_TaiKhoan"]==$creator_id && $check_result["ID_TrangThai"]<=1)) {
            return true;
        }
        $check_stm->close();
        
        return false;
    }

    function delete_booking($mysqli) {
        $stm = $mysqli->prepare("DELETE FROM LichKham WHERE ID = ?");
        $stm->bind_param("i",$_POST["id"]);

        if ($stm->execute()) {
            $result = $stm->get_result();

            $_SESSION["alertMessage"] = "Xóa lịch khám thành công.";
            if ($result->num_rows<=0) {
                $_SESSION["alertMessage"] = "Không tìm thấy lịch khám cần xóa!";
            }
            $stm->close();
        } else {
            $_SESSION["alertMessage"] = "Lỗi CSDL! $stm->error";
            header("Location: ");
            $stm->close();
            exit;
        }
    }
    
    $logged_in = is_logged_in($SESSION_KEYS);
    $verified = verify_user_has_access($mysqli);

    if ($logged_in && $verified) {
        delete_booking($mysqli);
    } else {
        if (!$logged_in) {
            $_SESSION["alertMessage"] = "Bạn chưa đăng nhập!";
        } elseif (!$verified) {
            $_SESSION["alertMessage"] = "Bạn không có quyền xóa lịch khám này.";
        }
    }
?>