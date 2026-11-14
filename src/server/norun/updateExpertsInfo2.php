<?php

$ck_value = null;
if (!isset($_GET["ck"])) {
    $ck_value = $id_ck;
} else {
    $ck_value = $_GET["ck"];
}

if ($ck_value!=null) {
    require_once("../server/scripts/sqlCredentials.php");

    $mysqli = new mysqli($hostname,$username,$password);
    $mysqli->select_db("htdlkbtt");

    if ($mysqli->connect_errno) {
        exit;
    }

    $stm = $mysqli->prepare("SELECT BacSi.ID as ID, ThongTinTaiKhoan.HoTen as HoTen FROM bacsi,ThongTinTaiKhoan WHERE ID_ChuyenKhoa = ? AND BacSi.ID = ThongTinTaiKhoan.ID");
    $stm->bind_param("s",$ck_value);
    
    if ($stm->execute()) {
        $result = $stm->get_result();

        echo "<option value=\"\">Trống (Khám theo chuyên khoa)</option>\n";
        while ($row = $result->fetch_assoc()) {
            $is_selected = "";
            if ($row["ID"]==$data_result["ID_BacSi"]) {
                $is_selected = "selected";
                echo "SELECTED";
            }

            echo "<option value=\"".htmlspecialchars($row["ID"])."\" $is_selected>".htmlspecialchars($row["HoTen"])."</option>\n";
        }
        
    }
}

?>