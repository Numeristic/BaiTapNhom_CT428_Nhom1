<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require_once("sqlCredentials.php");
    $mysqli = new mysqli($hostname,$username,$password);
    $mysqli->select_db("htdlkbtt");

    function logout() {
        unset($_SESSION['ID_TaiKhoan']);
        unset($_SESSION['HoTen']);
        unset($_SESSION['SoCCCD']);
        unset($_SESSION['NgaySinh']);
        unset($_SESSION['Admin']);
        unset($_SESSION['BacSi']);
        unset($_SESSION['ChuyenKhoa']);
    }

    if (isset($_SESSION['ID_TaiKhoan'])) {
        $account_verify_stm = $mysqli->prepare("SELECT ThongTinTaiKhoan.ID, ThongTinTaiKhoan.HoTen, ThongTinTaiKhoan.SoCCCD, ThongTinTaiKhoan.NgaySinh, COUNT(BacSi.ID) as LaBacSi, BacSi.ID_ChuyenKhoa, COUNT(QuanLy.ID) as LaQuanLy
        FROM ThongTinTaiKhoan
        LEFT JOIN BacSi ON ThongTinTaiKhoan.ID = BacSi.ID
        LEFT JOIN QuanLy ON ThongTinTaiKhoan.ID = QuanLy.ID
        WHERE ThongTinTaiKhoan.ID = ?");
        $account_verify_stm->bind_param("i",$_SESSION['ID_TaiKhoan']);

        $exec_result = $account_verify_stm->execute();
        $result = $account_verify_stm->get_result();

        if (!$exec_result || $result->num_rows<=0) {
            logout();

            $_SESSION["alertMessage"] = "Trạng thái tài khoản đã thay đổi. Mời bạn đăng nhập lại.";
            header("Location: ../user/dangnhap.php");
            exit;
        }

        $result = $result->fetch_assoc();

        if ((($_SESSION['Admin']>0)!=($result['LaQuanLy']>0)) || (($_SESSION['BacSi']>0)!=($result['LaBacSi']>0))) {
            logout();

            $_SESSION["alertMessage"] = "Trạng thái tài khoản đã thay đổi. Mời bạn đăng nhập lại.";
            header("Location: ../user/dangnhap.php");
            exit;
        }

        $_SESSION['HoTen'] = $result["HoTen"];
        $_SESSION['SoCCCD'] = $result["SoCCCD"];
        $_SESSION['NgaySinh'] = $result['NgaySinh'];

        if ($result['ID_ChuyenKhoa']!=null) {
            $_SESSION['ChuyenKhoa'] = $result['ID_ChuyenKhoa'];
        } else {
            $_SESSION['ChuyenKhoa'] = "";
        }
    }
?>