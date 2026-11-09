<?php
    require("sqlCredentials.php");

    $mysqli = new mysqli($hostname,$username,$password);
    $mysqli->select_db("htdlkbtt");

    $stm = 0;
    if (isset($_GET["ck"]) && isset($_GET["cg"])) {
        //Set stm, bind params.$stm = $mysqli->prepare("");
        $stm = $mysqli->prepare(
            "SELECT KhungGio.ID, KhungGio.Gio_BD, KhungGio.Gio_KT, Buoi.ID as BuoiID, Buoi.TenBuoi FROM BacSi,KhungGio,Buoi,LichLamViec
            WHERE BacSi.ID = ? AND BacSi.ID_ChuyenKhoa = ? AND BacSi.ID = LichLamViec.ID_BacSi AND LichLamViec.ID_KhungGio=KhungGio.ID AND KhungGio.ID_Buoi = Buoi.ID;"
        );
        $stm->bind_param("ss",$_GET["cg"],$_GET["ck"]);
    } elseif (isset($_GET["ck"])) {
        //Set stm
        $stm = $mysqli->prepare(
            "SELECT KhungGio.ID, KhungGio.Gio_BD, KhungGio.Gio_KT, Buoi.ID as BuoiID, Buoi.TenBuoi as BuoiID, Buoi.TenBuoi FROM BacSi,KhungGio,Buoi,LichLamViec
            WHERE BacSi.ID_ChuyenKhoa = ? AND BacSi.ID = LichLamViec.ID_BacSi AND LichLamViec.ID_KhungGio=KhungGio.ID AND KhungGio.ID_Buoi = Buoi.ID;"
        );
        $stm->bind_param("s",$_GET["ck"]);
    }

    if ($stm->execute()) {
        $result = $stm->get_result();
        $compiled = [];

        //Result must have: BuoiID, BuoiName :)
        while ($rows = $result->fetch_assoc()) {
            if ($compiled[(int)$result["BuoiID"]]==null){
                $compiled[(int)$result["BuoiID"]] = [$result["Buoi"]];
            }
            $compiled[$result["Buoi"]][] = $rows;
            //echo "<input type="radio" value="time_id1" name="khung_gio" id="timeslot_id1"><label for="timeslot_id1">07:00-08:00</label>";
        }
        
        for ($x = 0; $x<count($compiled); $x++) {
            echo "<div>";
            echo "<p><i>".htmlspecialchars_decode($compiled[$x][0])."</i></p>";
            for ($y = 1; $y<count($compiled[$x]); $y++) {
                $this_element = $compiled[$x][$y];
                echo "<input type=\"radio\" value=\"{$this_element["ID"]}\" name=\"khung_gio\" id=\"timeslot_id${$this_element["ID"]}\">";
                echo "<label for=\"timeslot_id{$this_element[$x][$y]["ID"]}\">{$this_element["Gio_BD"]}</label>";
            }
            echo "</div>";
        }
    }
?>