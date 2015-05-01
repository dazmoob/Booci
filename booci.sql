-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Inang: localhost
-- Waktu pembuatan: 02 Mei 2015 pada 00.44
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
-- Struktur dari tabel `bc_activities_log`
--

CREATE TABLE IF NOT EXISTS `bc_activities_log` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `initial` enum('plus','edit','trash','remove','file-text-o','reply','upload','globe') NOT NULL DEFAULT 'globe',
  `url` varchar(255) NOT NULL DEFAULT '#',
  `color` enum('danger','warning','info','success','reverse','primary') NOT NULL DEFAULT 'reverse',
  `title` varchar(25) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `bc_activities_log`
--

INSERT INTO `bc_activities_log` (`id`, `user_id`, `initial`, `url`, `color`, `title`, `description`, `created_time`) VALUES
(1, 1, 'plus', 'article/kerajinan-tangan-kabupaten/edit', 'info', 'Create Article', 'Booci_admin has been updated article with title Kerajinan Tangan Kabupaten', '2015-04-26 04:15:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bc_article`
--

CREATE TABLE IF NOT EXISTS `bc_article` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text,
  `featured_image` text,
  `excerpt` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `keyword` varchar(255) DEFAULT NULL,
  `created_time` datetime NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `updated_time` datetime NOT NULL,
  `updated_by` bigint(20) NOT NULL,
  `state` enum('Draft','Publish','Trash') NOT NULL DEFAULT 'Draft',
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `created_by` (`created_by`,`updated_by`),
  KEY `update_by` (`updated_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data untuk tabel `bc_article`
--

INSERT INTO `bc_article` (`id`, `title`, `slug`, `content`, `featured_image`, `excerpt`, `description`, `keyword`, `created_time`, `created_by`, `updated_time`, `updated_by`, `state`) VALUES
(1, 'Article 1', 'article-1', 'Article 1 Lalala Yeyeye <br> The strip_tags() function strips a string from HTML, XML, and PHP tags.\n\nNote: HTML comments are always stripped. This cannot be changed with the allow parameter.\n\nNote: This function is binary-safe.', NULL, NULL, NULL, NULL, '2015-04-02 05:25:21', 1, '2015-04-19 01:43:49', 1, 'Publish'),
(2, 'Article 2', 'article-2', 'Article 2 Wakwkawkak Yoyoyo Article 1 Lalala Yeyeye <br> The strip_tags() function strips a string from HTML, XML, and PHP tags.\n\nNote: HTML comments are always stripped. This cannot be changed with the allow parameter.\n\nNote: This function is binary-safe.', NULL, NULL, NULL, NULL, '2015-04-02 05:45:21', 1, '2015-04-19 01:43:01', 1, 'Publish'),
(3, 'Article 3', 'article-3', 'Article 3 Syalalalala Article 1 Lalala Yeyeye <br> The strip_tags() function strips a string from HTML, XML, and PHP tags.\n\nNote: HTML comments are always stripped. This cannot be changed with the allow parameter.\n\nNote: This function is binary-safe.', NULL, NULL, NULL, NULL, '2015-04-02 06:45:21', 1, '2015-04-19 03:43:01', 1, 'Publish'),
(5, 'Kesenian Teapot Itu Hebat', 'kesenian-teapot-itu-hebat', '0', 'gallery/images/pics-001.jpg', '', '', '', '2015-04-08 14:06:45', 1, '2015-04-19 01:43:01', 1, 'Publish'),
(6, 'Kesenian Teapot Itu Hebat', 'kesenian-teapot-itu-hebat1', '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', '', '', '', '', '2015-04-08 14:14:40', 1, '2015-04-19 03:43:01', 1, 'Publish'),
(7, 'Aenean hendrerit est quis imperdiet vulputate', 'aenean-hendrerit-est-quis-imperdiet-vulputate', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod massa non erat scelerisque consequat. Morbi at ultrices odio. Integer libero eros, consequat et ante at, elementum sagittis purus. Quisque facilisis felis velit, in lacinia ex cursus nec. Vivamus mauris tortor, consectetur eget rhoncus in, gravida eget urna. Fusce mollis enim urna. Nulla tempus felis sed ultrices posuere. Pellentesque ornare eleifend augue, id tempor neque ornare at. Curabitur sit amet nunc non odio mattis vulputate vitae at lorem. Aenean non libero nunc. Integer pretium tincidunt ante, et auctor purus ullamcorper sit amet. Nunc tempus sem iaculis, molestie ante in, egestas neque. Nulla ultricies efficitur felis at fermentum. Nam volutpat id elit sollicitudin sodales. Mauris feugiat lobortis arcu, eget ultricies nisi auctor non.</p><p>Aenean hendrerit est quis imperdiet vulputate. Morbi rhoncus ante eu lacus tincidunt, at maximus eros rutrum. Aenean ut tellus mollis nisi maximus pulvinar. Nulla venenatis id est lobortis fringilla. Pellentesque blandit dolor vel malesuada mattis. Donec sed mi orci. Sed a felis ut elit accumsan tristique. Etiam aliquet venenatis nisi, in maximus metus maximus eu. Vivamus cursus auctor elit. Pellentesque ut erat quis nunc semper venenatis et pharetra ligula. Vivamus purus justo, finibus malesuada risus quis, pharetra porta nisl.</p><p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aenean mattis augue sit amet ornare dictum. Duis tincidunt ligula in tellus imperdiet, et commodo mauris vehicula. Nullam justo velit, vulputate ut mauris at, iaculis hendrerit augue. Cras dapibus nibh dapibus nibh faucibus semper. Sed ultrices diam eget elit facilisis, eget sagittis est porta. Ut vitae sapien enim. Interdum et malesuada fames ac ante ipsum primis in faucibus. Sed a eros et leo euismod efficitur ac at risus.</p><p>Nullam maximus ac orci in varius. Proin blandit nunc eget quam aliquet tristique. Nullam ultricies mollis velit, a pharetra turpis posuere in. Donec viverra bibendum odio, in tempor ligula facilisis dapibus. In ullamcorper lacinia quam vel egestas. Ut pellentesque mi eget efficitur varius. Etiam in mattis libero, nec fringilla diam. Curabitur vulputate metus eget orci aliquet, in venenatis nibh tempor. Donec finibus metus quis massa scelerisque, ac cursus elit ultricies. Praesent porta orci orci. Suspendisse potenti. Phasellus quis purus libero. Nullam fermentum sapien et mi tempor varius. Etiam pulvinar quis dolor id rutrum. Nunc vel dolor consequat, ultricies lacus a, lacinia mi. Etiam ac maximus odio.</p><p>Quisque tristique semper est ac convallis. Etiam fermentum augue sit amet nisl sollicitudin suscipit. Maecenas ultrices hendrerit dapibus. Ut dapibus metus efficitur felis fermentum accumsan. Interdum et malesuada fames ac ante ipsum primis in faucibus. Mauris porttitor elit in lectus cursus hendrerit. Nam a congue libero. Maecenas et massa pellentesque dui consequat rhoncus. Suspendisse eleifend sit amet felis quis porta. Nam condimentum, massa nec finibus mollis, ligula diam mattis ligula, a hendrerit nulla nisl a justo. Vestibulum eu facilisis justo. Etiam venenatis turpis id vestibulum porta. Donec bibendum erat vel condimentum fermentum.</p>', '', '', '', '', '2015-04-16 23:58:24', 1, '2015-04-19 03:43:01', 1, 'Publish'),
(8, 'Aenean hendrerit est quis imperdiet vulputate', 'aenean-hendrerit-est-quis-imperdiet-vulputate1', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod massa non erat scelerisque consequat. Morbi at ultrices odio. Integer libero eros, consequat et ante at, elementum sagittis purus. Quisque facilisis felis velit, in lacinia ex cursus nec. Vivamus mauris tortor, consectetur eget rhoncus in, gravida eget urna. Fusce mollis enim urna. Nulla tempus felis sed ultrices posuere. Pellentesque ornare eleifend augue, id tempor neque ornare at. Curabitur sit amet nunc non odio mattis vulputate vitae at lorem. Aenean non libero nunc. Integer pretium tincidunt ante, et auctor purus ullamcorper sit amet. Nunc tempus sem iaculis, molestie ante in, egestas neque. Nulla ultricies efficitur felis at fermentum. Nam volutpat id elit sollicitudin sodales. Mauris feugiat lobortis arcu, eget ultricies nisi auctor non.</p><p>Aenean hendrerit est quis imperdiet vulputate. Morbi rhoncus ante eu lacus tincidunt, at maximus eros rutrum. Aenean ut tellus mollis nisi maximus pulvinar. Nulla venenatis id est lobortis fringilla. Pellentesque blandit dolor vel malesuada mattis. Donec sed mi orci. Sed a felis ut elit accumsan tristique. Etiam aliquet venenatis nisi, in maximus metus maximus eu. Vivamus cursus auctor elit. Pellentesque ut erat quis nunc semper venenatis et pharetra ligula. Vivamus purus justo, finibus malesuada risus quis, pharetra porta nisl.</p><p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aenean mattis augue sit amet ornare dictum. Duis tincidunt ligula in tellus imperdiet, et commodo mauris vehicula. Nullam justo velit, vulputate ut mauris at, iaculis hendrerit augue. Cras dapibus nibh dapibus nibh faucibus semper. Sed ultrices diam eget elit facilisis, eget sagittis est porta. Ut vitae sapien enim. Interdum et malesuada fames ac ante ipsum primis in faucibus. Sed a eros et leo euismod efficitur ac at risus.</p><p>Nullam maximus ac orci in varius. Proin blandit nunc eget quam aliquet tristique. Nullam ultricies mollis velit, a pharetra turpis posuere in. Donec viverra bibendum odio, in tempor ligula facilisis dapibus. In ullamcorper lacinia quam vel egestas. Ut pellentesque mi eget efficitur varius. Etiam in mattis libero, nec fringilla diam. Curabitur vulputate metus eget orci aliquet, in venenatis nibh tempor. Donec finibus metus quis massa scelerisque, ac cursus elit ultricies. Praesent porta orci orci. Suspendisse potenti. Phasellus quis purus libero. Nullam fermentum sapien et mi tempor varius. Etiam pulvinar quis dolor id rutrum. Nunc vel dolor consequat, ultricies lacus a, lacinia mi. Etiam ac maximus odio.</p><p>Quisque tristique semper est ac convallis. Etiam fermentum augue sit amet nisl sollicitudin suscipit. Maecenas ultrices hendrerit dapibus. Ut dapibus metus efficitur felis fermentum accumsan. Interdum et malesuada fames ac ante ipsum primis in faucibus. Mauris porttitor elit in lectus cursus hendrerit. Nam a congue libero. Maecenas et massa pellentesque dui consequat rhoncus. Suspendisse eleifend sit amet felis quis porta. Nam condimentum, massa nec finibus mollis, ligula diam mattis ligula, a hendrerit nulla nisl a justo. Vestibulum eu facilisis justo. Etiam venenatis turpis id vestibulum porta. Donec bibendum erat vel condimentum fermentum.</p>', '', '', '', '', '2015-04-16 23:59:22', 1, '2015-04-19 03:43:01', 1, 'Publish'),
(9, 'Quisque tristique semper est ac convallis.', 'quisque-tristique-semper-est-ac-convallis', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod massa non erat scelerisque consequat. Morbi at ultrices odio. Integer libero eros, consequat et ante at, elementum sagittis purus. Quisque facilisis felis velit, in lacinia ex cursus nec. Vivamus mauris tortor, consectetur eget rhoncus in, gravida eget urna. Fusce mollis enim urna. Nulla tempus felis sed ultrices posuere. Pellentesque ornare eleifend augue, id tempor neque ornare at. Curabitur sit amet nunc non odio mattis vulputate vitae at lorem. Aenean non libero nunc. Integer pretium tincidunt ante, et auctor purus ullamcorper sit amet. Nunc tempus sem iaculis, molestie ante in, egestas neque. Nulla ultricies efficitur felis at fermentum. Nam volutpat id elit sollicitudin sodales. Mauris feugiat lobortis arcu, eget ultricies nisi auctor non.</p><p>Aenean hendrerit est quis imperdiet vulputate. Morbi rhoncus ante eu lacus tincidunt, at maximus eros rutrum. Aenean ut tellus mollis nisi maximus pulvinar. Nulla venenatis id est lobortis fringilla. Pellentesque blandit dolor vel malesuada mattis. Donec sed mi orci. Sed a felis ut elit accumsan tristique. Etiam aliquet venenatis nisi, in maximus metus maximus eu. Vivamus cursus auctor elit. Pellentesque ut erat quis nunc semper venenatis et pharetra ligula. Vivamus purus justo, finibus malesuada risus quis, pharetra porta nisl.</p><p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aenean mattis augue sit amet ornare dictum. Duis tincidunt ligula in tellus imperdiet, et commodo mauris vehicula. Nullam justo velit, vulputate ut mauris at, iaculis hendrerit augue. Cras dapibus nibh dapibus nibh faucibus semper. Sed ultrices diam eget elit facilisis, eget sagittis est porta. Ut vitae sapien enim. Interdum et malesuada fames ac ante ipsum primis in faucibus. Sed a eros et leo euismod efficitur ac at risus.</p><p>Nullam maximus ac orci in varius. Proin blandit nunc eget quam aliquet tristique. Nullam ultricies mollis velit, a pharetra turpis posuere in. Donec viverra bibendum odio, in tempor ligula facilisis dapibus. In ullamcorper lacinia quam vel egestas. Ut pellentesque mi eget efficitur varius. Etiam in mattis libero, nec fringilla diam. Curabitur vulputate metus eget orci aliquet, in venenatis nibh tempor. Donec finibus metus quis massa scelerisque, ac cursus elit ultricies. Praesent porta orci orci. Suspendisse potenti. Phasellus quis purus libero. Nullam fermentum sapien et mi tempor varius. Etiam pulvinar quis dolor id rutrum. Nunc vel dolor consequat, ultricies lacus a, lacinia mi. Etiam ac maximus odio.</p><p>Quisque tristique semper est ac convallis. Etiam fermentum augue sit amet nisl sollicitudin suscipit. Maecenas ultrices hendrerit dapibus. Ut dapibus metus efficitur felis fermentum accumsan. Interdum et malesuada fames ac ante ipsum primis in faucibus. Mauris porttitor elit in lectus cursus hendrerit. Nam a congue libero. Maecenas et massa pellentesque dui consequat rhoncus. Suspendisse eleifend sit amet felis quis porta. Nam condimentum, massa nec finibus mollis, ligula diam mattis ligula, a hendrerit nulla nisl a justo. Vestibulum eu facilisis justo. Etiam venenatis turpis id vestibulum porta. Donec bibendum erat vel condimentum fermentum.</p>', '', '', '', '', '2015-04-16 23:59:31', 1, '2015-04-19 03:43:01', 1, 'Publish'),
(10, 'Quisque tristique semper est ac convallis', 'quisque-tristique-semper-est-ac-convallis1', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod massa non erat scelerisque consequat. Morbi at ultrices odio. Integer libero eros, consequat et ante at, elementum sagittis purus. Quisque facilisis felis velit, in lacinia ex cursus nec. Vivamus mauris tortor, consectetur eget rhoncus in, gravida eget urna. Fusce mollis enim urna. Nulla tempus felis sed ultrices posuere. Pellentesque ornare eleifend augue, id tempor neque ornare at. Curabitur sit amet nunc non odio mattis vulputate vitae at lorem. Aenean non libero nunc. Integer pretium tincidunt ante, et auctor purus ullamcorper sit amet. Nunc tempus sem iaculis, molestie ante in, egestas neque. Nulla ultricies efficitur felis at fermentum. Nam volutpat id elit sollicitudin sodales. Mauris feugiat lobortis arcu, eget ultricies nisi auctor non.</p><p>Aenean hendrerit est quis imperdiet vulputate. Morbi rhoncus ante eu lacus tincidunt, at maximus eros rutrum. Aenean ut tellus mollis nisi maximus pulvinar. Nulla venenatis id est lobortis fringilla. Pellentesque blandit dolor vel malesuada mattis. Donec sed mi orci. Sed a felis ut elit accumsan tristique. Etiam aliquet venenatis nisi, in maximus metus maximus eu. Vivamus cursus auctor elit. Pellentesque ut erat quis nunc semper venenatis et pharetra ligula. Vivamus purus justo, finibus malesuada risus quis, pharetra porta nisl.</p><p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aenean mattis augue sit amet ornare dictum. Duis tincidunt ligula in tellus imperdiet, et commodo mauris vehicula. Nullam justo velit, vulputate ut mauris at, iaculis hendrerit augue. Cras dapibus nibh dapibus nibh faucibus semper. Sed ultrices diam eget elit facilisis, eget sagittis est porta. Ut vitae sapien enim. Interdum et malesuada fames ac ante ipsum primis in faucibus. Sed a eros et leo euismod efficitur ac at risus.</p><p>Nullam maximus ac orci in varius. Proin blandit nunc eget quam aliquet tristique. Nullam ultricies mollis velit, a pharetra turpis posuere in. Donec viverra bibendum odio, in tempor ligula facilisis dapibus. In ullamcorper lacinia quam vel egestas. Ut pellentesque mi eget efficitur varius. Etiam in mattis libero, nec fringilla diam. Curabitur vulputate metus eget orci aliquet, in venenatis nibh tempor. Donec finibus metus quis massa scelerisque, ac cursus elit ultricies. Praesent porta orci orci. Suspendisse potenti. Phasellus quis purus libero. Nullam fermentum sapien et mi tempor varius. Etiam pulvinar quis dolor id rutrum. Nunc vel dolor consequat, ultricies lacus a, lacinia mi. Etiam ac maximus odio.</p><p>Quisque tristique semper est ac convallis. Etiam fermentum augue sit amet nisl sollicitudin suscipit. Maecenas ultrices hendrerit dapibus. Ut dapibus metus efficitur felis fermentum accumsan. Interdum et malesuada fames ac ante ipsum primis in faucibus. Mauris porttitor elit in lectus cursus hendrerit. Nam a congue libero. Maecenas et massa pellentesque dui consequat rhoncus. Suspendisse eleifend sit amet felis quis porta. Nam condimentum, massa nec finibus mollis, ligula diam mattis ligula, a hendrerit nulla nisl a justo. Vestibulum eu facilisis justo. Etiam venenatis turpis id vestibulum porta. Donec bibendum erat vel condimentum fermentum.</p>', '', '', '', '', '2015-04-17 00:00:12', 1, '2015-04-19 03:43:01', 1, 'Publish'),
(11, 'Nullam fermentum sapien et mi tempor varius', 'nullam-fermentum-sapien-et-mi-tempor-varius', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod massa non erat scelerisque consequat. Morbi at ultrices odio. Integer libero eros, consequat et ante at, elementum sagittis purus. Quisque facilisis felis velit, in lacinia ex cursus nec. Vivamus mauris tortor, consectetur eget rhoncus in, gravida eget urna. Fusce mollis enim urna. Nulla tempus felis sed ultrices posuere. Pellentesque ornare eleifend augue, id tempor neque ornare at. Curabitur sit amet nunc non odio mattis vulputate vitae at lorem. Aenean non libero nunc. Integer pretium tincidunt ante, et auctor purus ullamcorper sit amet. Nunc tempus sem iaculis, molestie ante in, egestas neque. Nulla ultricies efficitur felis at fermentum. Nam volutpat id elit sollicitudin sodales. Mauris feugiat lobortis arcu, eget ultricies nisi auctor non.</p><p>Aenean hendrerit est quis imperdiet vulputate. Morbi rhoncus ante eu lacus tincidunt, at maximus eros rutrum. Aenean ut tellus mollis nisi maximus pulvinar. Nulla venenatis id est lobortis fringilla. Pellentesque blandit dolor vel malesuada mattis. Donec sed mi orci. Sed a felis ut elit accumsan tristique. Etiam aliquet venenatis nisi, in maximus metus maximus eu. Vivamus cursus auctor elit. Pellentesque ut erat quis nunc semper venenatis et pharetra ligula. Vivamus purus justo, finibus malesuada risus quis, pharetra porta nisl.</p><p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aenean mattis augue sit amet ornare dictum. Duis tincidunt ligula in tellus imperdiet, et commodo mauris vehicula. Nullam justo velit, vulputate ut mauris at, iaculis hendrerit augue. Cras dapibus nibh dapibus nibh faucibus semper. Sed ultrices diam eget elit facilisis, eget sagittis est porta. Ut vitae sapien enim. Interdum et malesuada fames ac ante ipsum primis in faucibus. Sed a eros et leo euismod efficitur ac at risus.</p><p>Nullam maximus ac orci in varius. Proin blandit nunc eget quam aliquet tristique. Nullam ultricies mollis velit, a pharetra turpis posuere in. Donec viverra bibendum odio, in tempor ligula facilisis dapibus. In ullamcorper lacinia quam vel egestas. Ut pellentesque mi eget efficitur varius. Etiam in mattis libero, nec fringilla diam. Curabitur vulputate metus eget orci aliquet, in venenatis nibh tempor. Donec finibus metus quis massa scelerisque, ac cursus elit ultricies. Praesent porta orci orci. Suspendisse potenti. Phasellus quis purus libero. Nullam fermentum sapien et mi tempor varius. Etiam pulvinar quis dolor id rutrum. Nunc vel dolor consequat, ultricies lacus a, lacinia mi. Etiam ac maximus odio.</p><p>Quisque tristique semper est ac convallis. Etiam fermentum augue sit amet nisl sollicitudin suscipit. Maecenas ultrices hendrerit dapibus. Ut dapibus metus efficitur felis fermentum accumsan. Interdum et malesuada fames ac ante ipsum primis in faucibus. Mauris porttitor elit in lectus cursus hendrerit. Nam a congue libero. Maecenas et massa pellentesque dui consequat rhoncus. Suspendisse eleifend sit amet felis quis porta. Nam condimentum, massa nec finibus mollis, ligula diam mattis ligula, a hendrerit nulla nisl a justo. Vestibulum eu facilisis justo. Etiam venenatis turpis id vestibulum porta. Donec bibendum erat vel condimentum fermentum.</p>', '', '', '', '', '2015-04-17 00:00:15', 1, '2015-04-19 03:43:01', 1, 'Publish'),
(12, 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas', 'pellentesque-habitant-morbi-tristique-senectus-et-netus-et-malesuada-fames-ac-turpis-egestas', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod massa non erat scelerisque consequat. Morbi at ultrices odio. Integer libero eros, consequat et ante at, elementum sagittis purus. Quisque facilisis felis velit, in lacinia ex cursus nec. Vivamus mauris tortor, consectetur eget rhoncus in, gravida eget urna. Fusce mollis enim urna. Nulla tempus felis sed ultrices posuere. Pellentesque ornare eleifend augue, id tempor neque ornare at. Curabitur sit amet nunc non odio mattis vulputate vitae at lorem. Aenean non libero nunc. Integer pretium tincidunt ante, et auctor purus ullamcorper sit amet. Nunc tempus sem iaculis, molestie ante in, egestas neque. Nulla ultricies efficitur felis at fermentum. Nam volutpat id elit sollicitudin sodales. Mauris feugiat lobortis arcu, eget ultricies nisi auctor non.</p><p>Aenean hendrerit est quis imperdiet vulputate. Morbi rhoncus ante eu lacus tincidunt, at maximus eros rutrum. Aenean ut tellus mollis nisi maximus pulvinar. Nulla venenatis id est lobortis fringilla. Pellentesque blandit dolor vel malesuada mattis. Donec sed mi orci. Sed a felis ut elit accumsan tristique. Etiam aliquet venenatis nisi, in maximus metus maximus eu. Vivamus cursus auctor elit. Pellentesque ut erat quis nunc semper venenatis et pharetra ligula. Vivamus purus justo, finibus malesuada risus quis, pharetra porta nisl.</p><p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aenean mattis augue sit amet ornare dictum. Duis tincidunt ligula in tellus imperdiet, et commodo mauris vehicula. Nullam justo velit, vulputate ut mauris at, iaculis hendrerit augue. Cras dapibus nibh dapibus nibh faucibus semper. Sed ultrices diam eget elit facilisis, eget sagittis est porta. Ut vitae sapien enim. Interdum et malesuada fames ac ante ipsum primis in faucibus. Sed a eros et leo euismod efficitur ac at risus.</p><p>Nullam maximus ac orci in varius. Proin blandit nunc eget quam aliquet tristique. Nullam ultricies mollis velit, a pharetra turpis posuere in. Donec viverra bibendum odio, in tempor ligula facilisis dapibus. In ullamcorper lacinia quam vel egestas. Ut pellentesque mi eget efficitur varius. Etiam in mattis libero, nec fringilla diam. Curabitur vulputate metus eget orci aliquet, in venenatis nibh tempor. Donec finibus metus quis massa scelerisque, ac cursus elit ultricies. Praesent porta orci orci. Suspendisse potenti. Phasellus quis purus libero. Nullam fermentum sapien et mi tempor varius. Etiam pulvinar quis dolor id rutrum. Nunc vel dolor consequat, ultricies lacus a, lacinia mi. Etiam ac maximus odio.</p><p>Quisque tristique semper est ac convallis. Etiam fermentum augue sit amet nisl sollicitudin suscipit. Maecenas ultrices hendrerit dapibus. Ut dapibus metus efficitur felis fermentum accumsan. Interdum et malesuada fames ac ante ipsum primis in faucibus. Mauris porttitor elit in lectus cursus hendrerit. Nam a congue libero. Maecenas et massa pellentesque dui consequat rhoncus. Suspendisse eleifend sit amet felis quis porta. Nam condimentum, massa nec finibus mollis, ligula diam mattis ligula, a hendrerit nulla nisl a justo. Vestibulum eu facilisis justo. Etiam venenatis turpis id vestibulum porta. Donec bibendum erat vel condimentum fermentum.</p>', '', '', '', '', '2015-04-17 00:00:16', 1, '2015-04-19 03:43:01', 1, 'Publish'),
(13, 'Kerajinan Tangan Kabupaten', 'kerajinan-tangan-kabupaten', '<p class="wysiwyg-text-align-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sodales tempus enim, a vulputate ligula scelerisque ut. Sed in posuere turpis. Etiam facilisis neque turpis, vel accumsan leo sagittis id. Vivamus et velit quis augue semper scelerisque. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam luctus eros ut odio venenatis, quis pellentesque ante maximus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque facilisis eget nunc vitae molestie. Maecenas sodales in lacus in tincidunt. Nam pulvinar luctus mi, nec ultrices orci facilisis ut. Etiam condimentum, orci a efficitur condimentum, purus mauris ultrices augue, vel finibus nisi leo sit amet diam. Morbi auctor sollicitudin nulla condimentum dictum. Nulla quam lorem, interdum id ante id, scelerisque mollis erat. Nunc nec tincidunt erat, eget vehicula justo. Nullam id sollicitudin felis.</p><p class="wysiwyg-text-align-justify"></p><div class="embed-responsive"><iframe frameborder="0" src="//www.youtube.com/embed/e-ORhEE9VVg" class="embed-responsive-item"></iframe></div><br><p></p><p class="wysiwyg-text-align-justify">Donec condimentum convallis suscipit. Fusce tincidunt vel sapien eget tristique. Phasellus vulputate lacus gravida augue efficitur viverra. Maecenas laoreet augue ac neque iaculis, non ultrices nisl viverra. Donec facilisis purus ultricies mi ultrices scelerisque. Aenean eu diam sed libero gravida pellentesque convallis nec urna. Maecenas vitae est sapien. Aenean eu ornare leo, eu pellentesque odio. Ut mi ipsum, egestas eget augue vitae, ultrices commodo tellus. Mauris tincidunt consequat auctor. In hac habitasse platea dictumst.</p><p class="wysiwyg-text-align-justify">Donec accumsan metus tincidunt, consectetur turpis eu, tincidunt nisl. Donec mattis id augue nec vehicula. Donec a arcu sed ex commodo congue ut non tellus. Maecenas ac mauris ex. Ut dapibus odio vitae tincidunt consectetur. Proin ut tempor metus. Donec malesuada pulvinar metus a viverra. Quisque dignissim dui et rhoncus iaculis. Proin rhoncus consectetur turpis congue suscipit. Nam finibus fringilla nulla, semper dignissim erat tempor posuere. Nunc eu varius nibh. Quisque sit amet volutpat libero.</p><p class="wysiwyg-text-align-justify">Mauris a ante quam. Sed aliquam risus ut scelerisque varius. Maecenas lectus mi, tempus vehicula justo at, maximus rhoncus lectus. Donec porttitor eros eu accumsan viverra. Nam et lectus sit amet velit tempor lacinia. Pellentesque at venenatis tortor, eu mollis enim. In hac habitasse platea dictumst. Proin sit amet purus at ante sagittis rutrum at id metus. Vivamus sagittis vitae magna vitae consequat. Mauris ac erat tellus. Cras sapien velit, venenatis ultricies ligula a, laoreet tincidunt ante.</p><p class="wysiwyg-text-align-justify">Sed rhoncus at enim sed malesuada. Phasellus id malesuada dui. Nam maximus metus a massa sagittis, non mattis tortor porta. Donec est ante, condimentum id pretium et, commodo sit amet eros. Phasellus vel nisl velit. Duis vestibulum a lacus sit amet cursus. Nulla viverra et purus quis mattis. Donec in erat sed enim condimentum pulvinar vitae nec risus. Integer tincidunt eleifend dolor vitae ultrices. Aliquam viverra ante in lorem scelerisque, a tempor elit tristique. In id nunc placerat purus varius sollicitudin eget quis orci.</p>', '', '', '', '', '2015-04-19 04:24:15', 1, '2015-04-19 04:24:15', 1, 'Publish');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bc_article_category`
--

CREATE TABLE IF NOT EXISTS `bc_article_category` (
  `article_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`article_id`,`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `bc_article_category`
--

INSERT INTO `bc_article_category` (`article_id`, `category_id`) VALUES
(1, 1),
(1, 2),
(2, 2),
(3, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `bc_category`
--

CREATE TABLE IF NOT EXISTS `bc_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data untuk tabel `bc_category`
--

INSERT INTO `bc_category` (`id`, `name`, `slug`, `description`) VALUES
(1, 'News', 'news', 'News in Booci'),
(2, 'Announcement', 'announcement', 'Announcement in Booci'),
(3, 'Test', 'test', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `bc_login_log`
--

CREATE TABLE IF NOT EXISTS `bc_login_log` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `login_time` datetime NOT NULL,
  `logout_time` datetime DEFAULT NULL,
  `status` enum('online','busy','idle','offline') NOT NULL DEFAULT 'online',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `bc_media`
--

CREATE TABLE IF NOT EXISTS `bc_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `description` text,
  `type` enum('image','video','audio','file') DEFAULT NULL,
  `src` text,
  `created_time` datetime NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `updated_time` datetime NOT NULL,
  `updated_by` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data untuk tabel `bc_media`
--

INSERT INTO `bc_media` (`id`, `title`, `filename`, `description`, `type`, `src`, `created_time`, `created_by`, `updated_time`, `updated_by`) VALUES
(1, 'Pics 001', 'pics-001.jpg', NULL, 'image', 'gallery/images/pics-001.jpg', '2015-04-06 04:16:16', 1, '2015-04-06 04:16:16', 1),
(2, 'Pics 002', 'pics-002.jpg', NULL, 'image', 'gallery/images/pics-002.jpg', '2015-04-06 04:16:16', 1, '2015-04-06 04:16:16', 1),
(3, 'Pics 003', 'pics-003.jpg', NULL, 'image', 'gallery/images/pics-003.jpg', '2015-04-06 04:16:16', 1, '2015-04-06 04:16:16', 1),
(4, 'Pics 004', 'pics-004.jpg', NULL, 'image', 'gallery/images/pics-004.jpg', '2015-04-06 04:16:16', 1, '2015-04-06 04:16:16', 1),
(5, 'Pics 005', 'pics-005.jpg', NULL, 'image', 'gallery/images/pics-005.jpg', '2015-04-06 04:16:16', 1, '2015-04-06 04:16:16', 1),
(6, 'Pics 006', 'pics-006.jpg', NULL, 'image', 'gallery/images/pics-006.jpg', '2015-04-06 04:16:16', 1, '2015-04-06 04:16:16', 1),
(7, 'Pics 007', 'pics-007.jpg', NULL, 'image', 'gallery/images/pics-007.jpg', '2015-04-06 04:16:16', 1, '2015-04-06 04:16:16', 1),
(8, 'Pics 008', 'pics-008.jpg', NULL, 'image', 'gallery/images/pics-008.jpg', '2015-04-06 04:16:16', 1, '2015-04-06 04:16:16', 1),
(9, 'Pics 009', 'pics-009.jpg', NULL, 'image', 'gallery/images/pics-009.jpg', '2015-04-06 04:16:16', 1, '2015-04-06 04:16:16', 1),
(10, 'Pics 010', 'pics-010.jpg', NULL, 'image', 'gallery/images/pics-010.jpg', '2015-04-06 04:16:16', 1, '2015-04-06 04:16:16', 1),
(11, '091113 Wow', '091113-wow.jpg', '0', 'image', 'gallery/images/091113-wow.jpg', '2015-04-20 04:53:44', 1, '2015-04-20 04:53:44', 1),
(12, '27253', '27253.jpg', '0', 'image', 'gallery/images/27253.jpg', '2015-04-20 04:55:35', 1, '2015-04-20 04:55:35', 1),
(13, '340x 2010 05 02 203335', '340x_2010-05-02_203335.jpg', '0', 'image', 'gallery/images/340x_2010-05-02_203335.jpg', '2015-04-20 04:56:49', 1, '2015-04-20 04:56:49', 1),
(14, '5114063505 Ed3ea3602b B', '5114063505_ed3ea3602b_b.jpg', '0', 'image', 'gallery/images/5114063505_ed3ea3602b_b.jpg', '2015-04-20 04:58:49', 1, '2015-04-20 04:58:49', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `bc_message`
--

CREATE TABLE IF NOT EXISTS `bc_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `state` enum('unread','read') NOT NULL DEFAULT 'unread',
  `solve` enum('unsolved','solved') NOT NULL DEFAULT 'unsolved',
  `type` enum('critism','suggestion','question','others') NOT NULL DEFAULT 'others',
  `created_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `bc_message`
--

INSERT INTO `bc_message` (`id`, `title`, `content`, `state`, `solve`, `type`, `created_time`) VALUES
(1, 'Hello Booci !', 'Welcome to Booci, don''t be stressed !', 'unread', 'unsolved', 'others', '2015-04-26 05:13:21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bc_page`
--

CREATE TABLE IF NOT EXISTS `bc_page` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text,
  `featured_image` text,
  `excerpt` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `keyword` varchar(255) DEFAULT NULL,
  `created_time` datetime NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `updated_time` datetime NOT NULL,
  `updated_by` bigint(20) NOT NULL,
  `state` enum('Draft','Publish','Trash') NOT NULL DEFAULT 'Draft',
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `created_by` (`created_by`,`updated_by`),
  KEY `update_by` (`updated_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `bc_user`
--

CREATE TABLE IF NOT EXISTS `bc_user` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data untuk tabel `bc_user`
--

INSERT INTO `bc_user` (`id`, `username`, `email`, `name`, `picture`, `picture_path`, `website`, `facebook`, `twitter`, `google`, `password`, `level`, `state`, `created_time`, `updated_time`, `notes`) VALUES
(1, 'booci_admin', 'ayubna32@gmail.com', 'Ayub As Booci Admin', 'user8-128x128.jpg', 'gallery/profile/user8-128x128.jpg', 'http://booci.ownel.com', '', '', '', 'Uso7rDTAJPtkKEJD3s97D1cSRa0XHiaRJLtLKfFXZAQxTPOu8hPxELKyZiGJODEZtYno+RJ5XzJX2dBpxWzFkg==', 1, 'Active', '2015-03-23 08:38:28', '2015-04-26 23:05:54', '0'),
(2, 'userone', 'user@gmail.com', 'User One 1232', NULL, NULL, '', '', '', '', '61UpC5gBnoVzTYJ+3lXKI4q1NthlR9aY9ibXP1NVVT00Urtkw0PCy3wrxKHGPNHmVQgHhkh1VQR3ptnvA6wqoA==', 5, 'Pending', '2015-03-31 23:22:42', '2015-04-01 02:04:47', '0'),
(3, 'user', 'user@gmail.com', 'Ayub As Booci Admin', NULL, NULL, 'http://booci.ownel.com/oke', '', '', '', 'KvVq2maIuerIDAIPw/xGNnlWqY+UOKtebhnDAITkUq0KrIhJtwq/vt+lDKSvlWf6yz10VbpXTIJ7Va3RuDpP9Q==', 5, 'Active', '2015-04-02 11:32:56', '2015-04-26 23:04:20', '0'),
(4, 'writer', 'writer@gmail.com3a7152', 'Ayub As Booci Admin', NULL, NULL, 'http://booci.ownel.com/oke', '', '', '', 'Dvg0I4NzvyvBiulAF4Nco4ZcpX6+ibxz1dvo+wgSS0dGNr5Ua+Jq7Xbqu+/Pa32SKMpesOBmxcz84FgmQtul3w==', 4, 'Active', '2015-04-02 11:35:08', '2015-04-26 23:04:20', '0');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bc_web`
--

CREATE TABLE IF NOT EXISTS `bc_web` (
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
-- Dumping data untuk tabel `bc_web`
--

INSERT INTO `bc_web` (`id`, `name`, `domain`, `title`, `description`, `keyword`, `created`, `creator`, `adm_log`) VALUES
(1, 'Booci', 'http://booci.opreklab.com/', 'Booci : CMS implemented with Codeigniter and Bootstrap', 'Booci is simple Website CMS that implemented with Codeigniter 2.2.1 and Bootstrap 3.', 'Booci, CMS, Codeigniter, Bootstrap', '2014-07-29 10:00:00', 'Ayub Narwidian Adiputra', 'try_in');

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `bc_article`
--
ALTER TABLE `bc_article`
  ADD CONSTRAINT `art_cre_by_fk` FOREIGN KEY (`created_by`) REFERENCES `bc_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `art_upd_by_fk` FOREIGN KEY (`updated_by`) REFERENCES `bc_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
