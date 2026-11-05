<html>
    <head>
        <?php
            include '../server/stylesheets.php'
        ?>
        <link rel="stylesheet" href="../server/styles/booking_form_extra.css">
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
                            <br>
                            <div id="timeslots_container">
                                <div id="morning_container">
                                    <p>Sáng</p>

                                    <input type="radio" value="time_id1" name="select_time" id="timeslot_id1">
                                    <label for="timeslot_id1">7h-8h</label>

                                    <br>
                                    <input type="radio" value="time_id2" name="select_time" id="timeslot_id2">
                                    <label for="timeslot_id2">8h-9h</label>

                                    <br>
                                    <input type="radio" value="time_id3" name="select_time" id="timeslot_id3">
                                    <label for="timeslot_id2">9h-10h</label>

                                    <br>
                                    <input type="radio" value="time_id4" name="select_time" id="timeslot_id4">
                                    <label for="timeslot_id2">9h-10h</label>
                                </div>
                                <div id="night_container">
                                    <p>Chiều</p>

                                    <input type="radio" value="time_id1" name="select_time" id="timeslot_id1">
                                    <label for="timeslot_id1">1h-2h</label>

                                    <br>
                                    <input type="radio" value="time_id2" name="select_time" id="timeslot_id2">
                                    <label for="timeslot_id2">2h-3h</label>

                                    <br>
                                    <input type="radio" value="time_id3" name="select_time" id="timeslot_id3">
                                    <label for="timeslot_id2">3h-4h</label>

                                    <br>
                                    <input type="radio" value="time_id4" name="select_time" id="timeslot_id4">
                                    <label for="timeslot_id2">4h-5h</label>
                                </div>
                            </div>

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