<?php

    require_once("sqlCredentials.php");
    require_once("initSession.php");
    require_once("loggedInFunc.php");

    if (!is_logged_in($SESSION_KEYS) || $_SESSION["Admin"]<=0) {
        $_SESSION["alertMessage"] = "Bạn không có quyền thực hiện tác vụ này.";
        header("Location: ../../../index.php");
        exit;
    }

    if (!isset($_POST["idck"]) || !isset($_POST["tenck"])) {
        $_SESSION["alertMessage"] = "Đầu vào không hợp lệ!";
        header("Location: ../../../index.php");
        exit;
    }

    function verify_exist($mysqli){
        $check_stm = $mysqli->prepare("SELECT * FROM ChuyenKhoa WHERE ID = ?");
        $check_stm->bind_param("s",$_POST["idck"]);

        if (!$check_stm->execute()) {
            $_SESSION["alertMessage"] = "Lỗi CSDL! $check_stm->error";
            header("Location: ../../../index.php");
            exit;
        }
        $check_result = $check_stm->get_result();

        return $check_result->num_rows>0;
    }

    function update_ck($mysqli){
        $update_stm = $mysqli->prepare("UPDATE ChuyenKhoa SET TenChuyenKhoa = ? WHERE ID = ?");
        $update_stm->bind_param("ss",$_POST["tenck"],$_POST["idck"]);

        $_SESSION["alertMessage"] = "Cập nhật thành công.";
        if (!$update_stm->execute()) {
            $_SESSION["alertMessage"] = "Lỗi CSDL! $update_stm->error";
        }

        header("Location: ../../user/thongtinck.php?id=".$_POST["idck"]);
    }

    if (verify_exist($mysqli)) {
        update_ck($mysqli);
    }

?>