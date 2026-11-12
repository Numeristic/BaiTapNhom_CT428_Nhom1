<?php

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $SESSION_KEYS = [
        "ID_TaiKhoan",
        "HoTen",
        "Role"
    ]

?>
