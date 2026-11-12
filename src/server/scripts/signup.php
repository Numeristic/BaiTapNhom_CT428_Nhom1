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
            die("Error: $stm->error");
        }
    }

    function sign_up($POST_KEYS,$register_as,$check_result,$mysqli) {
        /*$stm = $mysqli->prepare("INSERT INTO ThongTinTaiKhoan(Email,HoTen,NgaySinh,SoCCCD,SoDT,PHash) VALUES(?,?,?,?,?,?);");
        
        $hashed_pswd = password_hash(trim($_POST["mk"]),PASSWORD_BCRYPT);
        $lowered_email = trim(strtolower($_POST["emailtk"]));
        $stm->bind_param("sssiss",$lowered_email,$_POST["hoten"],$_POST["ngaysinh"],$_POST["socccd"],$_POST["sodt"],$hashed_pswd);
        if ($stm->execute()) {
            $stm2 = $mysqli->prepare("SELECT ID FROM ThongTinTaiKhoan WHERE Email = ?");

            $query3 = "INSERT INTO $register_as(ID) VALUES (?)";
            $stm3 = $mysqli->prepare($query3);

            $stm2->bind_param("s",$lowered_email);

            if ($stm2->execute()) {

                $id_result = $stm2->get_result()->fetch_assoc();
                $stm3->bind_param("i",$id_result["ID"]);
                
                if ($stm3->execute()){
                    echo "Signed up successfully.";
                }
            }
            
        } else {
            die("Error: $stm->error");
        }*/
        if ($check_result==0) {
            $stm = $mysqli->prepare("INSERT INTO ThongTinTaiKhoan(Email,HoTen,NgaySinh,SoCCCD,SoDT,PHash) VALUES(?,?,?,?,?,?);");
        
            $hashed_pswd = password_hash(trim($_POST["mk"]),PASSWORD_BCRYPT);
            $lowered_email = trim(strtolower($_POST["emailtk"]));
            $stm->bind_param("sssiss",$lowered_email,$_POST["hoten"],$_POST["ngaysinh"],$_POST["socccd"],$_POST["sodt"],$hashed_pswd);
            if (!$stm->execute()) {
                die("Error: $stm->error");
            }
        }

        $stm2 = $mysqli->prepare("SELECT ID FROM ThongTinTaiKhoan WHERE Email = ?");
        $query3 = "INSERT INTO $register_as(ID) VALUES (?)";
        $stm3 = $mysqli->prepare($query3);

        $stm2->bind_param("s",$lowered_email);

        if ($stm2->execute()) {

            $id_result = $stm2->get_result()->fetch_assoc();
            $stm3->bind_param("i",$id_result["ID"]);
            
            if ($stm3->execute()){
                echo "Signed up successfully.";
            }
        }
    }

    $check_result = check_account_exists($POST_KEYS,"BenhNhan",$mysqli);
    if (validate($POST_KEYS) && $check_result<2) {
        sign_up($POST_KEYS,"BenhNhan",$check_result,$mysqli);
    }
?>