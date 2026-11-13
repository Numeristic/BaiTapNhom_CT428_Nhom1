<?php
    $POST_KEYS = [

        "hoten",
        "socccd",
        "sodt",
        "ngaysinh",
        "emailtk",
        "mk",

    ];

    require("sqlCredentials.php");
    require("initSession.php");

    $mysqli = new mysqli($hostname,$username,$password);
    $mysqli->select_db("htdlkbtt");

    if ($mysqli->connect_errno) {
        $_SESSION["alertMessage"] = "CSDL lỗi!";
        header("Location: ../../user/dangky.php");
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

    //Trang đăng ký sẽ dành cho tài khoản bệnh nhân.

    //Các tài khoản của Bác Sĩ hoặc quản lý phải được
    //cấp thủ công bởi người có thẩm quyền (Tài khoản root)

    //TODO: Trim and escape HTML for all inputs.
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
            $_SESSION["alertMessage"] = "CSDL lỗi: $stm->error";
            header("Location: ../../user/dangky.php");
            die();
        }
    }

    function sign_up($POST_KEYS,$register_as,$check_result,$mysqli) {
        $stm = "";
        if ($check_result==0) {
            $stm = $mysqli->prepare("INSERT INTO ThongTinTaiKhoan(Email,HoTen,NgaySinh,SoCCCD,SoDT,PHash) VALUES(?,?,?,?,?,?);");
        
            $hashed_pswd = password_hash(trim($_POST["mk"]),PASSWORD_BCRYPT);
            $lowered_email = trim(strtolower($_POST["emailtk"]));
            $stm->bind_param("sssiss",$lowered_email,$_POST["hoten"],$_POST["ngaysinh"],$_POST["socccd"],$_POST["sodt"],$hashed_pswd);  
        } else {
            $query = "SELECT * FROM ThongTinTaiKhoan WHERE ThongTinTaiKhoan.Email = ?";
            $lowered_email = trim(strtolower($_POST["emailtk"]));
            $stm = $mysqli->prepare($query);
            $stm->bind_param("s",$lowered_email);
        }
        if (!$stm->execute()) {
            $_SESSION["alertMessage"] = "Lỗi CSDL $stm->error.";
            header("Location: ../../user/dangky.php");
            die("Error: $stm->error");
        } 
        $result = $stm->get_result();

        $query2 = "INSERT INTO $register_as(ID) VALUES (?)";
        $stm2 = $mysqli->prepare($query2);
        if ($check_result==0){
            $new_index = $stm->insert_id;
            $stm2->bind_param("i",$new_index);
        } else {
            $stm2->bind_param("i",$result->fetch_assoc()["ID"]);
        }
        if ($stm2->execute()) {
            $_SESSION["alertMessage"] = "Đăng ký thành công.";
            header("Location: ../../user/dangky.php");
        } else {
            $_SESSION["alertMessage"] = "Lỗi CSDL.";
            header("Location: ../../user/dangky.php");
        }
    }

    $check_result = check_account_exists($POST_KEYS,"BenhNhan",$mysqli);
    if (validate($POST_KEYS) && $check_result<2) {
        sign_up($POST_KEYS,"BenhNhan",$check_result,$mysqli);
    } else {
        $_SESSION["alertMessage"] = "Lỗi đầu vào/đã có tài khoản gắn với email này.";
        header("Location: ../../user/dangky.php");
    }
?>