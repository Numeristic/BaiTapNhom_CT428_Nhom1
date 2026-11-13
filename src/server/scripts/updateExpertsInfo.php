<?php

if (isset($_GET["ck"])) {
    require("sqlCredentials.php");

    $mysqli = new mysqli($hostname,$username,$password);
    $mysqli->select_db("htdlkbtt");

    if ($mysqli->connect_errno) {
        exit;
    }

    $stm = $mysqli->prepare("SELECT BacSi.ID as ID, ThongTinTaiKhoan.HoTen as HoTen FROM bacsi,ThongTinTaiKhoan WHERE ID_ChuyenKhoa = ? AND BacSi.ID = ThongTinTaiKhoan.ID");
    $stm->bind_param("s",$_GET["ck"]);
    
    if ($stm->execute()) {
        $result = $stm->get_result();
        while ($row = $result->fetch_assoc()) {
            echo "<option value=\"".htmlspecialchars($row["ID"])."\">".htmlspecialchars($row["HoTen"])."</option>\n";
        }
    }
}

?>