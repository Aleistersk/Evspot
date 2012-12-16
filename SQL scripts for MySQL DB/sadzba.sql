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
-- Štruktúra tabuľky pre tabuľku `sadzba`
--

DROP TABLE IF EXISTS `sadzba`;
CREATE TABLE IF NOT EXISTS `sadzba` (
  `id_s` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `Popis` varchar(20) COLLATE utf8_slovak_ci NOT NULL,
  `Cena` float(5,4) unsigned NOT NULL,
  PRIMARY KEY (`id_s`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci AUTO_INCREMENT=4 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
