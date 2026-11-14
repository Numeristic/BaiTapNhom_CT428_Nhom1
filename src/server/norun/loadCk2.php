<?php
    require("../server/scripts/sqlCredentials.php");

    $mysqli = new mysqli($hostname,$username,$password);
    $mysqli->select_db("htdlkbtt");

    $result = $mysqli->query("SELECT DISTINCT * FROM chuyenkhoa ORDER BY TenChuyenKhoa ASC");
    while ($rows=$result->fetch_assoc()) {
        $is_selected = "";
        if ($rows["ID"]==$data_result["ID_ChuyenKhoa"]) {
            $is_selected = "selected";
        }

        echo "<option value=\"".htmlspecialchars($rows["ID"])."\" $is_selected>".(htmlspecialchars($rows["TenChuyenKhoa"]))."</option>\n";
    }
?>