-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 05-07-2016 a las 22:58:05
-- Versión del servidor: 5.1.36-community-log
-- Versión de PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `letitbrew`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbusuarios`
--

CREATE TABLE IF NOT EXISTS `dbusuarios` (
  `idusuario` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(10) NOT NULL,
  `password` varchar(10) NOT NULL,
  `refroll` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nombrecompleto` varchar(70) NOT NULL,
  PRIMARY KEY (`idusuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `dbusuarios`
--

INSERT INTO `dbusuarios` (`idusuario`, `usuario`, `password`, `refroll`, `email`, `nombrecompleto`) VALUES
(1, 'marcos', 'marcos', 1, 'msredhotero@msn.com', 'Saupurein Marcos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbventas`
--

CREATE TABLE IF NOT EXISTS `dbventas` (
  `idventa` int(11) NOT NULL AUTO_INCREMENT,
  `reftipocerveza` int(11) NOT NULL,
  `precioventa` decimal(18,2) NOT NULL,
  `cantidad` smallint(6) NOT NULL,
  `usuario` varchar(120) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechaventa` datetime DEFAULT NULL,
  `cancelado` bit(1) DEFAULT NULL,
  `observaciones` varchar(300) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idventa`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `dbventas`
--

INSERT INTO `dbventas` (`idventa`, `reftipocerveza`, `precioventa`, `cantidad`, `usuario`, `fechaventa`, `cancelado`, `observaciones`) VALUES
(1, 2, '70.00', 1, 'Saupurein Marcos', '2016-07-05 19:40:53', b'0', ''),
(2, 3, '70.00', 1, 'Saupurein Marcos', '2016-07-05 19:41:58', b'0', ''),
(3, 4, '70.00', 1, 'Saupurein Marcos', '2016-07-05 19:42:50', b'0', ''),
(4, 1, '70.00', 1, 'Saupurein Marcos', '2016-07-05 19:44:41', b'0', ''),
(5, 2, '70.00', 1, 'Saupurein Marcos', '2016-07-05 19:45:09', b'0', ''),
(6, 6, '70.00', 4, 'Saupurein Marcos', '2016-07-05 19:49:46', b'0', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `predio_menu`
--

CREATE TABLE IF NOT EXISTS `predio_menu` (
  `idmenu` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `icono` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Orden` smallint(6) DEFAULT NULL,
  `hover` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `permiso` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idmenu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbroles`
--

CREATE TABLE IF NOT EXISTS `tbroles` (
  `idrol` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  `activo` bit(1) NOT NULL,
  PRIMARY KEY (`idrol`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `tbroles`
--

INSERT INTO `tbroles` (`idrol`, `descripcion`, `activo`) VALUES
(1, 'Administrador', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbtipocervezas`
--

CREATE TABLE IF NOT EXISTS `tbtipocervezas` (
  `idtipocerveza` int(11) NOT NULL AUTO_INCREMENT,
  `tipocerveza` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `color` varchar(120) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ibu` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `alcohol` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `precio` decimal(18,2) DEFAULT NULL,
  `distribuidor` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `observaciones` varchar(300) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idtipocerveza`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=11 ;

--
-- Volcado de datos para la tabla `tbtipocervezas`
--

INSERT INTO `tbtipocervezas` (`idtipocerveza`, `tipocerveza`, `color`, `ibu`, `alcohol`, `precio`, `distribuidor`, `observaciones`) VALUES
(1, 'Golden', 'Rubia', NULL, NULL, '70.00', NULL, NULL),
(2, 'Scottish', 'Brown', NULL, NULL, '70.00', NULL, NULL),
(3, 'Tripel', 'Rubia', NULL, NULL, '70.00', NULL, NULL),
(4, 'Red Belgium', 'Red', NULL, NULL, '70.00', NULL, NULL),
(5, 'Kolsch', 'Rubia', NULL, NULL, '70.00', NULL, NULL),
(6, 'Porter', 'Brown', NULL, NULL, '70.00', NULL, NULL),
(7, 'Irish Red', 'Red', NULL, NULL, '70.00', NULL, NULL),
(8, 'APA', 'Rubia', NULL, NULL, '70.00', NULL, NULL),
(9, 'IPA', 'Amber', NULL, NULL, '70.00', NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
