<?php
    require("../server/scripts/sqlCredentials.php");

    $mysqli = new mysqli($hostname,$username,$password);
    $mysqli->select_db("htdlkbtt");

    $result = $mysqli->query("SELECT DISTINCT * FROM TrangThai");
    while ($rows=$result->fetch_assoc()) {
        $is_selected = "";
        if ($rows["ID"]==$id_tt) {
            $is_selected = "selected";
        }
        echo "<option value=\"".htmlspecialchars($rows["ID"])."\" $is_selected>".(htmlspecialchars($rows["TenTrangThai"]))."</option>\n";
    }

?>
