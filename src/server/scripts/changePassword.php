<?php

    require_once("sqlCredentials.php");
    require_once("loggedInFunc.php");

    $mysqli = new mysqli($hostname,$username,$password);
    $mysqli->select_db("htdlkbtt");

    $POST_KEYS = [
        "idtk",
        "oldmk",
        "mk",
    ];

    function update_password($mysqli,$POST_KEYS) {
        if ($_SESSION["ID_TaiKhoan"] != $_POST["idtk"] && $_SESSION["Admin"]<=0) {
            $_SESSION["alertMessage"] = "Bạn không có quyền cập nhật mật khẩu cho tài khoản này!";
            header("Location: ../../user/thongtincanhan.php?id=".$_POST["idtk"]);
            exit;
        }

        $check_stm = $mysqli->prepare("SELECT PHash FROM ThongTinTaiKhoan WHERE ID = ?");
        $check_stm->bind_param("i",$_POST["idtk"]);

        if (!$check_stm->execute()) {
            $_SESSION["alertMessage"] = "Lỗi CSDL: $stm->error";
            header("Location: ../../user/doimatkhau.php?id=".$_POST["idtk"]);
            exit;
        }
        $check_result = $check_stm->get_result();
        if ($check_result->num_rows<=0) {
            $_SESSION["alertMessage"] = "Tài khoản chưa được đăng ký!";
            header("Location: ../../../index.php");
            exit;
        }

        $check_result = $check_result->fetch_assoc();

        if (!password_verify($_POST["oldmk"],$check_result["PHash"])) {
            $_SESSION["alertMessage"] = "Mật khẩu cũ không đúng.";
            header("Location: ../../user/doimatkhau.php?id=".$_POST["idtk"]);
            exit;
        }

        $update_stm = $mysqli->prepare("UPDATE ThongTinTaiKhoan SET PHash = ? WHERE ID = ?");
        $hashed_new_password = password_hash($_POST["mk"],PASSWORD_BCRYPT);

        $update_stm->bind_param("si",$hashed_new_password,$_POST["idtk"]);

        $_SESSION["alertMessage"] = "Cập nhật mật khẩu thành công.";
        if (!$update_stm->execute()) {
            $_SESSION["alertMessage"] = "Lỗi CSDL. Cập nhật mật khẩu thất bại!\n$update_stm->error";
        }
        header("Location: ../../user/thongtincanhan.php?id=".$_POST["idtk"]);
    }

    function validate($POST_KEYS){
        for ($x=0;$x<count($POST_KEYS);$x++){
            if (!isset($_POST[$POST_KEYS[$x]])) {
                return false;
            }
        }
        return true;
    }

    $logged_in = is_logged_in($SESSION_KEYS);
    $validated = validate($POST_KEYS);
    
    if ($logged_in && $validated) {
        update_password($mysqli,$POST_KEYS);
    }
?>