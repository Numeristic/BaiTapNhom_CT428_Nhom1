<?php
    require("sqlCredentials.php");

    $mysqli = new mysqli($hostname,$username,$password);

    $GET_KEYS = [
        "ho_ten",
        "so_cccd",
        "loai_hinh",
        "ck",
        "cg",
        "ly_do_kham",
        "ngay_kham",
        "khung_gio"
    ]
    
    function validateBooking($GET_KEYS,$mysqli){
        if ($_GET["loai_hinh"]=="cg"&&!isset($_GET["cg"])) {
            return false;
        }
        for ($x=0;$x<count($GET_KEYS);$x++){
            if ($GET_KEYS[$x]=="ck" || $GET_KEYS[$x]=="cg" || $GET_KEYS[$x]=="ly_do_kham") {
                continue;
            }
            if (!isset($_GET[$GET_KEYS[$x]])) {
                return false;
            }
        }
        return true;
    }
?>