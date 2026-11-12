<?php
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
                } else {
                    
                }
            } else {
                header("Location: ../../user/dangky.php");
            }
        } else {
            die("Error: $stm->error");
        }
    }
    
    if (validate($POST_KEYS)) {
        login($POST_KEYS,"BenhNhan",$mysqli);
    }
?>