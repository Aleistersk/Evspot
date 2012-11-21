-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Hostiteľ: localhost
-- Vygenerované:: 17.Nov, 2012 - 16:34
-- Verzia serveru: 5.5.20
-- Verzia PHP: 5.3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáza: `evspot`
--

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `zariadenie`
--

DROP TABLE IF EXISTS `zariadenie`;
CREATE TABLE IF NOT EXISTS `zariadenie` (
  `id_zar` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `Nazov` varchar(20) COLLATE utf8_slovak_ci NOT NULL,
  `odh_cas` float(5,2) NOT NULL,
  `Prikon` float(8,2) NOT NULL,
  `odh_spot` float(8,2) NOT NULL,
  `nam_spot` float(8,2) NOT NULL,
  `id_p` int(5) unsigned NOT NULL,
  `id_kat` int(5) unsigned NOT NULL,
  `id_s` int(5) unsigned NOT NULL,
  PRIMARY KEY (`id_zar`),
  KEY `id_p` (`id_p`),
  KEY `id_s` (`id_s`),
  KEY `id_kat` (`id_kat`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci AUTO_INCREMENT=9 ;

--
-- Obmedzenie pre exportované tabuľky
--

--
-- Obmedzenie pre tabuľku `zariadenie`
--
ALTER TABLE `zariadenie`
  ADD CONSTRAINT `zariadenie_ibfk_1` FOREIGN KEY (`id_p`) REFERENCES `pouzivatel` (`id_p`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `zariadenie_ibfk_2` FOREIGN KEY (`id_kat`) REFERENCES `kategoria` (`id_kat`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `zariadenie_ibfk_3` FOREIGN KEY (`id_s`) REFERENCES `sadzba` (`id_s`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
