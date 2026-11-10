use htdlkbtt;

insert into Thu(ID,TenThu) values(2,"Thứ Hai");
insert into Thu(ID,TenThu) values(3,"Thứ Ba");
insert into Thu(ID,TenThu) values(4,"Thứ Tư");
insert into Thu(ID,TenThu) values(5,"Thứ Năm");
insert into Thu(ID,TenThu) values(6,"Thứ Sáu");
insert into Thu(ID,TenThu) values(7,"Thứ Bảy");
insert into Thu(ID,TenThu) values(1,"Chủ Nhật");

insert into Buoi(ID,TenBuoi) values(1,"Sáng");
insert into Buoi(ID,TenBuoi) values(2,"Chiều");
insert into Buoi(ID,TenBuoi) values(3,"Tối");

insert into KhungGio(ID,Gio_BD,Gio_KT,ID_Buoi) values(1,'07:00:00','08:00:00',1);
insert into KhungGio(ID,Gio_BD,Gio_KT,ID_Buoi) values(2,'08:00:00','09:00:00',1);
insert into KhungGio(ID,Gio_BD,Gio_KT,ID_Buoi) values(3,'10:00:00','11:00:00',1);
insert into KhungGio(ID,Gio_BD,Gio_KT,ID_Buoi) values(4,'11:00:00','12:00:00',1);

insert into KhungGio(ID,Gio_BD,Gio_KT,ID_Buoi) values(5,'13:30:00','14:00:00',2);
insert into KhungGio(ID,Gio_BD,Gio_KT,ID_Buoi) values(6,'14:00:00','15:00:00',2);
insert into KhungGio(ID,Gio_BD,Gio_KT,ID_Buoi) values(7,'15:00:00','16:00:00',2);
insert into KhungGio(ID,Gio_BD,Gio_KT,ID_Buoi) values(8,'16:00:00','17:00:00',2);

insert into KhungGio(ID,Gio_BD,Gio_KT,ID_Buoi) values(9,'17:00:00','18:00:00',3);
insert into KhungGio(ID,Gio_BD,Gio_KT,ID_Buoi) values(10,'18:00:00','19:00:00',3);
insert into KhungGio(ID,Gio_BD,Gio_KT,ID_Buoi) values(11,'19:00:00','20:00:00',3);

insert into ChuyenKhoa(ID,TenChuyenKhoa,MoTa) values("noitq", "Nội Tổng Quát","");
insert into ChuyenKhoa(ID,TenChuyenKhoa,MoTa) values("tm", "Tim Mạch","");
insert into ChuyenKhoa(ID,TenChuyenKhoa,MoTa) values("nt", "Nội Tiết","");
insert into ChuyenKhoa(ID,TenChuyenKhoa,MoTa) values("th", "Tiêu Hóa","");
insert into ChuyenKhoa(ID,TenChuyenKhoa,MoTa) values("tk", "Thần Kinh","");
insert into ChuyenKhoa(ID,TenChuyenKhoa,MoTa) values("ngoaitq", "Ngoại Tổng Quát","");
insert into ChuyenKhoa(ID,TenChuyenKhoa,MoTa) values("ct", "Chấn Thương Chỉnh Hình","");
insert into ChuyenKhoa(ID,TenChuyenKhoa,MoTa) values("spk", "Sản Phụ Khoa","");
insert into ChuyenKhoa(ID,TenChuyenKhoa,MoTa) values("nk", "Nhi Khoa","");
insert into ChuyenKhoa(ID,TenChuyenKhoa,MoTa) values("dl", "Da liễu","");
insert into ChuyenKhoa(ID,TenChuyenKhoa,MoTa) values("rhm", "Răng-Hàm-Mặt","");
insert into ChuyenKhoa(ID,TenChuyenKhoa,MoTa) values("tmh", "Tai-Mũi-Họng","");
insert into ChuyenKhoa(ID,TenChuyenKhoa,MoTa) values("cdha", "Chẩn Đoán Hình Ảnh","");

insert into ThongTinTaiKhoan(Email,ID,PHash) values("abcd12345@gmail.com","BS12345","random");
insert into ThongTinTaiKhoan(Email,ID,PHash) values("abcd12346@gmail.com","BS12346","random");
insert into ThongTinTaiKhoan(Email,ID,PHash) values("abcd12347@gmail.com","BS12347","random");
insert into ThongTinTaiKhoan(Email,ID,PHash) values("abcd12348@gmail.com","BS12348","random");
insert into ThongTinTaiKhoan(Email,ID,PHash) values("abcd12349@gmail.com","BS12349","random");
insert into bacsi(ID,HoTen,ID_ChuyenKhoa) values("BS12345","Nguyễn Văn A","tmh");
insert into bacsi(ID,HoTen,ID_ChuyenKhoa) values("BS12346","Nguyễn Văn B","rhm");
insert into bacsi(ID,HoTen,ID_ChuyenKhoa) values("BS12347","Lê Thị C","nk");
insert into bacsi(ID,HoTen,ID_ChuyenKhoa) values("BS12348","Nguyễn Thị D","dl");
insert into bacsi(ID,HoTen,ID_ChuyenKhoa) values("BS12349","Lê Thu Hân","dl");

insert into LichLamViec(ID_BacSi,ID_KhungGio) values ("BS12348",1),("BS12348",2),("BS12348",3),("BS12348",4);
insert into LichLamViec(ID_BacSi,ID_KhungGio) values ("BS12349",1),("BS12349",2),("BS12349",5),("BS12349",6),("BS12349",7),("BS12349",8);
insert into LichLamViec(ID_BacSi,ID_KhungGio) values ("BS12347",1),("BS12347",3),("BS12347",5),("BS12347",7),("BS12347",8);


