<?php

    require_once "../server/scripts/loggedInFunc.php";
    require_once "../server/scripts/sqlCredentials.php";

    if (!is_logged_in($SESSION_KEYS)) {
        $_SESSION["alertMessage"] = "Bạn chưa đăng nhập!";
        header("Location: dangnhap.php");
    }

    $mysqli = new mysqli($hostname,$username,$password);
    $mysqli->select_db("htdlkbtt");
    $stm = $mysqli->prepare("SELECT DISTINCT LichKham.ID as ID, LichKham.ID_BacSi, LichKham.ID_BenhNhan, LichKham.ID_ChuyenKhoa, LichKham.LyDoKham, LichKham.ID_TrangThai, LichKham.NgayKham, ThongTinTaiKhoan.HoTen as HoTen_BacSi, ChuyenKhoa.TenChuyenKhoa as Ten_ChuyenKhoa, TrangThai.TenTrangThai as Ten_TrangThai 
    FROM LichKham,BacSi,ChuyenKhoa,ThongTinTaiKhoan,TrangThai
    WHERE ((ID_BenhNhan = ?) OR (ID_BacSi = ?)) AND (BacSi.ID = LichKham.ID_BacSi AND BacSi.ID = ThongTinTaiKhoan.ID) AND (LichKham.ID_ChuyenKhoa = ChuyenKhoa.ID) AND (LichKham.ID_TrangThai = TrangThai.ID)");
    
    $stm->bind_param("ii",$_SESSION["ID_TaiKhoan"],$_SESSION["ID_TaiKhoan"]);

    $data_result = "";

    $lich_kham = [];
    if ($stm->execute()) {
        $data_result = $stm->get_result();
        if ($data_result->num_rows<=0) {
            $_SESSION["alertMessage"] = "Bạn chưa có lịch khám!";
            exit;
        }
        while ($row = $data_result->fetch_assoc()) {
            $lich_kham[] = $row;
        }
    } else {
        echo "$stm->error";
    }
?>

<html>
    <head>
        <?php
            include '../server/stylesheets.php'
        ?>
        <link rel="stylesheet" href="../server/styles/list_extras.css">
        <script src="../client/scripts/danhsachkham.js" defer></script>
    </head>
    <body>
        <?php
            include '../server/templates/header.php'
        ?>
        <main>
            <div id="flex_div1">
                <div class="empty"></div>
                <div id="login_panel">
                    <h2><b>Danh sách lịch khám</b></h2>
                    <form id="main_form">

                        <select id="ck">
                            <option value="">Chọn chuyên khoa</option>
                        </select>

                        <select id="cg">
                            <option value="">Chọn bác sĩ</option>
                        </select>

                        <select id="khoang">
                            <option value="">Chọn khoảng thời gian</option>
                            <option value=1>Trước ngày</option>
                            <option value=2>Trong ngày</option>
                            <option value=3>Sau ngày</option>
                        </select>

                        <input id="ngaykham" type="date">

                        <select id="trangthai">
                            <option value="">Chọn trạng thái</option>
                        </select>

                        <input type="submit" value="Lọc">

                    </form>
                    <table>
                        <tr>
                            <td>STT</td>
                            <td>Mã phiếu</td>
                            <td>Lập bởi</td>
                            <td>Chuyên khoa</td>
                            <td>Chuyên gia</td>
                            <td>Ngày khám</td>
                            <td>Lý do</td>
                            <td>Trạng thái</td>
                            <td>Tùy chọn</td>
                        </tr>
                        <?php

                            for ($x=0;$x<count($lich_kham);$x++){
                                $stt = $x+1;
                                $this_element = $lich_kham[$x];
                                $id = $this_element["ID"];

                                $ht_bs = $this_element["HoTen_BacSi"];
                                $id_bs = $this_element["ID_BacSi"];
                                $id_bn = $this_element["ID_BenhNhan"];
                                $id_ck = $this_element["ID_ChuyenKhoa"];
                                $ten_ck = $this_element["Ten_ChuyenKhoa"];
    
                                $lydokham = $this_element["LyDoKham"];
                                $trangthai = $this_element["Ten_TrangThai"];
                                $ngaykham = $this_element["NgayKham"];

                                $card = "<tr class=\"lichkham_card\">

                                    <td>$stt</td>
                                    <td>$id</td>
                                    <td>$id_bn</td>
                                    <td>$ten_ck</td>
                                    <td>$ht_bs</td>
                                    <td>$ngaykham</td>
                                    <td>$lydokham</td>
                                    <td>$trangthai</td>
                                    <td style=\"display: none;\">$id_bs</td>
                                    <td style=\"display: none;\">$id_ck</td>
                                    <td><a href=\"phieukhambenh.php?id=$id\">Xem</a></td>

                                </tr>";
                                echo $card;
                            }

                        ?>
                    </table>
                </div>
                <div class="empty"></div>
            </div>
        </main>
        <?php
            include '../server/templates/footer.php'
        ?>
    </body>
</html>