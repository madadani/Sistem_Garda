-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2025 at 07:50 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_garda`
--

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `driver_id_card` varchar(255) NOT NULL COMMENT 'ID unik dari barcode',
  `name` varchar(255) NOT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `instansi` varchar(255) DEFAULT NULL,
  `total_points` int(11) NOT NULL DEFAULT 0 COMMENT 'Akumulasi poin yang dimiliki driver',
  `points_redeemed` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `driver_id_card`, `name`, `phone_number`, `instansi`, `total_points`, `points_redeemed`, `created_at`, `updated_at`) VALUES
(1, '089644037015', 'GALUH PARWATI', '089644037015', 'ABIMANYU AMBULANCE', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(3, '081329572307', 'MUHAMMAD AMIR', '081329572307', 'NU MIRI', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(4, '085642205549', 'DWI SAPUTRO', '085642205549', 'DEMOKRAT', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(5, '088985259151', 'MUHAMMAD SETYO', '088985259151', 'NU MIRI', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(6, '082241949991', 'MUHAMMAD TEGUH', '082241949991', 'RSSG', 1, 0, '2025-12-01 03:27:36', '2025-12-11 05:04:44'),
(7, '081287460464', 'DAVID CAHYONO', '081287460464', 'SIAGA TEMPELREJO', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(8, '087733623996', 'ANDI PRASETYO', '087733623996', 'BMT INSAN', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(9, '081542211548', 'SAID', '081542211548', 'NU MONDOKAN', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(10, '082229998001', 'ADE EBROT', '082229998001', 'NF PEDULI', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(11, '081393441449', 'HENDRO', '081393441449', 'NF PEDULI', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(12, '082119810339', 'BAMBANG S', '082119810339', 'NU PLUPUH', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(13, '08562812536', 'DARVIKA', '08562812536', 'NU MONDOKAN', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(14, '081218073815', 'BAGIYONO', '081218073815', 'KLINIK ASY-SYIFA', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(15, '081329336161', 'EDDY', '081329336161', 'PGA GEMOLONG', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(16, '087836577774', 'SUSAN', '087836577774', 'PGA GEMOLONG', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(17, '082136711568', 'AGUS', '082136711568', 'RESCUE PGN SRAGEN', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(18, '081393924964', 'ALIEF PANJI', '081393924964', 'NU GEMOLONG', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(19, '088806658181', 'SATRIO', '088806658181', 'NU GEMOLONG', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(20, '082327698881', 'SUYANTO DEDY', '082327698881', 'PKM TANON 1', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(21, '082136078878', 'KRISTANTO', '082136078878', 'PKM TANON 2', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(22, '082136578135', 'HANAFI', '082136578135', 'NU GEMOLONG', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(23, '083113096468', 'ARIE', '083113096468', 'NU GEMOLONG', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(24, '085743638249', 'RUSTIYOTO', '085743638249', 'SIAGA WONOREJO', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(25, '0882003656568', 'DHONI', '0882003656568', 'NU GEMOLONG', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(26, '085158331362', 'ALFIAN', '085158331362', 'NU MIRI', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(27, '081393650105', 'SURANTO', '081393650105', 'PKM KALIJAMBE', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(28, '081225111122', 'ARDIANSYAH', '081225111122', 'LAZISMU PLUPUH', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(29, '085741127152', 'HAFIDZ', '085741127152', 'LAZISMU PLUPUH', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(30, '085229032104', 'AGUS PURWANTO', '085229032104', 'PKM GEMOLONG', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(31, '085600026142', 'ARFIAN', '085600026142', 'RSSG', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(32, '082134358009', 'SUMARNO', '082134358009', 'RSSG', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(33, '085248569739', 'DWI', '085248569739', 'RSSG', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(34, '085701388519', 'WIDODO', '085701388519', 'RSSG', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(35, '087825223945', 'AKIL', '087825223945', 'RSSG', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(36, '081253016020', 'KHUMAIDI', '081253016020', 'LAZISMU SUMBERLAWANG', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(37, '081329583363', 'NARDI', '081329583363', 'LAZISMU SUMBERLAWANG', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(38, '082226011975', 'WAHYUDI', '082226011975', 'LAZISMU GEMOLONG', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(39, '082241950979', 'AGUS SULISTYANTORO', '082241950979', 'PDIP MIRI', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(40, '082220044872', 'AHMAD TAUFIK', '082220044872', 'NU MONDOKAN', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(41, '082137522228', 'ARIS PURYANTO', '082137522228', 'SAGASUBA', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(42, '088215120394', 'SUMARDI CHOXI', '088215120394', 'SOBAT RSSG', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(43, '082124805906', 'MARSUDI SANTOSO', '082124805906', 'PPS', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(44, '082324999936', 'EKO PRASETYO', '082324999936', 'NU TANON', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(45, '082136899396', 'LUTHFAN', '082136899396', 'RSSG', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(46, '085229044130', 'BASUKI', '085229044130', 'RESCUE KALIJAMBE', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(47, '085640112258', 'BAMBANG', '085640112258', 'PP KALIJAMBE', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(48, '081234997605', 'IRFAN MISWANTO', '081234997605', 'MTA GEMOLONG', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(49, '081392455843', 'YAHYA', '081392455843', 'MTA GEMOLONG', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(50, '081227941528', 'ADE H', '081227941528', 'POSKESTREN MTA GEMOLONG', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(51, '085228070059', 'FITRIANTO', '085228070059', 'POSKESTREN MTA GEMOLONG', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(52, '081393677727', 'FAI', '081393677727', 'SAGASUBA', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(53, '088232082120', 'HARRIS', '088232082120', 'PKM SUMBERLAWANG', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(54, '082313852347', 'TEDIK ICHVAN', '082313852347', 'PKM MONDOKAN', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(55, '081391885121', 'TAMAS JOHN', '081391885121', 'PKM MONDOKAN', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(56, '082224369067', 'WAGIMAN', '082224369067', 'NU SUMBERLAWANG', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(57, '087853071887', 'SUTIMIN', '087853071887', 'SIAGA DESA KECIK', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(58, '085777742621', 'WAHYU TRI', '085777742621', 'PKM SUMBERLAWANG', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(59, '082137586707', 'SAKRI', '082137586707', 'PKM MIRI', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(60, '085229339324', 'NIDA', '085229339324', 'LAZISMU GEMOLONG', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(61, '081393052929', 'SATRIO WAHYU', '081393052929', 'LAZISMU GEMOLONG', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(62, '081390255900', 'PAIDI', '081390255900', 'NU MONDOKAN', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(63, '082136898011', 'SIDHIQ', '082136898011', 'NU MONDOKAN', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(64, '081225906883', 'DALIMAN', '081225906883', 'PKM PLUPUH 1', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(65, '0882007732958', 'ROFIQ ROFI', '0882007732958', 'SIAGA TEMPELREJO', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(66, '082138495286', 'JOKO MURYONO', '082138495286', 'PKU SUMBERLAWANG', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(67, '000000000001', 'AGUNG PRASTYO', '000000000001', 'PKU SUMBERLAWANG', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(68, '082225076898', 'SURATMAN', '082225076898', 'NU GEMOLONG', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(69, '085786602272', 'TOTOK', '085786602272', 'SAGASUBA', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(70, '087877207348', 'EKO CB', '087877207348', 'PPS', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(71, '085166989408', 'NURYANTO', '085166989408', 'SIAGA TEMPELREJO', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(72, '082245300098', 'ARIF', '082245300098', 'NU MONDOKAN', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(73, '081329650550', 'SRI WIDODO', '081329650550', 'SAGASUBA', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(74, '081329707693', 'SENTOT NUGROHO', '081329707693', 'SAGASUBA', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(75, '082137666877', 'AGUNG PRANOTO', '082137666877', 'SAGASUBA', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(76, '082220491940', 'EKO BUDIYANTO', '082220491940', 'NU ANDONG', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(77, '081335504875', 'WAWAN', '081335504875', 'NU ANDONG', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(78, '082325568544', 'IFAT', '082325568544', 'SIAGA TEMPELREJO', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(79, '085227846225', 'YULI STIYANTO', '085227846225', 'NU SUKODONO', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(80, '087836944765', 'WARSONO KARSO', '087836944765', 'PKM MONDOKAN', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(81, '082328611339', 'TOTOK', '082328611339', 'ERISA PEDULI', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(82, '0882005370163', 'ENI LESTARI', '0882005370163', 'NU MIRI', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(83, '081329242303', 'EKO AGUS', '081329242303', 'MERONA RESCUE', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(84, '000000000002', 'EKO PLETET', '000000000002', 'PPS', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(85, '085290601768', 'TUTIK HANDAYANI', '085290601768', 'NU KALIJAMBE', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(86, '081226226022', 'WAWAN', '081226226022', 'MERONA RESCUE', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(87, '085229172997', 'SUNOTO', '085229172997', 'LAZISMU SUMBERLAWANG', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(88, '081229504663', 'RAMADHAN', '081229504663', 'AZZAHRA', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(89, '081393454225', 'EKO KARSONO', '081393454225', 'SIAGA SUMBERLAWANG', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(90, '082133190702', 'MUHAMMAD TIBYANI', '082133190702', 'NU GEMOLONG', 0, 0, '2025-12-01 03:27:36', '2025-12-11 05:03:03'),
(93, '083102555185', 'HEZKYA LISTIABUDI', '083102555185', 'ABIMANYU AMBULANCE', 0, 0, '2025-12-01 19:11:33', '2025-12-11 05:03:03');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_12_02_000001_create_scan_logs_table', 2),
(6, '2025_12_02_000002_create_rewards_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` bigint(20) UNSIGNED NOT NULL,
  `patient_name` varchar(255) DEFAULT NULL,
  `patient_condition` text DEFAULT NULL COMMENT 'Keluhan atau diagnosis awal',
  `destination` enum('IGD','Ponek') NOT NULL,
  `arrival_time` datetime NOT NULL COMMENT 'Waktu kedatangan/konfirmasi',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rewards`
--

CREATE TABLE `rewards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `driver_id` bigint(20) UNSIGNED NOT NULL,
  `points_spent` int(11) NOT NULL DEFAULT 0,
  `convert_point` decimal(65,0) DEFAULT NULL,
  `remaining_points` int(11) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rewards`
--

INSERT INTO `rewards` (`id`, `driver_id`, `points_spent`, `convert_point`, `remaining_points`, `status`, `created_at`, `updated_at`) VALUES
(94, 6, 1, '50000', 0, 'completed', '2025-12-11 05:04:44', '2025-12-11 05:04:44');

-- --------------------------------------------------------

--
-- Table structure for table `scan_logs`
--

CREATE TABLE `scan_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `driver_id` bigint(20) UNSIGNED DEFAULT NULL,
  `patient_id` bigint(20) UNSIGNED DEFAULT NULL,
  `scan_time` datetime NOT NULL DEFAULT '2025-12-02 07:16:15',
  `status` varchar(255) NOT NULL DEFAULT 'completed',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `driver_id` bigint(20) UNSIGNED NOT NULL,
  `scan_time` datetime NOT NULL COMMENT 'Waktu driver melakukan scan',
  `status` enum('CONFIRMED') NOT NULL,
  `points_awarded` int(11) NOT NULL COMMENT 'Poin yang diberikan untuk transaksi ini (misal: 1)',
  `confirmed_by_admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@admin.com', NULL, '$2y$10$YGpLZj9sqipNdRVnsEdjSOLo9NNSKmhCFnocTibiaabPpfqqFNlKO', NULL, '2025-12-01 02:42:37', '2025-12-01 02:42:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `driver_id_card` (`driver_id_card`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transaction_id` (`transaction_id`),
  ADD KEY `idx_transaction_id` (`transaction_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `rewards`
--
ALTER TABLE `rewards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rewards_driver_id_index` (`driver_id`),
  ADD KEY `rewards_status_index` (`status`);

--
-- Indexes for table `scan_logs`
--
ALTER TABLE `scan_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `scan_logs_driver_id_index` (`driver_id`),
  ADD KEY `scan_logs_patient_id_index` (`patient_id`),
  ADD KEY `scan_logs_scan_time_index` (`scan_time`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transaction_id` (`transaction_id`),
  ADD KEY `idx_driver_id` (`driver_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rewards`
--
ALTER TABLE `rewards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `scan_logs`
--
ALTER TABLE `scan_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `patients_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rewards`
--
ALTER TABLE `rewards`
  ADD CONSTRAINT `rewards_driver_id_foreign` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `scan_logs`
--
ALTER TABLE `scan_logs`
  ADD CONSTRAINT `scan_logs_driver_id_foreign` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `scan_logs_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
