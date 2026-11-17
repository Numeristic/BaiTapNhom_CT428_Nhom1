<?php
    require_once("loggedInFunc.php");

    if (!is_logged_in($SESSION_KEYS)) {
        $_SESSION["alertMessage"] = "Bạn chưa đăng nhập.";
        header("Location: ../../../index.php");
    }

    function logout() {
        unset($_SESSION['ID_TaiKhoan']);
        unset($_SESSION['HoTen']);
        unset($_SESSION['SoCCCD']);
        unset($_SESSION['NgaySinh']);
        unset($_SESSION['Admin']);
        unset($_SESSION['BacSi']);
        unset($_SESSION['ChuyenKhoa']);
    }
    
    logout();
    $_SESSION["alertMessage"] = "Đăng xuất hoàn tất.";
    header("Location: ../../../index.php");

?>