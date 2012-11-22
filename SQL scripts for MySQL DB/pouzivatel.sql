-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Hostiteľ: localhost
-- Vygenerované:: 17.Nov, 2012 - 16:33
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
-- Štruktúra tabuľky pre tabuľku `pouzivatel`
--

DROP TABLE IF EXISTS `pouzivatel`;
CREATE TABLE IF NOT EXISTS `pouzivatel` (
  `id_p` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `Meno` varchar(15) COLLATE utf8_slovak_ci DEFAULT NULL,
  `Priezvisko` varchar(20) COLLATE utf8_slovak_ci DEFAULT NULL,
  `Nickname` varchar(15) COLLATE utf8_slovak_ci NOT NULL,
  `Email` varchar(20) COLLATE utf8_slovak_ci NOT NULL,
  `Heslo` varchar(60) COLLATE utf8_slovak_ci NOT NULL,
  PRIMARY KEY (`id_p`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci AUTO_INCREMENT=4 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
