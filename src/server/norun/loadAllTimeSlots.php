<?php
    
    require("../server/scripts/sqlCredentials.php");
    
    $mysqli = new mysqli($hostname,$username,$password);
    $mysqli->select_db("htdlkbtt");

    $result = $mysqli->query("SELECT KhungGio.ID, KhungGio.Gio_BD, KhungGio.Gio_KT, KhungGio.ID_Buoi, Buoi.TenBuoi FROM KhungGio,Buoi WHERE KhungGio.ID_Buoi = Buoi.ID ORDER BY KhungGio.Gio_BD ASC");

    $timeslot_result = [];
    if (!$result) {
        $_SESSION["alertMessage"] = "Lỗi CSDL!";
        //header("Location: ");
        exit;
    }

    $count = 0;
    if ($result->num_rows>0) {
        while ($row = $result->fetch_assoc()) {
            if (!isset($timeslot_result[$row["ID_Buoi"]])) {
                $timeslot_result[$row["ID_Buoi"]] = [];
                $count+=1;
            }
            $timeslot_result[$row["ID_Buoi"]][] = $row;
        }
    }
    if ($count==0) {
        //Errors.
    }

    for ($x=1;$x<=$count;$x++) {
        $this_buoi = $timeslot_result[$x];
        $buoi_name = $this_buoi[0]["TenBuoi"];

        echo "<div>\n";
        echo "<p><i>".htmlspecialchars($buoi_name)."</i></p>\n";

        for ($y=0;$y<count($this_buoi);$y++) {
            $this_element = $this_buoi[$y];
            $selected = "";
            if (in_array($this_element["ID"],$khung_gio,false)) {
                $selected = "checked";
            }

            echo "<input type=\"checkbox\" name=\"kg_".$this_element["ID"]."\" $selected>\n";
            echo "<label for=\"kg_".$this_element["ID"]."\" >".$this_element["Gio_BD"]."-".$this_element["Gio_KT"]."</label>\n";
            echo "<br>";
        }
        echo "</div>\n";

    }
?>