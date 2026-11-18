<?php

    require_once "../server/scripts/loggedInFunc.php";
    require_once "../server/scripts/sqlCredentials.php";
    include_once '../server/scripts/initSession.php';

    if (!is_logged_in($SESSION_KEYS)) {
        $_SESSION["alertMessage"] = "Bạn chưa đăng nhập!";
        header("Location: dangnhap.php");
    }
    
    if (!($_SESSION["Admin"]>0)) {
        $_SESSION["alertMessage"] = "Bạn không có quyền xem trang này!";
        header("Location: ../../index.php");
        exit;
    }

    $mysqli = new mysqli($hostname,$username,$password);
    $mysqli->select_db("htdlkbtt");

    $result = $mysqli->query("SELECT * FROM ChuyenKhoa");

    $chuyenkhoa = [];
    if ($result->num_rows>0) {
        while ($row = $result->fetch_assoc()) {
            $chuyenkhoa[] = $row;
        }
    }
?>

<html>
    <head>
        <?php
            include '../server/stylesheets.php';
            require_once("../server/scripts/alert.php");
        ?>
        <link rel="stylesheet" href="../server/styles/list_extras.css">
        <script src="../client/scripts/danhsachck.js" defer></script>
    </head>
    <body>
        <?php
            include '../server/templates/header.php'
        ?>
        <main>
            <div id="flex_div1">
                <div class="empty"></div>
                <div id="login_panel">
                    <h2><b>Danh sách chuyên khoa</b></h2>
                    <form id="main_form">
                        
                        <input type="text" id="input_idck" placeholder="Nhập mã chuyên khoa..." required>
                        <input type="text" id="input_tenck" placeholder="Nhập tên chuyên khoa..." required>

                        <input type="submit" value="Thêm">

                    </form>
                    <table>
                        <tr>
                            <td>STT</td>
                            <td>Mã chuyên khoa</td>
                            <td>Tên chuyên khoa</td>
                            <td>Chỉnh sửa</td>
                        </tr>
                        <?php

                            for ($x=0;$x<count($chuyenkhoa);$x++){
                                $stt = $x+1;
                                $this_element = $chuyenkhoa[$x];
                                $id = $this_element["ID"];
                                $ten_ck = $this_element["TenChuyenKhoa"];

                                $card = "<tr class=\"lichkham_card\">

                                    <td>$stt</td>
                                    <td>$id</td>
                                    <td>$ten_ck</td>
                                    <td><a href=\"thongtinck.php?id=$id\">Xem</a></td>

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