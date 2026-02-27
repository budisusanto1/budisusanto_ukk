-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2026 at 11:43 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `parkir1`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2026-02-25-061253', 'App\\Database\\Migrations\\CreateTbUserTable', 'default', 'App', 1771999992, 1),
(2, '2026-02-25-062744', 'App\\Database\\Migrations\\AddNamaLengkapToTbUser', 'default', 'App', 1772000878, 2),
(3, '2026-02-25-064436', 'App\\Database\\Migrations\\CreateTbKendaraanTable', 'default', 'App', 1772001900, 3),
(4, '2026-02-25-065449', 'App\\Database\\Migrations\\CreateTbTransaksiTable', 'default', 'App', 1772002505, 4),
(5, '2026-02-25-065543', 'App\\Database\\Migrations\\CreateTbTarifTable', 'default', 'App', 1772002581, 5),
(6, '2026-02-25-065749', 'App\\Database\\Migrations\\AddForeignKeyTarifToTransaksi', 'default', 'App', 1772002686, 6),
(7, '2026-02-25-065953', 'App\\Database\\Migrations\\CreateTbLogAktivitasTable', 'default', 'App', 1772002821, 7),
(8, '2026-02-25-070225', 'App\\Database\\Migrations\\CreateTbAreaParkirTable', 'default', 'App', 1772002970, 8),
(9, '2026-02-25-070402', 'App\\Database\\Migrations\\AddForeignKeyAreaToTransaksi', 'default', 'App', 1772003062, 9),
(10, '2026-02-25-075749', 'App\\Database\\Migrations\\FixLogAktivitasForeignKey', 'default', 'App', 1772006345, 10),
(11, '2026-02-25-143500', 'App\\Database\\Migrations\\SimplifyLogAktivitasTable', 'default', 'App', 1772026582, 11),
(12, '2026-02-26-024801', 'App\\Database\\Migrations\\AddMetodePembayaranToTbTransaksi', 'default', 'App', 1772074094, 12);

-- --------------------------------------------------------

--
-- Table structure for table `tb_area_parkir`
--

