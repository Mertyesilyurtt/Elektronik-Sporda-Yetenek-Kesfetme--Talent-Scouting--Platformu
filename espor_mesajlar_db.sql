-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 21 Haz 2023, 13:28:52
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
-- Veritabanı: `espor_mesajlar_db`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `gorusme`
--

CREATE TABLE `gorusme` (
  `gorusmeID` int(11) NOT NULL,
  `gorusmeTuru` tinyint(11) NOT NULL DEFAULT 0,
  `gorusmeOnayDurum` tinyint(11) NOT NULL DEFAULT 0,
  `gonderenID` int(11) NOT NULL,
  `aliciID` int(11) NOT NULL,
  `gorusmeBasligi` varchar(255) NOT NULL,
  `gorusmeIcerik` text NOT NULL,
  `gonderenDiscordHesap` varchar(255) NOT NULL DEFAULT 'girilmemiş',
  `aliciDiscordHesap` varchar(255) NOT NULL DEFAULT 'girilmemiş',
  `gorusmeTarih` timestamp NOT NULL DEFAULT current_timestamp(),
  `sorumluAdmin` int(11) NOT NULL,
  `adminMesaj` text NOT NULL DEFAULT 'Yok',
  `takimID` int(11) NOT NULL,
  `oyuncuID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `gorusme`
--

INSERT INTO `gorusme` (`gorusmeID`, `gorusmeTuru`, `gorusmeOnayDurum`, `gonderenID`, `aliciID`, `gorusmeBasligi`, `gorusmeIcerik`, `gonderenDiscordHesap`, `aliciDiscordHesap`, `gorusmeTarih`, `sorumluAdmin`, `adminMesaj`, `takimID`, `oyuncuID`) VALUES
(19, 0, 4, 20, 17, '[Team Vitality] Takımınıza Katılmak İstiyorum', 'Takımınızda oyuncu olmak istiyorum.', 'ibrahimsandikci#2596', 'mertalkan#6663', '2023-06-20 20:34:38', 4, '', 21, 24),
(20, 0, 4, 21, 18, '[FUT Esports] Takımınıza Katılmak İstiyorum', 'Takımınızda oyuncu olmak istiyorum.', 'batuhanmalkac#4578', 'volkanyonal#9814', '2023-06-20 20:46:05', 4, '', 22, 25),
(21, 0, 1, 22, 19, '[Team Liquid] Takımınıza Katılmak İstiyorum', 'Takımınızda yer almak isterim.\r\n', 'hakanlekesizer#5130', 'girilmemiş', '2023-06-20 20:47:07', 4, 'Yok', 23, 26),
(22, 0, 4, 22, 19, '[Team Liquid] Takımınıza Katılmak İstiyorum', 'Takımınızda yer almak isterim.', 'hakanlekesizer#5130', 'eraybudak#4789', '2023-06-20 20:50:12', 4, '', 23, 26),
(23, 0, 4, 24, 23, '[Natus Vincere] Takımınıza Katılmak İstiyorum', '', 'emrebekce#4390', 'yigitkaradeniz#9463', '2023-06-20 20:54:57', 4, '', 24, 28),
(24, 0, 4, 28, 25, '[FNATIC] Takımınıza Katılmak İstiyorum', '', 'emredemirci#2791', 'mertsaatci#	7351', '2023-06-20 21:03:45', 4, '', 25, 32),
(25, 0, 4, 29, 26, '[Global Esports] Takımınıza Katılmak İstiyorum', '', 'canerdemir#6721', 'baranselnasircan#3081', '2023-06-20 21:04:18', 4, '', 26, 33),
(26, 0, 4, 30, 27, '[Gen.G] Takımınıza Katılmak İstiyorum', '', 'efeteber#5127', 'buraközveren#7351', '2023-06-20 21:04:51', 4, '', 27, 34),
(27, 0, 4, 31, 17, '[Team Vitality] Takımınıza Katılmak İstiyorum', '', 'baranyilmaz#8234', 'mertalkan#6663', '2023-06-20 21:08:54', 4, '', 21, 35),
(28, 0, 4, 32, 18, '[FUT Esports] Takımınıza Katılmak İstiyorum', '', 'yigithankesici#6472', 'volkanyonal#9814', '2023-06-20 21:09:30', 4, '', 22, 36),
(29, 0, 4, 33, 19, '[Team Liquid] Takımınıza Katılmak İstiyorum', '', 'toprakkaynak#6783', 'eraybudak#4789', '2023-06-20 21:10:41', 4, '', 23, 38),
(30, 0, 4, 34, 23, '[Natus Vincere] Takımınıza Katılmak İstiyorum', '', 'asilyalcin#9302', 'yigitkaradeniz#9463', '2023-06-20 21:11:10', 4, '', 24, 37);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `iletisim`
--

CREATE TABLE `iletisim` (
  `iletisimID` int(11) NOT NULL,
  `isim` varchar(60) NOT NULL,
  `email` varchar(250) NOT NULL,
  `telefon` varchar(15) NOT NULL,
  `mesaj` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `iletisim`
--

INSERT INTO `iletisim` (`iletisimID`, `isim`, `email`, `telefon`, `mesaj`) VALUES
(1, 'hasan', 'denememail21@gmail.com', '05555555555', 'Site çok güzel'),
(2, 'ömer', 'denememail@gmail.com', '05454454545', '8. numaralı oyuncu talebime bakabilir misiniz');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kategoriler`
--

CREATE TABLE `kategoriler` (
  `kategoriID` int(11) NOT NULL,
  `kategoriIsmi` varchar(255) NOT NULL,
  `kategoriTuru` varchar(255) NOT NULL,
  `kategoriAciklama` varchar(850) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `kategoriler`
--

INSERT INTO `kategoriler` (`kategoriID`, `kategoriIsmi`, `kategoriTuru`, `kategoriAciklama`) VALUES
(1, 'Oyuncu Olma Talebi Yanıtı', 'Oyuncu Olma Talebi', ''),
(2, 'Deneme', 'deneme tür', ''),
(3, 'Takım Kurma Talebi Yanıtı', 'Takım Kurma', 'Takım Kurma Talebi Yanıtı'),
(4, 'Takıma Davet Et', 'Takım Daveti', 'Takıma Davet Et'),
(5, 'Takımdan At', 'Takım İşlemleri', 'Takım lideri seçili oyuncuyu takımdan çıkarttı');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `mesajlar`
--

CREATE TABLE `mesajlar` (
  `mesaj_id` int(11) NOT NULL,
  `gonderen_id` int(11) NOT NULL,
  `alici_id` int(11) NOT NULL,
  `mesaj_kategori_id` int(11) NOT NULL,
  `mesaj_icerik` text NOT NULL,
  `mesaj_tarih` timestamp NOT NULL DEFAULT current_timestamp(),
  `mesaj_konu` varchar(255) NOT NULL,
  `sorumlu_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `gorusme`
--
ALTER TABLE `gorusme`
  ADD PRIMARY KEY (`gorusmeID`);

--
-- Tablo için indeksler `iletisim`
--
ALTER TABLE `iletisim`
  ADD PRIMARY KEY (`iletisimID`);

--
-- Tablo için indeksler `kategoriler`
--
ALTER TABLE `kategoriler`
  ADD PRIMARY KEY (`kategoriID`);

--
-- Tablo için indeksler `mesajlar`
--
ALTER TABLE `mesajlar`
  ADD PRIMARY KEY (`mesaj_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `gorusme`
--
ALTER TABLE `gorusme`
  MODIFY `gorusmeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Tablo için AUTO_INCREMENT değeri `iletisim`
--
ALTER TABLE `iletisim`
  MODIFY `iletisimID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `kategoriler`
--
ALTER TABLE `kategoriler`
  MODIFY `kategoriID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `mesajlar`
--
ALTER TABLE `mesajlar`
  MODIFY `mesaj_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
