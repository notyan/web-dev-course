/* Basis data */
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `berita` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `berita`;

CREATE TABLE `berita` (
  `id_berita` int(5) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `judul` varchar(100) NOT NULL,
  `baris_kepala` text NOT NULL,
  `isi` text NOT NULL,
  `pengirim` varchar(30) NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT current_timestamp(),
  `id_kategori` int(3) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `kategori` (
  `id_kategori` int(3) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nama_kategori` varchar(30) NOT NULL,
  `deskripsi` varchar(200) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `deskripsi`) VALUES
(1, 'Ruang angkasa', 'Kumpulan berita tentang ruang angkasa'),
(2, 'Teknologi', 'Kumpulan berita tentang teknologi');

INSERT INTO `berita` (`id_berita`,`judul`, `baris_kepala`, `isi`, `pengirim`, `tanggal`, `id_kategori`) VALUES
(69, 'Ini Kronologi Sampah Antariksa Lubangi ISS', 'Sebuah potongan sampah antariksa menghantam Stasiun Luar Angkasa Internasional (ISS). Hantaman dari puing luar angkasa tersebut menyebabkan lubang di salah satu lengan robotik Canadarm2.',
'NEW YORK - Sebuah potongan sampah antariksa menghantam Stasiun Luar Angkasa Internasional (ISS). Hantaman dari puing luar angkasa tersebut menyebabkan lubang di salah satu lengan robotik Canadarm2.
Canadarm2 sendiri adalah lengan robot yang dirancang oleh badan antariksa Kanada (CSA). Lengan robot ini sudah menjadi bagian ISS selama 20 tahun dan berfungsi untuk memanuver objek di luar ISS, seperti angkutan kargo.
Setelah terjadi tabrakan, instrumen tersebut memang masih beroperasi, tapi puing sampah berhasil menembus lapisan termal dan merusak bagian di bawahnya.
Tidak diketahui kapan tepatnya tabrakan terjadi, namun kerusakan ini baru terdeteksi pada 12 Mei saat inspeksi rutin. NASA dan CSA sudah bekerjasama untuk mengambil foto yang jelas dan meneliti kerusakan yang ditimbulkan.
"Terlepas dari hantaman, hasil analisis yang sedang berlangsung mengindikasikan bahwa kinerja lengan tetap tidak terpengaruh," kata CSA dalam blog, seperti dikutip dari Science Alert, Selasa (1/6/2021).
Kejadian ini tentu menjadi pengingat yang serius bahwa masalah sampah luar angkasa orbit rendah Bumi adalah bom waktu yang terus berjalan.
Badan antariksa di banyak negara sudah menyadari masalah sampah antariksa ini. Lebih dari 23.000 objek yang berada di orbit Bumi rendah telah dilacak untuk menghindari tabrakan antara satelit dan ISS.
Tapi ukuran benda antariksa yang bisa dilacak hanya yang seukuran bola softball dan lebih besar. Objek yang ukurannya lebih kecil sulit untuk dilacak, tapi jika objek itu terbang dengan kecepatan tinggi tetap bisa menghasilkan kerusakan yang signifikan.
Meskipun ISS kali ini tampaknya beruntung, masalah sampah antariksa tampaknya semakin meningkat. Tahun lalu, ISS harus melakukan manuver darurat tiga kali untuk menghindari tabrakan dengan puing-puing luar angkasa di ketinggian sekitar 400 kilometer.',
'Intan Rakhmayanti Dewi', '2021-05-10 13:47:15', '1');

CREATE TABLE `komentar` (
  `id_komentar` int(5) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `komentator` varchar(128) NOT NULL,
  `isi` text NOT NULL,
  `waktu` datetime NOT NULL DEFAULT current_timestamp(),
  `id_berita` int(5) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;