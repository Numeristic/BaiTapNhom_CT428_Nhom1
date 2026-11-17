<html>
    <head>
        <?php
            include_once '../server/stylesheets.php';
            include_once '../server/scripts/alert.php';
            include_once '../server/scripts/initSession.php';
        ?>
        <script src="../client/scripts/dangky.js" defer></script>
    </head>
    <body>
        <?php
            include_once '../server/templates/header.php';
        ?>
        
        <main>
            <div id="flex_div1">
                <div class="empty"></div>
                <div id="login_panel">
                    <h2><b>Bạn có chắc mình muốn đăng xuất?</b></h2>
                    <div>
                        <form action="../server/scripts/logout.php" class="main_form" name="main_form" id="main_form" method="post">

                            <div id="login_sr_container">
                                <input id="login_button" for="main_form" type="submit" value="Đăng xuất">
                                <!--<div id="sr_container">
                                    <p id="signup_redirect_label">Đã có tài khoản?</p>
                                    <a id="forgot_password" href="dangnhap.php">Đăng nhập</a>
                                </div>--> 
                            </div>

                        </form>
                    </div>
                </div>
                <div class="empty"></div>
            </div>
        </main>
        <?php
            include '../server/templates/footer.php'
        ?>
    </body>
</html>