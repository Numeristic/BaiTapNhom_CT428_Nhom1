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

    //Trang đăng ký sẽ dành cho tài khoản bệnh nhân.

    //Các tài khoản của Bác Sĩ hoặc quản lý phải được
    //cấp thủ công bởi người có thẩm quyền (Tài khoản root)

    //TODO: Trim all inputs.
    function sign_up($POST_KEYS,$mysqli) {
        $stm = $mysqli->prepare("INSERT INTO ThongTinTaiKhoan(Email,HoTen,NgaySinh,SoCCCD,SoDT,PHash) VALUES(?,?,?,?,?,?);");
        
        $hashed_pswd = password_hash($_POST["mk"],PASSWORD_BCRYPT);

        $stm->bind_param("sssiss",strtolower($_POST["emailtk"]),$_POST["hoten"],$_POST["ngaysinh"],$_POST["socccd"],$_POST["sodt"],$hashed_pswd);
        if ($stm->execute()) {
            $stm2 = $mysqli->prepare("SELECT ID FROM ThongTinTaiKhoan WHERE Email = ?");
            $stm3 = $mysqli->prepare("INSERT INTO BenhNhan(ID) VALUES (?)");

            $stm2->bind_param("s",strtolower($_POST["emailtk"]));

            if ($stm2->execute()) {

                $id_result = $stm2->get_result()->fetch_assoc();
                $stm3->bind_param("i",$id_result["ID"]);
                
                if ($stm3->execute()){

                }
            }
            
        } else {
            die("Error: $stm->error");
        }
    }

    if (validate($POST_KEYS)) {
        sign_up($POST_KEYS,$mysqli);
    }
?>