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

    $mysqli = new mysqli($hostname,$username,$password);
    $mysqli->select_db("htdlkbtt");

    function verify_doesnt_exist($mysqli){
        $check_stm = $mysqli->prepare("SELECT * FROM ChuyenKhoa WHERE ID = ?");
        $check_stm->bind_param("s",$_POST["idck"]);

        if (!$check_stm->execute()) {
            echo "Lỗi CSDL! $check_stm->error";
            /*header("");*/
            exit;
        }
        $check_result = $check_stm->get_result();

        return $check_result->num_rows<=0;
    }

    function add_ck($mysqli){
        $update_stm = $mysqli->prepare("INSERT INTO ChuyenKhoa(ID,TenChuyenKhoa) VALUES (?,?)");
        $update_stm->bind_param("ss",$_POST["idck"],$_POST["tenck"]);

        if (!$update_stm->execute()) {
            echo "Lỗi CSDL! $update_stm->error";
        } else {
            echo "Thêm thành công!";
        }
    }

    if (verify_doesnt_exist($mysqli)) {
        add_ck($mysqli);
    }
?>