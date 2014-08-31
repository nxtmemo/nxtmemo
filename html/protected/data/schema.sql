-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 31. Aug 2014 um 00:40
-- Server Version: 5.5.38-0ubuntu0.14.04.1
-- PHP-Version: 5.5.9-1ubuntu4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `nxtmemo`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_blacklist`
--

CREATE TABLE IF NOT EXISTS `tbl_blacklist` (
  `type` char(10) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`value`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_memos`
--

CREATE TABLE IF NOT EXISTS `tbl_memos` (
  `txid` varchar(20) NOT NULL,
  `account` varchar(128) NOT NULL,
  `alias` varchar(1000) NOT NULL,
  `timestamp` int(8) NOT NULL,
  `tags` varchar(1000) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`txid`),
  UNIQUE KEY `txid` (`txid`),
  UNIQUE KEY `txid_3` (`txid`),
  KEY `txid_2` (`txid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_params`
--

CREATE TABLE IF NOT EXISTS `tbl_params` (
  `key` varchar(50) NOT NULL,
  `value` text NOT NULL,
  UNIQUE KEY `key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_users`
--

CREATE TABLE IF NOT EXISTS `tbl_users` (
  `accountRS` varchar(25) CHARACTER SET latin1 NOT NULL,
  `alias` varchar(1000) CHARACTER SET latin1 NOT NULL,
  `login_timestamp` int(8) DEFAULT NULL,
  PRIMARY KEY (`accountRS`),
  UNIQUE KEY `accountRS` (`accountRS`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
