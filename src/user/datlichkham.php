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
        <?php
            //PHP code embed here.
        
        ?>
        <main>
            <div id="flex_div1">
                <div id="empty"></div>
                <div id="login_panel">
                    <h2><b>Đặt lịch khám</b></h2>
                    <div>
                        <form action="login.php" id="main_form" name="main_form" method="post">
                            <label for="ten_tk">
                                Họ và tên người khám <p class="red_required">*</p>
                            </label>
                            <br>
                            <input class="input_text" type="text" name="ten_tk">
                            <br>



                            <label for="mk">
                                Số CCCD <p class="red_required">*</p>
                            </label>
                            <br>
                            <input class="input_text" type="number" name="mk">
                            <br>



                            <label>
                                Hình thức khám <p class="red_required">*</p>
                            </label>
                            <br>
                            <select name="hinhthuckham" class="input_text">
                                <option value="trong_gio_hc">Trong giờ hành chính</option>
                                <option value="ngoai_gio_hc">Ngoài giờ hành chính (Khám theo yêu cầu)</option>
                            </select>
                            <br>



                            <label>
                                Chuyên khoa <p class="red_required">*</p>
                            </label>
                            <br>
                            <select name="ck" class="input_text">
                                <option value="ck_tmh">Tai-Mũi-Họng</option>
                                <option value="ck_noi">Chuyên khoa Nội</option>
                                <option value="ck_ngoai">Chuyên khoa Ngoại</option>
                                <option value="ck_ungbuou">Ung bướu</option>
                                <option value="ck_sanphu">Sản phụ</option>
                            </select>
                            <br>

                            <label>
                                Chuyên gia <p class="red_required">*</p>
                            </label>
                            <br>
                            <select name="cf" class="input_text">
                                <option value="cg_tmh">Bs.CKII.TS. Nguyễn Thị L</option>
                                <option value="cg_noi">Bs.CKII.TS. Nguyễn Thị M</option>
                                <option value="cg_ngoai">Bs.CKII.TS. Nguyễn Thị N</option>
                                <option value="cg_ungbuou">Bs.CKII.TS. Nguyễn Thị O</option>
                                <option value="cg_sanphu">Bs.CKII.TS. Nguyễn Thị P</option>
                            </select>
                            <br>

                            <label>
                                Khung giờ <p class="red_required">*</p>
                            </label>

                            <div id="login_sr_container">
                                <input id="login_button" for="main_form" type="submit" value="Đăng ký khám bệnh">
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