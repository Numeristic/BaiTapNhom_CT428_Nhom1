<?php
    require("sqlCredentials.php");
    require("initSession.php");

    $mysqli = new mysqli($hostname,$username,$password);
    $mysqli->select_db("htdlkbtt");

    if ($mysqli->connect_errno) {
        exit;
    }

    $POST_KEYS = [
        //"ho_ten",
        //"so_cccd",
        "loai_hinh",
        "ck",
        "cg",
        "ly_do_kham",
        "ngay_kham",
        "khung_gio"
    ];
    
    function validateBooking($POST_KEYS,$mysqli){

        if ($_POST["loai_hinh"]=="cg"&&!isset($_POST["cg"])) {
            return false;
        }
        for ($x=0;$x<count($POST_KEYS);$x++){
            if ($POST_KEYS[$x]=="cg" || $POST_KEYS[$x]=="ly_do_kham") {
                continue;
            }
            if (!isset($_POST[$POST_KEYS[$x]])) {
                return false;
            }
            if ($POST_KEYS[$x]=="loai_hinh" && $_POST[$POST_KEYS[$x]]=="cg" && !isset($_POST["cg"])) {
                return false;
            }
        }

        //Mặc định cho lịch khám hình thức theo chuyên khoa.
        $query = "SELECT BacSi.ID FROM BacSi,KhungGio,LichLamViec 
        WHERE KhungGio.ID = ? AND BacSi.ID_ChuyenKhoa = ? AND BacSi.ID = LichLamViec.ID_BacSi AND KhungGio.ID = LichLamViec.ID_KhungGio";
        $params = "is";
        $arguments = [$_POST["khung_gio"],$_POST["ck"]];
        
        //Nếu có chuyên gia, thì điều chỉnh lại.
        if ($_POST["loai_hinh"]=="cg") {
            $query = "SELECT BacSi.ID FROM BacSi,KhungGio,LichLamViec 
            WHERE KhungGio.ID = ? AND BacSi.ID = ? AND BacSi.ID_ChuyenKhoa = ? AND BacSi.ID = LichLamViec.ID_BacSi AND KhungGio.ID = LichLamViec.ID_KhungGio";
            $params = "iis";
            $arguments = [$_POST["khung_gio"],$_POST["cg"],$_POST["ck"]];
        }

        $available_time_stm = $mysqli->prepare($query);
        $available_time_stm->bind_param($params,...$arguments);

        if (!$available_time_stm->execute()) {
            $_SESSION["alertMessage"] = "Lỗi CSDL! $available_time_stm->error";
            return false;
        }
        $available_result = $available_time_stm->get_result();
        if ($available_result->num_rows<=0) {
            $_SESSION["alertMessage"] = "Không có bác sĩ nào khả dụng ở khung giờ này! Có thể lịch khám vừa được cập nhật.";
            return false;
        }

        //Lúc này, số lượng hàng được trả về là số lượng bác sĩ
        //có lịch làm việc tại thời điểm hẹn lịch khám.
        
        //Để hiệu quả, thay vì trả về true. Ta trả về số lượng
        //bác sĩ có lịch làm việc tại thời điểm đó để có thể sử
        //dụng trong hàm processBooking().
        return $available_result->num_rows;
    }

    function processBooking($POST_KEYS,$mysqli,$limit) {
        $check_query = "";
        
        $stm = "";


        if ($_POST["loai_hinh"]=="ck") {
            $check_query = "SELECT LichKham.ID from LichKham WHERE ID_ChuyenKhoa = ? AND KhungGio = ? AND NgayKham = ?;";
            $stm = $mysqli->prepare($check_query);
            $stm->bind_param("sis",$_POST["ck"],$_POST["khung_gio"],$_POST["ngay_kham"]);

            //Nếu là khám chuyên khoa thì số lượng lịch khám không được quá số lượng bác sĩ của khoa đó.
            //(Trong bài này, ta cho rằng mỗi bác sĩ xử lý được 1 lịch khám đặt trước mỗi khung giờ)

        } elseif ($_POST["loai_hinh"]=="cg") {
            $check_query = "SELECT LichKham.ID from LichKham WHERE ID_ChuyenKhoa = ? AND ID_BacSi = ? AND KhungGio = ? AND NgayKham = ?;";

            $stm = $mysqli->prepare($check_query);
            $stm->bind_param("siis",$_POST["ck"],$_POST["cg"],$_POST["khung_gio"],$_POST["ngay_kham"]);
        }
        if ($stm->execute()) {

            $check_result = $stm->get_result();

            //Nếu số lượng lịch khám trong thời điểm đó vượt quá giới hạn đã được tính
            //-> Không tạo lịch khám vì lịch không còn trống.

            //Có dấu bằng vì tạo lịch sẽ thêm một phiếu mới.
            if ($check_result->num_rows>=$limit){
                $_SESSION["alertMessage"] = "Lịch không còn trống!";
                header("Location: ../../user/datlichkham.php?");
                exit;
            }

            $stm2 = $mysqli->prepare("INSERT INTO LichKham(ID_BacSi,ID_BenhNhan,ID_ChuyenKhoa,ID_TrangThai,KhungGio,LyDoKham,NgayKham) VALUES(?,?,?,?,?,?,?)");
           
            
            $id_bn = $_SESSION["ID_TaiKhoan"];
            $id_trangthai = 1;

            $id_cg = null;
            if ($_POST["loai_hinh"]=="cg") {
                $id_cg = $_POST["cg"];
            }

            $stm2->bind_param("iisiiss",$id_cg,$id_bn,$_POST["ck"],$id_trangthai,$_POST["khung_gio"],$_POST["ly_do_kham"],$_POST["ngay_kham"]);
            if ($stm2->execute()) {
                //Đặt lịch khám thành công.
                $_SESSION["alertMessage"] = "Đặt lịch khám thành công!";
                header("Location: ../../user/phieukhambenh.php?id=$stm2->insert_id");
            } else {
                die("Error while inserting data: $stm2->error");
            }

        } else {

            die("Error: $stm->error");
            exit;

        }
    }

    $limit = validateBooking($POST_KEYS,$mysqli);
    if ($limit!=false) {
        $query_result = processBooking($POST_KEYS,$limit);
    } else {
        header("Location: ../../user/datlichkham.php?");
    }
?>