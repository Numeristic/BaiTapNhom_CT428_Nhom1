<?php

    require_once "../server/scripts/loggedInFunc.php";
    require_once "../server/scripts/sqlCredentials.php";

    if !(is_logged_in($SESSION_KEYS)) {
        $_SESSION["alertMessage"] = "Bạn chưa đăng nhập!";
        header("Location: dangnhap.php");
    }

    $mysqli = new mysqli($hostname,$username,$password);
    $stm = $mysqli->prepare("SELECT * FROM LichKham WHERE (ID_BenhNhan = ?) OR (ID_BacSi = ?)");
    
    $stm->bind_param("ii",$_SESSION["ID_TaiKhoan"],$_SESSION["ID_TaiKhoan"]);

    $data_result = "";

    $lich_kham = [];
    if ($stm->execute()) {
        $data_result = $stm->get_result();
        if ($data_result<=0) {
            $_SESSION["alertMessage"] = "Bạn chưa có lịch khám!";
            exit;
        }
        while ($row = $data_result->fetch_assoc()) {
            $lich_kham[] = [$row["ID"],$row["ID_BenhNhan"],$row["ID_BacSi"],$row["LyDoKham"],$row["NgayKham"],$row["KhungGio"]];
        }
    } else {

    }
?>

<html>
    <head>
        <?php
            include '../server/stylesheets.php'
        ?>
    </head>
    <body>
        <?php
            include '../server/templates/header.php'
        ?>
        <main>
            
        </main>
        <?php
            include '../server/templates/footer.php'
        ?>
    </body>
</html>