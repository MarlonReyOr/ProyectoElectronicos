-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 15-01-2025 a las 05:55:24
-- Versión del servidor: 8.3.0
-- Versión de PHP: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `red_electronicos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensaje`
--

DROP TABLE IF EXISTS `mensaje`;
CREATE TABLE IF NOT EXISTS `mensaje` (
  `id_mensaje` int NOT NULL AUTO_INCREMENT,
  `id_solicitud` int NOT NULL,
  `id_donante` int NOT NULL,
  `mensaje` text NOT NULL,
  `fecha_mensaje` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_mensaje`),
  KEY `id_solicitud` (`id_solicitud`),
  KEY `id_donante` (`id_donante`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `mensaje`
--

INSERT INTO `mensaje` (`id_mensaje`, `id_solicitud`, `id_donante`, `mensaje`, `fecha_mensaje`) VALUES
(1, 1, 1, 'Tengo una laptop disponible para donar', '2025-01-15 01:36:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte`
--

DROP TABLE IF EXISTS `reporte`;
CREATE TABLE IF NOT EXISTS `reporte` (
  `id_reporte` int NOT NULL AUTO_INCREMENT,
  `id_usuario_reportado` int NOT NULL,
  `motivo` text NOT NULL,
  `fecha_reporte` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_reporte`),
  KEY `id_usuario_reportado` (`id_usuario_reportado`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud`
--

DROP TABLE IF EXISTS `solicitud`;
CREATE TABLE IF NOT EXISTS `solicitud` (
  `id_solicitud` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `id_tipo_dispositivo` int NOT NULL,
  `descripcion` text,
  `ruta_imagen` varchar(255) DEFAULT NULL,
  `finalizado` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_solicitud`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_tipo_dispositivo` (`id_tipo_dispositivo`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `solicitud`
--

INSERT INTO `solicitud` (`id_solicitud`, `id_usuario`, `id_tipo_dispositivo`, `descripcion`, `ruta_imagen`, `finalizado`) VALUES
(1, 1, 1, 'Necesito una laptop para estudiar', 'ruta/a/la/imagen.jpg', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_dispositivo`
--

DROP TABLE IF EXISTS `tipo_dispositivo`;
CREATE TABLE IF NOT EXISTS `tipo_dispositivo` (
  `id_tipo` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id_tipo`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `tipo_dispositivo`
--

INSERT INTO `tipo_dispositivo` (`id_tipo`, `nombre`) VALUES
(1, 'Laptop'),
(2, 'Teléfono móvil'),
(3, 'Tablet'),
(4, 'Monitor'),
(5, 'Impresora'),
(6, 'Teclado'),
(7, 'Ratón'),
(8, 'Cámara'),
(9, 'Televisor'),
(10, 'Consola de videojuegos'),
(11, 'Router'),
(12, 'Altavoces'),
(13, 'Proyector'),
(14, 'Disco duro externo'),
(15, 'Cargador'),
(16, 'Refrigerador'),
(17, 'Lavadora'),
(18, 'Microondas'),
(19, 'Horno'),
(20, 'Aspiradora'),
(21, 'Aire acondicionado'),
(22, 'Calefactor'),
(23, 'Ventilador'),
(24, 'Licuadora'),
(25, 'Tostadora'),
(26, 'Otros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `primer_apellido` varchar(100) NOT NULL,
  `segundo_apellido` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `bloqueado` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `correo` (`correo`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `primer_apellido`, `segundo_apellido`, `correo`, `contraseña`, `bloqueado`) VALUES
(1, 'Juan', 'Pérez', 'García', 'juan.perez@example.com', 'password123', 0),
(2, 'jhejhew', 'weqwedw', 'mreyeso1900@alumno.ipn.mx', 'dwqd@sa', '$2y$10$1o.3kYZuqZiBj5CPPLI4BOVXXek5Trt04d6e2hYKmMQA5QrqqRxrK', 0),
(3, 'q', 'q', 'q', 'q@q', '$2y$10$XGJRrZJrZ8N3xK0ge7oT7.imuOdQqa38YK2Rf8qsaKsOtw1PlPYey', 0),
(4, 'w', 'w', 'w', 'w@w', '$2y$10$kuBRcSrYK35B/yI0YPyNyOaWm1vEu8ykmjv6qun5oG36aODn01.oO', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
