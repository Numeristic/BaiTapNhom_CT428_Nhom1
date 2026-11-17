<?php

    require_once "../server/scripts/loggedInFunc.php";
    require_once "../server/scripts/sqlCredentials.php";
    include_once '../server/scripts/initSession.php';

    if (!is_logged_in($SESSION_KEYS)) {
        $_SESSION["alertMessage"] = "Bạn chưa đăng nhập!";
        header("Location: dangnhap.php");
    }

    if ($_SESSION["Admin"]<=0) {
        $_SESSION["alertMessage"] = "Bạn cần có quyền quản trị để xem trang này.";
        header("Location: ../../index.php");
    }


    $mysqli = new mysqli($hostname,$username,$password);
    $mysqli->select_db("htdlkbtt");

    $list_query = $mysqli->query("SELECT ThongTinTaiKhoan.ID, ThongTinTaiKhoan.HoTen, ThongTinTaiKhoan.SoCCCD, ThongTinTaiKhoan.SoDT, ChuyenKhoa.TenChuyenKhoa, BacSi.ID_ChuyenKhoa
    FROM ThongTinTaiKhoan,BacSi
    LEFT JOIN ChuyenKhoa ON BacSi.ID_ChuyenKhoa = ChuyenKhoa.ID
    WHERE ThongTinTaiKhoan.ID = BacSi.ID
    ORDER BY BacSi.ID_ChuyenKhoa;");

    $thongtin_bacsi = [];

    if (!$list_query) {
        $_SESSION["alertMessage"] = "Lỗi truy vấn CSDL!";
        header("Location: ../../index.php");
    }

    while ($row = $list_query->fetch_assoc()) {
        $thongtin_bacsi[] = $row;
    }
?>

<html>
    <head>
        <?php
            include '../server/stylesheets.php';
            require_once("../server/scripts/alert.php");
        ?>
        <link rel="stylesheet" href="../server/styles/list_extras.css">
        <script src="../client/scripts/danhsachnhanvien.js" defer></script>
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

                        <input>

                        <input type="submit" value="Lọc">

                    </form>
                    <table>
                        <tr>
                            <td>STT</td>
                            <td>Mã tài khoản</td>
                            <td>Họ tên</td>
                            <td>Số CCCD</td>
                            <td>Số ĐT</td>
                            <td>Chuyên khoa</td>
                            <td>Thông tin cá nhân</td>
                            <td>Lịch sử khám</td>
                            <td>Lịch làm việc</td>
                        </tr>
                        <?php

                            for ($x=0;$x<count($thongtin_bacsi);$x++){
                                $stt = $x+1;
                                $this_element = $thongtin_bacsi[$x];
                                $id = $this_element["ID"];

                                $ht_bs = $this_element["HoTen"];
                                $so_cccd = $this_element["SoCCCD"];
                                $so_dt = $this_element["SoDT"];
                                $id_ck = $this_element["ID_ChuyenKhoa"];
                                $ten_ck = $this_element["TenChuyenKhoa"];

                                $card = "<tr class=\"lichkham_card\">

                                    <td>$stt</td>
                                    <td>$id</td>
                                    <td>$ht_bs</td>
                                    <td>$so_cccd</td>
                                    <td>$so_dt</td>
                                    <td>$ten_ck</td>
                                    <td style=\"display: none;\">$id_ck</td>
                                    <td><a href=\"thongtincanhan.php?id=$id\">Xem</a></td>
                                    <td><a href=\"xemyeucaukham.php?id=$id\">Xem</a></td>
                                    <td><a href=\"quanlylichlamviec.php?id=$id\">Xem</a></td>
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