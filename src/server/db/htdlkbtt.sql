
create database HTDLKBTT;
use HTDLKBTT;

create table ThongTinTaiKhoan (
    Email char(256) primary key,
    ID char(10) unique,
      
    PHash char(64) not null
);

create table BenhNhan (
    ID char(10) primary key,
    HoTen varchar(50) not null,
    NgaySinh date not null,
    SoDT varchar(20),
    
    constraint fk_ThongTinTKBN
    foreign key (ID)
    references ThongTinTaiKhoan(ID)
);

create table ChuyenKhoa (
    ID char(10) primary key,
    TenChuyenKhoa varchar(50) not null unique,
    MoTa varchar(1000)
);

create table BacSi (
    ID char(10) primary key,
    HoTen varchar(50) not null,
    ID_ChuyenKhoa char(10) not null,
    constraint fk_ChuyenKhoaBS
    foreign key (ID_ChuyenKhoa)
    references ChuyenKhoa(ID),
    
    constraint fk_ThongTinTKBS
    foreign key (ID)
    references ThongTinTaiKhoan(ID)
);

create table QuanLy (
    ID char(10) primary key,
    HoTen varchar(50) not null,
    
    constraint fk_ThongTinTKQL
    foreign key (ID)
    references ThongTinTaiKhoan(ID)
);

create table TrangThai (
    ID char(10) primary key,
    TenTrangThai char(50) unique
);

create table Buoi(
     TenBuoi char(20) primary key   
);

create table KhungGio(
     ID int primary key AUTO_INCREMENT,
    Gio_BD date not null,
    Gio_KT date not null,
    Buoi char(20) not null,
    
    constraint fk_Buoi
    foreign key (Buoi)
    references Buoi(TenBuoi)
);

create table LichKham (
    ID char(20) primary key,
    ID_BenhNhan char(10) not null,
    ID_ChuyenKhoa char(10) not null,
    ID_BacSi char(10),
    KhungGio int not null,
    LyDoKham varchar(1000),
    ID_TrangThai char(10) not null,
    
    constraint fk_BenhNhan
    foreign key (ID_BenhNhan)
    references BenhNhan(ID),
    
    constraint fk_BacSi
    foreign key (ID_BacSi)
    references BacSi(ID),
    
    constraint fk_TrangThai
    foreign key (ID_TrangThai)
    references TrangThai(ID),

    constraint fk_KhungGioKham
    foreign key (KhungGio)
    references KhungGio(ID)
);

create table Thu(
 ID int AUTO_INCREMENT primary key,
 TenThu char(10) not null unique
);

create table LichLamViec (
  ID_BacSi char(10),
  ID_KhungGioLamViec int not null,
    
  constraint fk_LichCuaBacSi
  foreign key (ID_BacSi)
  references BacSi(ID),
  
  constraint fk_BuoiLamViec
  foreign key (ID_KhungGioLamViec)
  references KhungGio(ID),
    
  constraint pk_LichLamViec
  primary key (ID_BacSi,ID_KhungGioLamViec)
);

create table LichNghiPhep (
    ID_BacSi char(10) primary key,
    Ngay_BD date not null,
    Ngay_KT date not null,
    LyDo varchar(1500),
    TrangThai char(10) not null,
    
    constraint fk_BacSiNghiPhep
    foreign key (ID_BacSi)
    references BacSi(ID),

    constraint fk_TrangThaiDXNP
    foreign key (TrangThai)
    references TrangThai(ID)
);

create table LichNghi (
    ID_BacSi char(10) primary key,
    ID_Thu int not null,
    
    constraint fk_BacSiNghi
    foreign key (ID_BacSi)
    references BacSi(ID),
    
    constraint fk_NgayNghi
    foreign key (ID_Thu)
    references Thu(ID),
    
    constraint pk_NgayNghiBacSi
    primary key (ID_BacSi, ID_Thu)
);