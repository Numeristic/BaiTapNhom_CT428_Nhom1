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

insert into TrangThai(ID,TenTrangThai) values(1,"Đang chờ");
insert into TrangThai(ID,TenTrangThai) values(2,"Đã khám");
insert into TrangThai(ID,TenTrangThai) values(3,"Đã hủy");
insert into TrangThai(ID,TenTrangThai) values(4,"Lỡ lịch");
insert into TrangThai(ID,TenTrangThai) values(5,"Từ chối");

insert into KhungGio(Gio_BD,Gio_KT,ID_Buoi) values('07:00:00','08:00:00',1);
insert into KhungGio(Gio_BD,Gio_KT,ID_Buoi) values('08:00:00','09:00:00',1);
insert into KhungGio(Gio_BD,Gio_KT,ID_Buoi) values('09:00:00','10:00:00',1);
insert into KhungGio(Gio_BD,Gio_KT,ID_Buoi) values('10:00:00','11:00:00',1);
insert into KhungGio(Gio_BD,Gio_KT,ID_Buoi) values('11:00:00','12:00:00',1);

insert into KhungGio(Gio_BD,Gio_KT,ID_Buoi) values('13:30:00','14:00:00',2);
insert into KhungGio(Gio_BD,Gio_KT,ID_Buoi) values('14:00:00','15:00:00',2);
insert into KhungGio(Gio_BD,Gio_KT,ID_Buoi) values('15:00:00','16:00:00',2);
insert into KhungGio(Gio_BD,Gio_KT,ID_Buoi) values('16:00:00','17:00:00',2);

insert into KhungGio(Gio_BD,Gio_KT,ID_Buoi) values('17:00:00','18:00:00',3);
insert into KhungGio(Gio_BD,Gio_KT,ID_Buoi) values('18:00:00','19:00:00',3);
insert into KhungGio(Gio_BD,Gio_KT,ID_Buoi) values('19:00:00','20:00:00',3);

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

/* Copy code tới đây nếu chỉ cần dữ liệu danh mục. */

insert into ThongTinTaiKhoan(Email,ID,HoTen,SoCCCD,NgaySinh,SoDT,PHash) values("abcd12345@gmail.com",1,"Nguyễn Văn A","","","","random");
insert into ThongTinTaiKhoan(Email,ID,HoTen,SoCCCD,NgaySinh,SoDT,PHash) values("abcd12346@gmail.com",2,"Nguyễn Văn B","","","","random");
insert into ThongTinTaiKhoan(Email,ID,HoTen,SoCCCD,NgaySinh,SoDT,PHash) values("abcd12347@gmail.com",3,"Lê Thị C","","","","random");
insert into ThongTinTaiKhoan(Email,ID,HoTen,SoCCCD,NgaySinh,SoDT,PHash) values("abcd12348@gmail.com",4,"Nguyễn Thị D","","","","random");
insert into ThongTinTaiKhoan(Email,ID,HoTen,SoCCCD,NgaySinh,SoDT,PHash) values("abcd12349@gmail.com",5,"Lê Thu Hân","","","","random");
insert into bacsi(ID,ID_ChuyenKhoa) values(1,"tmh");
insert into benhnhan(ID) values(1);
insert into bacsi(ID,ID_ChuyenKhoa) values(2,"rhm");
insert into bacsi(ID,ID_ChuyenKhoa) values(3,"nk");
insert into bacsi(ID,ID_ChuyenKhoa) values(4,"dl");
insert into bacsi(ID,ID_ChuyenKhoa) values(5,"dl");

insert into LichLamViec(ID_BacSi,ID_KhungGio) values (4,1),(4,2),(4,3),(4,4);
insert into LichLamViec(ID_BacSi,ID_KhungGio) values (5,1),(5,2),(5,5),(5,6),(5,7),(5,8);
insert into LichLamViec(ID_BacSi,ID_KhungGio) values (3,1),(3,3),(3,5),(3,7),(3,8),(3,10);


