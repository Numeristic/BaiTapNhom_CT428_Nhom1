<?php

    require_once "../server/scripts/loggedInFunc.php";
    require_once "../server/scripts/sqlCredentials.php";
    include_once '../server/scripts/initSession.php';

    if (!is_logged_in($SESSION_KEYS)) {
        $_SESSION["alertMessage"] = "Bạn chưa đăng nhập!";
        header("Location: dangnhap.php");
    }
    
    $load_id = 0;
    $load_ck = "";
    if (isset($_GET["id"])) {
        $load_id = $_GET["id"];

        $check_stm = $mysqli->prepare("SELECT ChuyenKhoa.ID FROM BacSi, ChuyenKhoa WHERE BacSi.ID = ? AND BacSi.ID_ChuyenKhoa = ChuyenKhoa.ID");
        $check_stm->bind_param("i",$load_id);
        if ($check_stm->execute()) {
            $check_result = $check_stm->get_result();
            if ($check_result->num_rows>0) {
                $check_result = $check_result->fetch_assoc();
                $load_ck = $check_result["ID"];
            } else {
                $load_ck = "null";
            }
        } else {
            $_SESSION["alertMessage"] = "Lỗi CSDL!";
        }
        $check_stm->close();
    } else {
        $load_id = $_SESSION["ID_TaiKhoan"];
        $load_ck = $_SESSION["ChuyenKhoa"];
    }

    if ($load_id!=$_SESSION["ID_TaiKhoan"] && !($_SESSION["Admin"]>0 || $_SESSION["BacSi"]>0)) {
        $_SESSION["alertMessage"] = "Bạn không có quyền xem lịch sử đặt lịch của tài khoản này!";
        header("Location: ../../index.php");
        exit;
    }

    $mysqli = new mysqli($hostname,$username,$password);
    $mysqli->select_db("htdlkbtt");

    $stm = $mysqli->prepare("SELECT DISTINCT LichKham.ID as ID, LichKham.ID_BacSi, LichKham.ID_BenhNhan, LichKham.ID_ChuyenKhoa, LichKham.LyDoKham, LichKham.ID_TrangThai, LichKham.NgayKham, bs.HoTen as HoTen_BacSi, bn.HoTen as HoTen_BenhNhan, ChuyenKhoa.TenChuyenKhoa as Ten_ChuyenKhoa, TrangThai.TenTrangThai as Ten_TrangThai 
    FROM LichKham
    LEFT JOIN ChuyenKhoa ON LichKham.ID_ChuyenKhoa = ChuyenKhoa.ID
    LEFT JOIN BacSi ON LichKham.ID_BacSi = BacSi.ID
    LEFT JOIN ThongTinTaiKhoan bs ON LichKham.ID_BacSi = bs.ID
    LEFT JOIN ThongTinTaiKhoan bn ON LichKham.ID_BenhNhan = bn.ID
    LEFT JOIN KhungGio ON LichKham.KhungGio = KhungGio.ID
    LEFT JOIN TrangThai ON LichKham.ID_TrangThai = TrangThai.ID
    WHERE (LichKham.ID_BenhNhan=? OR (LichKham.ID_BacSi=? OR (LichKham.ID_BacSi IS NULL AND LichKham.ID_ChuyenKhoa = ?)));");

    $stm->bind_param("iis",$load_id,$load_id,$load_ck);

    $data_result = "";

    $lich_kham = [];
    if ($stm->execute()) {
        $data_result = $stm->get_result();
        if ($data_result->num_rows<=0) {
            /*$_SESSION["alertMessage"] = "Người dùng chưa có lịch khám!";
             header("Location: ../../index.php");
            exit;*/
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
            include '../server/stylesheets.php';
            require_once("../server/scripts/alert.php");
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
                    <table id="main_table">
                        <tr>
                            <td class="list_title">STT</td>
                            <td class="list_title">Mã phiếu</td>
                            <td class="list_title">Bệnh nhân</td>
                            <td class="list_title">Chuyên khoa</td>
                            <td class="list_title">Chuyên gia</td>
                            <td class="list_title">Ngày khám</td>
                            <td class="list_title">Lý do</td>
                            <td class="list_title">Trạng thái</td>
                            <td class="list_title">Tùy chọn</td>
                        </tr>
                        <?php

                            for ($x=0;$x<count($lich_kham);$x++){
                                $stt = $x+1;
                                $this_element = $lich_kham[$x];
                                $id = $this_element["ID"];

                                $ht_bs = $this_element["HoTen_BacSi"];
                                $ht_bn = $this_element["HoTen_BenhNhan"];
                                $id_bs = $this_element["ID_BacSi"];
                                $id_bn = $this_element["ID_BenhNhan"];
                                $id_ck = $this_element["ID_ChuyenKhoa"];
                                $ten_ck = $this_element["Ten_ChuyenKhoa"];
    
                                $lydokham = $this_element["LyDoKham"];
                                $trangthai = $this_element["Ten_TrangThai"];
                                $ngaykham = $this_element["NgayKham"];

                                $tt_class = "";
                                $id_tt = $this_element["ID_TrangThai"];
                                if ($id_tt==1) {
                                    $tt_class = "card_tt_wait";
                                } elseif ($id_tt==2) {
                                    $tt_class = "card_tt_good";
                                } elseif ($id_tt==3 || $id_tt==4) {
                                    $tt_class = "card_tt_bad";
                                } else {
                                    $tt_class = "card_tt_missed";
                                }

                                $card = "<tr class=\"lichkham_card\">

                                    <td class=\"card_stt\">$stt</td>
                                    <td class=\"card_nd\">$id</td>
                                    <td class=\"card_nd\">$ht_bn</td>
                                    <td class=\"card_nd\">$ten_ck</td>
                                    <td class=\"card_nd\">$ht_bs</td>
                                    <td class=\"card_nd\">$ngaykham</td>
                                    <td class=\"card_nd\">$lydokham</td>
                                    <td class=\"$tt_class\">$trangthai</td>
                                    <td style=\"display: none;\">$id_bs</td>
                                    <td style=\"display: none;\">$id_ck</td>
                                    <td class=\"card_link\"><a href=\"phieukhambenh.php?id=$id\">Xem</a></td>

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