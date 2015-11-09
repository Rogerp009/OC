-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 02-03-2012 a las 09:45:06
-- Versión del servidor: 5.5.16
-- Versión de PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `system`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `downloads`
--

CREATE TABLE IF NOT EXISTS `downloads` (
  `DownloadId` int(11) NOT NULL AUTO_INCREMENT,
  `DownloadName` varchar(100) NOT NULL DEFAULT 'none',
  `FileName` varchar(150) NOT NULL DEFAULT 'none',
  `DateAdded` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `DateModified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `IsEnabled` tinyint(1) NOT NULL DEFAULT '0',
  `PremiumLevel` varchar(100) NOT NULL DEFAULT '1',
  PRIMARY KEY (`DownloadId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Volcado de datos para la tabla `downloads`
--

INSERT INTO `downloads` (`DownloadId`, `DownloadName`, `FileName`, `DateAdded`, `DateModified`, `IsEnabled`, `PremiumLevel`) VALUES
(1, 'Test Download File 1', 'rar.zip', '2011-04-05 00:00:00', '2011-11-06 23:28:20', 1, '0,1,2'),
(2, 'Test Download File 2', 'test.rar', '2011-04-05 00:00:00', '2011-04-07 22:23:04', 1, '0'),
(12, 'Test Download File 3', '1302429301-test.rar', '2011-04-10 02:55:01', '2011-11-07 00:39:20', 1, '0'),
(13, 'Test Download File 4', '1302429324-rar.zip', '2011-04-10 02:55:24', '2011-11-07 00:39:14', 1, '0'),
(14, 'Test Download File 5', '1319964955-another-test.rar', '2011-10-30 01:55:55', '2011-10-30 01:55:55', 1, '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `membership_types`
--

CREATE TABLE IF NOT EXISTS `membership_types` (
  `TypesId` int(11) NOT NULL AUTO_INCREMENT,
  `Type` varchar(50) NOT NULL DEFAULT 'Free Membership',
  `Description` longtext NOT NULL,
  `OrdinalPosition` int(3) NOT NULL DEFAULT '0',
  `IsEnabled` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`TypesId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `membership_types`
--

INSERT INTO `membership_types` (`TypesId`, `Type`, `Description`, `OrdinalPosition`, `IsEnabled`) VALUES
(2, 'Silver Membership', 'Premium membership with some restrictions.', 1, 1),
(3, 'Gold Membership', 'Top of the line membership access to all options', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus`
--

CREATE TABLE IF NOT EXISTS `menus` (
  `MenuId` int(11) NOT NULL AUTO_INCREMENT,
  `MenuName` varchar(50) NOT NULL DEFAULT 'default',
  `Url` varchar(100) DEFAULT NULL,
  `Target` varchar(10) DEFAULT '_self',
  `Label` varchar(50) NOT NULL,
  `Title` varchar(100) DEFAULT NULL,
  `Description` varchar(250) DEFAULT NULL,
  `ParentId` int(11) DEFAULT '0',
  `ParentLabel` varchar(50) DEFAULT NULL,
  `OrdinalPosition` int(11) DEFAULT NULL,
  `IsEnabled` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`MenuId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Volcado de datos para la tabla `menus`
--

INSERT INTO `menus` (`MenuId`, `MenuName`, `Url`, `Target`, `Label`, `Title`, `Description`, `ParentId`, `ParentLabel`, `OrdinalPosition`, `IsEnabled`) VALUES
(1, 'user dash', 'index.php', '_self', 'Mi cuenta', '', '', 0, 'Mi cuenta', 2, 1),
(15, 'user dash', '../index.php', '_new', 'Home', '', '', 0, 'Home', 1, 1),
(16, 'user dash', 'premium.php', '_self', 'Usuarios Pagos', '', '', 1, 'Mi cuenta', 1, 1),
(17, 'user dash', 'downloads.php', '_self', 'Descargas', '', '', 1, 'Mi cuenta', 3, 1),
(21, 'user dash', 'profile.php', '_self', 'Mi cuenta', '', '', 1, 'Mi cuenta', 7, 1),
(22, 'user dash', 'avatar.php', '_self', 'Avatar', '', '', 1, 'Mi cuenta', 8, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu_names`
--

CREATE TABLE IF NOT EXISTS `menu_names` (
  `MenuNameId` int(11) NOT NULL AUTO_INCREMENT,
  `MenuName` varchar(100) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`MenuNameId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `menu_names`
--

INSERT INTO `menu_names` (`MenuNameId`, `MenuName`, `Description`) VALUES
(1, 'user dash', 'none');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profiles`
--

CREATE TABLE IF NOT EXISTS `profiles` (
  `ProfileId` int(25) NOT NULL AUTO_INCREMENT,
  `UserId` int(25) NOT NULL,
  `UserName` varchar(60) NOT NULL,
  `FirstName` varchar(60) NOT NULL,
  `LastName` varchar(60) NOT NULL,
  `CompanyName` varchar(150) DEFAULT NULL,
  `WebsiteUrl` varchar(255) DEFAULT NULL,
  `ProfileTitle` varchar(200) DEFAULT NULL,
  `ProfileText` text,
  `Phone` varchar(20) DEFAULT NULL,
  `Address` varchar(50) DEFAULT NULL,
  `Street` varchar(50) DEFAULT NULL,
  `City` varchar(100) DEFAULT NULL,
  `State` varchar(100) DEFAULT NULL,
  `Zip` varchar(20) DEFAULT NULL,
  `Country` varchar(100) DEFAULT NULL,
  `AvatarImage` varchar(255) DEFAULT NULL,
  `Newsletter` tinyint(1) NOT NULL DEFAULT '0',
  `Promotion` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ProfileId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Volcado de datos para la tabla `profiles`
--

INSERT INTO `profiles` (`ProfileId`, `UserId`, `UserName`, `FirstName`, `LastName`, `CompanyName`, `WebsiteUrl`, `ProfileTitle`, `ProfileText`, `Phone`, `Address`, `Street`, `City`, `State`, `Zip`, `Country`, `AvatarImage`, `Newsletter`, `Promotion`) VALUES
(19, 114, 'admin', 'asas', 'asasas', '', '', 'asas', '', 'asasas', '', '', '', '', '', 'Venezuela', 'http://localhost/psum/user/upload/avatars/admin-hunzonian.jpg', 1, 0),
(20, 146, 'admin2', 'asas', 'asas', '', '', 'asas', '', 'asas', '', '', '', '', '', '', NULL, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `RoleId` int(11) NOT NULL AUTO_INCREMENT,
  `RoleName` varchar(50) DEFAULT NULL,
  `Description` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`RoleId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`RoleId`, `RoleName`, `Description`) VALUES
(1, 'Maximus', ''),
(2, 'superadmin', ''),
(3, 'Facilitador', ''),
(4, 'Usuario Pago', ''),
(5, 'Usuario', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `UserId` int(25) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(60) NOT NULL,
  `Password` varchar(64) NOT NULL,
  `PasswordQuestion` varchar(100) DEFAULT NULL,
  `PasswordAnswer` varchar(100) DEFAULT NULL,
  `Email` varchar(100) NOT NULL,
  `IsApproved` tinyint(1) NOT NULL DEFAULT '0',
  `IsLockedOut` tinyint(1) NOT NULL DEFAULT '0',
  `IsLoggedIn` tinyint(1) NOT NULL DEFAULT '0',
  `SessionId` varchar(64) NOT NULL DEFAULT '0',
  `CreateDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `LastLoginDate` datetime DEFAULT '0000-00-00 00:00:00',
  `LastLoginIP` varchar(60) NOT NULL,
  `LastPasswordChangeDate` datetime DEFAULT '0000-00-00 00:00:00',
  `LastActivityDate` datetime DEFAULT '0000-00-00 00:00:00',
  `LastLockoutDate` datetime DEFAULT '0000-00-00 00:00:00',
  `LastUnlockDate` datetime DEFAULT '0000-00-00 00:00:00',
  `Comment` longtext,
  `DestinationUrl` varchar(100) NOT NULL DEFAULT 'default',
  `ActivationKey` varchar(64) NOT NULL,
  `IsOwner` tinyint(1) NOT NULL DEFAULT '0',
  `IsPremium` tinyint(1) NOT NULL DEFAULT '0',
  `PremiumType` varchar(100) NOT NULL DEFAULT 'Free Membership',
  `PremiumStartDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `PremiumEndDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `PremiumAmount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `IsCancelled` tinyint(1) NOT NULL DEFAULT '0',
  `CancelledDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `IsEndOfTerm` tinyint(1) NOT NULL DEFAULT '0',
  `EndOfTermDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `IsPending` tinyint(1) NOT NULL DEFAULT '0',
  `PendingDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `PremiumLevel` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`UserId`),
  FULLTEXT KEY `UserName` (`UserName`),
  FULLTEXT KEY `Email` (`Email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=147 ;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`UserId`, `UserName`, `Password`, `PasswordQuestion`, `PasswordAnswer`, `Email`, `IsApproved`, `IsLockedOut`, `IsLoggedIn`, `SessionId`, `CreateDate`, `LastLoginDate`, `LastLoginIP`, `LastPasswordChangeDate`, `LastActivityDate`, `LastLockoutDate`, `LastUnlockDate`, `Comment`, `DestinationUrl`, `ActivationKey`, `IsOwner`, `IsPremium`, `PremiumType`, `PremiumStartDate`, `PremiumEndDate`, `PremiumAmount`, `IsCancelled`, `CancelledDate`, `IsEndOfTerm`, `EndOfTermDate`, `IsPending`, `PendingDate`, `PremiumLevel`) VALUES
(114, 'admin', '1417c6235bc79819765456bb0132670060a955e6', 'none', 'none', 'none', 1, 0, 0, '', '2012-02-29 17:32:46', '2012-03-02 02:20:26', '127.0.0.1', '0000-00-00 00:00:00', '2012-03-02 02:20:26', '2012-03-02 01:51:15', '2012-03-02 01:52:15', '', 'default', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, 0, 'Free Membership', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0.00, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(146, 'admin2', '14303ae277ed23dd2a862255ae8d9a58f53adc8d', 'loquesea', 'loquesea', 'daniek3@hotmail.com', 1, 0, 0, '', '2012-03-02 01:24:21', '2012-03-02 03:05:05', '127.0.0.1', '0000-00-00 00:00:00', '2012-03-02 03:05:05', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 'default', '4b3c43ef00f9aa814c566b082609bda048c4bf2d', 1, 0, 'Free Membership', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0.00, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_in_roles`
--

CREATE TABLE IF NOT EXISTS `users_in_roles` (
  `UsersInRolesId` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` int(11) NOT NULL,
  `RoleId` int(11) NOT NULL,
  `RoleName` varchar(50) NOT NULL,
  PRIMARY KEY (`UsersInRolesId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=649 ;

--
-- Volcado de datos para la tabla `users_in_roles`
--

INSERT INTO `users_in_roles` (`UsersInRolesId`, `UserId`, `RoleId`, `RoleName`) VALUES
(641, 114, 1, 'Maximus'),
(581, 115, 5, 'user'),
(582, 116, 5, 'user'),
(583, 117, 5, 'user'),
(584, 118, 5, 'user'),
(585, 119, 5, 'user'),
(586, 120, 5, 'user'),
(587, 121, 5, 'user'),
(588, 122, 5, 'user'),
(589, 123, 5, 'user'),
(590, 124, 5, 'user'),
(591, 125, 5, 'user'),
(592, 126, 5, 'user'),
(625, 127, 5, 'user'),
(594, 128, 5, 'user'),
(595, 129, 5, 'user'),
(596, 130, 5, 'user'),
(597, 131, 5, 'user'),
(598, 132, 5, 'user'),
(599, 133, 5, 'user'),
(605, 134, 5, 'user'),
(630, 143, 5, 'user'),
(648, 146, 5, 'Usuario'),
(647, 146, 3, 'Facilitador'),
(646, 146, 2, 'superadmin'),
(645, 146, 1, 'Maximus'),
(642, 114, 2, 'superadmin'),
(643, 114, 3, 'Facilitador'),
(644, 114, 5, 'Usuario');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
