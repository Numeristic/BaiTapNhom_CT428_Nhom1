drop database htdlkbtt;
create database HTDLKBTT;
use HTDLKBTT;

create table ThongTinTaiKhoan (
    Email char(255) primary key,
    ID int unique,
    
    HoTen varchar(50) not null,
    SoCCCD char(12) not null,
    NgaySinh date not null,
    SoDT varchar(20),
      
    PHash char(64) not null
);

create table BenhNhan (
    ID int AUTO_INCREMENT primary key,
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
    ID int AUTO_INCREMENT primary key,
    ID_ChuyenKhoa char(10) not null,

    constraint fk_ChuyenKhoaBS
    foreign key (ID_ChuyenKhoa)
    references ChuyenKhoa(ID),
    
    constraint fk_ThongTinTKBS
    foreign key (ID)
    references ThongTinTaiKhoan(ID)
);

create table QuanLy (
    ID int AUTO_INCREMENT primary key,
    HoTen varchar(50) not null,
    
    constraint fk_ThongTinTKQL
    foreign key (ID)
    references ThongTinTaiKhoan(ID)
);

create table TrangThai (
    ID int primary key,
    TenTrangThai char(50) unique
);

create table Buoi(
    ID int AUTO_INCREMENT primary key,
    TenBuoi char(20) not null unique
);

create table KhungGio(
    ID int primary key AUTO_INCREMENT,
    Gio_BD time not null,
    Gio_KT time not null,
    ID_Buoi int not null,
    
    constraint fk_Buoi
    foreign key (ID_Buoi)
    references Buoi(ID)
);

create table LichKham (
    ID int AUTO_INCREMENT primary key,

    ID_BenhNhan int not null,

    ID_ChuyenKhoa char(10) not null,
    ID_BacSi int null,
    KhungGio int not null,
    NgayKham date not null,
    LyDoKham varchar(1000),
    ID_TrangThai int not null,
    
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
  ID_BacSi int,
  ID_KhungGio int not null,
    
  constraint fk_LichCuaBacSi
  foreign key (ID_BacSi)
  references BacSi(ID),
  
  constraint fk_BuoiLamViec
  foreign key (ID_KhungGio)
  references KhungGio(ID),
    
  constraint pk_LichLamViec
  primary key (ID_BacSi,ID_KhungGio)
);

create table LichNghiPhep (
    ID_BacSi int primary key,
    Ngay_BD date not null,
    Ngay_KT date not null,
    LyDo varchar(1500),
    TrangThai int not null,
    
    constraint fk_BacSiNghiPhep
    foreign key (ID_BacSi)
    references BacSi(ID),

    constraint fk_TrangThaiDXNP
    foreign key (TrangThai)
    references TrangThai(ID)
);

create table LichNghi (
    ID_BacSi int,
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