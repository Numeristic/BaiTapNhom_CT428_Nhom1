<html>
    <head>
        <link rel="stylesheet" href="page.css">
    </head>
    <body>
        <?php
            include '../server/header.php'
        ?>
        <?php
            //PHP code embed here.
        
        ?>
        <main>
            <div id="flex_div1">
                <div class="empty"></div>
                <div id="login_panel">
                    <h2><b>Đăng nhập</b></h2>
                    <div>
                        <form action="login.php" id="main_form" name="main_form" method="post">
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
                                    <p id="signup_redirect_label">Chưa có tài khoản? <a id="forgot_password" href="signup.php">Đăng ký</a></p>
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