<?php
    require("../server/scripts/sqlCredentials.php");

    $mysqli = new mysqli($hostname,$username,$password);
    $mysqli->select_db("htdlkbtt");

    $result = $mysqli->query("SELECT * FROM chuyenkhoa");
    while ($rows=$result->fetch_assoc()) {
        echo "<option value=\"".$rows["ID"]."\">".($rows["TenChuyenKhoa"])."</option>\n";
    }
?>