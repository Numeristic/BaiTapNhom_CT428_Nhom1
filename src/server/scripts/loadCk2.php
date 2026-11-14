<?php
    require("sqlCredentials.php");

    $mysqli = new mysqli($hostname,$username,$password);
    $mysqli->select_db("htdlkbtt");

    $result = $mysqli->query("SELECT DISTINCT * FROM chuyenkhoa ORDER BY TenChuyenKhoa ASC");
    //echo "Bruh?";
    while ($rows=$result->fetch_assoc()) {
        echo "<option value=\"".htmlspecialchars($rows["ID"])."\">".(htmlspecialchars($rows["TenChuyenKhoa"]))."</option>\n";
    }
?>