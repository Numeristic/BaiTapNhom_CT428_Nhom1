<?php

    require_once("sqlCredentials.php");
    require_once("initSession.php");
    require_once("loggedInFunc.php");

    if (!is_logged_in($SESSION_KEYS) || $_SESSION["Admin"]<=0) {
        $_SESSION["alertMessage"] = "Bạn không có quyền thực hiện tác vụ này.";
        header("Location: ../../../index.php");
        exit;
    }

    if (!isset($_POST["idck"])) {
        echo "Đầu vào không hợp lệ!";
        //header("Location: ../../../index.php");
        exit;
    }

    function verify_exist($mysqli){
        $check_stm = $mysqli->prepare("SELECT * FROM ChuyenKhoa WHERE ID = ?");
        $check_stm->bind_param("s",$_POST["idck"]);

        if (!$check_stm->execute()) {
            echo "Lỗi CSDL! $check_stm->error";
            //header("");
            exit;
        }
        $check_result = $check_stm->get_result();

        return $check_result->num_rows>0;
    }
    function verify_safe($mysqli) {
        return true;
    }

    function delete_ck($mysqli){
        $update_stm = $mysqli->prepare("DELETE FROM ChuyenKhoa WHERE ID = ?");
        $update_stm->bind_param("s",$_POST["idck"]);
        
        
        if (!$update_stm->execute()) {
            echo "Lỗi CSDL! $update_stm->error";
        } else {
            echo "Xóa thành công.";
        }

        //header("Location: ../../user/thongtinck.php?id=".$_POST["idck"]);
    }

    if (verify_exist($mysqli) && verify_safe($mysqli)) {
        delete_ck($mysqli);
    }

?>