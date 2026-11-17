<?php

    require_once "sqlCredentials.php";
    require_once "initSession.php";
    require_once "loggedInFunc.php";

    $POST_KEYS = [
        "idtk",
        "hoten",
        "socccd",
        "ngaysinh"
    ];
    $home_url = "../../user/thongtincanhan.php";

    $mysqli = new mysqli($hostname,$username,$password);
    $mysqli->select_db("htdlkbtt");

    function validate($POST_KEYS){
        $returned_value = true;
        for ($x=0;$x<count($POST_KEYS);$x++){
            if (!isset($_POST[$POST_KEYS[$x]])) {
                echo $POST_KEYS[$x]."\n";
                $returned_value = false;
            }
        }
        return $returned_value;
    }

    function verify_user_has_access($POST_KEYS,$mysqli){
        if ($_SESSION["ID_TaiKhoan"]==$_POST["idtk"] || $_SESSION["Admin"]>0) {
            return true;
        }
        return false;
    }
    
    function update_personal_info($mysqli,$home_url) {
        $has_ck = false;
        $has_bs = isset($_POST['bs_perms']);
        $has_admin = isset($_POST['admin_perms']);

        /*if (isset($_POST['bs_perms'])) {
            $has_bs = 1;
        }
        if (isset($_POST['admin_perms'])) {
            $has_admin = 1;
        }*/

        $check_stm = $mysqli->prepare("SELECT COUNT(BacSi.ID) AS LaBacSi, COUNT(QuanLy.ID) AS LaQuanLy FROM ThongTinTaiKhoan
        LEFT JOIN BacSi ON ThongTinTaiKhoan.ID = BacSi.ID
        LEFT JOIN QuanLy ON ThongTinTaiKhoan.ID = QuanLy.ID
        WHERE ThongTinTaiKhoan.ID = ?");
        $check_stm->bind_param("i",$_POST["idtk"]);
        if (!$check_stm->execute()) {
            $_SESSION["alertMessage"] = "Lỗi truy vấn! $check_stm->error";
            header("Location: $home_url?ck=".$_POST["idtk"]);
            exit;
        }
        $check_result = $check_stm->get_result();
        $check_row = $check_result->fetch_assoc();

        /*if (isset($_POST["ck"]) && !($_SESSION["Admin"]>0)) {
            if ($_SESSION["Admin"]<=0 || $check_result->num_rows<=0 || $check_row['LaBacSi']<=0) {
                if ($_SESSION["Admin"]<=0) {
                    $_SESSION["alertMessage"] = "Bạn không có quyền thay đổi thông tin liên quan đến bác sĩ!";
                } else {
                    $_SESSION["alertMessage"] = "Tài khoản này không phải là tài khoản Bác Sĩ!";
                }
                header("Location: $home_url?ck=".$_POST["idtk"]);
                exit;
            } else {
                echo "What?";
                echo $_POST["bs_perms"];
                $has_ck = 1;
            }
        }*/

        $query = "UPDATE ThongTinTaiKhoan SET HoTen = ?, SoCCCD = ?, NgaySinh = ? WHERE ID = ?";
        $stm = $mysqli->prepare($query);
        $stm->bind_param("sisi",$_POST["hoten"],$_POST["socccd"],$_POST["ngaysinh"],$_POST["idtk"]);

        $success = $stm->execute();
        if (!$success) {
            $_SESSION["alertMessage"] = "Lỗi thao tác CSDL! $stm->error";
            header("Location: $home_url?ck=".$_POST["idtk"]);
            exit;
        }

        if ($_SESSION["ID_TaiKhoan"]==$_POST["idtk"]) {
            $_SESSION['HoTen'] = $_POST["hoten"];
            $_SESSION['SoCCCD'] = $_POST["socccd"];
            $_SESSION['NgaySinh'] = $_POST["ngaysinh"];
        }

        $_SESSION["alertMessage"] = "Cập nhật thành công!";

        if ($_SESSION["Admin"]>0) {
            $query = "";

            $bsupdate_stm = "";
            if (($check_row['LaBacSi']>0)!=($has_bs)){
                if ($has_bs) {
                    if (!isset($_POST['ck']) || $_POST['ck']=="") {
                        $_SESSION['alertMessage'] = "Chuyên khoa không thể để trống!";
                        header("Location: $home_url?ck=".$_POST["idtk"]);
                        exit;
                    }
                    $query = "INSERT INTO BacSi(ID,ID_ChuyenKhoa) VALUES (?,?)";
                    $bsupdate_stm = $mysqli->prepare($query);
                    $bsupdate_stm->bind_param("is",$_POST['idtk'],$_POST['ck']);
                } else {
                    $query = "DELETE FROM BacSi WHERE ID = ?";
                    $bsupdate_stm = $mysqli->prepare($query);
                    $bsupdate_stm->bind_param('i',$_POST['idtk']);
                }
                if (!$bsupdate_stm->execute()) {
                    $_SESSION["alertMessage"] = "";
                }
            } elseif ($check_row['LaBacSi']>0) {
                if (!isset($_POST['ck']) || $_POST['ck']=="") {
                    $_SESSION['alertMessage'] = "Chuyên khoa không thể để trống!";
                    header("Location: $home_url?ck=".$_POST["idtk"]);
                    exit;
                }
                $query = "UPDATE BacSi SET ID_ChuyenKhoa = ? WHERE BacSi.ID = ?";
                $bsupdate_stm = $mysqli->prepare($query);
                $bsupdate_stm->bind_param('si',$_POST['ck'],$_POST['idtk']);
                if (!$bsupdate_stm->execute()) {
                    $_SESSION["alertMessage"] = "";
                 }
            }
        }

        if ($_SESSION["Admin"]>0 && (($check_row['LaQuanLy']>0)!=($has_admin))) {
            $query = "";

            $adminupdate_stm = "";
            if ($has_admin) {
                $query = "INSERT INTO QuanLy VALUES (?)";
            } else {
                $query = "DELETE FROM QuanLy WHERE ID = ?";
            }

            $adminupdate_stm = $mysqli->prepare($query);
            $adminupdate_stm->bind_param("i",$_POST['idtk']);
            
            if (!$adminupdate_stm->execute()) {
                $_SESSION["alertMessage"] = "";
            }
        }

        /*if ($has_ck==true) {
            $bs_stm = $mysqli->prepare("UPDATE BacSi SET ID_ChuyenKhoa = ? WHERE BacSi.ID = ?");
            $bs_stm->bind_param("si",$_POST["ck"],$_POST["idtk"]);

            if (!$bs_stm->execute()) {
                $_SESSION["alertMessage"] = "Cập nhật thông tin bác sĩ thất bại!";
            }
        }*/
        echo $_POST["idtk"]."\n";
        echo $_POST["hoten"]."\n";
        echo $_POST["socccd"]."\n";
        echo $_POST["ngaysinh"]."\n";
        header("Location: $home_url?ck=".$_POST["idtk"]);
    }

    $valid = validate($POST_KEYS);
    $logged_in = is_logged_in($SESSION_KEYS);
    $verified = verify_user_has_access($POST_KEYS,$mysqli);

    if ($valid && $logged_in && $verified) {
        update_personal_info($mysqli,$home_url);
    }

?>