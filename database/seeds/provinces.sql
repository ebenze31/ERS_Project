-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2025 at 05:45 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ers_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `provinces`
--

CREATE TABLE `provinces` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name_province` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `provinces`
--

INSERT INTO `provinces` (`id`, `created_at`, `updated_at`, `name_province`, `logo`, `banner`, `status`) VALUES
(1, NULL, NULL, 'กระบี่', NULL, NULL, NULL),
(2, NULL, NULL, 'กรุงเทพมหานคร', NULL, NULL, NULL),
(3, NULL, NULL, 'กาญจนบุรี', NULL, NULL, NULL),
(4, NULL, NULL, 'กาฬสินธุ์', NULL, NULL, NULL),
(5, NULL, NULL, 'กำแพงเพชร', NULL, NULL, NULL),
(6, NULL, NULL, 'ขอนแก่น', NULL, NULL, NULL),
(7, NULL, NULL, 'จันทบุรี', NULL, NULL, NULL),
(8, NULL, NULL, 'ฉะเชิงเทรา', NULL, NULL, NULL),
(9, NULL, NULL, 'ชลบุรี', NULL, NULL, NULL),
(10, NULL, NULL, 'ชัยนาท', NULL, NULL, NULL),
(11, NULL, NULL, 'ชัยภูมิ', NULL, NULL, NULL),
(12, NULL, NULL, 'ชุมพร', NULL, NULL, NULL),
(13, NULL, NULL, 'ตรัง', NULL, NULL, NULL),
(14, NULL, NULL, 'ตราด', NULL, NULL, NULL),
(15, NULL, NULL, 'ตาก', NULL, NULL, NULL),
(16, NULL, NULL, 'นครนายก', NULL, NULL, NULL),
(17, NULL, NULL, 'นครปฐม', NULL, NULL, NULL),
(18, NULL, NULL, 'นครพนม', NULL, NULL, NULL),
(19, NULL, NULL, 'นครราชสีมา', NULL, NULL, NULL),
(20, NULL, NULL, 'นครศรีธรรมราช', NULL, NULL, NULL),
(21, NULL, NULL, 'นครสวรรค์', NULL, NULL, NULL),
(22, NULL, NULL, 'นนทบุรี', NULL, NULL, NULL),
(23, NULL, NULL, 'นราธิวาส', NULL, NULL, NULL),
(24, NULL, NULL, 'น่าน', NULL, NULL, NULL),
(25, NULL, NULL, 'บึงกาฬ', NULL, NULL, NULL),
(26, NULL, NULL, 'บุรีรัมย์', NULL, NULL, NULL),
(27, NULL, NULL, 'ปทุมธานี', NULL, NULL, NULL),
(28, NULL, NULL, 'ประจวบคีรีขันธ์', NULL, NULL, NULL),
(29, NULL, NULL, 'ปราจีนบุรี', NULL, NULL, NULL),
(30, NULL, NULL, 'ปัตตานี', NULL, NULL, NULL),
(31, NULL, NULL, 'พระนครศรีอยุธยา', NULL, NULL, NULL),
(32, NULL, NULL, 'พะเยา', NULL, NULL, NULL),
(33, NULL, NULL, 'พังงา', NULL, NULL, NULL),
(34, NULL, NULL, 'พัทลุง', NULL, NULL, NULL),
(35, NULL, NULL, 'พิจิตร', NULL, NULL, NULL),
(36, NULL, NULL, 'พิษณุโลก', NULL, NULL, NULL),
(37, NULL, NULL, 'ภูเก็ต', NULL, NULL, NULL),
(38, NULL, NULL, 'มหาสารคาม', NULL, NULL, NULL),
(39, NULL, NULL, 'มุกดาหาร', NULL, NULL, NULL),
(40, NULL, NULL, 'ยะลา', NULL, NULL, NULL),
(41, NULL, NULL, 'ยโสธร', NULL, NULL, NULL),
(42, NULL, NULL, 'ระนอง', NULL, NULL, NULL),
(43, NULL, NULL, 'ระยอง', NULL, NULL, NULL),
(44, NULL, NULL, 'ราชบุรี', NULL, NULL, NULL),
(45, NULL, NULL, 'ร้อยเอ็ด', NULL, NULL, NULL),
(46, NULL, NULL, 'ลพบุรี', NULL, NULL, NULL),
(47, NULL, NULL, 'ลำปาง', NULL, NULL, NULL),
(48, NULL, NULL, 'ลำพูน', NULL, NULL, NULL),
(49, NULL, NULL, 'ศรีสะเกษ', NULL, NULL, NULL),
(50, NULL, NULL, 'สกลนคร', NULL, NULL, NULL),
(51, NULL, NULL, 'สงขลา', NULL, NULL, NULL),
(52, NULL, NULL, 'สตูล', NULL, NULL, NULL),
(53, NULL, NULL, 'สมุทรปราการ', NULL, NULL, NULL),
(54, NULL, NULL, 'สมุทรสงคราม', NULL, NULL, NULL),
(55, NULL, NULL, 'สมุทรสาคร', NULL, NULL, NULL),
(56, NULL, NULL, 'สระบุรี', NULL, NULL, NULL),
(57, NULL, NULL, 'สระแก้ว', NULL, NULL, NULL),
(58, NULL, NULL, 'สิงห์บุรี', NULL, NULL, NULL),
(59, NULL, NULL, 'สุพรรณบุรี', NULL, NULL, NULL),
(60, NULL, NULL, 'สุราษฎร์ธานี', NULL, NULL, NULL),
(61, NULL, NULL, 'สุรินทร์', NULL, NULL, NULL),
(62, NULL, NULL, 'สุโขทัย', NULL, NULL, NULL),
(63, NULL, NULL, 'หนองคาย', NULL, NULL, NULL),
(64, NULL, NULL, 'หนองบัวลำภู', NULL, NULL, NULL),
(65, NULL, NULL, 'อำนาจเจริญ', NULL, NULL, NULL),
(66, NULL, NULL, 'อุดรธานี', NULL, NULL, NULL),
(67, NULL, NULL, 'อุตรดิตถ์', NULL, NULL, NULL),
(68, NULL, NULL, 'อุทัยธานี', NULL, NULL, NULL),
(69, NULL, NULL, 'อุบลราชธานี', NULL, NULL, NULL),
(70, NULL, NULL, 'อ่างทอง', NULL, NULL, NULL),
(71, NULL, NULL, 'เชียงราย', NULL, NULL, NULL),
(72, NULL, NULL, 'เชียงใหม่', NULL, NULL, NULL),
(73, NULL, NULL, 'เพชรบุรี', NULL, NULL, NULL),
(74, NULL, NULL, 'เพชรบูรณ์', NULL, NULL, NULL),
(75, NULL, NULL, 'เลย', NULL, NULL, NULL),
(76, NULL, NULL, 'แพร่', NULL, NULL, NULL),
(77, NULL, NULL, 'แม่ฮ่องสอน', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `provinces`
--
ALTER TABLE `provinces`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `provinces`
--
ALTER TABLE `provinces`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
