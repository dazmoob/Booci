-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Inang: localhost
-- Waktu pembuatan: 30 Mar 2015 pada 23.35
-- Versi Server: 5.5.41-0ubuntu0.14.04.1
-- Versi PHP: 5.5.9-1ubuntu4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Basis data: `booci`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `login_time` datetime NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `picture` text,
  `picture_path` text,
  `website` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `google` varchar(255) DEFAULT NULL,
  `password` text NOT NULL,
  `level` int(11) NOT NULL,
  `state` enum('Pending','Active','Inactive','Blocked') NOT NULL DEFAULT 'Pending',
  `created_time` datetime NOT NULL,
  `updated_time` datetime DEFAULT NULL,
  `notes` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`,`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `name`, `picture`, `picture_path`, `website`, `facebook`, `twitter`, `google`, `password`, `level`, `state`, `created_time`, `updated_time`, `notes`) VALUES
(1, 'booci_admin', 'ayubna32@gmail.com', 'Ayub As Booci Admin 123213', 'user6-128x128.jpg', 'images/profiles/user6-128x128.jpg', '', '', '', '', 'CHORvyAyPbG3haopgkMZ176Qj3j/d81vaoHb1tk5sqbHXvC9Y5Etb0TGlU/8DsEmnTH55sDJYxM+Cdsja3Suuw==', 1, 'Active', '2015-03-23 08:38:28', '2015-03-30 13:36:13', '0');

-- --------------------------------------------------------

--
-- Struktur dari tabel `web`
--

CREATE TABLE IF NOT EXISTS `web` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `domain` text,
  `title` varchar(60) DEFAULT NULL,
  `description` varchar(160) DEFAULT NULL,
  `keyword` varchar(250) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `creator` varchar(255) DEFAULT NULL,
  `adm_log` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `web`
--

INSERT INTO `web` (`id`, `name`, `domain`, `title`, `description`, `keyword`, `created`, `creator`, `adm_log`) VALUES
(1, 'Booci', 'http://booci.opreklab.com/', 'Booci : CMS implemented with Codeigniter and Bootstrap', 'Booci is simple Website CMS that implemented with Codeigniter 2.2.1 and Bootstrap 3.', 'Booci, CMS, Codeigniter, Bootstrap', '2014-07-29 10:00:00', 'Ayub Narwidian Adiputra', 'try_in');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
