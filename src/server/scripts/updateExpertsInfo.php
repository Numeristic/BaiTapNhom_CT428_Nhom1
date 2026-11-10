<?php

if (isset($_GET["ck"])) {
    require("sqlCredentials.php");

    $mysqli = new mysqli($hostname,$username,$password);
    $mysqli->select_db("htdlkbtt");

    $stm = $mysqli->prepare("SELECT * FROM bacsi WHERE ID_ChuyenKhoa = ?");
    $stm->bind_param("s",$_GET["ck"]);
    
    if ($stm->execute()) {
        $result = $stm->get_result();
        while ($row = $result->fetch_assoc()) {
            echo "<option value=\"".htmlspecialchars_decode($row["ID"])."\">".htmlspecialchars_decode($row["HoTen"])."</option>\n";
        }
    }
}

?>