<?php



?>
<html>
    <head>
        <?php
            include '../server/stylesheets.php'
        ?>
        <link rel="stylesheet" href="../server/styles/booking_info_extra.css">
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
                <div class="empty"></div>
                <div id="login_panel">
                    <h2><b>Phiếu khám bệnh</b></h2>
                    <div>
                        <div class="info_container">
                            <h3 class="info_title"><b>Họ tên:</b></h3>
                            <p class="info_content">Nguyễn Huỳnh Tuấn Khang</p>
                        </div>
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