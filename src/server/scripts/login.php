<?php

    include_once "initSession.php";

    $POST_KEYS = [

        "emailtk",
        "mk",

    ];

    require("sqlCredentials.php");

    $mysqli = new mysqli($hostname,$username,$password);
    $mysqli->select_db("htdlkbtt");

    if ($mysqli->connect_errno) {
        exit;
    }

    function validate($POST_KEYS){
        for ($x=0;$x<count($POST_KEYS);$x++){
            if (!isset($_POST[$POST_KEYS[$x]])) {
                return false;
            }
        }
        return true;
    }

    function check_account_exists($POST_KEYS,$exist_as,$mysqli) {
        $query = "select ThongTinTaiKhoan.ID,ThongTinTaiKhoan.HoTen,count($exist_as.ID) as IDCount from ThongTinTaiKhoan left join $exist_as on $exist_as.ID = ThongTinTaiKhoan.ID
        where ThongTinTaiKhoan.Email = ?
        group by ThongTinTaiKhoan.ID;";

        $stm = $mysqli->prepare($query);
        $stm->bind_param("s",$_POST["emailtk"]);
        
        if ($stm->execute()) {
            $result = $stm->get_result();
            if ($result->num_rows>0) {
                $row = $result->fetch_assoc();
                if ($row["IDCount"]<=0) {
                    return 1; //Returns 1: Account information exists, but wasn't registered on $exist_as.
                } else {
                    return 2; //Returns 2: Everything is okay.
                }
            } else {
                return 0; //Returns 0: The account itself doesn't exist.
            }
        } else {
            die("Error: $stm->error");
        }
    }
    
    function login($POST_KEYS,$dangnhap_as,$mysqli) {
        $query = "SELECT ThongTinTaiKhoan.ID,ThongTinTaiKhoan.HoTen,ThongTinTaiKhoan.PHash FROM $dangnhap_as,ThongTinTaiKhoan WHERE ThongTinTaiKhoan.Email = ? AND ThongTinTaiKhoan.ID = $dangnhap_as.ID";
        $stm = $mysqli->prepare($query);
        $stm->bind_param("s",strtolower($_POST["emailtk"]));
        if ($stm->execute()) {
            if ($stm->num_rows>0){
                $result = $stm->get_result();
                $result = $result->fetch_assoc();

                if (password_verify($_POST["mk"],$result["PHash"])) {
                    $_SESSION['ID_TaiKhoan'] = $result["ID"];
                    $_SESSION['HoTen'] = $result["HoTen"];
                    $_SESSION['Role'] = $dangnhap_as;

                    echo "Dang nhap thanh cong.";
                } else {
                    echo "No.";
                }
            } else {
                header("Location: ../../user/dangky.php");
            }
        } else {
            die("Error: $stm->error");
        }
    }
    
    if (validate($POST_KEYS) && check_account_exists($POST_KEYS,"BenhNhan",$mysqli)==0) {
        login($POST_KEYS,"BenhNhan",$mysqli);
    }
?>