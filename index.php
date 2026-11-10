<html>
    <head>
        <?php
            include '/src/server/stylesheets.php'
        ?>
    </head>
    <body>
        <?php
            include '/src/server/templates/header_special.php'
        ?>
        <?php
            //PHP code embed here.
        
        ?>
        <main>
            <form action="login.php" class="main_form" name="main_form" method="post">
                <label for="ten_tk">
                    Email tài khoản <p class="red_required">*</p>
                </label>
                <br>
                <input class="input_text" type="email" name="ten_tk" id="input_ten_tk">
                <br>


                <label for="mk">
                    Mật khẩu <p class="red_required">*</p>
                </label>
                <br>
                <input class="input_text" type="password" name="mk" id="input_ten_tk">
                <br>


                <div id="login_sr_container">
                    <input id="login_button" for="main_form" type="submit" value="Đăng nhập">
                    <div id="sr_container">
                        <p id="signup_redirect_label">Chưa có tài khoản?</p>
                        <a id="forgot_password" href="signup.php">Đăng ký</a>
                    </div>  
                </div>
            </form>
        </main>
        <?php
            include '/src/server/templates/footer_special.php'
        ?>
    </body>
</html>