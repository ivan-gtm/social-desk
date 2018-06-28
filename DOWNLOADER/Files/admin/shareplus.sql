-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-03-2018 a las 03:10:51
-- Versión del servidor: 10.1.26-MariaDB
-- Versión de PHP: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `shareplus`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin_browser_graphics`
--

CREATE TABLE `admin_browser_graphics` (
  `Browser` varchar(25) NOT NULL,
  `Access` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `admin_browser_graphics`
--

INSERT INTO `admin_browser_graphics` (`Browser`, `Access`) VALUES
('Opera', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin_device_graphics`
--

CREATE TABLE `admin_device_graphics` (
  `Device` varchar(25) NOT NULL,
  `Access` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `admin_device_graphics`
--

INSERT INTO `admin_device_graphics` (`Device`, `Access`) VALUES
('Windows 8.1', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin_graphics`
--

CREATE TABLE `admin_graphics` (
  `graphicsID` int(11) NOT NULL,
  `look` date NOT NULL,
  `Visits` int(11) NOT NULL,
  `click` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `chat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `admin_graphics`
--

INSERT INTO `admin_graphics` (`graphicsID`, `look`, `Visits`, `click`, `user`, `chat`) VALUES
(0, '2018-03-15', 2, 2, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin_graphics_countries`
--

CREATE TABLE `admin_graphics_countries` (
  `Countries` varchar(255) NOT NULL,
  `Results` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin_graphic_visits_month`
--

CREATE TABLE `admin_graphic_visits_month` (
  `sessionIP` char(255) NOT NULL,
  `time` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `admin_graphic_visits_month`
--

INSERT INTO `admin_graphic_visits_month` (`sessionIP`, `time`) VALUES
('rqb4gvlgbf7d1dv3mq5o14fi4l', 1521076305);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `settings`
--

CREATE TABLE `settings` (
  `name` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `admin` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `language` varchar(11) NOT NULL,
  `language_system` varchar(11) NOT NULL,
  `Captcha` tinyint(1) NOT NULL,
  `Site_Key` varchar(255) NOT NULL,
  `Hashes` varchar(1024) NOT NULL,
  `echo_youtube` tinyint(1) NOT NULL,
  `echo_vimeo` tinyint(1) NOT NULL,
  `echo_facebook` tinyint(1) NOT NULL,
  `echo_dailymotion` tinyint(1) NOT NULL,
  `echo_instagram` tinyint(1) NOT NULL,
  `echo_flooxer` tinyint(1) NOT NULL,
  `echo_liveleak` tinyint(1) NOT NULL,
  `echo_imgur` tinyint(1) NOT NULL,
  `cookies` tinyint(1) NOT NULL,
  `error_system` tinyint(1) NOT NULL,
  `contract` tinyint(1) NOT NULL,
  `ads_one` varchar(1000) NOT NULL,
  `ads_two` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `settings`
--

INSERT INTO `settings` (`name`, `Description`, `admin`, `password`, `email`, `language`, `language_system`, `Captcha`, `Site_Key`, `Hashes`, `echo_youtube`, `echo_vimeo`, `echo_facebook`, `echo_dailymotion`, `echo_instagram`, `echo_flooxer`, `echo_liveleak`, `echo_imgur`, `cookies`, `error_system`, `contract`, `ads_one`, `ads_two`) VALUES
('SharePlus', ' - Download videos youtube,facebook,vimeo', 'admine', 'e10adc3949ba59abbe56e057f20f883e', 'chuyd23@gmail.com', 'en', 'es', 1, 'TMJsEmrrqvIOSMBy2kRkYH1eOBXBbeEV', '1024', 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, '<img src=\"./assets/img/publi.png\"></img>', '<img src=\"./assets/img/publi.png\"></img>');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
