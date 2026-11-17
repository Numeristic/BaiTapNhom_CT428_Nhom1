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
                        <!--<h3>Người khám</h3>
                        <div class="feature_list">

                            <div class="feature_container">
                                <img src="img/hospital.png" class="feature_img">
                                <p class="feature_title"><b>Đặt lịch khám</b></p>
                                <p class="feature_description">
                                    - Chọn giờ và chuyên gia. <br>
                                    - Không cần thủ tục rườm rà. <br>
                                    - Vào là khám ngay.
                                </p>
                                <button onclick="location.href = 'src/user/datlichkham.php'" class="feature_button">Đặt ngay</button>
                            </div>

                            <div class="feature_container">
                                <img src="img/info.png" class="feature_img">
                                <p class="feature_title"><b>Xem lịch khám</b></p>
                                <p class="feature_description">
                                    Xem danh sách lịch khám bạn đã đặt.
                                </p>
                                <button onclick="location.href = 'src/user/xemyeucaukham.php'" class="feature_button">Xem ngay</button>
                            </div>
                        </div>-->


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

                        <!--<h3>Bác sĩ</h3>
                        <div class="feature_list">

                            <div class="feature_container">
                                <img src="img/file-text.png" class="feature_img">
                                <p class="feature_title"><b>Báo lịch bận</b></p>
                                <p class="feature_description">
                                    Gửi yêu cầu xem xét lịch bận cho một khoảng thời gian.<br><br> Khi có hiệu lực người bệnh sẽ không đặt khám được với bạn.
                                </p>
                                <button class="feature_button">Viết đơn</button>
                            </div>
                        </div>-->

                        <!--<h3>Quản lý</h3>
                        <div class="feature_list">

                            <div class="feature_container">
                                <img src="img/user-star.png" class="feature_img">
                                <p class="feature_title"><b>Quản lý lịch khám</b></p>
                                <p class="feature_description">
                                    Xem thông tin, trạng thái của lịch khám.
                                </p>
                                <button onclick="location.href = 'src/user/xemdanhsachlichkham.php'" class="feature_button">Vào</button>
                            </div>

                            <div class="feature_container">
                                <img src="img/user-star.png" class="feature_img">
                                <p class="feature_title"><b>Quản lý chuyên khoa</b></p>
                                <p class="feature_description">
                                    Thêm/sửa/xóa thông tin chuyên khoa.
                                </p>
                                <button onclick="location.href = 'src/user/quanlychuyenkhoa.php'" class="feature_button">Vào</button>
                            </div>

                            <div class="feature_container">
                                <img src="img/user-star.png" class="feature_img">
                                <p class="feature_title"><b>Quản lý tài khoản bệnh nhân</b></p>
                                <p class="feature_description">
                                    Thêm/sửa/xóa thông tin, cấp quyền cho bệnh nhân.
                                </p>
                                <button onclick="location.href = 'src/user/xemdanhsachbn.php'" class="feature_button">Vào</button>
                            </div>

                            <div class="feature_container">
                                <img src="img/user-star.png" class="feature_img">
                                <p class="feature_title"><b>Quản lý tài khoản bác sĩ</b></p>
                                <p class="feature_description">
                                    Thêm/sửa/xóa thông tin, cấp quyền cho bác sĩ.
                                </p>
                                <button onclick="location.href = 'src/user/xemdanhsachnv.php'" class="feature_button">Vào</button>
                            </div>
                        </div>-->
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