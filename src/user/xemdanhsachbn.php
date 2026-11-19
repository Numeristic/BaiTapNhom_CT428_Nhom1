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

    $list_query = $mysqli->query("SELECT ThongTinTaiKhoan.ID, ThongTinTaiKhoan.HoTen, ThongTinTaiKhoan.SoCCCD, ThongTinTaiKhoan.SoDT, BacSi.ID as ID_BacSi
    FROM ThongTinTaiKhoan
    LEFT JOIN BacSi ON ThongTinTaiKhoan.ID = BacSi.ID;");

    $thongtin_benhnhan = [];

    if (!$list_query) {
        $_SESSION["alertMessage"] = "Lỗi truy vấn CSDL!";
        header("Location: ../../index.php");
    }

    while ($row = $list_query->fetch_assoc()) {
        if ($row["ID_BacSi"]!=null && $row["ID_BacSi"]>0) {
            continue;
        }
        $thongtin_benhnhan[] = $row;
    }
?>

<html>
    <head>
        <?php
            include '../server/stylesheets.php';
            require_once("../server/scripts/alert.php");
        ?>
        <link rel="stylesheet" href="../server/styles/list_extras.css">
        <!--<script src="../client/scripts/danhsachbacsi.js" defer></script>-->
    </head>
    <body>
        <?php
            include '../server/templates/header.php'
        ?>
        <main>
            <div id="flex_div1">
                <div class="empty"></div>
                <div id="login_panel">
                    <h2><b>Danh sách tài khoản bệnh nhân</b></h2>
                    <form id="main_form">

                        <select id="ck">
                            <option value="">Chọn chuyên khoa</option>
                        </select>

                        <input type="submit" value="Lọc">

                    </form>
                    <table>
                        <tr>
                            <td class="list_title">STT</td>
                            <td class="list_title">Mã tài khoản</td>
                            <td class="list_title">Họ tên</td>
                            <td class="list_title">Số CCCD</td>
                            <td class="list_title">Số ĐT</td>
                            <td class="list_title">Thông tin cá nhân</td>
                            <td class="list_title">Lịch sử khám</td>
                        </tr>
                        <?php

                            for ($x=0;$x<count($thongtin_benhnhan);$x++){
                                $stt = $x+1;
                                $this_element = $thongtin_benhnhan[$x];
                                $id = $this_element["ID"];

                                $ht_bs = $this_element["HoTen"];
                                $so_cccd = $this_element["SoCCCD"];
                                $so_dt = $this_element["SoDT"];

                                $card = "<tr class=\"lichkham_card\">

                                    <td class=\"card_stt\">$stt</td>
                                    <td>$id</td>
                                    <td>$ht_bs</td>
                                    <td>$so_cccd</td>
                                    <td>$so_dt</td>
                                    <td class=\"card_link\"><a href=\"thongtincanhan.php?id=$id\">Xem</a></td>
                                    <td class=\"card_link\"><a href=\"xemyeucaukham.php?id=$id\">Xem</a></td>
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