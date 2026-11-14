<?php

    require("sqlCredentials.php");

    $mysqli = new mysqli($hostname,$username,$password);
    $mysqli->select_db("htdlkbtt");

    $result = $mysqli->query("SELECT * FROM TrangThai");

    while ($rows=$result->fetch_assoc()) {
        echo "<option value=\"".htmlspecialchars($rows["TenTrangThai"])."\">".(htmlspecialchars($rows["TenTrangThai"]))."</option>\n";
    }
?>