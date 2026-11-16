<?php

?>
<html>
    <head>
        <?php
            include '../server/stylesheets.php'
        ?>
    </head>
    <body>
        <?php
            include '../server/templates/header.php'
        ?>
        <main>
            <div id="flex_div1">
                <div class="empty"></div>
                <div id="login_panel">
                    <h2><b>Đổi mật khẩu</b></h2>
                    <div>
                        <form action="" class="main_form" id="main_form" name="main_form" method="post">
                            <label for="idtk" id="label_idtk">
                                ID Tài Khoản <p class="red_required">*</p>
                            </label>
                            <br>
                            <input class="input_text" type="number" name="idtk" id="input_idtk" disabled>
                            <br>


                            <label for="oldmk" id="label_mk">
                                Mật khẩu cũ <p class="red_required">*</p>
                            </label>
                            <br>
                            <input class="input_text" type="password" name="oldmk" id="input_mk" required>
                            <br>

                            <label for="mk" id="label_mk">
                                Mật khẩu mới <p class="red_required">*</p>
                            </label>
                            <br>
                            <input class="input_text" type="password" name="mk" id="input_mk" required>
                            <br>

                            <label for="rptmk" id="label_mk">
                                Lặp lại mật khẩu mới <p class="red_required">*</p>
                            </label>
                            <br>
                            <input class="input_text" type="password" name="rptmk" id="input_mk" required>
                            <br>


                            <div id="form_step_finish" class="form_footer">
                                <input id="login_button" for="main_form" type="submit" value="Đổi mật khẩu" class="form_button_container">
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