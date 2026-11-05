<html>
    <head>
        <?php
            include '../server/stylesheets.php'
        ?>
    </head>
    <body>
        <?php
            include '../server/header.php'
        ?>
        <main>
            <div id="flex_div1">
                <div class="empty"></div>
                <div id="login_panel">
                    <h2><b>Đăng ký</b></h2>
                    <div>
                        <form action="/login" id="main_form" name="main_form" method="post">
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
                            <input class="input_text" type="password" name="mk" id="input_mk">
                            <br>

                            <label for="mk">
                                Nhập lại mật khẩu <p class="red_required">*</p>
                            </label>
                            <input class="input_text" type="password" name="rpt_mk" id="input_rptmk">


                            <div id="login_sr_container">
                                <input id="login_button" for="main_form" type="submit" value="Đăng ký">
                                <div id="sr_container">
                                    <p id="signup_redirect_label">Đã có tài khoản?</p>
                                    <a id="forgot_password" href="login.php">Đăng nhập</a>
                                </div>  
                            </div>
                        </form>
                    </div>
                </div>
                <div class="empty"></div>
            </div>
        </main>
        <?php
            include '../server/footer.php'
        ?>
    </body>
</html>