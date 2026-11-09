<?php
    require("../server/scripts/sqlCredentials.php");

    $mysqli = new mysqli($hostname,$username,$password);
    $mysqli->select_db("htdlkbtt");

    $result = $mysqli->query("SELECT * FROM chuyenkhoa");
    while ($rows=$result->fetch_assoc()) {
        echo "<option value=\"".htmlspecialchars_decode($rows["ID"])."\">".(htmlspecialchars_decode($rows["TenChuyenKhoa"]))."</option>\n";
    }
?>