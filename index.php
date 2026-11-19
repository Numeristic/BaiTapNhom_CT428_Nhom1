<html>
    <head>
        <?php
            include 'src/server/stylesheets_special.php';
        ?>
        <link rel="stylesheet" href="src/server/styles/trangchu_extra.css">
    </head>
    <body>
        <?php
            include 'src/server/templates/header_special.php';
            include_once 'src/server/scripts/initSessionSpecial.php';
            require_once("src/server/scripts/alert.php");
        ?>
        <?php
            //PHP code embed here.
        
        ?>
        <main>
            <div id="flex_div1">
                <div class="empty"></div>
                <div id="login_panel">
                    <h2><b>Trang chủ</b></h2>
                    <div>

                        <?php

                        if (isset($_SESSION["ID_TaiKhoan"]) && $_SESSION["ID_TaiKhoan"]>0) {
                            include_once "src/server/templates/trangchu_benhnhan.php";
                        } else {
                            include_once "src/server/templates/trangchu_chuadangnhap.php";
                        }
                        
                        if (isset($_SESSION["BacSi"]) && $_SESSION["BacSi"]>0){
                            include_once "src/server/templates/trangchu_bacsi.php";
                        }

                        if (isset($_SESSION["Admin"]) && $_SESSION["Admin"]>0){
                            include_once "src/server/templates/trangchu_admin.php";
                        }
                        
                        ?>
                    </div>
                </div>
                <div class="empty"></div>
            </div>
        </main>
        <?php
            include 'src/server/templates/footer_special.php'
        ?>
    </body>
</html>