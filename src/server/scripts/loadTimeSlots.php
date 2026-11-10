<?php
    require("sqlCredentials.php");

    $mysqli = new mysqli($hostname,$username,$password);
    $mysqli->select_db("htdlkbtt");

    $stm = 0;
    if (isset($_GET["ck"]) && isset($_GET["cg"])) {
        //Set stm, bind params.$stm = $mysqli->prepare("");
        $stm = $mysqli->prepare(
            "SELECT DISTINCT KhungGio.ID, KhungGio.Gio_BD, KhungGio.Gio_KT, Buoi.ID as BuoiID, Buoi.TenBuoi as Buoi FROM BacSi,KhungGio,Buoi,LichLamViec
            WHERE BacSi.ID = ? AND BacSi.ID_ChuyenKhoa = ? AND BacSi.ID = LichLamViec.ID_BacSi AND LichLamViec.ID_KhungGio=KhungGio.ID AND KhungGio.ID_Buoi = Buoi.ID
            ORDER BY KhungGio.ID ASC;"
        );
        $stm->bind_param("ss",$_GET["cg"],$_GET["ck"]);
    } elseif (isset($_GET["ck"])) {
        //Set stm
        $stm = $mysqli->prepare(
            "SELECT DISTINCT KhungGio.ID, KhungGio.Gio_BD, KhungGio.Gio_KT, Buoi.ID as BuoiID, Buoi.TenBuoi as BuoiID, Buoi.TenBuoi as Buoi FROM BacSi,KhungGio,Buoi,LichLamViec
            WHERE BacSi.ID_ChuyenKhoa = ? AND BacSi.ID = LichLamViec.ID_BacSi AND LichLamViec.ID_KhungGio=KhungGio.ID AND KhungGio.ID_Buoi = Buoi.ID
            ORDER BY KhungGio.ID ASC;"
        );
        $stm->bind_param("s",$_GET["ck"]);
    } else {
        exit;
    }

    if ($stm->execute()) {
        $result = $stm->get_result();
        $compiled = [];
        $compiled_index = [];

        //Result must have: BuoiID, BuoiName :)
        while ($rows = $result->fetch_assoc()) {
            if (!isset($compiled[$rows["Buoi"]])) {
                $compiled[$rows["Buoi"]] = [];
                $compiled_index[] = $rows["Buoi"];
            }
            $compiled[$rows["Buoi"]][] = $rows;
        }


        for ($x=0; $x<count($compiled_index); $x++) {
            $buoi_name = $compiled_index[$x];
            echo "<div>";
            echo "<p><i>".htmlspecialchars_decode($buoi_name)."</i></p>";
            for ($y=0; $y<count($compiled[$buoi_name]); $y++){
                $this_element = $compiled[$buoi_name][$y];
                if ($y>0) {
                    $offset_previous = $this_element["ID"] - $compiled[$buoi_name][$y-1]["ID"];
                    if ($offset_previous>1) {
                        for ($z=0; $z<$offset_previous; $z++){
                            echo "<br>";
                        }
                    }
                }
                echo "<input type=\"radio\" value=\"".htmlspecialchars_decode($this_element["ID"])."\" name=\"khung_gio\" id=\"timeslot_id".htmlspecialchars_decode($this_element["ID"]).">";
                echo "<label for=\"timeslot_id".htmlspecialchars_decode($this_element["ID"])."\">{$this_element["Gio_BD"]}-{$this_element["Gio_KT"]}</label>";
                echo "<br>";
            }
            echo "</div>";
        }
    }
?>