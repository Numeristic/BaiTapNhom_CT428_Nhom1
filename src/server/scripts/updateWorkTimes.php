<?php

    require_once("sqlCredentials.php");
    require_once("initSession.php");
    require_once("loggedInFunc.php");

    if (!is_logged_in($SESSION_KEYS) || $_SESSION["Admin"]<=0) {
        $_SESSION["alertMessage"] = "Bạn không có quyền thực hiện tác vụ này.";
        header("Location: ../../../index.php");
        exit;
    }

    if (!isset($_POST["id"])) {
        $_SESSION["alertMessage"] = "Đầu vào không hợp lệ!";
        header("Location: ../../../index.php");
        exit;
    }

    $mysqli = new mysqli($hostname,$username,$password);
    $mysqli->select_db("htdlkbtt");

    $recover_stm = $mysqli->prepare("SELECT * FROM LichLamViec WHERE ID_BacSi = ?");
    $clear_stm = $mysqli->prepare("DELETE FROM LichLamViec WHERE ID_BacSi = ?");
    $all_keys = $mysqli->query("SELECT * FROM KhungGio");
    $key_list = [];
    $kg_list = [];

    if ($all_keys->num_rows<=0) {
        $_SESSION["alertMessage"] = "";
        header("Location: ../../user/quanlylichlamviec.php?id=".$_POST["id"]);
        exit;
    }
    while ($row = $all_keys->fetch_assoc()) {
        $key_list[] = $row["ID"];
    }

    $clear_stm->bind_param("i",$_POST["id"]);
    $recover_stm->bind_param("i",$_POST["id"]);

    if (!$recover_stm->execute()) {
        $_SESSION["alertMessage"] = "Lỗi CSDL! Hãy thử lại. $recover_stm->error";
        header("Location: ../../user/quanlylichlamviec.php?id=".$_POST["id"]);
        exit;
    }
    if (!$clear_stm->execute()){
        $_SESSION["alertMessage"] = "Lỗi CSDL! $clear_stm->error";
        header("Location: ../../user/quanlylichlamviec.php?id=".$_POST["id"]);
        exit;
    }


    $first = true;
    $parameters = "";
    $types = "";

    for ($x=0; $x<count($key_list); $x++) {
        $this_key = $key_list[$x];
        if (isset($_POST["kg_".(string)$this_key])) {
            if ($first==false) {
                $parameters = $parameters.", ";
            } else {
                $first = false;
            }
            $kg_list[] = (int)$_POST["id"];
            $kg_list[] = $this_key;
            $parameters = $parameters."(?,?)";
            $types = $types."ii";
        }
    }


    $_SESSION["alertMessage"] = "Cập nhật thành công!";
    if (!$first){
        $query = "INSERT INTO LichLamViec(ID_BacSi,ID_KhungGio) VALUES $parameters";
        $update_stm = $mysqli->prepare($query);
        $update_stm->bind_param($types,...$kg_list);

        
        if (!$update_stm->execute()) {
            echo $update_stm->error."\n";
            echo $query."\n".$types."\n";
            for ($x=0;$x<count($kg_list);$x++) {
                echo $kg_list[$x]."\n";
            }
            exit;
        }
    }
    
    
    header("Location: ../../user/quanlylichlamviec.php?id=".$_POST["id"]);
?>