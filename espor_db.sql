-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 21 Haz 2023, 13:28:48
-- Sunucu sürümü: 10.4.28-MariaDB
-- PHP Sürümü: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `espor_db`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `gorusme`
--

CREATE TABLE `gorusme` (
  `GorusmeID` int(10) UNSIGNED NOT NULL,
  `LiderID` int(10) UNSIGNED NOT NULL,
  `OyuncuID` int(10) UNSIGNED NOT NULL,
  `GorusmeBaslik` varchar(100) NOT NULL,
  `GorusmeAciklama` text NOT NULL,
  `GorusmeBaslangic` varchar(25) NOT NULL DEFAULT current_timestamp(),
  `GorusmeBitis` varchar(25) NOT NULL,
  `YoneticiID` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `oyuncu`
--

CREATE TABLE `oyuncu` (
  `oyuncuID` int(10) UNSIGNED NOT NULL,
  `uyeID` int(10) UNSIGNED NOT NULL,
  `oyunID` int(10) UNSIGNED NOT NULL,
  `oyuncuKullaniciAdi` varchar(40) NOT NULL,
  `oyuncuTakimDurumu` tinyint(1) NOT NULL DEFAULT 0,
  `takimID` int(10) UNSIGNED DEFAULT NULL,
  `oyuncuSiralama` int(10) NOT NULL,
  `oyuncuRank` int(11) NOT NULL,
  `oyuncuEtiketi` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `oyuncu`
--

INSERT INTO `oyuncu` (`oyuncuID`, `uyeID`, `oyunID`, `oyuncuKullaniciAdi`, `oyuncuTakimDurumu`, `takimID`, `oyuncuSiralama`, `oyuncuRank`, `oyuncuEtiketi`) VALUES
(21, 17, 1, 'Wo0t', 2, 21, 900, 2, '6663'),
(22, 18, 1, 'sociablEE', 2, 22, 7003, 2, '9814'),
(23, 19, 1, 'yetujey', 2, 23, 983, 2, '4789'),
(24, 20, 1, 'lurzy0y0', 2, 21, 3607, 2, '5252'),
(25, 21, 1, 'uss', 2, 22, 400, 2, '4591'),
(26, 22, 1, 'DESTRUCT1VEE', 2, 23, 3502, 2, '9054'),
(27, 23, 1, 'ip0TT', 2, 24, 1607, 2, '9463'),
(28, 24, 1, 'JN3v1cEEE', 2, 24, 42, 2, '8130'),
(29, 25, 2, 'MerSa', 2, 25, 793, 2, '7351'),
(30, 26, 2, 'Baransel', 2, 26, 1501, 2, '3081'),
(31, 27, 2, 'Burzzy', 2, 27, 0, 2, '7351'),
(32, 28, 2, 'sterben', 2, 25, 910, 2, '6172'),
(33, 29, 2, 'CyderX', 2, 26, 800, 2, '8124'),
(34, 30, 2, 'Elite', 2, 27, 608, 2, '6749'),
(35, 31, 1, 'Izzy', 2, 21, 502, 2, '8379'),
(36, 32, 1, 'DeepMans', 2, 22, 290, 2, '6139'),
(37, 34, 1, 'skylen', 2, 24, 300, 2, '8603'),
(38, 33, 1, 'lauress', 2, 23, 1, 2, '1479');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `oyuncuonaytalep`
--

CREATE TABLE `oyuncuonaytalep` (
  `talepID` int(11) NOT NULL,
  `uyeID` int(10) UNSIGNED NOT NULL,
  `kullaniciAdi` varchar(255) NOT NULL,
  `etiket` int(11) NOT NULL,
  `kanit` varchar(255) NOT NULL DEFAULT 'default.png',
  `oyun` varchar(255) NOT NULL,
  `discordHesap` varchar(255) NOT NULL DEFAULT 'default',
  `onayDurum` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `oyuncuonaytalep`
--

INSERT INTO `oyuncuonaytalep` (`talepID`, `uyeID`, `kullaniciAdi`, `etiket`, `kanit`, `oyun`, `discordHesap`, `onayDurum`) VALUES
(20, 17, 'Wo0t', 6663, '647bad3499497.png', 'Val', 'mertalkan#7341', 2),
(21, 18, 'sociablEE', 9814, '647bae0e9d96f.png', 'Val', 'volkanyonal#4598', 2),
(22, 19, 'yetujey', 4789, '647baed4f3ee8.png', 'Val', 'eraybudak#6782', 2),
(23, 20, 'lurzy0y0', 5252, '647baff3e42e6.png', 'Val', 'ibrahimsandikci#2596', 2),
(24, 21, 'uss', 4591, '647bb06d2390c.png', 'Val', 'batuhanmalkac#4578', 2),
(25, 22, 'DESTRUCT1VEE', 9054, '647bb1f5d2e29.png', 'Val', 'hakanlekesizer#5130', 2),
(26, 23, 'ip0TT', 9463, '647bb2b84bfe8.png', 'Val', 'yigitkaradeniz#5758', 2),
(27, 24, 'JN3v1cEEE', 8130, '647bb36cac4a2.png', 'Val', 'emrebekce#4390', 2),
(28, 25, 'MerSa', 7351, '647bb3eab50fe.png', 'Val', 'mertsaatci#6971', 2),
(29, 26, 'Baransel', 3081, '647bb491bb59e.png', 'Val', 'baranselnasircan#3276', 2),
(30, 27, 'Burzzy', 7351, '647bb562189fc.png', 'Val', 'burakozveren#4931', 2),
(31, 28, 'sterben', 6172, '647bb60c71866.png', 'Val', 'emredemirci#2791', 2),
(32, 29, 'CyderX', 8124, '647bb67b32e58.png', 'Val', 'canerdemir#6721', 2),
(33, 30, 'Elite', 6749, '647bb6ebe2d52.png', 'Val', 'efeteber#5127', 2),
(34, 31, 'Izzy', 8379, '647bb7e70b089.png', 'Val', 'baranyilmaz#8234', 2),
(35, 32, 'DeepMans', 6139, '647bb86bc9709.png', 'Val', 'yigithankesici#6472', 2),
(36, 33, 'lauress', 1479, '647bb8ee74eeb.png', 'Val', 'toprakkaynak#6783', 2),
(37, 34, 'skylen', 8603, '647bb97073a0d.png', 'Val', 'asilyalcin#9302', 2);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `oyunlar`
--

CREATE TABLE `oyunlar` (
  `oyunID` int(10) UNSIGNED NOT NULL,
  `oyunIsmi` varchar(40) NOT NULL,
  `oyunLogo` varchar(255) NOT NULL,
  `oyunAciklama` text NOT NULL,
  `oyunTag` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `oyunlar`
--

INSERT INTO `oyunlar` (`oyunID`, `oyunIsmi`, `oyunLogo`, `oyunAciklama`, `oyunTag`) VALUES
(1, 'Valorant', 'default', 'Valorant oyunu', 'Val'),
(2, 'Counter Strike Global Offensive', 'default', 'Counter Strike Global Offensive oyunu', 'CSGO');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `oyunrank`
--

CREATE TABLE `oyunrank` (
  `rankID` int(11) NOT NULL,
  `oyunID` int(11) NOT NULL,
  `rankAd` varchar(255) NOT NULL,
  `rankAciklama` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `oyunrank`
--

INSERT INTO `oyunrank` (`rankID`, `oyunID`, `rankAd`, `rankAciklama`) VALUES
(1, 2, 'Elmas', 'Elmas Rank'),
(2, 1, 'Gümüş', 'Gümüş Rank');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `takimlar`
--

CREATE TABLE `takimlar` (
  `takimID` int(10) UNSIGNED NOT NULL,
  `oyunID` int(10) UNSIGNED NOT NULL,
  `takimAdi` varchar(50) NOT NULL,
  `takimLogo` varchar(255) NOT NULL,
  `takimEtiket` varchar(10) NOT NULL,
  `takimAciklama` text NOT NULL,
  `takimPuani` int(10) NOT NULL,
  `takimOnayDurumu` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `takimlar`
--

INSERT INTO `takimlar` (`takimID`, `oyunID`, `takimAdi`, `takimLogo`, `takimEtiket`, `takimAciklama`, `takimPuani`, `takimOnayDurumu`) VALUES
(21, 1, 'Team Vitality', '64920b93b6c4d.png', '6663', 'Takımımız valorant oyununda yer almak istiyor.', 0, 1),
(22, 1, 'FUT Esports', '64920c90302dd.png', '7351', 'Takımımız esporda valorantı temsil etmek istiyor.', 0, 1),
(23, 1, 'Team Liquid', '64920cf2d49aa.png', '7982', 'Valorantı canlandırmak istiyoruz.', 0, 1),
(24, 1, 'Natus Vincere', '6492118e2ff71.png', '9462', 'Takımımız valorant oyununda önde gelen takımlardan olacak.', 0, 1),
(25, 2, 'FNATIC', '6492133a8ddb9.png', '4263', 'Takımımız CS oyununda başarı gösterecektir.', 0, 1),
(26, 2, 'Global Esports', '6492139556f52.png', '4793', 'CS-Go da başarılarımızı kanıtlayacağız.', 0, 1),
(27, 2, 'Gen.G', '649213ec483fb.png', '6218', 'Takımımız başarılı olacak.', 0, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `takimlideri`
--

CREATE TABLE `takimlideri` (
  `LiderID` int(10) UNSIGNED NOT NULL,
  `uyeID` int(11) NOT NULL,
  `oyuncuID` int(11) NOT NULL,
  `takimID` int(10) UNSIGNED NOT NULL,
  `liderRolu` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `takimlideri`
--

INSERT INTO `takimlideri` (`LiderID`, `uyeID`, `oyuncuID`, `takimID`, `liderRolu`) VALUES
(13, 17, 21, 21, 5),
(14, 18, 22, 22, 5),
(15, 19, 23, 23, 5),
(16, 23, 27, 24, 5),
(17, 25, 29, 25, 5),
(18, 26, 30, 26, 5),
(19, 27, 31, 27, 5);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `takimonaytalep`
--

CREATE TABLE `takimonaytalep` (
  `talepID` int(11) NOT NULL,
  `uyeID` int(11) NOT NULL,
  `oyunID` int(11) NOT NULL,
  `oyuncuID` int(11) NOT NULL,
  `takimAdi` varchar(255) NOT NULL,
  `takimLogo` varchar(255) NOT NULL,
  `takimAciklama` text NOT NULL,
  `takimEtiket` varchar(255) NOT NULL,
  `takimPuani` varchar(2555) NOT NULL DEFAULT '0',
  `kullaniciAdi` varchar(255) NOT NULL,
  `discordHesap` varchar(255) NOT NULL DEFAULT 'default',
  `takimOnayDurum` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `takimonaytalep`
--

INSERT INTO `takimonaytalep` (`talepID`, `uyeID`, `oyunID`, `oyuncuID`, `takimAdi`, `takimLogo`, `takimAciklama`, `takimEtiket`, `takimPuani`, `kullaniciAdi`, `discordHesap`, `takimOnayDurum`) VALUES
(17, 17, 1, 21, 'Team Vitality', '64920b93b6c4d.png', 'Takımımız valorant oyununda yer almak istiyor.', '6663', '0', '', 'mertalkan#7341', 2),
(18, 18, 1, 22, 'FUT Esports', '64920c90302dd.png', 'Takımımız esporda valorantı temsil etmek istiyor.', '7351', '0', '', 'volkanyonal#4598', 2),
(19, 19, 1, 23, 'Team Liquid', '64920cf2d49aa.png', 'Valorantı canlandırmak istiyoruz.', '7982', '0', '', 'eraybudak#6782', 2),
(20, 23, 1, 27, 'Natus Vincere', '6492118e2ff71.png', 'Takımımız valorant oyununda önde gelen takımlardan olacak.', '9462', '0', '', 'yigitkaradeniz#5758', 2),
(21, 25, 2, 29, 'FNATIC', '6492133a8ddb9.png', 'Takımımız CS oyununda başarı gösterecektir.', '4263', '0', '', 'mertsaatci#6971', 2),
(22, 26, 2, 30, 'Global Esports', '6492139556f52.png', 'CS-Go da başarılarımızı kanıtlayacağız.', '4793', '0', '', 'baranselnasircan#3276', 2),
(23, 27, 2, 31, 'Gen.G', '649213ec483fb.png', 'Takımımız başarılı olacak.', '6218', '0', '', 'burakozveren#4931', 2);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `uye`
--

CREATE TABLE `uye` (
  `ID` int(10) UNSIGNED NOT NULL,
  `KullaniciAdi` varchar(40) NOT NULL,
  `Sifre` varchar(600) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Ismi` varchar(50) NOT NULL,
  `Soyismi` varchar(50) NOT NULL,
  `Dogumtarihi` varchar(10) NOT NULL,
  `Onayi` tinyint(1) NOT NULL DEFAULT 0,
  `Kayittarihi` timestamp NOT NULL DEFAULT current_timestamp(),
  `Puani` int(11) NOT NULL,
  `ProfilResmi` varchar(255) NOT NULL DEFAULT 'defaultpp.png',
  `rol` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `uye`
--

INSERT INTO `uye` (`ID`, `KullaniciAdi`, `Sifre`, `Email`, `Ismi`, `Soyismi`, `Dogumtarihi`, `Onayi`, `Kayittarihi`, `Puani`, `ProfilResmi`, `rol`) VALUES
(1, 'Myre', 'denemesifre', 'denememail@gmail.com', 'hasan', 'tezcan', '2010-1-1', 2, '2023-03-08 13:44:06', 0, '64149fb9e0c2f.png', 1),
(16, 'Mert2020', '$2y$10$YL46P.tBpDZE2lJFAdos6u1JfcCC.4RFfAD72avUhsa4toURYC95C', 'mertmert@gmail.com', 'Mert', 'Yeşilyurt', '2000-4-11', 2, '2023-06-02 11:04:02', 0, 'defaultpp.png', 2),
(17, 'Wo0t', '$2y$10$qdSkXzeNhFE9TJLv0wJRbOzGbhJEp3HxvkAMWUDPc14aeYh.pVn92', 'mertalkan@gmail.com', 'Mert', 'Alkan', '1996-5-8', 2, '2023-06-03 20:57:31', 0, '647bae3376cc2.png', 2),
(18, 'sociablEE', '$2y$10$GVeoDQfxIfMk7f102YkL6OGG8tlS7HjbCQExbNrMKFRHfL2kZITMS', 'volkanyonal@gmail.com', 'Volkan', 'Yonal', '2001-12-26', 2, '2023-06-03 21:16:42', 0, '647bae1b1a30d.png', 2),
(19, 'yetujey', '$2y$10$8K3CzPtiyx1KW4LZDaUGdOtjcXk6v96ls1a6XwwtUWWLxyKLwdBn.', 'eraybudak@gmail.com', 'Eray', 'Budak', '1993-8-14', 2, '2023-06-03 21:20:15', 0, '647baedcd93f6.png', 2),
(20, 'lurzy0y0', '$2y$10$ILpkPkjzIGNZj3f1pJeYbuPehJn2FkWHOORYHT.MH88EjLgJaj/fu', 'ibrahimsandikci@gmail.com', 'İbrahim', 'Sandıkçı', '2003-2-25', 2, '2023-06-03 21:22:41', 0, '647baffa866e7.png', 1),
(21, 'uss', '$2y$10$jofStcu4bw1bpnLl8xCeAuKgOdE5IiD5KsZJ8zk7CNzA/hW0u0Nl.', 'batuhanmalkac@gmail.com', 'Batuhan', 'Malkaç', '1996-6-26', 2, '2023-06-03 21:27:09', 0, '647bb073e29e0.png', 1),
(22, 'DESTRUCT1VEE', '$2y$10$LigWm2/9WDhREUafBL.mFu0/9rtPiSpVpJCb1GO2Csa057lUD5pxW', 'hakanlekesizer@gmail.com', 'Hakan', 'Lekesizer', '2001-10-29', 2, '2023-06-03 21:32:25', 0, '647bb1fe6a101.png', 1),
(23, 'ip0TT', '$2y$10$kygOyVRQYGTdgdO82l.LCesoFRwsOUtjEEzdqNPJflx2rAZQw9jKC', 'yigitkaradeniz@gmail.com', 'Yiğit', 'Karadeniz', '2000-1-31', 2, '2023-06-03 21:37:05', 0, '647bb2beb7be3.png', 2),
(24, 'JN3v1cEEE', '$2y$10$CFqcru7gwgRxZOjETHJxkO7y8cs8QuL8Lnm1EEYo9pIyDisGedA2u', 'emrebekce@gmail.com', 'Emre', 'Bekçe', '2004-6-18', 2, '2023-06-03 21:40:00', 0, '647bb37281ab8.png', 1),
(25, 'MerSa', '$2y$10$ZDFUAzKXmqdrevhGhNiabuOPR3kF2RKUactYTVD1FiqcZCLyFlifu', 'mertsaatci@gmail.com', 'Mert', 'Saatcı', '1991-3-29', 2, '2023-06-03 21:42:05', 0, '647bb3f13669e.png', 2),
(26, 'Baransel', '$2y$10$XDNw5XLHATKO2/94eG./pOvieOow/1lj1PVLZzTgK2ieyoxAPlPmW', 'baranselnasircan@gmail.com', 'Baransel', 'Nasırcan', '1990-9-25', 2, '2023-06-03 21:44:31', 0, '647bb499da92e.png', 2),
(27, 'Burzzy', '$2y$10$zKs3AeSpUVQbVHVvDNLeoeEbqhG6Id.hnQzZ3GHSgzjdZkNnHQuhe', 'burakozveren@gmail.com', 'Burak', 'Özveren', '2002-8-4', 2, '2023-06-03 21:47:35', 0, '647bb522b9bd8.png', 2),
(28, 'sterben', '$2y$10$Xj0qwhQmmRvpD4gIhwUEq.o8jpMi/PgJG93323ObEiZxvZm6j32XO', 'emredemirci@gmail.com', 'Emre', 'Demirci', '2004-8-17', 2, '2023-06-03 21:51:27', 0, '647bb5f29139e.png', 1),
(29, 'CyderX', '$2y$10$FDTtuTNzJRd.miS4wxstierAkS0pnm96LDTB18ETeZChPbN5wnNDe', 'canerdemir@gmail.com', 'Caner', 'Demir', '2002-5-25', 2, '2023-06-03 21:53:15', 0, '647bb660d66f5.png', 1),
(30, 'Elite', '$2y$10$PGOxUoqF5/0waGqrRKLuqudsrz1mkx9Y7fRcTxJfysK/mZmtrhC5y', 'efeteber@gmail.com', 'Efe', 'Teber', '1993-11-3', 2, '2023-06-03 21:55:09', 0, '647bb6ce361ab.png', 1),
(31, 'Izzy', '$2y$10$LPZCFGAMQU16oKyg3WGhC.Cy09ZCkzAO0pLuG9b.DbvV10CWN8HLq', 'baranyilmaz@gmail.com', 'Baran', 'Yılmaz', '1987-9-17', 2, '2023-06-03 21:59:20', 0, '647bb7c8d86a0.png', 1),
(32, 'DeepMans', '$2y$10$FKNH1NRLC6eOoY/vQUd06uPW0hIlVw31FZpnk1UmK6bTwQIbdFBFm', 'yigithankesici@gmail.com', 'Yiğithan', 'Kesici', '2005-9-25', 2, '2023-06-03 22:01:34', 0, '647bb84f0cbde.png', 1),
(33, 'lauress', '$2y$10$21aRFLy9Hu1IJx2NzS82a.05RWGKLBWc/JSQeahVRBGq.HL5pn5cK', 'toprakkaynak@gmail.com', 'Toprak', 'Kaynak', '1998-7-5', 2, '2023-06-03 22:03:38', 0, '647bb8ceb5bf1.png', 1),
(34, 'skylen', '$2y$10$TQOZspDtjKgxuqdMNnRyaeqdw3aPI4JAmLk5rvRKz2vYmW4teJcR2', 'asilyalcin@gmail.com', 'Asil', 'Yalçın', '2001-2-30', 2, '2023-06-03 22:05:52', 0, '647bb94e081c3.png', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yonetici`
--

CREATE TABLE `yonetici` (
  `YoneticiID` int(10) UNSIGNED NOT NULL,
  `UyeID` int(10) UNSIGNED NOT NULL,
  `YoneticiRolu` tinyint(1) NOT NULL DEFAULT 0,
  `yoneticiSifre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `yonetici`
--

INSERT INTO `yonetici` (`YoneticiID`, `UyeID`, `YoneticiRolu`, `yoneticiSifre`) VALUES
(4, 16, 4, '123456');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `gorusme`
--
ALTER TABLE `gorusme`
  ADD PRIMARY KEY (`GorusmeID`),
  ADD KEY `LiderID` (`LiderID`,`OyuncuID`,`YoneticiID`);

--
-- Tablo için indeksler `oyuncu`
--
ALTER TABLE `oyuncu`
  ADD PRIMARY KEY (`oyuncuID`),
  ADD KEY `UyeID` (`uyeID`,`oyunID`,`takimID`),
  ADD KEY `OyunID` (`oyunID`),
  ADD KEY `TakimID` (`takimID`);

--
-- Tablo için indeksler `oyuncuonaytalep`
--
ALTER TABLE `oyuncuonaytalep`
  ADD PRIMARY KEY (`talepID`),
  ADD KEY `uyeID` (`uyeID`);

--
-- Tablo için indeksler `oyunlar`
--
ALTER TABLE `oyunlar`
  ADD PRIMARY KEY (`oyunID`),
  ADD UNIQUE KEY `OyunIsmi` (`oyunIsmi`),
  ADD UNIQUE KEY `OyunTag` (`oyunTag`);

--
-- Tablo için indeksler `oyunrank`
--
ALTER TABLE `oyunrank`
  ADD PRIMARY KEY (`rankID`);

--
-- Tablo için indeksler `takimlar`
--
ALTER TABLE `takimlar`
  ADD PRIMARY KEY (`takimID`),
  ADD UNIQUE KEY `TakimIsmi` (`takimAdi`),
  ADD KEY `OyunID` (`oyunID`);

--
-- Tablo için indeksler `takimlideri`
--
ALTER TABLE `takimlideri`
  ADD PRIMARY KEY (`LiderID`),
  ADD KEY `TakimID` (`takimID`);

--
-- Tablo için indeksler `takimonaytalep`
--
ALTER TABLE `takimonaytalep`
  ADD PRIMARY KEY (`talepID`);

--
-- Tablo için indeksler `uye`
--
ALTER TABLE `uye`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `UyeUsername` (`KullaniciAdi`),
  ADD UNIQUE KEY `UyeEmail` (`Email`),
  ADD UNIQUE KEY `KullaniciAdi` (`KullaniciAdi`);

--
-- Tablo için indeksler `yonetici`
--
ALTER TABLE `yonetici`
  ADD PRIMARY KEY (`YoneticiID`),
  ADD KEY `UyeID` (`UyeID`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `gorusme`
--
ALTER TABLE `gorusme`
  MODIFY `GorusmeID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `oyuncu`
--
ALTER TABLE `oyuncu`
  MODIFY `oyuncuID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Tablo için AUTO_INCREMENT değeri `oyuncuonaytalep`
--
ALTER TABLE `oyuncuonaytalep`
  MODIFY `talepID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Tablo için AUTO_INCREMENT değeri `oyunlar`
--
ALTER TABLE `oyunlar`
  MODIFY `oyunID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `oyunrank`
--
ALTER TABLE `oyunrank`
  MODIFY `rankID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `takimlar`
--
ALTER TABLE `takimlar`
  MODIFY `takimID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Tablo için AUTO_INCREMENT değeri `takimlideri`
--
ALTER TABLE `takimlideri`
  MODIFY `LiderID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Tablo için AUTO_INCREMENT değeri `takimonaytalep`
--
ALTER TABLE `takimonaytalep`
  MODIFY `talepID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Tablo için AUTO_INCREMENT değeri `uye`
--
ALTER TABLE `uye`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Tablo için AUTO_INCREMENT değeri `yonetici`
--
ALTER TABLE `yonetici`
  MODIFY `YoneticiID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `oyuncu`
--
ALTER TABLE `oyuncu`
  ADD CONSTRAINT `oyuncu_ibfk_1` FOREIGN KEY (`uyeID`) REFERENCES `uye` (`ID`),
  ADD CONSTRAINT `oyuncu_ibfk_2` FOREIGN KEY (`oyunID`) REFERENCES `oyunlar` (`oyunID`),
  ADD CONSTRAINT `oyuncu_ibfk_3` FOREIGN KEY (`takimID`) REFERENCES `takimlar` (`takimID`);

--
-- Tablo kısıtlamaları `oyuncuonaytalep`
--
ALTER TABLE `oyuncuonaytalep`
  ADD CONSTRAINT `oyuncuonaytalep_ibfk_1` FOREIGN KEY (`uyeID`) REFERENCES `uye` (`ID`);

--
-- Tablo kısıtlamaları `takimlideri`
--
ALTER TABLE `takimlideri`
  ADD CONSTRAINT `takimlideri_ibfk_1` FOREIGN KEY (`takimID`) REFERENCES `takimlar` (`takimID`);

--
-- Tablo kısıtlamaları `yonetici`
--
ALTER TABLE `yonetici`
  ADD CONSTRAINT `yonetici_ibfk_1` FOREIGN KEY (`UyeID`) REFERENCES `uye` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
