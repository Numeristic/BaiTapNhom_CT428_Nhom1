<?php
    require("../server/scripts/sqlCredentials.php");

    $mysqli = new mysqli($hostname,$username,$password);
    $mysqli->select_db("htdlkbtt");

    $stm = 0;
    if (isset($_GET["ck"]) && isset($_GET["cg"])) {
        //Set stm, bind params.
    } elseif (isset($_GET["ck"])) {
        //Set stm
    }
    if ($stm->execute()) {
        $result = $stm->get_result();
        $compiled = [];
        while ($rows = $result->fetch_assoc()) {
            echo "<input type="radio" value="time_id1" name="khung_gio" id="timeslot_id1"><label for="timeslot_id1">07:00-08:00</label>";
        }
    }
?>