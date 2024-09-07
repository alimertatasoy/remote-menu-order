-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 16, 2024 at 06:15 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `siparis`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `username` varchar(45) COLLATE utf8mb4_turkish_ci NOT NULL,
  `password` varchar(45) COLLATE utf8mb4_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(2, 'alimert', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `siparisler`
--

CREATE TABLE `siparisler` (
  `id` int NOT NULL,
  `urun_adi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `miktar` int NOT NULL,
  `tarih` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `masa` varchar(45) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `verildi_mi` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `siparisler`
--

INSERT INTO `siparisler` (`id`, `urun_adi`, `miktar`, `tarih`, `masa`, `verildi_mi`) VALUES
(5, 'Ekmek Arası Et Döner', 3, '2024-05-01 09:04:30', '1', 1),
(6, 'Ekmek Arası Et Döner', 2, '2024-05-01 09:04:55', '3', 1),
(7, 'Buz Gibi Ayran', 1, '2024-05-01 09:04:55', '3', 1),
(8, 'Sopsoğuk Bol Asitli Kola', 1, '2024-05-01 09:04:55', '3', 1),
(9, 'Fıstıklı Dondurmalı Künefe', 2, '2024-05-01 09:04:55', '3', 1),
(10, 'Ekmek Arası Et Döner', 2, '2024-05-01 09:09:34', '2', 1),
(11, 'Buz Gibi Ayran', 2, '2024-05-01 09:09:34', '2', 1),
(12, 'Ekmek Arası Et Döner', 3, '2024-05-01 09:36:41', '1', 1),
(13, 'Buz Gibi Ayran', 2, '2024-05-01 09:36:41', '1', 1),
(14, 'Antepli Ustadan Lahmacun', 1, '2024-05-01 10:19:30', '2', 1),
(15, 'Buz Gibi Ayran', 1, '2024-05-01 10:19:30', '2', 1),
(16, 'Sopsoğuk Bol Asitli Kola', 3, '2024-05-01 18:00:20', '2', 1),
(17, 'Tereyağlı Et İskender', 2, '2024-05-02 05:16:55', '3', 1),
(18, 'Sopsoğuk Bol Asitli Kola', 2, '2024-05-02 05:16:55', '3', 1),
(19, 'Ekmek Arası Et Döner', 4, '2024-05-02 05:38:16', '2', 1),
(20, 'Sopsoğuk Bol Asitli Kola', 4, '2024-05-02 05:38:16', '2', 1),
(21, 'Tavuk Döner', 2, '2024-05-02 06:17:27', '3', 1),
(22, 'Tavuk Döner', 3, '2024-05-02 09:05:39', '3', 1),
(23, 'Tereyağlı İskender', 2, '2024-05-02 09:05:39', '3', 1),
(24, 'Ekler', 3, '2024-05-02 09:05:39', '3', 1),
(25, 'Su', 4, '2024-05-02 09:05:39', '3', 1),
(26, 'Tavuk Döner', 2, '2024-05-02 09:08:55', '2', 1),
(27, 'Kola', 2, '2024-05-02 09:08:55', '2', 1),
(28, 'Tavuk Döner', 2, '2024-05-02 10:28:53', '3', 1),
(29, 'Baklava', 2, '2024-05-02 10:28:53', '3', 1),
(30, 'Ekler', 4, '2024-05-02 10:28:53', '3', 1),
(31, 'Baklava', 2, '2024-05-03 19:27:43', '3', 1),
(32, 'Kola', 2, '2024-05-03 19:27:43', '3', 1),
(33, 'Tavuk Döner', 2, '2024-05-06 08:11:33', '3', 1),
(34, 'Künefe', 1, '2024-05-06 08:11:33', '3', 1),
(35, 'Kola', 2, '2024-05-06 08:11:33', '3', 1),
(36, 'Tavuk Döner', 3, '2024-05-07 07:31:09', '3', 1),
(37, 'Su', 5, '2024-05-07 07:31:09', '3', 1),
(38, 'Tavuk Döner', 1, '2024-05-07 07:52:29', '3', 1),
(39, 'Kola', 1, '2024-05-07 07:52:29', '3', 1),
(40, 'Tavuk Döner', 1, '2024-05-13 06:25:41', '2', 1),
(41, 'Kola', 2, '2024-05-13 06:25:41', '2', 1),
(42, 'Tavuk Döner', 2, '2024-05-13 15:29:36', '1', 1),
(43, 'Ayran', 2, '2024-05-13 15:29:36', '1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sitebilgi`
--

CREATE TABLE `sitebilgi` (
  `id` int NOT NULL,
  `siteismi` varchar(45) COLLATE utf8mb4_turkish_ci NOT NULL,
  `sitearkaurl` varchar(250) COLLATE utf8mb4_turkish_ci NOT NULL,
  `sitelogourl` varchar(250) COLLATE utf8mb4_turkish_ci NOT NULL,
  `footer` varchar(500) COLLATE utf8mb4_turkish_ci NOT NULL,
  `masasayisi` varchar(45) COLLATE utf8mb4_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `sitebilgi`
--

INSERT INTO `sitebilgi` (`id`, `siteismi`, `sitearkaurl`, `sitelogourl`, `footer`, `masasayisi`) VALUES
(1, 'ATASOY FAST FOOD', 'uploads/back.png', 'uploads/ATASOY.png', 'Bu web sitesi Aksaray Üniversitesi @Ali Mert adlı kişi tarafından yapılmıştır.', '10');

-- --------------------------------------------------------

--
-- Table structure for table `urunler`
--

CREATE TABLE `urunler` (
  `id` int NOT NULL,
  `urun_adi` varchar(45) COLLATE utf8mb4_turkish_ci NOT NULL,
  `fiyat` float NOT NULL,
  `resim_yolu` varchar(90) COLLATE utf8mb4_turkish_ci NOT NULL,
  `tip` varchar(45) COLLATE utf8mb4_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `urunler`
--

INSERT INTO `urunler` (`id`, `urun_adi`, `fiyat`, `resim_yolu`, `tip`) VALUES
(9, 'Tavuk Döner', 75, 'uploads/66332f7ed89588.80326070.jpg', 'yemek'),
(10, 'Tereyağlı İskender', 100, 'uploads/66332f8f71a8e3.76395065.png', 'yemek'),
(11, 'Köfte Hamburger', 85, 'uploads/66332fbe079e03.00698085.jpg', 'yemek'),
(12, 'Baklava', 150, 'uploads/66333429c2b053.90951117.jpg', 'tatlı'),
(13, 'Künefe', 160, 'uploads/6633343de99da7.57802133.png', 'tatlı'),
(14, 'Ekler', 35, 'uploads/66333452bb02b6.46446316.jpg', 'tatlı'),
(16, 'Su', 15, 'uploads/66334d3f250327.36974239.jpg', 'içecek'),
(17, 'Şalgam', 25, 'uploads/66334d4dbaebf7.69596373.jpg', 'içecek'),
(18, 'Ayran', 15, 'uploads/66334d5c154ba9.32544050.jpg', 'içecek'),
(19, 'Kola', 30, 'uploads/66334d80196b81.03464632.jpg', 'içecek');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `siparisler`
--
ALTER TABLE `siparisler`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sitebilgi`
--
ALTER TABLE `sitebilgi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `urunler`
--
ALTER TABLE `urunler`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `siparisler`
--
ALTER TABLE `siparisler`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `sitebilgi`
--
ALTER TABLE `sitebilgi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `urunler`
--
ALTER TABLE `urunler`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
