<?php

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $SESSION_KEYS = [
        "ID_TaiKhoan",
        "HoTen",
        "Role"
    ]

    function is_logged_in(){
        for ($x=0;$x<count($SESSION_KEYS);$x++){
            if (!isset($_SESSION[$SESSION_KEYS[$x]])) {
                return false;
            }
        }
        return true;
    }
?>