CREATE TABLE `tb_area_parkir` (
  `id_area` int(11) UNSIGNED NOT NULL,
  `nama_area` varchar(100) NOT NULL,
  `kapasitas` int(11) NOT NULL DEFAULT 0,
  `terisi` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_area_parkir`
--

INSERT INTO `tb_area_parkir` (`id_area`, `nama_area`, `kapasitas`, `terisi`, `created_at`, `updated_at`) VALUES
(1, 'Area A - Mobil', 50, 0, '2026-02-25 07:29:49', '2026-02-25 07:29:49'),
(2, 'Area B - Motor', 100, 0, '2026-02-25 07:29:49', '2026-02-25 07:29:49'),
(3, 'Area C - Bus/Truk', 20, 0, '2026-02-25 07:29:49', '2026-02-25 07:29:49'),
(4, 'Area D - VIP', 10, 0, '2026-02-25 07:29:49', '2026-02-25 07:29:49'),
(5, 'hwa', 10, 0, '2026-02-25 07:36:03', '2026-02-25 07:36:03'),
(6, 'area b motor', 100, 1, '2026-02-25 13:47:24', '2026-02-25 13:47:24'),
(7, 'area b motor', 100, 1, '2026-02-25 13:47:24', '2026-02-25 13:47:24'),
(9, 'area c motor', 10, 1, '2026-02-25 13:50:06', '2026-02-25 13:50:06'),
(10, 'Area A', 50, 25, NULL, NULL),
(11, 'Area B', 30, 15, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_kendaraan`
--

CREATE TABLE `tb_kendaraan` (
  `id_kendaraan` int(11) UNSIGNED NOT NULL,
  `plat_nomor` varchar(20) NOT NULL,
  `jenis_kendaraan` enum('mobil','motor','truk','bus','lainnya') NOT NULL,
  `warna` varchar(50) DEFAULT NULL,
  `pemilik` varchar(100) DEFAULT NULL,
  `id_user` int(11) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_kendaraan`
--

INSERT INTO `tb_kendaraan` (`id_kendaraan`, `plat_nomor`, `jenis_kendaraan`, `warna`, `pemilik`, `id_user`, `created_at`, `updated_at`) VALUES
(1, 'b1233w', 'motor', 'merah', 'budi', 4, '2026-02-25 07:12:52', '2026-02-25 07:14:21'),
(2, 'b1287u', 'mobil', 'hitam', 'kevin', 4, '2026-02-25 13:46:26', '2026-02-25 13:46:26'),
(4, 'B1234ABC', 'mobil', 'Hitam', 'Ahmad Yani', 4, '0000-00-00 00:00:00', NULL),
(5, 'C5678DEF', 'motor', 'Merah', 'Siti Nurhaliza', 4, '0000-00-00 00:00:00', NULL),
(6, 'B1234ABC', 'mobil', 'Hitam', 'Ahmad Yani', 4, '2026-02-25 16:24:29', '2026-02-25 16:24:29'),
(7, 'C5678DEF', 'motor', 'Merah', 'Siti Nurhaliza', 4, '2026-02-25 16:24:29', '2026-02-25 16:24:29');

-- --------------------------------------------------------

--
-- Table structure for table `tb_log_aktivitas`
--

CREATE TABLE `tb_log_aktivitas` (
  `id_log` int(11) UNSIGNED NOT NULL,
  `id_user` int(11) UNSIGNED DEFAULT NULL,
  `aktivitas` varchar(255) NOT NULL,
  `waktu_aktivitas` datetime NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_log_aktivitas`
--

INSERT INTO `tb_log_aktivitas` (`id_log`, `id_user`, `aktivitas`, `waktu_aktivitas`, `ip_address`) VALUES
(3, 4, 'Mengakses halaman Log Aktivitas', '2026-02-25 13:38:50', '::1'),
(4, 4, 'Mengakses halaman Log Aktivitas', '2026-02-25 13:38:58', '::1'),
(5, 4, 'Mengakses halaman Log Aktivitas', '2026-02-25 13:39:01', '::1'),
(6, 4, 'Mengakses halaman Log Aktivitas', '2026-02-25 13:39:01', '::1'),
(7, 4, 'Mengakses halaman Manajemen User', '2026-02-25 13:39:21', '::1'),
(8, 4, 'Membuka form tambah user baru', '2026-02-25 13:42:48', '::1'),
(9, 4, 'Gagal menambah user: Password minimal 6 karakter, Silakan verifikasi reCAPTCHA', '2026-02-25 13:43:01', '::1'),
(10, 4, 'Membuka form tambah user baru', '2026-02-25 13:43:01', '::1'),
(11, 4, 'Mengakses halaman Manajemen User', '2026-02-25 13:43:06', '::1'),
(12, 4, 'Mengakses halaman Manajemen User', '2026-02-25 13:43:07', '::1'),
(13, 4, 'Mengakses halaman Manajemen User', '2026-02-25 13:45:24', '::1'),
(14, 4, 'Membuka form tambah user baru', '2026-02-25 13:45:25', '::1'),
(15, 4, 'Gagal menambah user: Password minimal 6 karakter, Silakan verifikasi reCAPTCHA', '2026-02-25 13:45:34', '::1'),
(16, 4, 'Membuka form tambah user baru', '2026-02-25 13:45:35', '::1'),
(17, 4, 'Mengakses halaman Manajemen User', '2026-02-25 13:45:39', '::1'),
(18, 4, 'Mengakses halaman Manajemen User', '2026-02-25 13:45:40', '::1'),
(19, 4, 'Mengakses halaman Manajemen Kendaraan', '2026-02-25 13:46:09', '::1'),
(20, 4, 'Membuka form tambah kendaraan baru', '2026-02-25 13:46:10', '::1'),
(21, 4, 'Create kendaraan - Plat: b1287u, Jenis: mobil', '2026-02-25 13:46:26', '::1'),
(22, 4, 'Mengakses halaman Manajemen Kendaraan', '2026-02-25 13:46:26', '::1'),
(23, 4, 'Mengakses halaman Manajemen Tarif', '2026-02-25 13:46:34', '::1'),
(24, 4, 'Membuka form tambah tarif baru', '2026-02-25 13:46:37', '::1'),
(25, 4, 'Membuka form tambah tarif baru', '2026-02-25 13:46:37', '::1'),
(26, 4, 'Membuka form tambah tarif baru', '2026-02-25 13:46:47', '::1'),
(27, 4, 'Mengakses halaman Manajemen Tarif', '2026-02-25 13:46:50', '::1'),
(28, 4, 'Mengakses halaman Manajemen Tarif', '2026-02-25 13:46:52', '::1'),
(29, 4, 'Mengakses halaman Manajemen Tarif', '2026-02-25 13:46:55', '::1'),
(30, 4, 'Mengakses halaman Manajemen Area Parkir', '2026-02-25 13:46:58', '::1'),
(31, 4, 'Membuka form tambah area parkir baru', '2026-02-25 13:47:05', '::1'),
(32, 4, 'Create area parkir - Area: area b motor, Kapasitas: 100, Terisi: 1', '2026-02-25 13:47:24', '::1'),
(33, 4, 'Create area parkir - Area: area b motor, Kapasitas: 100, Terisi: 1', '2026-02-25 13:47:24', '::1'),
(34, 4, 'Mengakses halaman Manajemen Area Parkir', '2026-02-25 13:47:24', '::1'),
(35, 4, 'Mengakses halaman Manajemen Area Parkir', '2026-02-25 13:47:27', '::1'),
(36, 4, 'Mengakses halaman Manajemen Area Parkir', '2026-02-25 13:47:29', '::1'),
(37, 4, 'Mengakses halaman Manajemen Area Parkir', '2026-02-25 13:47:32', '::1'),
(38, 4, 'Mengakses halaman Manajemen Area Parkir', '2026-02-25 13:47:34', '::1'),
(39, 4, 'Mengakses halaman Manajemen Kendaraan', '2026-02-25 13:47:46', '::1'),
(40, 4, 'Mengakses halaman Manajemen Kendaraan', '2026-02-25 13:49:33', '::1'),
(41, 4, 'Mengakses halaman Manajemen Tarif', '2026-02-25 13:49:42', '::1'),
(42, 4, 'Membuka form tambah tarif baru', '2026-02-25 13:49:43', '::1'),
(43, 4, 'Membuka form tambah tarif baru', '2026-02-25 13:49:52', '::1'),
(44, 4, 'Mengakses halaman Manajemen Area Parkir', '2026-02-25 13:49:57', '::1'),
(45, 4, 'Membuka form tambah area parkir baru', '2026-02-25 13:49:59', '::1'),
(46, 4, 'Create area parkir - Area: area c motor, Kapasitas: 10, Terisi: 1', '2026-02-25 13:50:06', '::1'),
(47, 4, 'Mengakses halaman Manajemen Area Parkir', '2026-02-25 13:50:07', '::1'),
(48, 4, 'Mengakses halaman Manajemen Area Parkir', '2026-02-25 13:50:27', '::1'),
(49, 4, 'Mengakses halaman Manajemen Area Parkir', '2026-02-25 13:50:31', '::1'),
(50, 4, 'Mengakses halaman Manajemen Tarif', '2026-02-25 13:50:36', '::1'),
(51, 4, 'Mengakses halaman Manajemen User', '2026-02-25 13:50:50', '::1'),
(52, 4, 'Membuka form tambah user baru', '2026-02-25 13:50:51', '::1'),
(53, 4, 'Gagal menambah user: Password minimal 6 karakter', '2026-02-25 13:51:00', '::1'),
(54, 4, 'Membuka form tambah user baru', '2026-02-25 13:51:00', '::1'),
(55, 4, 'Mengakses halaman Manajemen User', '2026-02-25 13:51:03', '::1'),
(56, 4, 'Mengakses halaman Manajemen User', '2026-02-25 13:51:04', '::1'),
(57, 4, 'Mengakses halaman Manajemen User', '2026-02-25 13:52:29', '::1'),
(58, 4, 'Membuka form tambah user baru', '2026-02-25 13:52:31', '::1'),
(59, 4, 'Gagal menambah user: Password minimal 6 karakter', '2026-02-25 13:52:37', '::1'),
(60, 4, 'Membuka form tambah user baru', '2026-02-25 13:52:37', '::1'),
(61, 4, 'Mengakses halaman Manajemen User', '2026-02-25 13:52:40', '::1'),
(62, 4, 'Mengakses halaman Manajemen User', '2026-02-25 13:52:41', '::1'),
(63, 4, 'Mengakses halaman Manajemen User', '2026-02-25 13:52:52', '::1'),
(64, 4, 'Membuka form tambah user baru', '2026-02-25 13:52:53', '::1'),
(65, 4, 'Gagal menambah user: Password minimal 6 karakter', '2026-02-25 13:53:05', '::1'),
(66, 4, 'Membuka form tambah user baru', '2026-02-25 13:53:05', '::1'),
(67, 4, 'Mengakses halaman Manajemen User', '2026-02-25 13:53:07', '::1'),
(68, 4, 'Mengakses halaman Manajemen User', '2026-02-25 13:53:08', '::1'),
(69, 4, 'Mengakses halaman Manajemen User', '2026-02-25 13:54:46', '::1'),
(70, 4, 'Membuka form tambah user baru', '2026-02-25 13:54:48', '::1'),
(71, 4, 'Gagal menambah user: Password minimal 6 karakter', '2026-02-25 13:54:55', '::1'),
(72, 4, 'Membuka form tambah user baru', '2026-02-25 13:54:56', '::1'),
(73, 12, 'Register user baru (Username: Budisusanto)', '2026-02-25 13:57:16', '::1'),
(74, 4, 'Mengakses halaman Manajemen User', '2026-02-25 13:57:21', '::1'),
(75, 4, 'Membuka form edit user ID: 12', '2026-02-25 13:57:50', '::1'),
(76, 4, 'Gagal update user ID: 12 - Username sudah digunakan', '2026-02-25 13:57:58', '::1'),
(77, 4, 'Membuka form edit user ID: 12', '2026-02-25 13:57:58', '::1'),
(78, 4, 'Gagal update user ID: 12 - Username sudah digunakan', '2026-02-25 13:57:59', '::1'),
(79, 4, 'Membuka form edit user ID: 12', '2026-02-25 13:58:00', '::1'),
(80, 4, 'Gagal update user ID: 12 - Username sudah digunakan', '2026-02-25 13:58:06', '::1'),
(81, 4, 'Gagal update user ID: 12 - Username sudah digunakan', '2026-02-25 13:58:06', '::1'),
(82, 4, 'Membuka form edit user ID: 12', '2026-02-25 13:58:07', '::1'),
(83, 4, 'Mengakses halaman Manajemen User', '2026-02-25 13:58:11', '::1'),
(84, 4, 'Mengakses halaman Manajemen User', '2026-02-25 13:58:13', '::1'),
(85, 4, 'Membuka form tambah user baru', '2026-02-25 13:58:22', '::1'),
(86, 4, 'Membuka form tambah user baru', '2026-02-25 13:58:37', '::1'),
(87, 13, 'Register user baru (Username: admin)', '2026-02-25 13:58:54', '::1'),
(88, 4, 'Mengakses halaman Manajemen User', '2026-02-25 13:58:54', '::1'),
(89, 4, 'Membuka form edit user ID: 13', '2026-02-25 13:58:59', '::1'),
(90, 4, 'Update user - Username: admin → admins', '2026-02-25 13:59:02', '::1'),
(91, 4, 'Mengakses halaman Manajemen User', '2026-02-25 13:59:02', '::1'),
(92, 4, 'Membuka form edit user ID: 13', '2026-02-25 13:59:07', '::1'),
(93, 4, 'Membuka form edit user ID: 13', '2026-02-25 13:59:07', '::1'),
(94, 4, 'Gagal update user ID: 13 - Username sudah digunakan', '2026-02-25 13:59:11', '::1'),
(95, 4, 'Gagal update user ID: 13 - Username sudah digunakan', '2026-02-25 13:59:11', '::1'),
(96, 4, 'Membuka form edit user ID: 13', '2026-02-25 13:59:11', '::1'),
(97, 4, 'Membuka form edit user ID: 13', '2026-02-25 14:02:30', '::1'),
(98, 4, 'Mengakses halaman Manajemen User', '2026-02-25 14:02:35', '::1'),
(99, 4, 'Membuka form edit user ID: 13', '2026-02-25 14:02:38', '::1'),
(100, 4, 'Gagal update user ID: 13 - Username sudah digunakan', '2026-02-25 14:02:41', '::1'),
(101, 4, 'Membuka form edit user ID: 13', '2026-02-25 14:02:41', '::1'),
(102, 4, 'Mengakses halaman Manajemen User', '2026-02-25 14:02:43', '::1'),
(103, 4, 'Mengakses halaman Manajemen User', '2026-02-25 14:02:45', '::1'),
(104, 4, 'Mengakses halaman Manajemen User', '2026-02-25 14:05:49', '::1'),
(105, 4, 'Membuka form edit user ID: 13', '2026-02-25 14:05:52', '::1'),
(106, 4, 'Mengakses halaman Manajemen User', '2026-02-25 14:05:55', '::1'),
(107, 4, 'Mengakses halaman Manajemen User', '2026-02-25 14:05:56', '::1'),
(108, 4, 'Mengakses halaman Manajemen User', '2026-02-25 14:08:23', '::1'),
(109, 4, 'Mengakses halaman Manajemen User', '2026-02-25 14:08:29', '::1'),
(110, 4, 'Membuka form edit user ID: 13', '2026-02-25 14:08:31', '::1'),
(111, 4, 'Membuka form edit user ID: 13', '2026-02-25 14:08:35', '::1'),
(112, 4, 'Mengakses halaman Manajemen User', '2026-02-25 14:08:37', '::1'),
(113, 4, 'Membuka form tambah user baru', '2026-02-25 14:08:55', '::1'),
(114, 14, 'Register user baru (Username: justin)', '2026-02-25 14:09:07', '::1'),
(115, 4, 'Mengakses halaman Manajemen User', '2026-02-25 14:09:07', '::1'),
(116, 4, 'Mengakses halaman Manajemen User', '2026-02-25 14:09:08', '::1'),
(117, 4, 'Mengakses halaman Manajemen User', '2026-02-25 14:09:41', '::1'),
(118, 4, 'Mengakses halaman Manajemen User', '2026-02-25 14:10:57', '::1'),
(119, 4, 'Membuka form edit user ID: 14', '2026-02-25 14:11:03', '::1'),
(120, 4, 'Membuka form edit user ID: 14', '2026-02-25 14:11:07', '::1'),
(121, 4, 'Membuka form edit user ID: 14', '2026-02-25 14:11:13', '::1'),
(122, 4, 'Membuka form edit user ID: 14', '2026-02-25 14:11:20', '::1'),
(123, 4, 'Membuka form edit user ID: 14', '2026-02-25 14:11:23', '::1'),
(124, 4, 'Membuka form edit user ID: 14', '2026-02-25 14:11:48', '::1'),
(125, 4, 'Membuka form edit user ID: 14', '2026-02-25 14:11:52', '::1'),
(126, 4, 'Membuka form edit user ID: 14', '2026-02-25 14:13:28', '::1'),
(127, 4, 'Update user - Username: justin → justins', '2026-02-25 14:13:31', '::1'),
(128, 4, 'Gagal update user ID: 14 - Username sudah digunakan', '2026-02-25 14:13:31', '::1'),
(129, 4, 'Membuka form edit user ID: 14', '2026-02-25 14:13:31', '::1'),
(130, 4, 'Gagal update user ID: 14 - Username sudah digunakan', '2026-02-25 14:13:33', '::1'),
(131, 4, 'Membuka form edit user ID: 14', '2026-02-25 14:13:33', '::1'),
(132, 4, 'Membuka form edit user ID: 14', '2026-02-25 14:14:37', '::1'),
(133, 4, 'Update user - Username: justins → justin', '2026-02-25 14:14:41', '::1'),
(134, 4, 'Gagal update user ID: 14 - Username sudah digunakan', '2026-02-25 14:15:03', '::1'),
(135, 4, 'Membuka form edit user ID: 14', '2026-02-25 14:15:03', '::1'),
(136, 4, 'Update user - Username: justin → justins', '2026-02-25 14:15:05', '::1'),
(137, 4, 'Mengakses halaman Manajemen User', '2026-02-25 14:15:05', '::1'),
(138, 4, 'Delete user - Username: testuser3s, Role: petugas', '2026-02-25 14:15:11', '::1'),
(139, 4, 'Hapus user: testuser3s', '2026-02-25 14:15:11', '::1'),
(140, 4, 'Mengakses halaman Manajemen User', '2026-02-25 14:15:11', '::1'),
(141, 4, 'Delete user - Username: webtest4, Role: petugas', '2026-02-25 14:15:14', '::1'),
(142, 4, 'Hapus user: webtest4', '2026-02-25 14:15:14', '::1'),
(143, 4, 'Mengakses halaman Manajemen User', '2026-02-25 14:15:14', '::1'),
(144, 4, 'Membuka form edit user ID: 14', '2026-02-25 14:15:16', '::1'),
(145, 4, 'Update user - Username: justins → justin', '2026-02-25 14:15:18', '::1'),
(146, 4, 'Mengakses halaman Manajemen User', '2026-02-25 14:15:18', '::1'),
(147, 4, 'Mengakses halaman Manajemen User', '2026-02-25 14:15:24', '::1'),
(148, 4, 'Membuka form edit user ID: 14', '2026-02-25 14:15:25', '::1'),
(149, 4, 'Update user - Username: justin → justins', '2026-02-25 14:15:27', '::1'),
(150, 4, 'Mengakses halaman Manajemen User', '2026-02-25 14:15:28', '::1'),
(151, 4, 'Membuka form edit user ID: 14', '2026-02-25 14:15:33', '::1'),
(152, 4, 'Membuka form edit user ID: 14', '2026-02-25 14:15:33', '::1'),
(153, 4, 'Membuka form edit user ID: 14', '2026-02-25 14:15:37', '::1'),
(154, 4, 'Mengakses halaman Manajemen User', '2026-02-25 14:15:39', '::1'),
(155, 4, 'Mengakses halaman Manajemen User', '2026-02-25 14:15:39', '::1'),
(156, 4, 'Mengakses halaman Manajemen User', '2026-02-25 14:16:10', '::1'),
(157, 4, 'Mengakses halaman Manajemen User', '2026-02-25 14:16:10', '::1'),
(158, 4, 'Mengakses halaman Manajemen User', '2026-02-25 14:16:10', '::1'),
(159, 4, 'Membuka form edit user ID: 14', '2026-02-25 14:16:12', '::1'),
(160, 4, 'Membuka form edit user ID: 14', '2026-02-25 14:16:13', '::1'),
(161, 4, 'Membuka form edit user ID: 14', '2026-02-25 14:16:48', '::1'),
(162, 4, 'Update user - Username: justins → justin', '2026-02-25 14:16:51', '::1'),
(163, 4, 'Mengakses halaman Manajemen User', '2026-02-25 14:16:51', '::1'),
(164, 4, 'Mengakses halaman Manajemen User', '2026-02-25 14:16:52', '::1'),
(165, 4, 'Membuka form tambah user baru', '2026-02-25 14:16:54', '::1'),
(166, 4, 'Mengakses halaman Manajemen User', '2026-02-25 14:17:53', '::1'),
(167, 4, 'Mengakses halaman Manajemen User', '2026-02-25 14:17:54', '::1'),
(168, 4, 'Mengakses halaman Manajemen User', '2026-02-25 14:18:18', '::1'),
(169, 4, 'Membuka form tambah user baru', '2026-02-25 14:18:19', '::1'),
(170, 4, 'Membuka form tambah user baru', '2026-02-25 14:18:19', '::1'),
(171, 15, 'Register user baru (Username: ssa)', '2026-02-25 14:18:30', '::1'),
(172, 4, 'Gagal menambah user: Username sudah digunakan', '2026-02-25 14:18:30', '::1'),
(173, 4, 'Membuka form tambah user baru', '2026-02-25 14:18:30', '::1'),
(174, 16, 'Register user baru (Username: budisusanto9)', '2026-02-25 14:19:05', '::1'),
(175, 4, 'Mengakses halaman Manajemen User', '2026-02-25 14:19:05', '::1'),
(176, 4, 'Mengakses halaman Manajemen User', '2026-02-25 14:19:06', '::1'),
(177, 4, 'Mengakses halaman Log Aktivitas', '2026-02-25 14:19:11', '::1'),
(178, 4, 'Mengakses halaman Manajemen Tarif', '2026-02-25 14:19:38', '::1'),
(179, 4, 'Membuka form tambah tarif baru', '2026-02-25 14:19:39', '::1'),
(180, 4, 'Membuka form tambah tarif baru', '2026-02-25 14:19:39', '::1'),
(181, 4, 'Membuka form tambah tarif baru', '2026-02-25 14:19:44', '::1'),
(182, 4, 'Membuka form tambah tarif baru', '2026-02-25 14:20:15', '::1'),
(183, 4, 'Membuka form tambah tarif baru', '2026-02-25 14:21:58', '::1'),
(184, 4, 'Membuka form tambah tarif baru', '2026-02-25 14:22:03', '::1'),
(185, 4, 'Membuka form tambah tarif baru', '2026-02-25 14:23:29', '::1'),
(186, 4, 'Mengakses halaman Manajemen Tarif', '2026-02-25 14:23:57', '::1'),
(187, 4, 'Membuka form edit tarif ID: 2', '2026-02-25 14:23:59', '::1'),
(188, 4, 'Membuka form edit tarif ID: 2', '2026-02-25 14:39:30', '::1'),
(189, 4, 'Mengakses halaman Manajemen Tarif', '2026-02-25 14:41:51', '::1'),
(190, 4, 'Mengakses halaman Manajemen Tarif', '2026-02-25 14:41:53', '::1'),
(191, 4, 'Membuka form edit tarif ID: 2', '2026-02-25 14:41:55', '::1'),
(192, 4, 'Membuka form edit tarif ID: 2', '2026-02-25 14:41:55', '::1'),
(193, 4, 'Update tarif - Tarif Motor → Rp 200,000', '2026-02-25 14:44:25', '::1'),
(194, 4, 'Mengakses halaman Manajemen Tarif', '2026-02-25 14:44:25', '::1'),
(195, 4, 'Membuka form tambah tarif baru', '2026-02-25 14:44:32', '::1'),
(196, 4, 'Membuka form tambah tarif baru', '2026-02-25 14:44:36', '::1'),
(197, 4, 'Mengakses halaman Manajemen Tarif', '2026-02-25 14:44:37', '::1'),
(198, 4, 'Mengakses halaman Manajemen Area Parkir', '2026-02-25 14:44:41', '::1'),
(199, 4, 'Logout', '2026-02-25 14:44:43', '::1'),
(200, 3, 'Login berhasil (Username: dewasa)', '2026-02-25 14:44:57', '::1'),
(201, 3, 'Mengakses halaman Dashboard', '2026-02-25 14:44:57', '::1'),
(202, 3, 'Mengakses halaman Dashboard', '2026-02-25 14:47:31', '::1'),
(203, 3, 'Mengakses halaman transaksi masuk', '2026-02-25 14:49:45', '::1'),
(204, 3, 'Mengakses halaman transaksi masuk', '2026-02-25 14:49:55', '::1'),
(205, 3, 'Mengakses halaman transaksi masuk', '2026-02-25 14:50:54', '::1'),
(206, 3, 'Mengakses halaman transaksi masuk', '2026-02-25 14:51:03', '::1'),
(207, 3, 'Mengakses halaman transaksi keluar', '2026-02-25 14:51:07', '::1'),
(208, 3, 'Mengakses halaman Dashboard', '2026-02-25 14:51:10', '::1'),
(209, 3, 'Mengakses halaman transaksi masuk', '2026-02-25 14:51:13', '::1'),
(210, 3, 'Mengakses halaman transaksi masuk', '2026-02-25 14:53:24', '::1'),
(211, 3, 'Transaksi masuk: B1233W (motor)', '2026-02-25 14:53:55', '::1'),
(212, 3, 'Transaksi masuk: B1233W (motor)', '2026-02-25 14:53:55', '::1'),
(213, 3, 'Mengakses halaman transaksi masuk', '2026-02-25 14:53:55', '::1'),
(214, 3, 'Mengakses halaman Dashboard', '2026-02-25 14:55:44', '::1'),
(215, 3, 'Mengakses halaman transaksi keluar', '2026-02-25 14:55:46', '::1'),
(216, 3, 'Mengakses halaman Dashboard', '2026-02-25 14:55:55', '::1'),
(217, 3, 'Mengakses halaman Dashboard', '2026-02-25 14:56:04', '::1'),
(218, 3, 'Mengakses halaman transaksi masuk', '2026-02-25 14:56:06', '::1'),
(219, 3, 'Mengakses halaman transaksi masuk', '2026-02-25 14:56:35', '::1'),
(220, 3, 'Mengakses halaman Manajemen Tarif', '2026-02-25 14:56:42', '::1'),
(221, 3, 'Mengakses halaman transaksi keluar', '2026-02-25 14:56:45', '::1'),
(222, 3, 'Mengakses halaman transaksi keluar', '2026-02-25 14:57:07', '::1'),
(223, 3, 'Mengakses halaman transaksi keluar', '2026-02-25 14:57:16', '::1'),
(224, 3, 'Mengakses halaman transaksi keluar', '2026-02-25 14:57:30', '::1'),
(225, 3, 'Mengakses halaman Dashboard', '2026-02-25 14:57:39', '::1'),
(226, 3, 'Mengakses halaman transaksi keluar', '2026-02-25 14:57:42', '::1'),
(227, 3, 'Mengakses halaman transaksi keluar', '2026-02-25 14:58:02', '::1'),
(228, 3, 'Mengakses halaman transaksi keluar', '2026-02-25 14:58:32', '::1'),
(229, 3, 'Mengakses halaman transaksi keluar', '2026-02-25 14:58:46', '::1'),
(230, 3, 'Mengakses halaman transaksi keluar', '2026-02-25 14:59:17', '::1'),
(231, 3, 'Mengakses halaman transaksi keluar', '2026-02-25 14:59:20', '::1'),
(232, 3, 'Mengakses halaman transaksi masuk', '2026-02-25 14:59:22', '::1'),
(233, 3, 'Mengakses halaman transaksi keluar', '2026-02-25 14:59:23', '::1'),
(234, 3, 'Mengakses halaman transaksi keluar', '2026-02-25 15:05:36', '::1'),
(235, 3, 'Mengakses halaman transaksi masuk', '2026-02-25 15:05:39', '::1'),
(236, 3, 'Transaksi masuk: B1233W (motor)', '2026-02-25 15:05:48', '::1'),
(237, 3, 'Mengakses halaman transaksi masuk', '2026-02-25 15:05:48', '::1'),
(238, 3, 'Mengakses halaman transaksi keluar', '2026-02-25 15:05:50', '::1'),
(239, 3, 'Mengakses halaman transaksi keluar', '2026-02-25 15:05:52', '::1'),
(240, 3, 'Mengakses halaman transaksi keluar', '2026-02-25 15:05:54', '::1'),
(241, 3, 'Mengakses halaman Dashboard', '2026-02-25 15:06:11', '::1'),
(242, 3, 'Mengakses halaman Manajemen Tarif', '2026-02-25 15:06:14', '::1'),
(243, 3, 'Mengakses halaman Manajemen Tarif', '2026-02-25 15:06:38', '::1'),
(244, 3, 'Mengakses halaman transaksi keluar', '2026-02-25 15:06:39', '::1'),
(245, 3, 'Mengakses halaman transaksi keluar', '2026-02-25 15:06:40', '::1'),
(246, 3, 'Mengakses halaman Manajemen Tarif', '2026-02-25 15:06:42', '::1'),
(247, 3, 'Mengakses halaman transaksi keluar', '2026-02-25 15:06:43', '::1'),
(248, 3, 'Mengakses halaman transaksi keluar', '2026-02-25 15:07:13', '::1'),
(249, 3, 'Mengakses halaman transaksi keluar', '2026-02-25 15:07:17', '::1'),
(250, 3, 'Mengakses halaman transaksi keluar', '2026-02-25 15:07:44', '::1'),
(251, 3, 'Mengakses halaman Dashboard', '2026-02-25 15:07:52', '::1'),
(252, 3, 'Mengakses halaman transaksi masuk', '2026-02-25 15:07:54', '::1'),
(253, 3, 'Transaksi masuk: B1233W (motor)', '2026-02-25 15:08:01', '::1'),
(254, 3, 'Mengakses halaman transaksi masuk', '2026-02-25 15:08:01', '::1'),
(255, 3, 'Mengakses halaman transaksi keluar', '2026-02-25 15:08:04', '::1'),
(256, 3, 'Mengakses halaman transaksi keluar', '2026-02-25 15:08:04', '::1'),
(257, 3, 'Mengakses halaman transaksi keluar', '2026-02-25 15:08:28', '::1'),
(258, 3, 'Mengakses halaman transaksi keluar', '2026-02-25 15:08:59', '::1'),
(259, 3, 'Mengakses halaman transaksi keluar', '2026-02-25 15:09:30', '::1'),
(260, 3, 'Mengakses halaman transaksi keluar', '2026-02-25 15:10:01', '::1'),
(261, 3, 'Mengakses halaman transaksi keluar', '2026-02-25 15:10:32', '::1'),
(262, 3, 'Mengakses halaman transaksi keluar', '2026-02-25 15:13:18', '::1'),
(263, 3, 'Mengakses halaman transaksi keluar', '2026-02-25 15:13:19', '::1'),
(264, 3, 'Mengakses halaman Manajemen Tarif', '2026-02-25 15:13:20', '::1'),
(265, 3, 'Mengakses halaman Manajemen Tarif', '2026-02-25 15:13:20', '::1'),
(266, 3, 'Mengakses halaman Manajemen Tarif', '2026-02-25 15:13:21', '::1'),
(267, 3, 'Mengakses halaman Manajemen Tarif', '2026-02-25 15:13:39', '::1'),
(268, 3, 'Mengakses halaman Manajemen Tarif', '2026-02-25 15:13:59', '::1'),
(269, 3, 'Mengakses halaman daftar struk', '2026-02-25 15:14:01', '::1'),
(270, 3, 'Mengakses halaman daftar struk', '2026-02-25 15:14:07', '::1'),
(271, 3, 'Mengakses halaman daftar struk', '2026-02-25 15:14:09', '::1'),
(272, 3, 'Mengakses halaman daftar struk', '2026-02-25 15:14:39', '::1'),
(273, 3, 'Mengakses halaman transaksi masuk', '2026-02-25 15:14:45', '::1'),
(274, 3, 'Mengakses halaman transaksi masuk', '2026-02-25 15:14:45', '::1'),
(275, 3, 'Transaksi masuk: B1233W (mobil)', '2026-02-25 15:14:52', '::1'),
(276, 3, 'Mengakses halaman transaksi masuk', '2026-02-25 15:14:52', '::1'),
(277, 3, 'Mengakses halaman daftar struk', '2026-02-25 15:14:54', '::1'),
(278, 3, 'Mengakses halaman daftar struk', '2026-02-25 15:14:54', '::1'),
(279, 3, 'Mengakses halaman transaksi keluar', '2026-02-25 15:14:55', '::1'),
(280, 3, 'Mengakses halaman transaksi keluar', '2026-02-25 15:14:56', '::1'),
(281, 3, 'Mengakses halaman daftar struk', '2026-02-25 15:14:57', '::1'),
(282, 3, 'Mengakses halaman transaksi keluar', '2026-02-25 15:15:00', '::1'),
(283, 3, 'Mengakses halaman transaksi keluar', '2026-02-25 15:15:00', '::1'),
(284, 3, 'Mengakses halaman transaksi keluar', '2026-02-25 15:15:03', '::1'),
(285, 3, 'Mengakses halaman daftar struk', '2026-02-25 15:15:04', '::1'),
(286, 3, 'Mengakses halaman daftar struk', '2026-02-25 15:15:05', '::1'),
(287, 3, 'Mengakses halaman daftar struk', '2026-02-25 15:15:46', '::1'),
(288, 3, 'Mengakses halaman daftar struk', '2026-02-25 15:15:55', '::1'),
(289, 3, 'Mengakses halaman daftar struk', '2026-02-25 15:16:03', '::1'),
(290, 3, 'Mengakses halaman daftar struk', '2026-02-25 15:17:01', '::1'),
(291, 3, 'Mencetak struk transaksi: b1233w', '2026-02-25 15:17:04', '::1'),
(292, 3, 'Mengakses halaman daftar struk', '2026-02-25 15:18:09', '::1'),
(293, 3, 'Mencetak struk transaksi: b1233w', '2026-02-25 15:18:11', '::1'),
(294, 3, 'Mencetak struk transaksi: b1233w', '2026-02-25 15:18:18', '::1'),
(295, 3, 'Mengakses halaman daftar struk', '2026-02-25 15:18:54', '::1'),
(296, 3, 'Mengakses halaman daftar struk', '2026-02-25 15:19:14', '::1'),
(297, 3, 'Mengakses halaman daftar struk', '2026-02-25 15:19:21', '::1'),
(298, 3, 'Mengakses halaman daftar struk', '2026-02-25 15:19:31', '::1'),
(299, 3, 'Mengakses halaman daftar struk', '2026-02-25 15:22:56', '::1'),
(300, 3, 'Mengakses halaman daftar struk', '2026-02-25 15:23:35', '::1'),
(301, 3, 'Mengakses halaman daftar struk', '2026-02-25 15:23:38', '::1'),
(302, 3, 'Mengakses halaman daftar struk', '2026-02-25 15:24:35', '::1'),
(303, 3, 'Mencetak struk transaksi: b1287u', '2026-02-25 15:24:38', '::1'),
(304, 3, 'Mencetak struk transaksi: b1287u', '2026-02-25 15:24:45', '::1'),
(305, 3, 'Mengakses halaman transaksi keluar', '2026-02-25 15:25:06', '::1'),
(306, 3, 'Mengakses halaman transaksi keluar', '2026-02-25 15:25:09', '::1'),
(307, 3, 'Mengakses halaman daftar struk', '2026-02-25 15:25:10', '::1'),
(308, 3, 'Mengakses halaman daftar struk', '2026-02-25 15:25:11', '::1'),
(309, 3, 'Mengakses halaman daftar struk', '2026-02-25 15:25:13', '::1'),
(310, 3, 'Mengakses halaman daftar struk', '2026-02-25 15:25:14', '::1'),
(311, 3, 'Mengakses halaman daftar struk', '2026-02-25 15:25:15', '::1'),
(312, 3, 'Mengakses halaman daftar struk', '2026-02-25 15:28:04', '::1'),
(313, 3, 'Mencetak struk transaksi: b1233w', '2026-02-25 15:28:06', '::1'),
(314, 3, 'Mengakses halaman daftar struk', '2026-02-25 15:28:49', '::1'),
(315, 3, 'Mengakses halaman daftar struk', '2026-02-25 15:29:10', '::1'),
(316, 3, 'Logout', '2026-02-25 15:29:12', '::1'),
(317, 13, 'Login berhasil (Username: admins)', '2026-02-25 15:29:45', '::1'),
(318, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:29:45', '::1'),
(319, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:31:07', '::1'),
(320, 13, 'Login berhasil (Username: admins)', '2026-02-25 15:31:33', '::1'),
(321, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:31:33', '::1'),
(322, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:33:17', '::1'),
(323, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:36:01', '::1'),
(324, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:36:06', '::1'),
(325, 13, 'Login berhasil (Username: admins)', '2026-02-25 15:36:15', '::1'),
(326, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:36:15', '::1'),
(327, 13, 'Login berhasil (Username: admins)', '2026-02-25 15:37:18', '::1'),
(328, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:37:18', '::1'),
(329, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:38:46', '::1'),
(330, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:41:41', '::1'),
(331, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:41:45', '::1'),
(332, 13, 'Login berhasil (Username: admins)', '2026-02-25 15:46:27', '::1'),
(333, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:46:27', '::1'),
(334, 13, 'Logout', '2026-02-25 15:46:32', '::1'),
(335, 13, 'Login berhasil (Username: admins)', '2026-02-25 15:46:43', '::1'),
(336, 13, 'Login berhasil (Username: admins)', '2026-02-25 15:46:57', '::1'),
(337, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:46:57', '::1'),
(338, 13, 'Logout', '2026-02-25 15:47:00', '::1'),
(339, 13, 'Login berhasil (Username: admins)', '2026-02-25 15:47:13', '::1'),
(340, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:47:13', '::1'),
(341, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:47:50', '::1'),
(342, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:47:54', '::1'),
(343, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:48:21', '::1'),
(344, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:48:23', '::1'),
(345, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:48:24', '::1'),
(346, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:48:25', '::1'),
(347, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:48:26', '::1'),
(348, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:48:29', '::1'),
(349, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:48:34', '::1'),
(350, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:48:37', '::1'),
(351, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:48:48', '::1'),
(352, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:48:50', '::1'),
(353, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:49:20', '::1'),
(354, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:49:31', '::1'),
(355, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:49:33', '::1'),
(356, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:49:36', '::1'),
(357, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:49:38', '::1'),
(358, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:49:43', '::1'),
(359, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:49:46', '::1'),
(360, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:49:49', '::1'),
(361, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:49:52', '::1'),
(362, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:49:54', '::1'),
(363, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:50:50', '::1'),
(364, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:50:52', '::1'),
(365, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:50:55', '::1'),
(366, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:50:59', '::1'),
(367, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:51:01', '::1'),
(368, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:51:07', '::1'),
(369, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:51:08', '::1'),
(370, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:51:08', '::1'),
(371, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:51:08', '::1'),
(372, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:51:09', '::1'),
(373, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:52:19', '::1'),
(374, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:52:21', '::1'),
(375, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:52:25', '::1'),
(376, 13, 'Logout', '2026-02-25 15:52:32', '::1'),
(377, 13, 'Login berhasil (Username: admins)', '2026-02-25 15:52:52', '::1'),
(378, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:52:52', '::1'),
(379, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:52:55', '::1'),
(380, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:55:27', '::1'),
(381, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:55:29', '::1'),
(382, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:56:13', '::1'),
(383, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:56:14', '::1'),
(384, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:57:07', '::1'),
(385, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:57:09', '::1'),
(386, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:57:47', '::1'),
(387, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:57:48', '::1'),
(388, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:57:51', '::1'),
(389, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:59:35', '::1'),
(390, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:59:37', '::1'),
(391, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:59:39', '::1'),
(392, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:59:40', '::1'),
(393, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:59:42', '::1'),
(394, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:59:45', '::1'),
(395, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:59:49', '::1'),
(396, 13, 'Mengakses halaman Dashboard', '2026-02-25 15:59:51', '::1'),
(397, 13, 'Mengakses halaman Dashboard', '2026-02-25 16:00:03', '::1'),
(398, 13, 'Mengakses halaman Dashboard', '2026-02-25 16:00:06', '::1'),
(399, 13, 'Mengakses halaman Dashboard', '2026-02-25 16:00:30', '::1'),
(400, 13, 'Mengakses halaman Rekap Transaksi', '2026-02-25 16:00:42', '::1'),
(401, 13, 'Mengakses halaman Rekap Transaksi', '2026-02-25 16:00:46', '::1'),
(402, 13, 'Mengakses halaman Dashboard', '2026-02-25 16:00:53', '::1'),
(403, 13, 'Mengakses halaman Laporan Pendapatan', '2026-02-25 16:01:04', '::1'),
(404, 13, 'Mengakses halaman Statistik Parkir', '2026-02-25 16:01:08', '::1'),
(405, 13, 'Mengakses halaman Rekap Transaksi', '2026-02-25 16:01:11', '::1'),
(406, 13, 'Mengakses halaman Rekap Transaksi', '2026-02-25 16:01:13', '::1'),
(407, 13, 'Mengakses halaman Dashboard', '2026-02-25 16:01:15', '::1'),
(408, 13, 'Mengakses halaman Dashboard', '2026-02-25 16:02:41', '::1'),
(409, 13, 'Mengakses halaman Rekap Transaksi', '2026-02-25 16:02:43', '::1'),
(410, 13, 'Mengakses halaman Rekap Transaksi', '2026-02-25 16:02:44', '::1'),
(411, 13, 'Mengakses halaman Laporan Pendapatan', '2026-02-25 16:02:47', '::1'),
(412, 13, 'Mengakses halaman Laporan Pendapatan', '2026-02-25 16:02:48', '::1'),
(413, 13, 'Mengakses halaman Statistik Parkir', '2026-02-25 16:02:51', '::1'),
(414, 13, 'Mengakses halaman Rekap Transaksi', '2026-02-25 16:02:54', '::1'),
(415, 13, 'Mengakses halaman Rekap Transaksi', '2026-02-25 16:02:55', '::1'),
(416, 13, 'Mengakses halaman Dashboard', '2026-02-25 16:02:57', '::1'),
(417, 13, 'Mengakses halaman Dashboard', '2026-02-25 16:03:52', '::1'),
(418, 13, 'Mengakses halaman Rekap Transaksi', '2026-02-25 16:03:55', '::1'),
(419, 13, 'Mengakses halaman Rekap Transaksi', '2026-02-25 16:03:57', '::1'),
(420, 13, 'Mencetak struk transaksi: b1287u', '2026-02-25 16:03:58', '::1'),
(421, 3, 'Login berhasil (Username: dewasa)', '2026-02-26 01:07:39', '::1'),
(422, 3, 'Mengakses halaman Dashboard', '2026-02-26 01:07:39', '::1'),
(423, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 01:07:43', '::1'),
(424, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 01:09:09', '::1'),
(425, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 01:09:11', '::1'),
(426, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 01:09:14', '::1'),
(427, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 01:09:16', '::1'),
(428, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 01:09:24', '::1'),
(429, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 01:09:28', '::1'),
(430, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 01:09:29', '::1'),
(431, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 01:09:29', '::1'),
(432, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 01:09:30', '::1'),
(433, 3, 'Transaksi masuk: B1233W (motor)', '2026-02-26 01:09:50', '::1'),
(434, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 01:09:50', '::1'),
(435, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 01:10:12', '::1'),
(436, 3, 'Mencetak struk masuk: b1233w', '2026-02-26 01:10:13', '::1'),
(437, 3, 'Mencetak struk masuk: b1233w', '2026-02-26 01:10:40', '::1'),
(438, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 01:10:42', '::1'),
(439, 3, 'Mencetak struk masuk: b1233w', '2026-02-26 01:11:09', '::1'),
(440, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 01:11:12', '::1'),
(441, 3, 'Mencetak struk masuk: b1233w', '2026-02-26 01:11:24', '::1'),
(442, 3, 'Mengakses halaman daftar struk', '2026-02-26 01:11:33', '::1'),
(443, 3, 'Mengakses halaman Dashboard', '2026-02-26 01:11:37', '::1'),
(444, 3, 'Logout', '2026-02-26 01:26:55', '::1'),
(445, 3, 'Login berhasil (Username: dewasa)', '2026-02-26 01:31:38', '::1'),
(446, 3, 'Mengakses halaman Dashboard', '2026-02-26 01:31:38', '::1'),
(447, 3, 'Logout', '2026-02-26 01:31:46', '::1'),
(448, 4, 'Login berhasil (Username: dewasa1)', '2026-02-26 01:32:16', '::1'),
(449, 4, 'Mengakses halaman Dashboard', '2026-02-26 01:32:16', '::1'),
(450, 4, 'Mengakses halaman Dashboard', '2026-02-26 01:38:25', '::1'),
(451, 4, 'Mengakses halaman Dashboard', '2026-02-26 01:46:16', '::1'),
(452, 4, 'Mengakses halaman Dashboard', '2026-02-26 01:47:39', '::1'),
(453, 4, 'Logout', '2026-02-26 01:52:51', '::1'),
(454, 3, 'Login berhasil (Username: dewasa)', '2026-02-26 01:54:12', '::1'),
(455, 3, 'Mengakses halaman Dashboard', '2026-02-26 01:54:12', '::1'),
(456, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 01:54:14', '::1'),
(457, 3, 'Mencetak struk masuk: b1233w', '2026-02-26 01:54:15', '::1'),
(458, 3, 'Mengakses halaman daftar struk', '2026-02-26 02:38:47', '::1'),
(459, 3, 'Mencetak struk transaksi: b1233w', '2026-02-26 02:38:48', '::1'),
(460, 3, 'Mencetak struk transaksi: b1233w', '2026-02-26 02:38:57', '::1'),
(461, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 02:39:09', '::1'),
(462, 3, 'Mengakses halaman Dashboard', '2026-02-26 02:39:12', '::1'),
(463, 3, 'Mengakses halaman daftar struk', '2026-02-26 02:43:16', '::1'),
(464, 3, 'Mengakses halaman daftar struk', '2026-02-26 02:44:31', '::1'),
(465, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 02:44:37', '::1'),
(466, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 02:45:01', '::1'),
(467, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 02:45:06', '::1'),
(468, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 02:45:08', '::1'),
(469, 3, 'Mencetak struk masuk: b1233w', '2026-02-26 02:45:11', '::1'),
(470, 3, 'Mencetak struk transaksi: b1233w', '2026-02-26 02:45:15', '::1'),
(471, 3, 'Mencetak struk transaksi: b1233w', '2026-02-26 02:45:20', '::1'),
(472, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 02:45:39', '::1'),
(473, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 02:45:41', '::1'),
(474, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 02:46:12', '::1'),
(475, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 02:46:18', '::1'),
(476, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 02:46:22', '::1'),
(477, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 02:46:28', '::1'),
(478, 3, 'Mencetak struk transaksi: b1233w', '2026-02-26 02:46:30', '::1'),
(479, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 02:46:50', '::1'),
(480, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 02:47:21', '::1'),
(481, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 02:47:24', '::1'),
(482, 3, 'Mencetak struk masuk: b1233w', '2026-02-26 02:47:26', '::1'),
(483, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 02:47:32', '::1'),
(484, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 02:48:17', '::1'),
(485, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 02:48:47', '::1'),
(486, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 02:49:18', '::1'),
(487, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 02:49:49', '::1'),
(488, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 02:50:20', '::1'),
(489, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 02:50:51', '::1'),
(490, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 02:51:21', '::1'),
(491, 3, 'Transaksi masuk: B1233W (motor)', '2026-02-26 02:51:28', '::1'),
(492, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 02:51:28', '::1'),
(493, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 02:51:31', '::1'),
(494, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 02:51:41', '::1'),
(495, 3, 'Mencetak struk transaksi: b1233w', '2026-02-26 02:51:56', '::1'),
(496, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 02:52:12', '::1'),
(497, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 02:52:15', '::1'),
(498, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 02:52:45', '::1'),
(499, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 02:53:16', '::1'),
(500, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 02:53:47', '::1'),
(501, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 02:53:51', '::1'),
(502, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 02:53:56', '::1'),
(503, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 02:54:26', '::1'),
(504, 3, 'Transaksi keluar: b1233w (tunai) - Rp 10.000', '2026-02-26 02:54:39', '::1'),
(505, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 02:54:39', '::1'),
(506, 3, 'Mencetak struk transaksi: b1233w', '2026-02-26 02:54:45', '::1'),
(507, 3, 'Mengakses halaman daftar struk', '2026-02-26 02:54:52', '::1'),
(508, 3, 'Mencetak struk transaksi: b1233w', '2026-02-26 02:54:54', '::1'),
(509, 3, 'Mengakses halaman daftar struk', '2026-02-26 02:55:10', '::1'),
(510, 3, 'Mengakses halaman Dashboard', '2026-02-26 02:55:11', '::1'),
(511, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 02:55:13', '::1'),
(512, 3, 'Transaksi masuk: B1233W (motor)', '2026-02-26 02:55:20', '::1'),
(513, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 02:55:20', '::1'),
(514, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 02:55:24', '::1'),
(515, 3, 'Transaksi keluar: b1233w (tunai) - Rp 0', '2026-02-26 02:55:30', '::1'),
(516, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 02:55:30', '::1'),
(517, 3, 'Mengakses halaman daftar struk', '2026-02-26 02:55:37', '::1'),
(518, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 02:57:28', '::1'),
(519, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 03:04:32', '::1'),
(520, 3, 'Mengakses halaman Dashboard', '2026-02-26 03:04:39', '::1'),
(521, 3, 'Logout', '2026-02-26 03:04:43', '::1'),
(522, 13, 'Login berhasil (Username: admins)', '2026-02-26 03:05:21', '::1'),
(523, 13, 'Mengakses halaman Dashboard', '2026-02-26 03:05:22', '::1'),
(524, 13, 'Mengakses halaman Rekap Transaksi', '2026-02-26 03:05:27', '::1'),
(525, 13, 'Mengakses halaman Rekap Transaksi', '2026-02-26 03:05:29', '::1'),
(526, 13, 'Mencetak struk transaksi: b1233w', '2026-02-26 03:05:32', '::1'),
(527, 13, 'Mengakses halaman Laporan Pendapatan', '2026-02-26 03:05:42', '::1'),
(528, 13, 'Mengakses halaman Laporan Pendapatan', '2026-02-26 03:05:44', '::1'),
(529, 13, 'Mengakses halaman Statistik Parkir', '2026-02-26 03:05:48', '::1'),
(530, 13, 'Mengakses halaman Rekap Transaksi', '2026-02-26 03:05:52', '::1'),
(531, 13, 'Mengakses halaman Rekap Transaksi', '2026-02-26 03:05:54', '::1'),
(532, 13, 'Mengakses halaman Laporan Pendapatan', '2026-02-26 03:05:57', '::1'),
(533, 13, 'Mengakses halaman Laporan Pendapatan', '2026-02-26 03:06:12', '::1'),
(534, 13, 'Mengakses halaman Rekap Transaksi', '2026-02-26 03:06:14', '::1'),
(535, 13, 'Mengakses halaman Rekap Transaksi', '2026-02-26 03:06:14', '::1'),
(536, 13, 'Mengakses halaman Laporan Pendapatan', '2026-02-26 03:06:50', '::1'),
(537, 13, 'Mengakses halaman Laporan Pendapatan', '2026-02-26 03:07:57', '::1'),
(538, 13, 'Mengakses halaman Laporan Pendapatan', '2026-02-26 03:07:58', '::1'),
(539, 13, 'Mengakses halaman Laporan Pendapatan', '2026-02-26 03:07:59', '::1'),
(540, 13, 'Mengakses halaman Laporan Pendapatan', '2026-02-26 03:08:05', '::1'),
(541, 13, 'Mengakses halaman Laporan Pendapatan', '2026-02-26 03:08:18', '::1'),
(542, 13, 'Mengakses halaman Laporan Pendapatan', '2026-02-26 03:08:33', '::1'),
(543, 13, 'Mengakses halaman Rekap Transaksi', '2026-02-26 03:08:59', '::1'),
(544, 13, 'Mengakses halaman Rekap Transaksi', '2026-02-26 03:09:01', '::1'),
(545, 13, 'Mencetak struk transaksi: b1233w', '2026-02-26 03:09:02', '::1'),
(546, 13, 'Mengakses halaman Rekap Transaksi', '2026-02-26 03:09:15', '::1'),
(547, 13, 'Mengakses halaman Rekap Transaksi', '2026-02-26 03:09:35', '::1'),
(548, 13, 'Mengakses halaman Laporan Pendapatan', '2026-02-26 03:26:17', '::1'),
(549, 13, 'Mengakses halaman Laporan Pendapatan', '2026-02-26 03:26:25', '::1'),
(550, 13, 'Logout', '2026-02-26 03:32:55', '::1'),
(551, 18, 'Register user baru (Username: dewasawww)', '2026-02-26 04:13:28', '::1'),
(552, 4, 'Login berhasil (Username: dewasa1)', '2026-02-26 04:22:54', '::1'),
(553, 4, 'Mengakses halaman Dashboard', '2026-02-26 04:22:54', '::1'),
(554, 4, 'Mengakses halaman Manajemen User', '2026-02-26 04:28:21', '::1'),
(555, 4, 'Membuka form tambah user baru', '2026-02-26 04:29:30', '::1'),
(556, 4, 'Mengakses halaman Manajemen User', '2026-02-26 04:29:31', '::1'),
(557, 4, 'Membuka form tambah user baru', '2026-02-26 04:31:21', '::1'),
(558, 4, 'Mengakses halaman Manajemen User', '2026-02-26 04:33:06', '::1'),
(559, 4, 'Membuka form edit user ID: 18', '2026-02-26 04:33:09', '::1'),
(560, 4, 'Mengakses halaman Log Aktivitas', '2026-02-26 04:34:14', '::1'),
(561, 4, 'Logout', '2026-02-26 04:36:45', '::1'),
(562, 3, 'Transaksi keluar: b1233w (tunai) - Rp 9.000', '2026-02-26 09:35:25', '::1'),
(563, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:35:26', '::1'),
(564, 3, 'Mencetak struk masuk: b1233w', '2026-02-26 09:35:30', '::1'),
(565, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:35:46', '::1'),
(566, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 09:35:49', '::1'),
(567, 3, 'Transaksi masuk: B1287U (motor)', '2026-02-26 09:36:22', '::1'),
(568, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 09:36:22', '::1'),
(569, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:36:25', '::1'),
(570, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:36:55', '::1'),
(571, 3, 'Transaksi keluar: b1287u (tunai) - Rp 1.000', '2026-02-26 09:37:02', '::1'),
(572, 3, 'Transaksi keluar: b1287u (tunai) - Rp 1.000', '2026-02-26 09:37:02', '::1'),
(573, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:37:03', '::1'),
(574, 3, 'Mencetak struk masuk: b1287u', '2026-02-26 09:37:10', '::1'),
(575, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:37:33', '::1'),
(576, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:38:04', '::1'),
(577, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:38:35', '::1'),
(578, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:39:06', '::1'),
(579, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:39:37', '::1'),
(580, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:40:08', '::1'),
(581, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:40:39', '::1'),
(582, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:41:10', '::1'),
(583, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:41:41', '::1'),
(584, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:42:12', '::1'),
(585, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:42:43', '::1'),
(586, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:43:14', '::1'),
(587, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:43:45', '::1'),
(588, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:44:16', '::1'),
(589, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:44:47', '::1'),
(590, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:45:18', '::1'),
(591, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:45:49', '::1'),
(592, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:46:20', '::1'),
(593, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:46:51', '::1'),
(594, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:47:22', '::1'),
(595, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:47:53', '::1'),
(596, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:48:24', '::1'),
(597, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:48:55', '::1'),
(598, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:49:26', '::1'),
(599, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:49:57', '::1'),
(600, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:50:28', '::1'),
(601, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:50:59', '::1'),
(602, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:51:30', '::1'),
(603, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:52:01', '::1'),
(604, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:52:32', '::1'),
(605, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:52:42', '::1'),
(606, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 09:52:46', '::1'),
(607, 3, 'Transaksi masuk: B1287U (motor)', '2026-02-26 09:52:53', '::1'),
(608, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 09:52:53', '::1'),
(609, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:52:55', '::1'),
(610, 3, 'Transaksi keluar: b1287u (tunai) - Rp 1.000', '2026-02-26 09:53:07', '::1'),
(611, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:53:07', '::1'),
(612, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:53:30', '::1'),
(613, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:54:01', '::1'),
(614, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:54:32', '::1'),
(615, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:55:03', '::1'),
(616, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:55:34', '::1'),
(617, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:56:05', '::1'),
(618, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:56:36', '::1'),
(619, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 09:56:53', '::1'),
(620, 3, 'Transaksi masuk: B1233W (motor)', '2026-02-26 09:57:00', '::1'),
(621, 3, 'Transaksi masuk: B1233W (motor)', '2026-02-26 09:57:01', '::1'),
(622, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 09:57:01', '::1'),
(623, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 09:57:03', '::1'),
(624, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 09:57:04', '::1'),
(625, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:57:07', '::1'),
(626, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:57:27', '::1'),
(627, 3, 'Transaksi keluar: b1233w (tunai) - Rp 1.000', '2026-02-26 09:57:31', '::1'),
(628, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:57:31', '::1'),
(629, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:57:34', '::1'),
(630, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:58:04', '::1'),
(631, 3, 'Transaksi keluar: b1233w (tunai) - Rp 0', '2026-02-26 09:58:20', '::1'),
(632, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:58:20', '::1'),
(633, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:58:22', '::1'),
(634, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:58:52', '::1'),
(635, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:59:23', '::1'),
(636, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 09:59:54', '::1'),
(637, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:00:25', '::1'),
(638, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:00:56', '::1'),
(639, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:01:27', '::1'),
(640, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:01:58', '::1'),
(641, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:02:29', '::1'),
(642, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 10:02:42', '::1'),
(643, 3, 'Transaksi masuk: B1233W (motor)', '2026-02-26 10:02:49', '::1'),
(644, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 10:02:49', '::1'),
(645, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:02:52', '::1'),
(646, 3, 'Transaksi keluar: b1233w (tunai) - Rp 1.000', '2026-02-26 10:03:03', '::1'),
(647, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:03:03', '::1'),
(648, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:03:04', '::1'),
(649, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:03:34', '::1'),
(650, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 10:03:44', '::1'),
(651, 3, 'Transaksi masuk: B1233W (motor)', '2026-02-26 10:03:51', '::1'),
(652, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 10:03:51', '::1'),
(653, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 10:04:03', '::1'),
(654, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:04:05', '::1'),
(655, 3, 'Transaksi keluar: b1233w (tunai) - Rp 1.000', '2026-02-26 10:04:09', '::1'),
(656, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:04:09', '::1'),
(657, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:04:11', '::1'),
(658, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:04:42', '::1'),
(659, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:05:13', '::1'),
(660, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:05:44', '::1'),
(661, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:06:15', '::1'),
(662, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:06:46', '::1'),
(663, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:07:17', '::1'),
(664, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:07:48', '::1'),
(665, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:08:19', '::1'),
(666, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:08:50', '::1'),
(667, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:09:21', '::1'),
(668, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:09:52', '::1'),
(669, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:10:23', '::1'),
(670, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:10:54', '::1'),
(671, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:11:25', '::1'),
(672, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 10:11:27', '::1'),
(673, 3, 'Transaksi masuk: B1287U (motor)', '2026-02-26 10:11:35', '::1');
INSERT INTO `tb_log_aktivitas` (`id_log`, `id_user`, `aktivitas`, `waktu_aktivitas`, `ip_address`) VALUES
(674, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 10:11:35', '::1'),
(675, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:11:37', '::1'),
(676, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:12:07', '::1'),
(677, 3, 'Transaksi keluar: b1287u (tunai) - Rp 1.000', '2026-02-26 10:12:08', '::1'),
(678, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:12:08', '::1'),
(679, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:12:10', '::1'),
(680, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:12:40', '::1'),
(681, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:13:11', '::1'),
(682, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:13:42', '::1'),
(683, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:14:13', '::1'),
(684, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:14:39', '::1'),
(685, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 10:14:41', '::1'),
(686, 3, 'Transaksi masuk: B1287U (motor)', '2026-02-26 10:14:47', '::1'),
(687, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 10:14:47', '::1'),
(688, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:14:50', '::1'),
(689, 3, 'Transaksi keluar: b1287u (transfer) - Rp 0', '2026-02-26 10:14:55', '::1'),
(690, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:14:55', '::1'),
(691, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 10:15:10', '::1'),
(692, 3, 'Transaksi masuk: B1287U (motor)', '2026-02-26 10:15:20', '::1'),
(693, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 10:15:20', '::1'),
(694, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:15:22', '::1'),
(695, 3, 'Transaksi keluar: b1287u (tunai) - Rp 0', '2026-02-26 10:15:31', '::1'),
(696, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:15:31', '::1'),
(697, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:16:02', '::1'),
(698, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:16:33', '::1'),
(699, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:17:04', '::1'),
(700, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:17:35', '::1'),
(701, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:18:06', '::1'),
(702, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:18:37', '::1'),
(703, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:19:08', '::1'),
(704, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:19:39', '::1'),
(705, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:20:10', '::1'),
(706, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:20:41', '::1'),
(707, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:20:55', '::1'),
(708, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:21:01', '::1'),
(709, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 10:21:03', '::1'),
(710, 3, 'Transaksi masuk: B1233W (motor)', '2026-02-26 10:21:10', '::1'),
(711, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 10:21:10', '::1'),
(712, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:21:13', '::1'),
(713, 3, 'Transaksi keluar: b1233w (tunai) - Rp 0', '2026-02-26 10:21:43', '::1'),
(714, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:21:43', '::1'),
(715, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:21:46', '::1'),
(716, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:22:16', '::1'),
(717, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:22:47', '::1'),
(718, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:23:18', '::1'),
(719, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:23:49', '::1'),
(720, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:24:20', '::1'),
(721, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:24:51', '::1'),
(722, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:25:15', '::1'),
(723, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 10:25:17', '::1'),
(724, 3, 'Transaksi masuk: B1233W (motor)', '2026-02-26 10:25:28', '::1'),
(725, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 10:25:28', '::1'),
(726, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:25:30', '::1'),
(727, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:26:00', '::1'),
(728, 3, 'Transaksi keluar: b1233w (tunai) - Rp 1.000', '2026-02-26 10:26:20', '::1'),
(729, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:26:20', '::1'),
(730, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:26:23', '::1'),
(731, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:26:53', '::1'),
(732, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:27:24', '::1'),
(733, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 10:27:38', '::1'),
(734, 3, 'Transaksi masuk: B1233W (motor)', '2026-02-26 10:27:47', '::1'),
(735, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 10:27:47', '::1'),
(736, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:27:49', '::1'),
(737, 3, 'Transaksi keluar: b1233w (tunai) - Rp 3.000', '2026-02-26 10:28:02', '::1'),
(738, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:28:02', '::1'),
(739, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 10:28:18', '::1'),
(740, 3, 'Transaksi masuk: B1233W (motor)', '2026-02-26 10:28:25', '::1'),
(741, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 10:28:25', '::1'),
(742, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:28:27', '::1'),
(743, 3, 'Transaksi keluar: b1233w (tunai) - Rp 2.000', '2026-02-26 10:28:37', '::1'),
(744, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:28:37', '::1'),
(745, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:29:07', '::1'),
(746, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:29:38', '::1'),
(747, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:30:08', '::1'),
(748, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:30:38', '::1'),
(749, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:31:08', '::1'),
(750, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:31:38', '::1'),
(751, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:32:09', '::1'),
(752, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:32:39', '::1'),
(753, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:33:09', '::1'),
(754, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:33:40', '::1'),
(755, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:34:12', '::1'),
(756, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:34:43', '::1'),
(757, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:35:13', '::1'),
(758, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:35:43', '::1'),
(759, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:36:14', '::1'),
(760, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:36:44', '::1'),
(761, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:37:15', '::1'),
(762, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:37:46', '::1'),
(763, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:38:17', '::1'),
(764, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:38:48', '::1'),
(765, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:39:19', '::1'),
(766, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:39:26', '::1'),
(767, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 10:39:29', '::1'),
(768, 3, 'Transaksi masuk: B1233W (motor)', '2026-02-26 10:39:36', '::1'),
(769, 3, 'Mengakses halaman transaksi masuk', '2026-02-26 10:39:36', '::1'),
(770, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:39:47', '::1'),
(771, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:39:48', '::1'),
(772, 3, 'Transaksi keluar: b1233w (tunai) - Rp 3.000', '2026-02-26 10:39:56', '::1'),
(773, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:39:56', '::1'),
(774, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:40:26', '::1'),
(775, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:40:57', '::1'),
(776, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:41:28', '::1'),
(777, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:41:59', '::1'),
(778, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:42:30', '::1'),
(779, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:43:01', '::1'),
(780, 3, 'Mengakses halaman transaksi keluar', '2026-02-26 10:43:32', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `tb_tarif`
--

CREATE TABLE `tb_tarif` (
  `id_tarif` int(11) UNSIGNED NOT NULL,
  `jenis_kendaraan` enum('mobil','motor','truk','bus','lainnya') NOT NULL,
  `tarif_per_jam` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_tarif`
--

INSERT INTO `tb_tarif` (`id_tarif`, `jenis_kendaraan`, `tarif_per_jam`, `created_at`, `updated_at`) VALUES
(2, 'motor', 2000.00, '2026-02-25 07:29:49', '2026-02-25 14:44:25'),
(3, 'mobil', 5000.00, '2026-02-25 07:29:49', '2026-02-25 07:29:49'),
(4, 'truk', 10000.00, '2026-02-25 07:29:49', '2026-02-25 07:29:49'),
(5, 'bus', 15000.00, '2026-02-25 07:29:49', '2026-02-25 07:29:49'),
(6, 'lainnya', 3000.00, '2026-02-25 07:29:49', '2026-02-25 07:29:49');

-- --------------------------------------------------------

--
-- Table structure for table `tb_transaksi`
--

CREATE TABLE `tb_transaksi` (
  `id_parkir` int(11) UNSIGNED NOT NULL,
  `id_kendaraan` int(11) UNSIGNED NOT NULL,
  `waktu_masuk` datetime NOT NULL,
  `waktu_keluar` datetime DEFAULT NULL,
  `id_tarif` int(11) UNSIGNED DEFAULT NULL,
  `durasi_jam` int(11) DEFAULT 0,
  `biaya_total` decimal(10,2) DEFAULT 0.00,
  `metode_pembayaran` enum('tunai','transfer','ewallet','kartu_kredit','kartu_debit') DEFAULT NULL,
  `status` enum('masuk','keluar','selesai') NOT NULL DEFAULT 'masuk',
  `id_user` int(11) UNSIGNED NOT NULL,
  `id_area` int(11) UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_transaksi`
--

INSERT INTO `tb_transaksi` (`id_parkir`, `id_kendaraan`, `waktu_masuk`, `waktu_keluar`, `id_tarif`, `durasi_jam`, `biaya_total`, `metode_pembayaran`, `status`, `id_user`, `id_area`, `created_at`, `updated_at`) VALUES
(16, 1, '2026-02-26 10:03:51', '2026-02-26 10:06:09', 2, 1, 1000.00, 'tunai', 'selesai', 3, 2, '2026-02-26 10:03:51', '2026-02-26 10:04:09'),
(17, 2, '2026-02-26 10:11:35', '2026-02-26 10:12:08', 2, 1, 1000.00, 'tunai', 'selesai', 3, 2, '2026-02-26 10:11:35', '2026-02-26 10:12:08'),
(18, 2, '2026-02-26 10:14:47', '2026-02-26 10:14:55', 2, 3, 0.00, 'transfer', 'keluar', 3, 1, '2026-02-26 10:14:47', '2026-02-26 10:14:55'),
(19, 2, '2026-02-26 10:15:20', '2026-02-26 10:15:31', 2, 0, 0.00, 'tunai', 'keluar', 3, 2, '2026-02-26 10:15:20', '2026-02-26 10:15:31'),
(20, 1, '2026-02-26 10:21:10', '2026-02-26 10:21:43', 2, 3, 0.00, 'tunai', 'keluar', 3, 2, '2026-02-26 10:21:10', '2026-02-26 10:21:43'),
(21, 1, '2026-02-26 10:25:28', '2026-02-26 10:26:20', 2, 1, 1000.00, 'tunai', 'selesai', 3, 2, '2026-02-26 10:25:28', '2026-02-26 10:26:20'),
(22, 1, '2026-02-26 10:27:47', '2026-02-26 10:28:02', 2, 3, 3000.00, 'tunai', 'selesai', 3, 2, '2026-02-26 10:27:47', '2026-02-26 10:28:02'),
(23, 1, '2026-02-26 10:28:25', '2026-02-26 10:28:37', 2, 2, 2000.00, 'tunai', 'selesai', 3, 2, '2026-02-26 10:28:25', '2026-02-26 10:28:37'),
(24, 1, '2026-02-26 10:39:36', '2026-02-26 13:39:36', 2, 3, 3000.00, 'tunai', 'selesai', 3, 2, '2026-02-26 10:39:36', '2026-02-26 10:39:56');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(11) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `nama_lengkap` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('superadmin','admin','owner','petugas') NOT NULL DEFAULT 'petugas',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `username`, `nama_lengkap`, `password`, `role`, `created_at`, `updated_at`) VALUES
(3, 'dewasa', 'Dewasa User', '$2y$10$LHa./seCJ2dah8C4lHZGyeUj.C2eaiRt4fnHl7psj38xlidif4Qr.', 'petugas', '2026-02-25 06:27:01', '2026-02-25 06:27:01'),
(4, 'dewasa1', 'dewasa', '$2y$10$WeJJXFU.i8qaWOFEyljcY.5rwFa9rXaxWRbb5eqJdHsDPvJ8/jyIe', 'admin', '2026-02-25 06:29:46', '2026-02-25 06:29:46'),
(7, 'testuser123', 'Test User', '$2y$10$GRhCIiufHuCvReq/I7HufueX/oEC7xGWJY2jcEfDLzCXXVoYaVFqC', 'petugas', NULL, NULL),
(12, 'Budisusanto', 'budi', '$2y$10$8b/dRXHD37gypSWwGUn2xu96RuO939ovebUWUPSnjc.CIJ1YgHhMW', 'petugas', '2026-02-25 13:57:15', '2026-02-25 13:57:15'),
(13, 'admins', 'admin', '$2y$10$pte1dkJFmMUz66xFRUE0quFD4qD2IGSuJqch3SC1Y3Me5Y880xOlm', 'owner', '2026-02-25 13:58:54', '2026-02-25 13:59:02'),
(14, 'justin', 'admin', '$2y$10$pM8AxNlxYwvh.K8AEr73pug3HYPSGD9hHP3JKlWKgXCdgwjTrbh7.', 'petugas', '2026-02-25 14:09:06', '2026-02-25 14:16:51'),
(15, 'ssa', 'admin', '$2y$10$BgkuBmFPXbaq7WEnHb7c8OA52cMQjI7aZixmUjNpV2lgMFsaRZy7.', 'petugas', '2026-02-25 14:18:30', '2026-02-25 14:18:30'),
(16, 'budisusanto9', 'adminss', '$2y$10$DeSvUTagASPmHCwPDsj8..5nvOFJXN2l8PJ3lzPnvrjLOt0wUrXYa', 'petugas', '2026-02-25 14:19:05', '2026-02-25 14:19:05'),
(17, 'owner', 'BCS Mall Owner', '$2y$10$dd2H85s/tn27bAlTY4LCq.qYMId/u8ob1.HB9j5wqgv0kGGZ1NLUq', 'owner', '2026-02-25 16:54:55', '2026-02-25 16:54:55'),
(18, 'dewasawww', 'dadass', '$2y$10$dXngGLYbNFkYs3jCXtOMjOlygpYTkoxzJWPVhBAucoyGe4KJYfHOq', 'petugas', '2026-02-26 04:13:28', '2026-02-26 04:13:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_area_parkir`
--
ALTER TABLE `tb_area_parkir`
  ADD PRIMARY KEY (`id_area`);

--
-- Indexes for table `tb_kendaraan`
--
ALTER TABLE `tb_kendaraan`
  ADD PRIMARY KEY (`id_kendaraan`),
  ADD KEY `tb_kendaraan_id_user_foreign` (`id_user`);

--
-- Indexes for table `tb_log_aktivitas`
--
ALTER TABLE `tb_log_aktivitas`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `tb_log_aktivitas_id_user_foreign` (`id_user`),
  ADD KEY `waktu_aktivitas` (`waktu_aktivitas`);

--
-- Indexes for table `tb_tarif`
--
ALTER TABLE `tb_tarif`
  ADD PRIMARY KEY (`id_tarif`),
  ADD UNIQUE KEY `unique_jenis_kendaraan` (`jenis_kendaraan`);

--
-- Indexes for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD PRIMARY KEY (`id_parkir`),
  ADD KEY `tb_transaksi_id_kendaraan_foreign` (`id_kendaraan`),
  ADD KEY `tb_transaksi_id_user_foreign` (`id_user`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tb_area_parkir`
--
ALTER TABLE `tb_area_parkir`
  MODIFY `id_area` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tb_kendaraan`
--
ALTER TABLE `tb_kendaraan`
  MODIFY `id_kendaraan` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_log_aktivitas`
--
ALTER TABLE `tb_log_aktivitas`
  MODIFY `id_log` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=781;

--
-- AUTO_INCREMENT for table `tb_tarif`
--
ALTER TABLE `tb_tarif`
  MODIFY `id_tarif` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  MODIFY `id_parkir` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_kendaraan`
--
ALTER TABLE `tb_kendaraan`
  ADD CONSTRAINT `tb_kendaraan_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_log_aktivitas`
--
ALTER TABLE `tb_log_aktivitas`
  ADD CONSTRAINT `tb_log_aktivitas_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON DELETE CASCADE ON UPDATE SET NULL;

--
-- Constraints for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD CONSTRAINT `tb_transaksi_id_kendaraan_foreign` FOREIGN KEY (`id_kendaraan`) REFERENCES `tb_kendaraan` (`id_kendaraan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_transaksi_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
