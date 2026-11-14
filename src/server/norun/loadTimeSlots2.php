<?php
    require("../server/scripts/sqlCredentials.php");

    $mysqli = new mysqli($hostname,$username,$password);
    $mysqli->select_db("htdlkbtt");

    if ($mysqli->connect_errno) {
        exit;
    }

    $stm = 0;

    $ck_value = null;
    $cg_value = null;

    if (!isset($_GET["ck"])) {
        $ck_value = $id_ck;
    } else {
        $ck_value = $_GET["ck"];
    }

    if (!isset($_GET["cg"])) {
        $ck_value = $id_ck;
    } else {
        $ck_value = $_GET["ck"];
    }


    if ($ck_value!=null && $cg_value!=null) {
        //Set stm, bind params.$stm = $mysqli->prepare("");
        $stm = $mysqli->prepare(
            "SELECT DISTINCT KhungGio.ID as ID, Buoi.ID as BuoiID, Buoi.TenBuoi as Buoi FROM BacSi,KhungGio,Buoi,LichLamViec
            WHERE BacSi.ID = ? AND BacSi.ID_ChuyenKhoa = ? AND BacSi.ID = LichLamViec.ID_BacSi AND LichLamViec.ID_KhungGio=KhungGio.ID AND KhungGio.ID_Buoi = Buoi.ID
            ORDER BY KhungGio.ID ASC;"
        );
        $stm->bind_param("is",$cg_value,$ck_value);
    } elseif ($ck_value!=null) {
        //Set stm
        $stm = $mysqli->prepare(
            "SELECT DISTINCT KhungGio.ID as ID, Buoi.ID as BuoiID, Buoi.TenBuoi as Buoi FROM BacSi,KhungGio,Buoi,LichLamViec
            WHERE BacSi.ID_ChuyenKhoa = ? AND BacSi.ID = LichLamViec.ID_BacSi AND LichLamViec.ID_KhungGio=KhungGio.ID AND KhungGio.ID_Buoi = Buoi.ID
            ORDER BY KhungGio.ID ASC;"
        );
        $stm->bind_param("s",$ck_value);
    } else {
        exit;
    }

    $info_result = $mysqli->query("SELECT DISTINCT * FROM KhungGio ORDER BY KhungGio.ID ASC;");

    $khung_gio = [];
    $khung_gio_min = [];

    while ($kg = $info_result->fetch_assoc()) {
        if (!isset($khung_gio_min[$kg["ID_Buoi"]]) || ($khung_gio_min[$kg["ID_Buoi"]] > (int)$kg["ID"])) {
            $khung_gio_min[$kg["ID_Buoi"]] = (int)$kg["ID"];
        }
        $khung_gio[] = $kg;
    }

    if ($stm->execute()) {
        $result = $stm->get_result();
        $compiled = [];
        $compiled_index = [];

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
                $offset_behind = 0;

                if ($y>0) {
                    $offset_behind = ($this_element["ID"] - $compiled[$buoi_name][$y-1]["ID"])-1;
                } elseif ($y==0 && $this_element["ID"]>$khung_gio_min[$this_element["BuoiID"]]) {
                    $offset_behind = $this_element["ID"] - $khung_gio_min[$this_element["BuoiID"]];
                }
                if ($offset_behind>0) {
                    for ($z=0; $z<$offset_behind; $z++){
                        $element_behind = $khung_gio[($this_element["ID"]-1)-($offset_behind-$z)];
                        echo "<input type=\"radio\" disabled>";
                        echo "<label class=\"disabled_label\">{$element_behind["Gio_BD"]}-{$element_behind["Gio_KT"]}</label>";

                        echo "<br>";
                    }
                }

                $is_selected = "";
                if ($this_element["ID"]==$data_result["ID_KhungGio"]) {
                    $is_selected = "checked";
                }

                echo "<input type=\"radio\" value=\"".htmlspecialchars_decode($this_element["ID"])."\" name=\"khung_gio\" id=\"timeslot_id".htmlspecialchars_decode($this_element["ID"])."\" $is_selected>";
                echo "<label for=\"timeslot_id".htmlspecialchars_decode($this_element["ID"])."\">{$khung_gio[$this_element["ID"]-1]["Gio_BD"]}-{$khung_gio[$this_element["ID"]-1]["Gio_KT"]}</label>";
                echo "<br>";
            }
            echo "</div>";
        }
    }
?>