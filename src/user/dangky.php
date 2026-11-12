<html>
    <head>
        <?php
            include_once '../server/stylesheets.php'
        ?>
        <script src="../client/scripts/dangky.js" defer></script>
    </head>
    <body>
        <?php
            include_once '../server/templates/header.php'
        ?>
        
        <main>
            <div id="flex_div1">
                <div class="empty"></div>
                <div id="login_panel">
                    <h2><b>Đăng ký</b></h2>
                    <div>
                        <form action="../server/scripts/signup.php" class="main_form" name="main_form" id="main_form" method="post">
                            
                            <label for="hoten" id="label_hoten">
                                Họ tên <p class="red_required">*</p>
                            </label>
                            <br>
                            <input class="input_text" type="text" name="hoten" id="input_hoten" required>
                            <br>

                            <label for="socccd" id="label_socccd">
                                Số CCCD <p class="red_required">*</p>
                            </label>
                            <br>
                            <input class="input_text" type="number" name="socccd" id="input_socccd" pattern="^[0-9]+$" required>
                            <br>

                            <label for="ngaysinh" id="label_ngaysinh">
                                Ngày sinh <p class="red_required">*</p>
                            </label>
                            <br>
                            <input class="input_text" type="date" name="ngaysinh" id="input_ngaysinh" max=<?php echo date("Y-m-d"); ?> required>
                            <br>

                            <label for="sodt" id="label_sodt">
                                Số điện thoại <p class="red_required">*</p>
                            </label>
                            <br>
                            <input class="input_text" type="number" name="sodt" id="input_sodt" pattern="^[0-9]+$" required>
                            <br>

                            <label for="emailtk" id="label_email">
                                Email tài khoản <p class="red_required">*</p>
                            </label>
                            <br>
                            <input class="input_text" type="email" name="emailtk" id="input_emailtk" required>
                            <br>


                            <label for="mk" id="label_mk">
                                Mật khẩu <p class="red_required">*</p>
                            </label>
                            <br>
                            <input class="input_text" type="password" name="mk" id="input_mk" required>
                            <br>



                            <label for="rptmk" id="label_rptmk">
                                Nhập lại mật khẩu <p class="red_required">*</p>
                            </label>
                            <input class="input_text" type="password" name="rptmk" id="input_rptmk">

                            <div id="login_sr_container">
                                <input id="login_button" for="main_form" type="submit" value="Đăng ký">
                                <div id="sr_container">
                                    <p id="signup_redirect_label">Đã có tài khoản?</p>
                                    <a id="forgot_password" href="dangnhap.php">Đăng nhập</a>
                                </div>  
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