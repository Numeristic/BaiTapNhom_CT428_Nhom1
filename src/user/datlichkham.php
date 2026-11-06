<html>
    <head>
        <?php
            include '../server/stylesheets.php'
        ?>
        <link rel="stylesheet" href="../server/styles/multistep_form_extra.css">
        <script src="../client/scripts/booking.js" defer></script>
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
                        <form action="login.php" class="main_form" name="main_form" method="post">
                            <div id="form_step1" class="form_steps">
                                <label for="ho_ten">
                                Họ và tên người khám <p class="red_required">*</p>
                                </label>
                                <br>
                                <input name="ho_ten" class="input_text" type="text">
                                <br>


                                <label for="so_cccd">
                                    Số CCCD <p class="red_required">*</p>
                                </label>
                                <br>
                                <input name="so_cccd" class="input_text" type="number">
                                <br>

                                <label for="loai_hinh">
                                    Loại hình khám <p class="red_required">*</p>
                                </label>
                                <br>
                                <select name="loai_hinh" class="input_text" id="kham_ck">
                                    <option value="ck">Theo chuyên khoa</option>
                                    <option value="cg">Theo chuyên gia</option>
                                </select>
                                
                                <!--<br>-->
                            </div>
                            
                            <div id="form_step2" class="form_steps">

                                <div id="form_step2_1">
                                    <label for="ck">
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
                                </div>
                                <div id="form_step2_2">
                                    <label for="cg">
                                        Chuyên gia <p class="red_required">*</p>
                                    </label>
                                    <br>
                                    <select name="cg" class="input_text">
                                        <option value="cg_tmh">Bs.CKII.TS. Nguyễn Thị L</option>
                                        <option value="cg_noi">Bs.CKII.TS. Nguyễn Thị M</option>
                                        <option value="cg_ngoai">Bs.CKII.TS. Nguyễn Thị N</option>
                                        <option value="cg_ungbuou">Bs.CKII.TS. Nguyễn Thị O</option>
                                        <option value="cg_sanphu">Bs.CKII.TS. Nguyễn Thị P</option>
                                    </select>
                                </div>

                                <label for="ly_do_kham">
                                    Lý do khám <p class="red_required">*</p>
                                </label>
                                <br>
                                <textarea name="ly_do_kham" class="input_text" type="text" id="ly_do_kham" placeholder="Hãy ghi thêm thông tin về triệu chứng để bác sĩ có thể chẩn đoán hiệu quả hơn"></textarea>
                                <!--<br>-->
                            </div>

                            <div id="form_step3" class="form_steps">
                                <label for="ngay_kham">
                                    Ngày khám <p class="red_required">*</p><br><p class="tagalong" id="hinhthuck">Hình thức khám: (Placeholder)</p>
                                </label>
                                <!--<select name="hinhthuckham" class="input_text">
                                    <option value="trong_gio_hc">Trong giờ hành chính</option>
                                    <option value="ngoai_gio_hc">Ngoài giờ hành chính (Khám theo yêu cầu)</option>
                                </select>-->
                                <input name="ngay_kham" class="input_text" type="date">
                                <br>

                                <label for="khung_gio">
                                    Khung giờ <p class="red_required">*</p>
                                </label>
                                <br>
                                <div id="timeslots_container">
                                    <div id="morning_container">
                                        <p><i>Sáng</i></p>

                                        <input type="radio" value="time_id1" name="khung_gio" id="timeslot_id1">
                                        <label for="timeslot_id1">07:00-08:00</label>

                                        <br>
                                        <input type="radio" value="time_id2" name="khung_gio" id="timeslot_id2">
                                        <label for="timeslot_id2">08:00-09:00</label>

                                        <br>
                                        <input type="radio" value="time_id3" name="khung_gio" id="timeslot_id3">
                                        <label for="timeslot_id2">09:00-10:00</label>

                                        <br>
                                        <input type="radio" value="time_id4" name="khung_gio" id="timeslot_id4">
                                        <label for="timeslot_id2">10:00-11:00</label>

                                        <br>
                                        <input type="radio" value="time_id5" name="khung_gio" id="timeslot_id5">
                                        <label for="timeslot_id2">11:00-12:00</label>
                                    </div>
                                    <div id="night_container">
                                        <p><i>Chiều</i></p>

                                        <input type="radio" value="time_id1" name="khung_gio" id="timeslot_id6">
                                        <label for="timeslot_id1">13:30-14:00</label>

                                        <br>
                                        <input type="radio" value="time_id2" name="khung_gio" id="timeslot_id7">
                                        <label for="timeslot_id2">14:00-15:00</label>

                                        <br>
                                        <input type="radio" value="time_id3" name="khung_gio" id="timeslot_id8">
                                        <label for="timeslot_id2">15:00-16:00</label>

                                        <br>
                                        <input type="radio" value="time_id4" name="khung_gio" id="timeslot_id9">
                                        <label for="timeslot_id2">16:00-17:00</label>
                                    </div>
                                </div>
                            </div>
                            <div id="form_step_proceed" class="form_footer">
                                <div id="return_button" class="form_button_container"><button id="rbutton" type="button" class="form_button">Quay lại</button></div>
                                <div id="proceed_button" class="form_button_container"><button id="pbutton" type="button" class="form_button">Tiếp tục</button></div>
                            </div>
                            <div id="form_step_finish" class="form_footer">
                                <div id="return_button2" class="form_button_container"><button id="rbutton2" type="button" class="form_button">Quay lại</button></div>
                                <input id="login_button" for="main_form" type="submit" value="Đăng ký khám bệnh" class="form_button_container">
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