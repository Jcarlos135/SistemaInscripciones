-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 30-09-2026 a las 13:16:11
-- Versión del servidor: 8.0.15
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `inst`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignacion_docente`
--

CREATE TABLE `asignacion_docente` (
  `id` int(11) NOT NULL,
  `id_docente` int(11) NOT NULL,
  `cod_asig` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `gestion` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `asignacion_docente`
--

INSERT INTO `asignacion_docente` (`id`, `id_docente`, `cod_asig`, `gestion`) VALUES
(1, 2, 'MPI-101', '2026'),
(2, 7, 'PROG-102', '2026'),
(3, 11, 'INT-103', '2026'),
(4, 6, 'OMT-106', '2026'),
(6, 10, 'BDD-208', '2026'),
(7, 1, 'DPW-207', '2026'),
(20, 4, 'ADS-206', '2026'),
(21, 4, 'ADS-306', '2026'),
(23, 5, 'PDM-307', '2026'),
(24, 1, 'DPW-302', '2026'),
(25, 1, 'TMG-305', '2026'),
(26, 1, 'GMC-303', '2026'),
(27, 9, 'DPW-107', '2026'),
(28, 2, 'BDD-308', '2026'),
(29, 7, 'PDM-205', '2026'),
(30, 8, 'RDC-204', '2026'),
(31, 8, 'EST-201', '2026'),
(33, 9, 'PRG-202', '2026'),
(34, 6, 'EMP-301', '2026'),
(35, 6, 'HDC-104', '2026'),
(36, 3, 'RDC-304', '2026'),
(37, 2, 'TSO-105', '2026');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignatura`
--

CREATE TABLE `asignatura` (
  `codigo` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombre` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `horas` int(11) DEFAULT NULL,
  `gestion` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `hora` time NOT NULL DEFAULT '08:00:00',
  `id_carrera` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `nivel` int(11) NOT NULL DEFAULT '101',
  `activo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `asignatura`
--

INSERT INTO `asignatura` (`codigo`, `nombre`, `horas`, `gestion`, `hora`, `id_carrera`, `nivel`, `activo`) VALUES
('ADS-206', 'ANALISIS Y DISEÑO DE SISTEMAS I', NULL, '2024', '08:00:00', 'SIS-INF', 200, 1),
('ADS-306', 'ANALISIS Y DISEÑO DE SISTEMAS II', NULL, '2024', '08:00:00', 'SIS-INF', 300, 1),
('BDD-208', 'BASE DE DATOS I', NULL, '2024', '08:00:00', 'SIS-INF', 200, 1),
('BDD-308', 'BASE DE DATOS II', NULL, '2024', '08:00:00', 'SIS-INF', 300, 1),
('DPW-107', 'DISEÑO Y PROGRAMACIÓN WEB I', NULL, '2024', '08:00:00', 'SIS-INF', 100, 1),
('DPW-207', 'DISEÑO Y PROGRAMACIÓN WEB II', NULL, '2024', '08:00:00', 'SIS-INF', 200, 1),
('DPW-302', 'DISEÑO Y PROGRAMACIÓN WEB III', NULL, '2024', '08:00:00', 'SIS-INF', 300, 1),
('EDD-203', 'ESTRUCTURA DE DATOS', NULL, '2024', '08:00:00', 'SIS-INF', 200, 1),
('EMP-301', 'EMPRENDIMIENTO PRODUCTIVO', NULL, '2024', '08:00:00', 'SIS-INF', 300, 1),
('EST-201', 'ESTADISTICA', NULL, '2024', '08:00:00', 'SIS-INF', 200, 1),
('GMC-303', 'GESTIÓN Y MEJORAMIENTO DE LA CALIDAD DE SOFTWARE', NULL, '2024', '08:00:00', 'SIS-INF', 300, 1),
('HDC-104', 'HARDWARE DE COMPUTADORAS', NULL, '2024', '08:00:00', 'SIS-INF', 100, 1),
('INT-103', 'INGLES TECNICO', NULL, '2024', '08:00:00', 'SIS-INF', 100, 1),
('MPI-101', 'MATEMATICA PARA LA INFORMATICA', NULL, '2024', '08:00:00', 'SIS-INF', 100, 1),
('OMT-106', 'OFIMATICA Y TECNOLOGIA MULTIMEDIA', NULL, '2024', '08:00:00', 'SIS-INF', 100, 1),
('PDM-205', 'PROGRAMACIÓN PARA DISPOSITIVOS MOVILES I', NULL, '2024', '08:00:00', 'SIS-INF', 200, 1),
('PDM-307', 'PROGRAMACIÓN PARA DISPOSITIVOS MOVILES II', NULL, '2024', '08:00:00', 'SIS-INF', 300, 1),
('PRG-202', 'PROGRAMACIÓN II', NULL, '2024', '08:00:00', 'SIS-INF', 200, 1),
('PROG-102', 'PROGRAMACIÓN I', NULL, '2024', '08:00:00', 'SIS-INF', 100, 1),
('RDC-204', 'REDES DE COMPUTADORAS I', NULL, '2024', '08:00:00', 'SIS-INF', 200, 1),
('RDC-304', 'REDES DE COMPUTADORA II', NULL, '2024', '08:00:00', 'SIS-INF', 300, 1),
('TMG-305', 'TALLER DE MODALIDAD DE GRADUACIÓN', NULL, '2024', '08:00:00', 'SIS-INF', 300, 1),
('TSO-105', 'TALLER DE SISTEMAS OPERATIVOS', NULL, '2024', '08:00:00', 'SIS-INF', 100, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrera`
--

CREATE TABLE `carrera` (
  `id` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `resolucion` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `descripcion` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `gestion` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `duracion` int(11) DEFAULT NULL,
  `anios` int(11) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `carrera`
--

INSERT INTO `carrera` (`id`, `nombre`, `resolucion`, `descripcion`, `gestion`, `duracion`, `anios`, `activo`) VALUES
('SIS-INF', 'SISTEMAS INFORMÁTICOS', 'RM-205', 'Centro de Enseñanza Técnica', '2024', 3, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docente`
--

CREATE TABLE `docente` (
  `id_docente` int(11) NOT NULL,
  `ci` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `ap_pat` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `ap_mat` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `genero` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `cel` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `id_rol` int(11) NOT NULL DEFAULT '4',
  `activo` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `docente`
--

INSERT INTO `docente` (`id_docente`, `ci`, `nombre`, `ap_pat`, `ap_mat`, `genero`, `cel`, `email`, `id_rol`, `activo`) VALUES
(1, '5550001', 'JONATAN', 'HINOJOSA', 'MAMANI', 'M', '70500001', 'jhinojosa@instituto.edu', 4, 1),
(2, '5550002', 'WENDY', 'NAVIA', 'QUISPE', 'F', '70500002', 'wnavia@instituto.edu', 4, 1),
(3, '5550003', 'FREDDY', 'COLQUE', 'TORRES', 'M', '70500003', 'fcolque@instituto.edu', 4, 1),
(4, '5550004', 'ROXANA', 'FORONDA', 'LOPEZ', 'F', '70500004', 'rforonda@instituto.edu', 4, 1),
(5, '5550005', 'LUIS', 'GUTIERREZ', 'MORALES', 'M', '70500005', 'lgutierrez@instituto.edu', 4, 1),
(6, '5550006', 'YNCLAN', 'SANTOS', 'VARGAS', 'M', '70500006', 'ysantos@instituto.edu', 4, 1),
(7, '5550007', 'VICTOR', 'PACO', 'CHURA', 'M', '70500007', 'vpaco@instituto.edu', 4, 1),
(8, '5550008', 'ANGEL', 'RODRIGUEZ', 'FLORES', 'M', '70500008', 'arodriguez@instituto.edu', 4, 1),
(9, '5550009', 'FREDY', 'CALSI NA', 'MENDOZA', 'M', '70500009', 'fcalsina@instituto.edu', 4, 1),
(10, '5550010', 'PATRICIA', 'FERNANDEZ', 'ROJAS', 'F', '70500010', 'pfernandez@instituto.edu', 4, 1),
(11, '5550011', 'ANTONIO', 'CONDORI', 'APAZA', 'M', '70500011', 'acondori@instituto.edu', 4, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos_est`
--

CREATE TABLE `documentos_est` (
  `id_documento` int(11) NOT NULL,
  `ci_est` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `tipo_documento` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombre_archivo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `ruta_archivo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `fecha_subida` datetime DEFAULT CURRENT_TIMESTAMP,
  `observaciones` text CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante`
--

CREATE TABLE `estudiante` (
  `ci` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `ap_pat` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `ap_mat` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `genero` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `edad` int(11) DEFAULT NULL,
  `cel` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `id_carrera` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `estudiante`
--

INSERT INTO `estudiante` (`ci`, `nombre`, `ap_pat`, `ap_mat`, `genero`, `edad`, `cel`, `img`, `id_carrera`, `id_usuario`, `activo`) VALUES
('10203203', 'MARIA', 'MIRANDA', 'MERCADO', 'F', 23, '76754757', 'img/1781664837_1781664825_M11.jpg', 'SIS-INF', 6, 1),
('10223203', 'MAYTE', 'ORELLANA', 'REDONDO', 'F', 26, '75647576', 'img/1782266519_1782266491_DEFAUL_M.jpg', 'SIS-INF', 7, 0),
('11239832', 'DANIELA', 'LUJAN', '', 'F', 23, '6756453', 'img/1782266491_DEFAUL_M.jpg', 'SIS-INF', 12, 0),
('121232431', 'LUCIA', 'MERCADO', 'PARADO', 'F', 23, '76565454', 'img/1782271159_1781708233_1781664900_H1.jpg', 'SIS-INF', 25, 1),
('12345678', 'MARIA', 'MERCADO', 'PERALTA', 'F', 21, '76574757', 'img/1781664439_1__1_.jpg', 'SIS-INF', 1, 1),
('190102033', 'MARCOS', 'MERCAD', 'AGUILERA', 'M', 32, '64564565', 'img/1782269370_1782266470_1781664857_H1.jpg', 'SIS-INF', 23, 1),
('2222222', 'MARIA', 'MERCEZ', 'MERCADO', 'F', 23, '75675475', 'img/1781664622_M__4_.jpg', 'SIS-INF', 2, 1),
('2736233', 'MARCOS', 'MERCADO', '', 'M', 33, '75475746', 'img/1781664589_N__3_.webp', 'SIS-INF', 5, 1),
('2736234', 'LUCASSS', 'MARINO', 'MILIAN', 'M', 24, '6574756', 'img/1781664551_H__2_.jpg', 'SIS-INF', 10, 1),
('37473743', 'LUIS', 'MAMANI', 'MAMANI', 'M', 23, '67576757', 'img/1782268206_1781708233_1781664900_H1.jpg', 'SIS-INF', 22, 1),
('38283283', 'FERNADO', 'TORNADO', 'MENDEZ', 'M', 45, '75474757', 'img/1781664900_H1.jpg', 'SIS-INF', 8, 1),
('45345353', 'RAMIRO', 'PERALTA', 'MERCADO', 'M', 23, '56564564', 'img/1782271425_1781708233_1781664900_H1.jpg', 'SIS-INF', 26, 1),
('45463464', 'MARIA', 'MERCEDEZ', 'PARRILLA', 'F', 21, '565646564', 'img/1782270727_DEFAUL_M.jpg', 'SIS-INF', 24, 1),
('45645467', 'MARIANO', 'MERCADO', 'PERALTA', 'M', 32, '74564755', 'img/1782268041_1782266470_1781664857_H1.jpg', 'SIS-INF', 21, 1),
('46574343', 'JUAN CARLOS', 'QUISPE', 'CHIRINOS', 'M', 43, '75647574', 'img/1781664857_H1.jpg', 'SIS-INF', 14, 1),
('4780223', 'DANIELA', 'ROSARIO', 'MILAN', 'F', 23, '76767578', 'img/1781664868_H1.jpg', 'SIS-INF', 13, 1),
('4780252', 'MARINA', 'RODUATA', 'MERIDA', 'F', 33, '767575477', 'img/1781666105_1781664825_M11.jpg', 'SIS-INF', 19, 1),
('4780257', 'JUAN CARLOS', 'CHIRIINOS', 'QUISPE', 'M', 38, '77657635', 'img/1782266470_1781664857_H1.jpg', 'SIS-INF', 4, 1),
('47892832', 'MARCOS', 'RUIZ', 'PERALES', 'M', 32, '74547345', 'img/1782261748_1781664857_H1.jpg', 'SIS-INF', 20, 1),
('48574857', 'MARIA', 'MIRANDA', 'PACOSILLO', 'F', 34, '66566656', 'img/1781664825_M11.jpg', 'SIS-INF', 11, 1),
('61234567', 'DANIEL', 'MAMANI', 'QUISPE', 'M', 22, '71234567', 'img/default_m.jpg', 'SIS-INF', 46, 1),
('61234568', 'JUAN', 'CHOQUE', 'VARGAS', 'M', 23, '71234568', 'img/default_m.jpg', 'SIS-INF', 47, 1),
('61234569', 'RAUL', 'CONDORI', 'FLORES', 'M', 21, '71234569', 'img/default_m.jpg', 'SIS-INF', 48, 1),
('61234570', 'MARCOS', 'QUISPE', 'MAMANI', 'M', 24, '71234570', 'img/default_m.jpg', 'SIS-INF', 49, 1),
('61234571', 'DANIELA', 'VARGAS', 'CHOQUE', 'F', 22, '71234571', 'img/default_f.jpg', 'SIS-INF', 50, 1),
('61234572', 'ANDREA', 'FLORES', 'CONDORI', 'F', 23, '71234572', 'img/default_f.jpg', 'SIS-INF', 51, 1),
('61234573', 'CARLOS', 'APAZA', 'TICONA', 'M', 21, '71234573', 'img/default_m.jpg', 'SIS-INF', 52, 1),
('61234574', 'PATRICIA', 'ROJAS', 'SANCHEZ', 'F', 25, '71234574', 'img/default_f.jpg', 'SIS-INF', 53, 1),
('62345671', 'JORGE', 'CALLE', 'MAMANI', 'M', 20, '72345671', 'img/default_m.jpg', 'SIS-INF', 54, 1),
('62345672', 'ROXANA', 'TICONA', 'CHOQUE', 'F', 21, '72345672', 'img/default_f.jpg', 'SIS-INF', 55, 1),
('62345673', 'WILSON', 'APAZA', 'CONDORI', 'M', 22, '72345673', 'img/default_m.jpg', 'SIS-INF', 56, 1),
('7685675', 'MARTICA', 'MERCADO', 'MARIMA', 'M', 23, '75473745', 'img/1781664574_M__5_.jpg', 'SIS-INF', 3, 1),
('7685676', 'MARIA', 'MERCADO', '', 'F', 23, '67574757', 'img/1781664598_M__1_.png', 'SIS-INF', 9, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

CREATE TABLE `historial` (
  `id` int(11) NOT NULL,
  `ci_est` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `cod_asig` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `nota_teorico1` int(11) DEFAULT NULL,
  `nota_pract1` int(11) DEFAULT NULL,
  `nota_primerbim` int(11) DEFAULT NULL,
  `nota_teorico2` int(11) DEFAULT NULL,
  `nota_pract2` int(11) DEFAULT NULL,
  `nota_segundobim` int(11) DEFAULT NULL,
  `nota_teorico3` int(11) DEFAULT NULL,
  `nota_pract3` int(11) DEFAULT NULL,
  `nota_tercerbim` int(11) DEFAULT NULL,
  `nota_teorico4` int(11) DEFAULT NULL,
  `nota_pract4` int(11) DEFAULT NULL,
  `nota_cuartobim` int(11) DEFAULT NULL,
  `nota_parcial` int(11) DEFAULT NULL COMMENT 'Nota parcial (promedio bimestres)',
  `segundo_turno` int(2) DEFAULT '0' COMMENT '1 si la materia se cursa en segundo turno',
  `TotalAnual` int(11) DEFAULT NULL COMMENT 'Nota total anual',
  `gestion` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `literal` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL COMMENT 'Literal en texto de la nota TotalAnual',
  `observaciones` text CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci,
  `estado` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `id_docente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `historial`
--

INSERT INTO `historial` (`id`, `ci_est`, `cod_asig`, `nota_teorico1`, `nota_pract1`, `nota_primerbim`, `nota_teorico2`, `nota_pract2`, `nota_segundobim`, `nota_teorico3`, `nota_pract3`, `nota_tercerbim`, `nota_teorico4`, `nota_pract4`, `nota_cuartobim`, `nota_parcial`, `segundo_turno`, `TotalAnual`, `gestion`, `literal`, `observaciones`, `estado`, `id_docente`) VALUES
(2, '7685675', 'MPI-101', 75, 80, 78, 79, 82, 81, 81, 89, 85, 76, 84, 80, 81, 0, 81, '2024', 'OCHENTA Y UNO', 'Evaluación por porcentaje registrada', 'APROBADO', 2),
(3, '7685675', 'PROG-102', 82, 80, 81, 81, 88, 85, 80, 88, 84, 81, 85, 83, 83, 0, 83, '2024', 'OCHENTA Y TRES', 'Evaluación por porcentaje registrada', 'APROBADO', 7),
(4, '7685675', 'INT-103', 78, 80, 79, 83, 83, 83, 79, 87, 83, 78, 86, 82, 82, 0, 82, '2024', 'OCHENTA Y DOS', 'Evaluación por porcentaje registrada', 'APROBADO', 11),
(5, '7685675', 'HDC-104', 74, 80, 77, 76, 89, 83, 78, 86, 82, 75, 87, 81, 81, 0, 81, '2024', 'OCHENTA Y UNO', 'Evaluación por porcentaje registrada', 'APROBADO', 6),
(6, '7685675', 'TSO-105', 81, 80, 81, 78, 84, 81, 77, 85, 81, 80, 88, 84, 82, 0, 82, '2024', 'OCHENTA Y DOS', 'Evaluación por porcentaje registrada', 'APROBADO', 2),
(7, '7685675', 'OMT-106', 77, 80, 79, 80, 90, 85, 76, 84, 80, 77, 89, 83, 82, 0, 82, '2024', 'OCHENTA Y DOS', 'Evaluación por porcentaje registrada', 'APROBADO', 6),
(8, '7685675', 'DPW-107', 73, 80, 77, 82, 85, 84, 75, 83, 79, 74, 90, 82, 81, 0, 81, '2024', 'OCHENTA Y UNO', 'Evaluación por porcentaje registrada', 'APROBADO', 9),
(9, '12345678', 'MPI-101', 80, 80, 80, 75, 91, 83, 74, 82, 78, 79, 91, 85, 82, 0, 82, '2024', 'OCHENTA Y DOS', 'Evaluación por porcentaje registrada', 'APROBADO', 2),
(10, '12345678', 'PROG-102', 76, 80, 78, 77, 86, 82, 73, 81, 77, 76, 82, 79, 79, 0, 79, '2024', 'SETENTA Y NUEVE', 'Evaluación por porcentaje registrada', 'APROBADO', 7),
(11, '12345678', 'INT-103', 72, 80, 76, 79, 81, 80, 82, 80, 81, 81, 83, 82, 80, 0, 80, '2024', 'OCHENTA', 'Evaluación por porcentaje registrada', 'APROBADO', 11),
(12, '12345678', 'HDC-104', 79, 80, 80, 81, 87, 84, 81, 79, 80, 78, 84, 81, 81, 0, 81, '2024', 'OCHENTA Y UNO', 'Evaluación por porcentaje registrada', 'APROBADO', 6),
(13, '12345678', 'TSO-105', 75, 80, 78, 83, 82, 83, 80, 90, 85, 75, 85, 80, 82, 0, 82, '2024', 'OCHENTA Y DOS', 'Evaluación por porcentaje registrada', 'APROBADO', 2),
(14, '12345678', 'OMT-106', 82, 80, 81, 76, 88, 82, 79, 89, 84, 80, 86, 83, 83, 0, 83, '2024', 'OCHENTA Y TRES', 'Evaluación por porcentaje registrada', 'APROBADO', 6),
(15, '12345678', 'DPW-107', 78, 80, 79, 78, 83, 81, 78, 88, 83, 77, 87, 82, 81, 0, 81, '2024', 'OCHENTA Y UNO', 'Evaluación por porcentaje registrada', 'APROBADO', 9),
(16, '4780257', 'MPI-101', 68, 74, 71, 74, 83, 79, 71, 81, 76, 68, 82, 75, 75, 0, 75, '2024', 'SETENTA Y CINCO', 'Evaluación por porcentaje registrada', 'APROBADO', 2),
(17, '4780257', 'PROG-102', 75, 74, 75, 76, 78, 77, 70, 80, 75, 73, 83, 78, 76, 0, 76, '2024', 'SETENTA Y SEIS', 'Evaluación por porcentaje registrada', 'APROBADO', 7),
(18, '4780257', 'INT-103', 67, 70, 69, 65, 80, 73, 65, 75, 70, 66, 80, 73, 71, 0, 71, '2024', 'SETENTA Y UNO', 'Evaluación por porcentaje registrada', 'APROBADO', 11),
(19, '4780257', 'HDC-104', 67, 74, 71, 71, 79, 75, 68, 78, 73, 75, 85, 80, 75, 0, 75, '2024', 'SETENTA Y CINCO', 'Evaluación por porcentaje registrada', 'APROBADO', 6),
(20, '4780257', 'TSO-105', 65, 70, 67, 55, 80, 65, 70, 60, 66, 80, 75, 78, 69, 0, NULL, '2024', NULL, 'Evaluación por porcentaje registrada', 'APROBADO', 2),
(21, '4780257', 'OMT-106', 70, 74, 72, 75, 80, 78, 76, 76, 76, 69, 77, 73, 75, 0, 75, '2024', 'SETENTA Y CINCO', 'Evaluación por porcentaje registrada', 'APROBADO', 6),
(22, '4780257', 'DPW-107', 56, 64, 60, 67, 65, 66, 65, 65, 65, 64, 68, 66, 64, 0, 64, '2024', 'SESENTA Y CUATRO', 'Evaluación por porcentaje registrada', 'APROBADO', 9),
(23, '2736233', 'MPI-101', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 2),
(24, '2736233', 'PROG-102', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 7),
(25, '2736233', 'INT-103', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 11),
(26, '2736233', 'HDC-104', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 6),
(27, '2736233', 'TSO-105', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 2),
(28, '2736233', 'OMT-106', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 6),
(29, '2736233', 'DPW-107', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 9),
(30, '10203203', 'MPI-101', 26, 33, 30, 34, 38, 36, 26, 38, 32, 33, 35, 34, 33, 0, 33, '2024', 'TREINTA Y TRES', 'Evaluación por porcentaje registrada', 'REPROBADO', 2),
(31, '10203203', 'PROG-102', 33, 33, 33, 36, 44, 40, 35, 37, 36, 30, 36, 33, 36, 0, 36, '2024', 'TREINTA Y SEIS', 'Evaluación por porcentaje registrada', 'REPROBADO', 7),
(32, '10203203', 'INT-103', 29, 33, 31, 29, 39, 34, 34, 36, 35, 27, 37, 32, 33, 0, 33, '2024', 'TREINTA Y TRES', 'Evaluación por porcentaje registrada', 'REPROBADO', 11),
(33, '10203203', 'HDC-104', 25, 33, 29, 31, 34, 33, 33, 35, 34, 32, 38, 35, 33, 0, 33, '2024', 'TREINTA Y TRES', 'Evaluación por porcentaje registrada', 'REPROBADO', 6),
(34, '10203203', 'TSO-105', 32, 33, 33, 33, 40, 37, 32, 34, 33, 29, 39, 34, 34, 0, 34, '2024', 'TREINTA Y CUATRO', 'Evaluación por porcentaje registrada', 'REPROBADO', 2),
(35, '10203203', 'OMT-106', 28, 33, 31, 35, 35, 35, 31, 33, 32, 34, 40, 37, 34, 0, 34, '2024', 'TREINTA Y CUATRO', 'Evaluación por porcentaje registrada', 'REPROBADO', 6),
(36, '10203203', 'DPW-107', 35, 33, 34, 28, 41, 35, 30, 32, 31, 31, 41, 36, 34, 0, 34, '2024', 'TREINTA Y CUATRO', 'Evaluación por porcentaje registrada', 'REPROBADO', 9),
(37, '10223203', 'MPI-101', 31, 33, 32, 30, 36, 33, 29, 43, 36, 28, 42, 35, 34, 0, 34, '2024', 'TREINTA Y CUATRO', 'Evaluación por porcentaje registrada', 'REPROBADO', 2),
(38, '10223203', 'PROG-102', 27, 33, 30, 32, 42, 37, 28, 42, 35, 33, 43, 38, 35, 0, 35, '2024', 'TREINTA Y CINCO', 'Evaluación por porcentaje registrada', 'REPROBADO', 7),
(39, '10223203', 'INT-103', 34, 33, 34, 34, 37, 36, 27, 41, 34, 30, 44, 37, 35, 0, 35, '2024', 'TREINTA Y CINCO', 'Evaluación por porcentaje registrada', 'REPROBADO', 11),
(40, '10223203', 'HDC-104', 30, 33, 32, 36, 43, 40, 26, 40, 33, 27, 35, 31, 34, 0, 34, '2024', 'TREINTA Y CUATRO', 'Evaluación por porcentaje registrada', 'REPROBADO', 6),
(41, '10223203', 'TSO-105', 26, 33, 30, 29, 38, 34, 35, 39, 37, 32, 36, 34, 34, 0, 34, '2024', 'TREINTA Y CUATRO', 'Evaluación por porcentaje registrada', 'REPROBADO', 2),
(42, '10223203', 'OMT-106', 33, 33, 33, 31, 44, 38, 34, 38, 36, 29, 37, 33, 35, 0, 35, '2024', 'TREINTA Y CINCO', 'Evaluación por porcentaje registrada', 'REPROBADO', 6),
(43, '10223203', 'DPW-107', 29, 33, 31, 33, 39, 36, 33, 37, 35, 34, 38, 36, 35, 0, 35, '2024', 'TREINTA Y CINCO', 'Evaluación por porcentaje registrada', 'REPROBADO', 9),
(44, '2222222', 'MPI-101', 72, 80, 76, 82, 81, 82, 79, 83, 81, 78, 86, 82, 80, 0, 80, '2024', 'OCHENTA', 'Evaluación por porcentaje registrada', 'APROBADO', 2),
(45, '2222222', 'PROG-102', 79, 80, 80, 75, 87, 81, 78, 82, 80, 75, 87, 81, 81, 0, 81, '2024', 'OCHENTA Y UNO', 'Evaluación por porcentaje registrada', 'APROBADO', 7),
(46, '2222222', 'INT-103', 75, 80, 78, 77, 82, 80, 77, 81, 79, 80, 88, 84, 80, 0, 80, '2024', 'OCHENTA', 'Evaluación por porcentaje registrada', 'APROBADO', 11),
(47, '2222222', 'HDC-104', 82, 80, 81, 79, 88, 84, 76, 80, 78, 77, 89, 83, 82, 0, 82, '2024', 'OCHENTA Y DOS', 'Evaluación por porcentaje registrada', 'APROBADO', 6),
(48, '2222222', 'TSO-105', 78, 80, 79, 81, 83, 82, 75, 79, 77, 74, 90, 82, 80, 0, 80, '2024', 'OCHENTA', 'Evaluación por porcentaje registrada', 'APROBADO', 2),
(49, '2222222', 'OMT-106', 74, 80, 77, 83, 89, 86, 74, 90, 82, 79, 91, 85, 83, 0, 83, '2024', 'OCHENTA Y TRES', 'Evaluación por porcentaje registrada', 'APROBADO', 6),
(50, '2222222', 'DPW-107', 81, 80, 81, 76, 84, 80, 73, 89, 81, 76, 82, 79, 80, 0, 80, '2024', 'OCHENTA', 'Evaluación por porcentaje registrada', 'APROBADO', 9),
(51, '38283283', 'MPI-101', 30, 33, 32, 31, 43, 37, 35, 41, 38, 34, 36, 35, 36, 0, 36, '2024', 'TREINTA Y SEIS', 'Evaluación por porcentaje registrada', 'REPROBADO', 2),
(52, '38283283', 'PROG-102', 26, 33, 30, 33, 38, 36, 34, 40, 37, 31, 37, 34, 34, 0, 34, '2024', 'TREINTA Y CUATRO', 'Evaluación por porcentaje registrada', 'REPROBADO', 7),
(53, '38283283', 'INT-103', 33, 33, 33, 35, 44, 40, 33, 39, 36, 28, 38, 33, 36, 0, 36, '2024', 'TREINTA Y SEIS', 'Evaluación por porcentaje registrada', 'REPROBADO', 11),
(54, '38283283', 'HDC-104', 29, 33, 31, 28, 39, 34, 32, 38, 35, 33, 39, 36, 34, 0, 34, '2024', 'TREINTA Y CUATRO', 'Evaluación por porcentaje registrada', 'REPROBADO', 6),
(55, '38283283', 'TSO-105', 25, 33, 29, 30, 34, 32, 31, 37, 34, 30, 40, 35, 33, 0, 33, '2024', 'TREINTA Y TRES', 'Evaluación por porcentaje registrada', 'REPROBADO', 2),
(56, '38283283', 'OMT-106', 32, 33, 33, 32, 40, 36, 30, 36, 33, 27, 41, 34, 34, 0, 34, '2024', 'TREINTA Y CUATRO', 'Evaluación por porcentaje registrada', 'REPROBADO', 6),
(57, '38283283', 'DPW-107', 28, 33, 31, 34, 35, 35, 29, 35, 32, 32, 42, 37, 34, 0, 34, '2024', 'TREINTA Y CUATRO', 'Evaluación por porcentaje registrada', 'REPROBADO', 9),
(58, '7685676', 'MPI-101', 76, 74, 75, 77, 82, 80, 69, 75, 72, 70, 84, 77, 76, 0, 76, '2024', 'SETENTA Y SEIS', 'Evaluación por porcentaje registrada', 'APROBADO', 2),
(59, '7685676', 'PROG-102', 72, 74, 73, 70, 77, 74, 68, 74, 71, 75, 85, 80, 75, 0, 75, '2024', 'SETENTA Y CINCO', 'Evaluación por porcentaje registrada', 'APROBADO', 7),
(60, '7685676', 'INT-103', 68, 74, 71, 72, 83, 78, 67, 73, 70, 72, 76, 74, 73, 0, 73, '2024', 'SETENTA Y TRES', 'Evaluación por porcentaje registrada', 'APROBADO', 11),
(61, '7685676', 'HDC-104', 75, 74, 75, 74, 78, 76, 76, 84, 80, 69, 77, 73, 76, 0, 76, '2024', 'SETENTA Y SEIS', 'Evaluación por porcentaje registrada', 'APROBADO', 6),
(62, '7685676', 'TSO-105', 65, 70, 67, 55, 80, 65, 70, 60, 66, 80, 75, 78, 69, 0, NULL, '2024', NULL, 'Evaluación por porcentaje registrada', 'APROBADO', 2),
(63, '7685676', 'OMT-106', 67, 74, 71, 69, 79, 74, 74, 82, 78, 71, 79, 75, 75, 0, 75, '2024', 'SETENTA Y CINCO', 'Evaluación por porcentaje registrada', 'APROBADO', 6),
(64, '7685676', 'DPW-107', 74, 74, 74, 71, 85, 78, 73, 81, 77, 68, 80, 74, 76, 0, 76, '2024', 'SETENTA Y SEIS', 'Evaluación por porcentaje registrada', 'APROBADO', 9),
(65, '2736234', 'MPI-101', 76, 80, 78, 79, 86, 83, 78, 86, 82, 79, 87, 83, 82, 0, 82, '2024', 'OCHENTA Y DOS', 'Evaluación por porcentaje registrada', 'APROBADO', 2),
(66, '2736234', 'PROG-102', 72, 80, 76, 81, 81, 81, 77, 85, 81, 76, 88, 82, 80, 0, 80, '2024', 'OCHENTA', 'Evaluación por porcentaje registrada', 'APROBADO', 7),
(67, '2736234', 'INT-103', 79, 80, 80, 83, 87, 85, 76, 84, 80, 81, 89, 85, 83, 0, 83, '2024', 'OCHENTA Y TRES', 'Evaluación por porcentaje registrada', 'APROBADO', 11),
(68, '2736234', 'HDC-104', 75, 80, 78, 76, 82, 79, 75, 83, 79, 78, 90, 84, 80, 0, 80, '2024', 'OCHENTA', 'Evaluación por porcentaje registrada', 'APROBADO', 6),
(69, '2736234', 'TSO-105', 82, 80, 81, 78, 88, 83, 74, 82, 78, 75, 91, 83, 81, 0, 81, '2024', 'OCHENTA Y UNO', 'Evaluación por porcentaje registrada', 'APROBADO', 2),
(70, '2736234', 'OMT-106', 78, 80, 79, 80, 83, 82, 73, 81, 77, 80, 82, 81, 80, 0, 80, '2024', 'OCHENTA', 'Evaluación por porcentaje registrada', 'APROBADO', 6),
(71, '2736234', 'DPW-107', 74, 80, 77, 82, 89, 86, 82, 80, 81, 77, 83, 80, 81, 0, 81, '2024', 'OCHENTA Y UNO', 'Evaluación por porcentaje registrada', 'APROBADO', 9),
(72, '48574857', 'MPI-101', 75, 74, 75, 69, 78, 74, 75, 73, 74, 68, 78, 73, 74, 0, 74, '2025', 'SETENTA Y CUATRO', 'Evaluación por porcentaje registrada', 'APROBADO', 2),
(73, '48574857', 'PROG-102', 71, 74, 73, 71, 84, 78, 74, 84, 79, 73, 79, 76, 77, 0, 77, '2025', 'SETENTA Y SIETE', 'Evaluación por porcentaje registrada', 'APROBADO', 7),
(74, '48574857', 'INT-103', 66, 73, 70, 72, 78, 75, 72, 82, 77, 69, 79, 74, 74, 0, 74, '2025', 'SETENTA Y CUATRO', 'Evaluación por porcentaje registrada', 'APROBADO', 11),
(75, '48574857', 'HDC-104', 74, 74, 74, 75, 85, 80, 72, 82, 77, 75, 81, 78, 77, 0, 77, '2025', 'SETENTA Y SIETE', 'Evaluación por porcentaje registrada', 'APROBADO', 6),
(76, '48574857', 'TSO-105', 65, 70, 67, 55, 80, 65, 70, 60, 66, 80, 75, 78, 69, 0, NULL, '2025', NULL, 'Evaluación por porcentaje registrada', 'APROBADO', 2),
(77, '48574857', 'OMT-106', 66, 74, 70, 70, 75, 73, 70, 80, 75, 69, 83, 76, 74, 0, 74, '2025', 'SETENTA Y CUATRO', 'Evaluación por porcentaje registrada', 'APROBADO', 6),
(78, '48574857', 'DPW-107', 73, 74, 74, 72, 81, 77, 69, 79, 74, 74, 84, 79, 76, 0, 76, '2025', 'SETENTA Y SEIS', 'Evaluación por porcentaje registrada', 'APROBADO', 9),
(79, '11239832', 'MPI-101', 40, 36, 37, 40, 36, 37, 40, 36, 37, 40, 36, 37, 37, 1, 0, '2025', 'CERO', 'Evaluación por porcentaje registrada', 'REPROBADO', 2),
(80, '11239832', 'PROG-102', 40, 36, 37, 40, 36, 37, 40, 36, 37, 40, 36, 37, 37, 1, 0, '2025', 'CERO', 'Evaluación por porcentaje registrada', 'REPROBADO', 7),
(81, '11239832', 'INT-103', 40, 36, 37, 40, 36, 37, 40, 36, 37, 40, 36, 37, 37, 1, 0, '2025', 'CERO', 'Evaluación por porcentaje registrada', 'REPROBADO', 11),
(82, '11239832', 'HDC-104', 40, 36, 37, 40, 36, 37, 40, 36, 37, 40, 36, 37, 37, 1, 0, '2025', 'CERO', 'Evaluación por porcentaje registrada', 'REPROBADO', 6),
(83, '11239832', 'TSO-105', 40, 36, 37, 40, 36, 37, 40, 36, 37, 40, 36, 37, 37, 1, 0, '2025', 'CERO', 'Evaluación por porcentaje registrada', 'REPROBADO', 2),
(84, '11239832', 'OMT-106', 40, 36, 37, 40, 36, 37, 40, 36, 37, 40, 36, 37, 37, 1, 0, '2025', 'CERO', 'Evaluación por porcentaje registrada', 'REPROBADO', 6),
(85, '11239832', 'DPW-107', 79, 88, 85, 40, 36, 37, 40, 36, 37, 40, 36, 37, 49, 1, 0, '2025', 'CERO', 'Evaluación por porcentaje registrada', 'REPROBADO', 9),
(86, '4780223', 'MPI-101', 74, 74, 74, 70, 85, 78, 71, 83, 77, 74, 82, 78, 77, 0, 77, '2025', 'SETENTA Y SIETE', 'Evaluación por porcentaje registrada', 'APROBADO', 2),
(87, '4780223', 'PROG-102', 70, 74, 72, 72, 80, 76, 70, 82, 76, 71, 83, 77, 75, 0, 75, '2025', 'SETENTA Y CINCO', 'Evaluación por porcentaje registrada', 'APROBADO', 7),
(88, '4780223', 'INT-103', 66, 74, 70, 74, 75, 75, 69, 81, 75, 68, 84, 76, 74, 0, 74, '2025', 'SETENTA Y CUATRO', 'Evaluación por porcentaje registrada', 'APROBADO', 11),
(89, '4780223', 'HDC-104', 73, 74, 74, 76, 81, 79, 68, 80, 74, 73, 85, 79, 77, 0, 77, '2025', 'SETENTA Y SIETE', 'Evaluación por porcentaje registrada', 'APROBADO', 6),
(90, '4780223', 'TSO-105', 65, 70, 67, 55, 80, 65, 70, 60, 66, 80, 75, 78, 69, 0, NULL, '2025', NULL, 'Evaluación por porcentaje registrada', 'APROBADO', 2),
(91, '4780223', 'OMT-106', 76, 74, 75, 71, 82, 77, 76, 78, 77, 75, 77, 76, 76, 0, 76, '2025', 'SETENTA Y SEIS', 'Evaluación por porcentaje registrada', 'APROBADO', 6),
(92, '4780223', 'DPW-107', 72, 74, 73, 73, 77, 75, 75, 77, 76, 72, 78, 75, 75, 0, 75, '2025', 'SETENTA Y CINCO', 'Evaluación por porcentaje registrada', 'APROBADO', 9),
(93, '46574343', 'MPI-101', 74, 80, 77, 81, 89, 85, 80, 82, 81, 75, 85, 80, 81, 0, 81, '2025', 'OCHENTA Y UNO', 'Evaluación por porcentaje registrada', 'APROBADO', 2),
(94, '46574343', 'PROG-102', 81, 80, 81, 83, 84, 84, 79, 81, 80, 80, 86, 83, 82, 0, 82, '2025', 'OCHENTA Y DOS', 'Evaluación por porcentaje registrada', 'APROBADO', 7),
(95, '46574343', 'INT-103', 77, 80, 79, 76, 90, 83, 78, 80, 79, 77, 87, 82, 81, 0, 81, '2025', 'OCHENTA Y UNO', 'Evaluación por porcentaje registrada', 'APROBADO', 11),
(96, '46574343', 'HDC-104', 73, 80, 77, 78, 85, 82, 77, 79, 78, 74, 88, 81, 80, 0, 80, '2025', 'OCHENTA', 'Evaluación por porcentaje registrada', 'APROBADO', 6),
(97, '46574343', 'TSO-105', 80, 80, 80, 80, 91, 86, 76, 90, 83, 79, 89, 84, 83, 0, 83, '2025', 'OCHENTA Y TRES', 'Evaluación por porcentaje registrada', 'APROBADO', 2),
(98, '46574343', 'OMT-106', 76, 80, 78, 82, 86, 84, 75, 89, 82, 76, 90, 83, 82, 0, 82, '2025', 'OCHENTA Y DOS', 'Evaluación por porcentaje registrada', 'APROBADO', 6),
(99, '46574343', 'DPW-107', 72, 80, 76, 75, 81, 78, 74, 88, 81, 81, 91, 86, 80, 0, 80, '2025', 'OCHENTA', 'Evaluación por porcentaje registrada', 'APROBADO', 9),
(100, '4780252', 'DPW-107', 73, 74, 74, 71, 81, 76, 67, 81, 74, 72, 76, 74, 75, 0, 75, '2025', 'SETENTA Y CINCO', 'Evaluación por porcentaje registrada', 'APROBADO', 9),
(101, '4780252', 'HDC-104', 69, 74, 72, 73, 76, 75, 76, 80, 78, 69, 77, 73, 75, 0, 75, '2025', 'SETENTA Y CINCO', 'Evaluación por porcentaje registrada', 'APROBADO', 6),
(102, '4780252', 'INT-103', 76, 74, 75, 75, 82, 79, 75, 79, 77, 74, 78, 76, 77, 0, 77, '2025', 'SETENTA Y SIETE', 'Evaluación por porcentaje registrada', 'APROBADO', 11),
(103, '4780252', 'MPI-101', 72, 74, 73, 77, 77, 77, 74, 78, 76, 71, 79, 75, 75, 0, 75, '2025', 'SETENTA Y CINCO', 'Evaluación por porcentaje registrada', 'APROBADO', 2),
(104, '4780252', 'OMT-106', 68, 74, 71, 70, 83, 77, 73, 77, 75, 68, 80, 74, 74, 0, 74, '2025', 'SETENTA Y CUATRO', 'Evaluación por porcentaje registrada', 'APROBADO', 6),
(105, '4780252', 'PROG-102', 75, 74, 75, 72, 78, 75, 72, 76, 74, 73, 81, 77, 75, 0, 75, '2025', 'SETENTA Y CINCO', 'Evaluación por porcentaje registrada', 'APROBADO', 7),
(106, '4780252', 'TSO-105', 65, 70, 67, 55, 80, 65, 70, 60, 66, 80, 75, 78, 69, 0, NULL, '2025', NULL, 'Evaluación por porcentaje registrada', 'APROBADO', 2),
(107, '47892832', 'DPW-107', 67, 74, 71, 76, 79, 78, 70, 74, 72, 75, 83, 79, 75, 0, 75, '2025', 'SETENTA Y CINCO', 'Evaluación por porcentaje registrada', 'APROBADO', 9),
(108, '47892832', 'HDC-104', 74, 74, 74, 69, 85, 77, 69, 73, 71, 72, 84, 78, 75, 0, 75, '2025', 'SETENTA Y CINCO', 'Evaluación por porcentaje registrada', 'APROBADO', 6),
(109, '47892832', 'INT-103', 70, 74, 72, 71, 80, 76, 68, 84, 76, 69, 85, 77, 75, 0, 75, '2025', 'SETENTA Y CINCO', 'Evaluación por porcentaje registrada', 'APROBADO', 11),
(110, '47892832', 'MPI-101', 66, 74, 70, 73, 75, 74, 67, 83, 75, 74, 76, 75, 74, 0, 74, '2025', 'SETENTA Y CUATRO', 'Evaluación por porcentaje registrada', 'APROBADO', 2),
(111, '47892832', 'OMT-106', 73, 74, 74, 75, 81, 78, 76, 82, 79, 71, 77, 74, 76, 0, 76, '2025', 'SETENTA Y SEIS', 'Evaluación por porcentaje registrada', 'APROBADO', 6),
(112, '47892832', 'PROG-102', 69, 74, 72, 77, 76, 77, 75, 81, 78, 68, 78, 73, 75, 0, 75, '2025', 'SETENTA Y CINCO', 'Evaluación por porcentaje registrada', 'APROBADO', 7),
(113, '47892832', 'TSO-105', 65, 70, 67, 55, 80, 65, 70, 60, 66, 80, 75, 78, 69, 0, NULL, '2025', NULL, 'Evaluación por porcentaje registrada', 'APROBADO', 2),
(114, '2736233', 'ADS-206', 31, 33, 32, 31, 36, 34, 32, 38, 35, 29, 39, 34, 0, 0, 0, '2025', 'TREINTA Y CUATRO', 'Reprobó 2do año - Repite en 2026', 'REPROBADO', 4),
(115, '2736233', 'BDD-208', 27, 33, 30, 33, 42, 38, 31, 37, 34, 34, 40, 37, 0, 0, 0, '2025', 'TREINTA Y CINCO', 'Reprobó 2do año - Repite en 2026', 'REPROBADO', 10),
(116, '2736233', 'DPW-207', 34, 33, 34, 35, 37, 36, 30, 36, 33, 31, 41, 36, 0, 0, 0, '2025', 'TREINTA Y CINCO', 'Reprobó 2do año - Repite en 2026', 'REPROBADO', 1),
(117, '2736233', 'EDD-203', 30, 33, 32, 28, 43, 36, 29, 35, 32, 28, 42, 35, 0, 0, 0, '2025', 'TREINTA Y CUATRO', 'Reprobó 2do año - Repite en 2026', 'REPROBADO', NULL),
(118, '2736233', 'EST-201', 26, 33, 30, 30, 38, 34, 28, 34, 31, 33, 43, 38, 0, 0, 0, '2025', 'TREINTA Y TRES', 'Reprobó 2do año - Repite en 2026', 'REPROBADO', 8),
(119, '2736233', 'PDM-205', 33, 33, 33, 32, 44, 38, 27, 33, 30, 30, 44, 37, 0, 0, 0, '2025', 'TREINTA Y CINCO', 'Reprobó 2do año - Repite en 2026', 'REPROBADO', 7),
(120, '2736233', 'PRG-202', 29, 33, 31, 34, 39, 37, 26, 32, 29, 27, 35, 31, 0, 0, 0, '2025', 'TREINTA Y DOS', 'Reprobó 2do año - Repite en 2026', 'REPROBADO', 9),
(121, '2736233', 'RDC-204', 25, 33, 29, 36, 34, 35, 35, 43, 39, 32, 36, 34, 0, 0, 0, '2025', 'TREINTA Y CUATRO', 'Reprobó 2do año - Repite en 2026', 'REPROBADO', 8),
(122, '45645467', 'DPW-107', 79, 80, 80, 76, 87, 82, 81, 89, 85, 76, 84, 80, 82, 0, 82, '2025', 'OCHENTA Y DOS', 'Evaluación por porcentaje registrada', 'APROBADO', 9),
(123, '45645467', 'HDC-104', 75, 80, 78, 78, 82, 80, 80, 88, 84, 81, 85, 83, 81, 0, 81, '2025', 'OCHENTA Y UNO', 'Evaluación por porcentaje registrada', 'APROBADO', 6),
(124, '45645467', 'INT-103', 82, 80, 81, 80, 88, 84, 79, 87, 83, 78, 86, 82, 83, 0, 83, '2025', 'OCHENTA Y TRES', 'Evaluación por porcentaje registrada', 'APROBADO', 11),
(125, '45645467', 'MPI-101', 78, 80, 79, 82, 83, 83, 78, 86, 82, 75, 87, 81, 81, 0, 81, '2025', 'OCHENTA Y UNO', 'Evaluación por porcentaje registrada', 'APROBADO', 2),
(126, '45645467', 'OMT-106', 74, 80, 77, 75, 89, 82, 77, 85, 81, 80, 88, 84, 81, 0, 81, '2025', 'OCHENTA Y UNO', 'Evaluación por porcentaje registrada', 'APROBADO', 6),
(127, '45645467', 'PROG-102', 81, 80, 81, 77, 84, 81, 76, 84, 80, 77, 89, 83, 81, 0, 81, '2025', 'OCHENTA Y UNO', 'Evaluación por porcentaje registrada', 'APROBADO', 7),
(128, '45645467', 'TSO-105', 77, 80, 79, 79, 90, 85, 75, 83, 79, 74, 90, 82, 81, 0, 81, '2025', 'OCHENTA Y UNO', 'Evaluación por porcentaje registrada', 'APROBADO', 2),
(129, '37473743', 'DPW-107', 50, 57, 54, 58, 62, 60, 51, 59, 55, 56, 68, 62, 58, 0, 58, '2025', 'CINCUENTA Y OCHO', 'Evaluación por porcentaje registrada', 'REPROBADO', 9),
(130, '37473743', 'HDC-104', 53, 53, 53, 56, 64, 60, 46, 54, 50, 49, 55, 52, 54, 0, 54, '2025', 'CINCUENTA Y CUATRO', 'Evaluación por porcentaje registrada', 'REPROBADO', 6),
(131, '37473743', 'INT-103', 49, 53, 51, 49, 59, 54, 55, 53, 54, 54, 56, 55, 54, 0, 54, '2025', 'CINCUENTA Y CUATRO', 'Evaluación por porcentaje registrada', 'REPROBADO', 11),
(132, '37473743', 'MPI-101', 45, 53, 49, 51, 54, 53, 54, 52, 53, 51, 57, 54, 52, 0, 52, '2025', 'CINCUENTA Y DOS', 'Evaluación por porcentaje registrada', 'REPROBADO', 2),
(133, '37473743', 'OMT-106', 79, 80, 80, 80, 87, 84, 80, 90, 85, 75, 85, 80, 82, 0, 82, '2025', 'OCHENTA Y DOS', 'Evaluación por porcentaje registrada', 'APROBADO', 6),
(134, '37473743', 'PROG-102', 75, 80, 78, 82, 82, 82, 79, 89, 84, 80, 86, 83, 82, 0, 82, '2025', 'OCHENTA Y DOS', 'Evaluación por porcentaje registrada', 'APROBADO', 7),
(135, '37473743', 'TSO-105', 82, 80, 81, 75, 88, 82, 78, 88, 83, 77, 87, 82, 82, 0, 82, '2025', 'OCHENTA Y DOS', 'Evaluación por porcentaje registrada', 'APROBADO', 2),
(136, '190102033', 'DPW-107', 72, 74, 73, 71, 77, 74, 71, 81, 76, 68, 82, 75, 75, 0, 75, '2025', 'SETENTA Y CINCO', 'Evaluación por porcentaje registrada', 'APROBADO', 9),
(137, '190102033', 'HDC-104', 68, 74, 71, 73, 83, 78, 70, 80, 75, 73, 83, 78, 76, 0, 76, '2025', 'SETENTA Y SEIS', 'Evaluación por porcentaje registrada', 'APROBADO', 6),
(138, '190102033', 'INT-103', 75, 74, 75, 75, 78, 77, 69, 79, 74, 70, 84, 77, 76, 0, 76, '2025', 'SETENTA Y SEIS', 'Evaluación por porcentaje registrada', 'APROBADO', 11),
(139, '190102033', 'MPI-101', 71, 74, 73, 77, 84, 81, 68, 78, 73, 75, 85, 80, 77, 0, 77, '2025', 'SETENTA Y SIETE', 'Evaluación por porcentaje registrada', 'APROBADO', 2),
(140, '190102033', 'OMT-106', 67, 74, 71, 70, 79, 75, 67, 77, 72, 72, 76, 74, 73, 0, 73, '2025', 'SETENTA Y TRES', 'Evaluación por porcentaje registrada', 'APROBADO', 6),
(141, '190102033', 'PROG-102', 74, 74, 74, 72, 85, 79, 76, 76, 76, 69, 77, 73, 76, 0, 76, '2025', 'SETENTA Y SEIS', 'Evaluación por porcentaje registrada', 'APROBADO', 7),
(142, '190102033', 'TSO-105', 65, 70, 67, 55, 80, 65, 70, 60, 66, 80, 75, 78, 69, 0, NULL, '2025', NULL, 'Evaluación por porcentaje registrada', 'APROBADO', 2),
(150, '45463464', 'ADS-206', 77, 80, 79, 78, 90, 84, 73, 85, 79, 80, 82, 81, 81, 0, 81, '2025', 'OCHENTA Y UNO', 'Evaluación por porcentaje registrada', 'APROBADO', 4),
(151, '45463464', 'BDD-208', 73, 80, 77, 80, 85, 83, 82, 84, 83, 77, 83, 80, 81, 0, 81, '2025', 'OCHENTA Y UNO', 'Evaluación por porcentaje registrada', 'APROBADO', 10),
(152, '45463464', 'DPW-207', 80, 80, 80, 82, 91, 87, 81, 83, 82, 74, 84, 79, 82, 0, 82, '2025', 'OCHENTA Y DOS', 'Evaluación por porcentaje registrada', 'APROBADO', 1),
(153, '45463464', 'EDD-203', 76, 80, 78, 75, 86, 81, 80, 82, 81, 79, 85, 82, 81, 0, 81, '2025', 'OCHENTA Y UNO', 'Evaluación por porcentaje registrada', 'APROBADO', NULL),
(154, '45463464', 'EST-201', 72, 80, 76, 77, 81, 79, 79, 81, 80, 76, 86, 81, 79, 0, 79, '2025', 'SETENTA Y NUEVE', 'Evaluación por porcentaje registrada', 'APROBADO', 8),
(155, '45463464', 'PDM-205', 79, 80, 80, 79, 87, 83, 78, 80, 79, 81, 87, 84, 82, 0, 82, '2025', 'OCHENTA Y DOS', 'Evaluación por porcentaje registrada', 'APROBADO', 7),
(156, '45463464', 'PRG-202', 75, 80, 78, 81, 82, 82, 77, 79, 78, 78, 88, 83, 80, 0, 80, '2025', 'OCHENTA', 'Evaluación por porcentaje registrada', 'APROBADO', 9),
(157, '45463464', 'RDC-204', 82, 80, 81, 83, 88, 86, 76, 90, 83, 75, 89, 82, 83, 0, 83, '2025', 'OCHENTA Y TRES', 'Evaluación por porcentaje registrada', 'APROBADO', 8),
(165, '121232431', 'ADS-206', 40, 36, 37, 40, 36, 37, 40, 36, 37, 40, 36, 37, 37, 1, 0, '2025', 'CERO', 'Evaluación por porcentaje registrada', 'REPROBADO', 4),
(166, '121232431', 'BDD-208', 40, 36, 37, 40, 36, 37, 40, 36, 37, 40, 36, 37, 37, 1, 0, '2025', 'CERO', 'Evaluación por porcentaje registrada', 'REPROBADO', 10),
(167, '121232431', 'DPW-207', 40, 36, 37, 40, 36, 37, 40, 36, 37, 40, 61, 55, 42, 1, 0, '2025', 'CERO', 'Evaluación por porcentaje registrada', 'REPROBADO', 1),
(168, '121232431', 'EDD-203', 40, 36, 37, 40, 36, 37, 40, 36, 37, 40, 36, 37, 37, 1, 0, '2025', 'CERO', 'Evaluación por porcentaje registrada', 'REPROBADO', NULL),
(169, '121232431', 'EST-201', 78, 80, 79, 80, 83, 82, 74, 90, 82, 79, 91, 85, 82, 0, 82, '2025', 'OCHENTA Y DOS', 'Evaluación por porcentaje registrada', 'APROBADO', 8),
(170, '121232431', 'PDM-205', 74, 80, 77, 82, 89, 86, 73, 89, 81, 76, 82, 79, 81, 0, 81, '2025', 'OCHENTA Y UNO', 'Evaluación por porcentaje registrada', 'APROBADO', 7),
(171, '121232431', 'PRG-202', 81, 80, 81, 75, 84, 80, 82, 88, 85, 81, 83, 82, 82, 0, 82, '2025', 'OCHENTA Y DOS', 'Evaluación por porcentaje registrada', 'APROBADO', 9),
(172, '121232431', 'RDC-204', 77, 80, 79, 77, 90, 84, 81, 87, 84, 78, 84, 81, 82, 0, 82, '2025', 'OCHENTA Y DOS', 'Evaluación por porcentaje registrada', 'APROBADO', 8),
(173, '45345353', 'DPW-107', 60, 67, 64, 66, 72, 69, 67, 73, 70, 62, 72, 67, 68, 0, 68, '2025', 'SESENTA Y OCHO', 'Evaluación por porcentaje registrada', 'APROBADO', 9),
(174, '45345353', 'HDC-104', 67, 67, 67, 68, 78, 73, 66, 72, 69, 67, 73, 70, 70, 0, 70, '2025', 'SETENTA', 'Evaluación por porcentaje registrada', 'APROBADO', 6),
(175, '45345353', 'INT-103', 76, 80, 78, 83, 86, 85, 78, 84, 81, 77, 87, 82, 82, 0, 82, '2025', 'OCHENTA Y DOS', 'Evaluación por porcentaje registrada', 'APROBADO', 11),
(176, '45345353', 'MPI-101', 72, 80, 76, 76, 81, 79, 77, 83, 80, 74, 88, 81, 79, 0, 79, '2025', 'SETENTA Y NUEVE', 'Evaluación por porcentaje registrada', 'APROBADO', 2),
(177, '45345353', 'OMT-106', 79, 80, 80, 78, 87, 83, 76, 82, 79, 79, 89, 84, 82, 0, 82, '2025', 'OCHENTA Y DOS', 'Evaluación por porcentaje registrada', 'APROBADO', 6),
(178, '45345353', 'PROG-102', 75, 80, 78, 80, 82, 81, 75, 81, 78, 76, 90, 83, 80, 0, 80, '2025', 'OCHENTA', 'Evaluación por porcentaje registrada', 'APROBADO', 7),
(179, '45345353', 'TSO-105', 82, 80, 81, 82, 88, 85, 74, 80, 77, 81, 91, 86, 82, 0, 82, '2025', 'OCHENTA Y DOS', 'Evaluación por porcentaje registrada', 'APROBADO', 2),
(257, '61234567', 'ADS-306', 79, 81, 80, 77, 84, 81, 77, 87, 82, 80, 90, 85, 82, 0, 82, '2026', 'OCHENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 4),
(258, '61234567', 'BDD-308', 75, 81, 78, 79, 90, 85, 76, 86, 81, 77, 91, 84, 82, 0, 82, '2026', 'OCHENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 2),
(259, '61234567', 'DPW-302', 82, 81, 82, 81, 85, 83, 75, 85, 80, 82, 92, 87, 83, 0, 83, '2026', 'OCHENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 1),
(260, '61234567', 'EMP-301', 78, 81, 80, 83, 91, 87, 74, 84, 79, 79, 83, 81, 82, 0, 82, '2026', 'OCHENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 6),
(261, '61234567', 'GMC-303', 74, 81, 78, 76, 86, 81, 83, 83, 83, 76, 84, 80, 81, 0, 81, '2026', 'OCHENTA Y UNO', 'Evaluación por porcentaje', 'APROBADO', 1),
(262, '61234567', 'PDM-307', 81, 81, 81, 78, 92, 85, 82, 82, 82, 81, 85, 83, 83, 0, 83, '2026', 'OCHENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 5),
(263, '61234567', 'RDC-304', 77, 81, 79, 80, 87, 84, 81, 81, 81, 78, 86, 82, 82, 0, 82, '2026', 'OCHENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 3),
(264, '61234567', 'TMG-305', 73, 81, 77, 82, 82, 82, 80, 80, 80, 75, 87, 81, 80, 0, 80, '2026', 'OCHENTA', 'Evaluación por porcentaje', 'APROBADO', 1),
(265, '61234568', 'ADS-306', 75, 76, 76, 79, 83, 81, 74, 86, 80, 75, 83, 79, 79, 0, 79, '2026', 'SETENTA Y NUEVE', 'Evaluación por porcentaje', 'APROBADO', 4),
(266, '61234568', 'BDD-308', 71, 76, 74, 72, 78, 75, 73, 85, 79, 72, 84, 78, 77, 0, 77, '2026', 'SETENTA Y SIETE', 'Evaluación por porcentaje', 'APROBADO', 2),
(267, '61234568', 'DPW-302', 78, 76, 77, 74, 84, 79, 72, 84, 78, 77, 85, 81, 79, 0, 79, '2026', 'SETENTA Y NUEVE', 'Evaluación por porcentaje', 'APROBADO', 1),
(268, '61234568', 'EMP-301', 74, 76, 75, 76, 79, 78, 71, 83, 77, 74, 86, 80, 78, 0, 78, '2026', 'SETENTA Y OCHO', 'Evaluación por porcentaje', 'APROBADO', 6),
(269, '61234568', 'GMC-303', 70, 76, 73, 78, 85, 82, 70, 82, 76, 71, 87, 79, 78, 0, 78, '2026', 'SETENTA Y OCHO', 'Evaluación por porcentaje', 'APROBADO', 1),
(270, '61234568', 'PDM-307', 77, 76, 77, 71, 80, 76, 69, 81, 75, 76, 78, 77, 76, 0, 76, '2026', 'SETENTA Y SEIS', 'Evaluación por porcentaje', 'APROBADO', 5),
(271, '61234568', 'RDC-304', 73, 76, 75, 73, 86, 80, 78, 80, 79, 73, 79, 76, 78, 0, 78, '2026', 'SETENTA Y OCHO', 'Evaluación por porcentaje', 'APROBADO', 3),
(272, '61234568', 'TMG-305', 69, 76, 73, 75, 81, 78, 77, 79, 78, 70, 80, 75, 76, 0, 76, '2026', 'SETENTA Y SEIS', 'Evaluación por porcentaje', 'APROBADO', 1),
(273, '61234569', 'ADS-306', 86, 86, 86, 87, 97, 92, 86, 88, 87, 85, 91, 88, 88, 0, 88, '2026', 'OCHENTA Y OCHO', 'Evaluación por porcentaje', 'APROBADO', 4),
(274, '61234569', 'BDD-308', 82, 86, 84, 89, 92, 91, 85, 87, 86, 82, 92, 87, 87, 0, 87, '2026', 'OCHENTA Y SIETE', 'Evaluación por porcentaje', 'APROBADO', 2),
(275, '61234569', 'DPW-302', 78, 86, 82, 82, 87, 85, 84, 86, 85, 87, 93, 90, 86, 0, 86, '2026', 'OCHENTA Y SEIS', 'Evaluación por porcentaje', 'APROBADO', 1),
(276, '61234569', 'EMP-301', 85, 86, 86, 84, 93, 89, 83, 85, 84, 84, 94, 89, 87, 0, 87, '2026', 'OCHENTA Y SIETE', 'Evaluación por porcentaje', 'APROBADO', 6),
(277, '61234569', 'GMC-303', 81, 86, 84, 86, 88, 87, 82, 96, 89, 81, 95, 88, 87, 0, 87, '2026', 'OCHENTA Y SIETE', 'Evaluación por porcentaje', 'APROBADO', 1),
(278, '61234569', 'PDM-307', 88, 86, 87, 88, 94, 91, 81, 95, 88, 86, 96, 91, 89, 0, 89, '2026', 'OCHENTA Y NUEVE', 'Evaluación por porcentaje', 'APROBADO', 5),
(279, '61234569', 'RDC-304', 84, 86, 85, 81, 89, 85, 80, 94, 87, 83, 97, 90, 87, 0, 87, '2026', 'OCHENTA Y SIETE', 'Evaluación por porcentaje', 'APROBADO', 3),
(280, '61234569', 'TMG-305', 80, 86, 83, 83, 95, 89, 79, 93, 86, 80, 88, 84, 86, 0, 86, '2026', 'OCHENTA Y SEIS', 'Evaluación por porcentaje', 'APROBADO', 1),
(281, '61234570', 'ADS-306', 72, 71, 72, 70, 75, 73, 73, 77, 75, 70, 74, 72, 73, 0, 73, '2026', 'SETENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 4),
(282, '61234570', 'BDD-308', 68, 71, 70, 72, 81, 77, 72, 76, 74, 67, 75, 71, 73, 0, 73, '2026', 'SETENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 2),
(283, '61234570', 'DPW-302', 64, 71, 68, 74, 76, 75, 71, 75, 73, 72, 76, 74, 73, 0, 73, '2026', 'SETENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 1),
(284, '61234570', 'EMP-301', 71, 71, 71, 67, 82, 75, 70, 74, 72, 69, 77, 73, 73, 0, 73, '2026', 'SETENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 6),
(285, '61234570', 'GMC-303', 67, 71, 69, 69, 77, 73, 69, 73, 71, 66, 78, 72, 71, 0, 71, '2026', 'SETENTA Y UNO', 'Evaluación por porcentaje', 'APROBADO', 1),
(286, '61234570', 'PDM-307', 63, 71, 67, 71, 72, 72, 68, 72, 70, 71, 79, 75, 71, 0, 71, '2026', 'SETENTA Y UNO', 'Evaluación por porcentaje', 'APROBADO', 5),
(287, '61234570', 'RDC-304', 70, 71, 71, 73, 78, 76, 67, 71, 69, 68, 80, 74, 73, 0, 73, '2026', 'SETENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 3),
(288, '61234570', 'TMG-305', 66, 71, 69, 66, 73, 70, 66, 70, 68, 65, 81, 73, 70, 0, 70, '2026', 'SETENTA', 'Evaluación por porcentaje', 'APROBADO', 1),
(289, '61234571', 'ADS-306', 80, 78, 79, 75, 86, 81, 72, 88, 80, 77, 89, 83, 81, 0, 81, '2026', 'OCHENTA Y UNO', 'Evaluación por porcentaje', 'APROBADO', 4),
(290, '61234571', 'BDD-308', 76, 78, 77, 77, 81, 79, 71, 87, 79, 74, 80, 77, 78, 0, 78, '2026', 'SETENTA Y OCHO', 'Evaluación por porcentaje', 'APROBADO', 2),
(291, '61234571', 'DPW-302', 72, 78, 75, 79, 87, 83, 80, 86, 83, 79, 81, 80, 80, 0, 80, '2026', 'OCHENTA', 'Evaluación por porcentaje', 'APROBADO', 1),
(292, '61234571', 'EMP-301', 79, 78, 79, 81, 82, 82, 79, 85, 82, 76, 82, 79, 81, 0, 81, '2026', 'OCHENTA Y UNO', 'Evaluación por porcentaje', 'APROBADO', 6),
(293, '61234571', 'GMC-303', 75, 78, 77, 74, 88, 81, 78, 84, 81, 73, 83, 78, 79, 0, 79, '2026', 'SETENTA Y NUEVE', 'Evaluación por porcentaje', 'APROBADO', 1),
(294, '61234571', 'PDM-307', 71, 78, 75, 76, 83, 80, 77, 83, 80, 78, 84, 81, 79, 0, 79, '2026', 'SETENTA Y NUEVE', 'Evaluación por porcentaje', 'APROBADO', 5),
(295, '61234571', 'RDC-304', 78, 78, 78, 78, 89, 84, 76, 82, 79, 75, 85, 80, 80, 0, 80, '2026', 'OCHENTA', 'Evaluación por porcentaje', 'APROBADO', 3),
(296, '61234571', 'TMG-305', 74, 78, 76, 80, 84, 82, 75, 81, 78, 72, 86, 79, 79, 0, 79, '2026', 'SETENTA Y NUEVE', 'Evaluación por porcentaje', 'APROBADO', 1),
(297, '61234572', 'ADS-306', 75, 83, 79, 78, 84, 81, 79, 85, 82, 82, 92, 87, 82, 0, 82, '2026', 'OCHENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 4),
(298, '61234572', 'BDD-308', 82, 83, 83, 80, 90, 85, 78, 84, 81, 79, 93, 86, 84, 0, 84, '2026', 'OCHENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 2),
(299, '61234572', 'DPW-302', 78, 83, 81, 82, 85, 84, 77, 83, 80, 84, 94, 89, 84, 0, 84, '2026', 'OCHENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 1),
(300, '61234572', 'EMP-301', 85, 83, 84, 84, 91, 88, 76, 82, 79, 81, 85, 83, 84, 0, 84, '2026', 'OCHENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 6),
(301, '61234572', 'GMC-303', 81, 83, 82, 86, 86, 86, 85, 93, 89, 78, 86, 82, 85, 0, 85, '2026', 'OCHENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 1),
(302, '61234572', 'PDM-307', 77, 83, 80, 79, 92, 86, 84, 92, 88, 83, 87, 85, 85, 0, 85, '2026', 'OCHENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 5),
(303, '61234572', 'RDC-304', 84, 83, 84, 81, 87, 84, 83, 91, 87, 80, 88, 84, 85, 0, 85, '2026', 'OCHENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 3),
(304, '61234572', 'TMG-305', 80, 83, 82, 83, 93, 88, 82, 90, 86, 77, 89, 83, 85, 0, 85, '2026', 'OCHENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 1),
(305, '61234573', 'ADS-306', 66, 73, 70, 75, 78, 77, 71, 79, 75, 72, 80, 76, 75, 0, 75, '2026', 'SETENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 4),
(306, '61234573', 'BDD-308', 73, 73, 73, 68, 84, 76, 70, 78, 74, 69, 81, 75, 75, 0, 75, '2026', 'SETENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 2),
(307, '61234573', 'DPW-302', 69, 73, 71, 70, 79, 75, 69, 77, 73, 74, 82, 78, 74, 0, 74, '2026', 'SETENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 1),
(308, '61234573', 'EMP-301', 65, 73, 69, 72, 74, 73, 68, 76, 72, 71, 83, 77, 73, 0, 73, '2026', 'SETENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 6),
(309, '61234573', 'GMC-303', 72, 73, 73, 74, 80, 77, 67, 75, 71, 68, 84, 76, 74, 0, 74, '2026', 'SETENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 1),
(310, '61234573', 'PDM-307', 68, 73, 71, 76, 75, 76, 66, 74, 70, 73, 75, 74, 73, 0, 73, '2026', 'SETENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 5),
(311, '61234573', 'RDC-304', 75, 73, 74, 69, 81, 75, 75, 73, 74, 70, 76, 73, 74, 0, 74, '2026', 'SETENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 3),
(312, '61234573', 'TMG-305', 71, 73, 72, 71, 76, 74, 74, 72, 73, 67, 77, 72, 73, 0, 73, '2026', 'SETENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 1),
(313, '61234574', 'ADS-306', 73, 79, 76, 79, 88, 84, 79, 89, 84, 78, 84, 81, 81, 0, 81, '2026', 'OCHENTA Y UNO', 'Evaluación por porcentaje', 'APROBADO', 4),
(314, '61234574', 'BDD-308', 80, 79, 80, 81, 83, 82, 78, 88, 83, 75, 85, 80, 81, 0, 81, '2026', 'OCHENTA Y UNO', 'Evaluación por porcentaje', 'APROBADO', 2),
(315, '61234574', 'DPW-302', 76, 79, 78, 74, 89, 82, 77, 87, 82, 80, 86, 83, 81, 0, 81, '2026', 'OCHENTA Y UNO', 'Evaluación por porcentaje', 'APROBADO', 1),
(316, '61234574', 'EMP-301', 72, 79, 76, 76, 84, 80, 76, 86, 81, 77, 87, 82, 80, 0, 80, '2026', 'OCHENTA', 'Evaluación por porcentaje', 'APROBADO', 6),
(317, '61234574', 'GMC-303', 79, 79, 79, 78, 90, 84, 75, 85, 80, 74, 88, 81, 81, 0, 81, '2026', 'OCHENTA Y UNO', 'Evaluación por porcentaje', 'APROBADO', 1),
(318, '61234574', 'PDM-307', 75, 79, 77, 80, 85, 83, 74, 84, 79, 79, 89, 84, 81, 0, 81, '2026', 'OCHENTA Y UNO', 'Evaluación por porcentaje', 'APROBADO', 5),
(319, '61234574', 'RDC-304', 71, 79, 75, 82, 80, 81, 73, 83, 78, 76, 90, 83, 79, 0, 79, '2026', 'SETENTA Y NUEVE', 'Evaluación por porcentaje', 'APROBADO', 3),
(320, '61234574', 'TMG-305', 78, 79, 79, 75, 86, 81, 72, 82, 77, 73, 81, 77, 79, 0, 79, '2026', 'SETENTA Y NUEVE', 'Evaluación por porcentaje', 'APROBADO', 1),
(321, '62345671', 'ADS-206', 73, 79, 76, 69, 75, 72, 74, 72, 73, 71, 77, 74, 74, 0, 74, '2025', 'SETENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 4),
(322, '62345671', 'BDD-208', 71, 77, 74, 67, 73, 70, 76, 70, 73, 69, 75, 72, 72, 0, 72, '2025', 'SETENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 10),
(323, '62345671', 'DPW-207', 74, 80, 77, 70, 76, 73, 75, 73, 74, 72, 78, 75, 75, 0, 75, '2025', 'SETENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 1),
(324, '62345671', 'EDD-203', 70, 76, 73, 66, 72, 69, 73, 69, 71, 68, 74, 71, 71, 0, 71, '2025', 'SETENTA Y UNO', 'Evaluación por porcentaje', 'APROBADO', NULL),
(325, '62345671', 'EST-201', 72, 78, 75, 68, 74, 71, 75, 71, 73, 70, 76, 73, 73, 0, 73, '2025', 'SETENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 8),
(326, '62345671', 'PDM-205', 75, 81, 78, 71, 77, 74, 76, 74, 75, 73, 79, 76, 76, 0, 76, '2025', 'SETENTA Y SEIS', 'Evaluación por porcentaje', 'APROBADO', 7),
(327, '62345671', 'PRG-202', 71, 77, 74, 67, 73, 70, 74, 70, 72, 69, 75, 72, 72, 0, 72, '2025', 'SETENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 9),
(328, '62345671', 'RDC-204', 73, 79, 76, 69, 75, 72, 76, 72, 74, 71, 77, 74, 74, 0, 74, '2025', 'SETENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 8),
(329, '62345672', 'ADS-206', 68, 74, 71, 66, 72, 69, 70, 68, 69, 67, 73, 70, 70, 0, 70, '2025', 'SETENTA', 'Evaluación por porcentaje', 'APROBADO', 4),
(330, '62345672', 'BDD-208', 66, 72, 69, 64, 70, 67, 69, 67, 68, 65, 71, 68, 68, 0, 68, '2025', 'SESENTA Y OCHO', 'Evaluación por porcentaje', 'APROBADO', 10),
(331, '62345672', 'DPW-207', 69, 75, 72, 67, 73, 70, 71, 69, 70, 68, 74, 71, 71, 0, 71, '2025', 'SETENTA Y UNO', 'Evaluación por porcentaje', 'APROBADO', 1),
(332, '62345672', 'EDD-203', 65, 71, 68, 63, 69, 66, 68, 66, 67, 64, 70, 67, 67, 0, 67, '2025', 'SESENTA Y SIETE', 'Evaluación por porcentaje', 'APROBADO', NULL),
(333, '62345672', 'EST-201', 67, 73, 70, 65, 71, 68, 69, 67, 68, 66, 72, 69, 69, 0, 69, '2025', 'SESENTA Y NUEVE', 'Evaluación por porcentaje', 'APROBADO', 8),
(334, '62345672', 'PDM-205', 70, 76, 73, 68, 74, 71, 72, 70, 71, 69, 75, 72, 72, 0, 72, '2025', 'SETENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 7),
(335, '62345672', 'PRG-202', 66, 72, 69, 64, 70, 67, 68, 66, 67, 65, 71, 68, 68, 0, 68, '2025', 'SESENTA Y OCHO', 'Evaluación por porcentaje', 'APROBADO', 9),
(336, '62345672', 'RDC-204', 68, 74, 71, 66, 72, 69, 70, 68, 69, 67, 73, 70, 70, 0, 70, '2025', 'SETENTA', 'Evaluación por porcentaje', 'APROBADO', 8),
(337, '62345673', 'ADS-206', 71, 77, 74, 68, 74, 71, 72, 70, 71, 69, 75, 72, 72, 0, 72, '2025', 'SETENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 4),
(338, '62345673', 'BDD-208', 69, 75, 72, 67, 73, 70, 71, 69, 70, 68, 74, 71, 71, 0, 71, '2025', 'SETENTA Y UNO', 'Evaluación por porcentaje', 'APROBADO', 10),
(339, '62345673', 'DPW-207', 72, 78, 75, 69, 75, 72, 73, 71, 72, 70, 76, 73, 73, 0, 73, '2025', 'SETENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 1),
(340, '62345673', 'EDD-203', 68, 74, 71, 66, 72, 69, 70, 68, 69, 67, 73, 70, 70, 0, 70, '2025', 'SETENTA', 'Evaluación por porcentaje', 'APROBADO', NULL),
(341, '62345673', 'EST-201', 70, 76, 73, 68, 74, 71, 72, 70, 71, 69, 75, 72, 72, 0, 72, '2025', 'SETENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 8),
(342, '62345673', 'PDM-205', 73, 79, 76, 70, 76, 73, 74, 72, 73, 71, 77, 74, 74, 0, 74, '2025', 'SETENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 7),
(343, '62345673', 'PRG-202', 69, 75, 72, 67, 73, 70, 71, 69, 70, 68, 74, 71, 71, 0, 71, '2025', 'SETENTA Y UNO', 'Evaluación por porcentaje', 'APROBADO', 9),
(344, '62345673', 'RDC-204', 71, 77, 74, 68, 74, 71, 72, 70, 71, 69, 75, 72, 72, 0, 72, '2025', 'SETENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 8),
(555, '45463464', 'MPI-101', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 2),
(556, '45463464', 'PROG-102', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 7),
(557, '45463464', 'INT-103', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 11),
(558, '45463464', 'HDC-104', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 6),
(559, '45463464', 'TSO-105', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 2),
(560, '45463464', 'OMT-106', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 6),
(561, '45463464', 'DPW-107', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 9),
(562, '121232431', 'MPI-101', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 2),
(563, '121232431', 'PROG-102', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 7),
(564, '121232431', 'INT-103', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 11),
(565, '121232431', 'HDC-104', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 6),
(566, '121232431', 'TSO-105', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 2),
(567, '121232431', 'OMT-106', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 6),
(568, '121232431', 'DPW-107', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 9),
(569, '62345671', 'MPI-101', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 2),
(570, '62345671', 'PROG-102', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 7),
(571, '62345671', 'INT-103', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 11),
(572, '62345671', 'HDC-104', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 6),
(573, '62345671', 'TSO-105', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 2),
(574, '62345671', 'OMT-106', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 6),
(575, '62345671', 'DPW-107', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 9),
(576, '62345672', 'MPI-101', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 2),
(577, '62345672', 'PROG-102', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 7),
(578, '62345672', 'INT-103', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 11),
(579, '62345672', 'HDC-104', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 6),
(580, '62345672', 'TSO-105', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 2),
(581, '62345672', 'OMT-106', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 6),
(582, '62345672', 'DPW-107', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 9),
(583, '62345673', 'MPI-101', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 2),
(584, '62345673', 'PROG-102', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 7),
(585, '62345673', 'INT-103', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 11),
(586, '62345673', 'HDC-104', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 6),
(587, '62345673', 'TSO-105', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 2),
(588, '62345673', 'OMT-106', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 6),
(589, '62345673', 'DPW-107', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024', 'CONVALIDADO', 'CONVALIDADO', 'APROBADO', 9),
(597, '61234567', 'MPI-101', 78, 76, 77, 77, 84, 81, 72, 78, 75, 71, 85, 78, 78, 0, 78, '2024', 'SETENTA Y OCHO', 'Evaluación por porcentaje', 'APROBADO', 2),
(598, '61234567', 'PROG-102', 74, 76, 75, 79, 79, 79, 71, 77, 74, 76, 86, 81, 77, 0, 77, '2024', 'SETENTA Y SIETE', 'Evaluación por porcentaje', 'APROBADO', 7),
(599, '61234567', 'INT-103', 70, 76, 73, 72, 85, 79, 70, 76, 73, 73, 87, 80, 76, 0, 76, '2024', 'SETENTA Y SEIS', 'Evaluación por porcentaje', 'APROBADO', 11),
(600, '61234567', 'HDC-104', 77, 76, 77, 74, 80, 77, 69, 75, 72, 70, 78, 74, 75, 0, 75, '2024', 'SETENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 6),
(601, '61234567', 'TSO-105', 73, 76, 75, 76, 86, 81, 78, 86, 82, 75, 79, 77, 79, 0, 79, '2024', 'SETENTA Y NUEVE', 'Evaluación por porcentaje', 'APROBADO', 2),
(602, '61234567', 'OMT-106', 69, 76, 73, 78, 81, 80, 77, 85, 81, 72, 80, 76, 78, 0, 78, '2024', 'SETENTA Y OCHO', 'Evaluación por porcentaje', 'APROBADO', 6),
(603, '61234567', 'DPW-107', 76, 76, 76, 71, 87, 79, 76, 84, 80, 77, 81, 79, 79, 0, 79, '2024', 'SETENTA Y NUEVE', 'Evaluación por porcentaje', 'APROBADO', 9),
(604, '61234568', 'MPI-101', 67, 71, 69, 68, 77, 73, 70, 78, 74, 69, 77, 73, 72, 0, 72, '2024', 'SETENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 2),
(605, '61234568', 'PROG-102', 63, 71, 67, 70, 72, 71, 69, 77, 73, 66, 78, 72, 71, 0, 71, '2024', 'SETENTA Y UNO', 'Evaluación por porcentaje', 'APROBADO', 7),
(606, '61234568', 'INT-103', 70, 71, 71, 72, 78, 75, 68, 76, 72, 71, 79, 75, 73, 0, 73, '2024', 'SETENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 11),
(607, '61234568', 'HDC-104', 66, 71, 69, 74, 73, 74, 67, 75, 71, 68, 80, 74, 72, 0, 72, '2024', 'SETENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 6),
(608, '61234568', 'TSO-105', 73, 71, 72, 67, 79, 73, 66, 74, 70, 65, 81, 73, 72, 0, 72, '2024', 'SETENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 2),
(609, '61234568', 'OMT-106', 69, 71, 70, 69, 74, 72, 65, 73, 69, 70, 82, 76, 72, 0, 72, '2024', 'SETENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 6),
(610, '61234568', 'DPW-107', 65, 71, 68, 71, 80, 76, 64, 72, 68, 67, 73, 70, 71, 0, 71, '2024', 'SETENTA Y UNO', 'Evaluación por porcentaje', 'APROBADO', 9),
(611, '61234569', 'MPI-101', 82, 81, 82, 83, 85, 84, 83, 81, 82, 82, 84, 83, 83, 0, 83, '2024', 'OCHENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 2),
(612, '61234569', 'PROG-102', 78, 81, 80, 76, 91, 84, 82, 80, 81, 79, 85, 82, 82, 0, 82, '2024', 'OCHENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 7),
(613, '61234569', 'INT-103', 74, 81, 78, 78, 86, 82, 81, 91, 86, 76, 86, 81, 82, 0, 82, '2024', 'OCHENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 11),
(614, '61234569', 'HDC-104', 81, 81, 81, 80, 92, 86, 80, 90, 85, 81, 87, 84, 84, 0, 84, '2024', 'OCHENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 6),
(615, '61234569', 'TSO-105', 77, 81, 79, 82, 87, 85, 79, 89, 84, 78, 88, 83, 83, 0, 83, '2024', 'OCHENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 2),
(616, '61234569', 'OMT-106', 73, 81, 77, 84, 82, 83, 78, 88, 83, 75, 89, 82, 81, 0, 81, '2024', 'OCHENTA Y UNO', 'Evaluación por porcentaje', 'APROBADO', 6),
(617, '61234569', 'DPW-107', 80, 81, 81, 77, 88, 83, 77, 87, 82, 80, 90, 85, 83, 0, 83, '2024', 'OCHENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 9),
(618, '61234570', 'MPI-101', 63, 68, 66, 66, 70, 68, 63, 73, 68, 64, 78, 71, 68, 0, 68, '2024', 'SESENTA Y OCHO', 'Evaluación por porcentaje', 'APROBADO', 2),
(619, '61234570', 'PROG-102', 70, 68, 69, 68, 76, 72, 62, 72, 67, 69, 79, 74, 71, 0, 71, '2024', 'SETENTA Y UNO', 'Evaluación por porcentaje', 'APROBADO', 7),
(620, '61234570', 'INT-103', 66, 68, 67, 70, 71, 71, 61, 71, 66, 66, 70, 68, 68, 0, 68, '2024', 'SESENTA Y OCHO', 'Evaluación por porcentaje', 'APROBADO', 11),
(621, '61234570', 'HDC-104', 62, 68, 65, 63, 77, 70, 70, 70, 70, 63, 71, 67, 68, 0, 68, '2024', 'SESENTA Y OCHO', 'Evaluación por porcentaje', 'APROBADO', 6),
(622, '61234570', 'TSO-105', 69, 68, 69, 65, 72, 69, 69, 69, 69, 68, 72, 70, 69, 0, 69, '2024', 'SESENTA Y NUEVE', 'Evaluación por porcentaje', 'APROBADO', 2),
(623, '61234570', 'OMT-106', 65, 68, 67, 67, 78, 73, 68, 68, 68, 65, 73, 69, 69, 0, 69, '2024', 'SESENTA Y NUEVE', 'Evaluación por porcentaje', 'APROBADO', 6),
(624, '61234570', 'DPW-107', 61, 68, 65, 69, 73, 71, 67, 67, 67, 62, 74, 68, 68, 0, 68, '2024', 'SESENTA Y OCHO', 'Evaluación por porcentaje', 'APROBADO', 9);
INSERT INTO `historial` (`id`, `ci_est`, `cod_asig`, `nota_teorico1`, `nota_pract1`, `nota_primerbim`, `nota_teorico2`, `nota_pract2`, `nota_segundobim`, `nota_teorico3`, `nota_pract3`, `nota_tercerbim`, `nota_teorico4`, `nota_pract4`, `nota_cuartobim`, `nota_parcial`, `segundo_turno`, `TotalAnual`, `gestion`, `literal`, `observaciones`, `estado`, `id_docente`) VALUES
(625, '61234571', 'MPI-101', 78, 78, 78, 81, 89, 85, 76, 88, 82, 77, 85, 81, 82, 0, 82, '2024', 'OCHENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 2),
(626, '61234571', 'PROG-102', 74, 78, 76, 74, 84, 79, 75, 87, 81, 74, 86, 80, 79, 0, 79, '2024', 'SETENTA Y NUEVE', 'Evaluación por porcentaje', 'APROBADO', 7),
(627, '61234571', 'INT-103', 70, 78, 74, 76, 79, 78, 74, 86, 80, 79, 87, 83, 79, 0, 79, '2024', 'SETENTA Y NUEVE', 'Evaluación por porcentaje', 'APROBADO', 11),
(628, '61234571', 'HDC-104', 77, 78, 78, 78, 85, 82, 73, 85, 79, 76, 88, 82, 80, 0, 80, '2024', 'OCHENTA', 'Evaluación por porcentaje', 'APROBADO', 6),
(629, '61234571', 'TSO-105', 73, 78, 76, 80, 80, 80, 72, 84, 78, 73, 89, 81, 79, 0, 79, '2024', 'SETENTA Y NUEVE', 'Evaluación por porcentaje', 'APROBADO', 2),
(630, '61234571', 'OMT-106', 80, 78, 79, 73, 86, 80, 71, 83, 77, 78, 80, 79, 79, 0, 79, '2024', 'SETENTA Y NUEVE', 'Evaluación por porcentaje', 'APROBADO', 6),
(631, '61234571', 'DPW-107', 76, 78, 77, 75, 81, 78, 80, 82, 81, 75, 81, 78, 79, 0, 79, '2024', 'SETENTA Y NUEVE', 'Evaluación por porcentaje', 'APROBADO', 9),
(632, '61234572', 'MPI-101', 77, 83, 80, 82, 92, 87, 84, 86, 85, 77, 87, 82, 84, 0, 84, '2024', 'OCHENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 2),
(633, '61234572', 'PROG-102', 84, 83, 84, 84, 87, 86, 83, 85, 84, 82, 88, 85, 85, 0, 85, '2024', 'OCHENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 7),
(634, '61234572', 'INT-103', 80, 83, 82, 86, 93, 90, 82, 84, 83, 79, 89, 84, 85, 0, 85, '2024', 'OCHENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 11),
(635, '61234572', 'HDC-104', 76, 83, 80, 79, 88, 84, 81, 83, 82, 84, 90, 87, 83, 0, 83, '2024', 'OCHENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 6),
(636, '61234572', 'TSO-105', 83, 83, 83, 81, 94, 88, 80, 82, 81, 81, 91, 86, 85, 0, 85, '2024', 'OCHENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 2),
(637, '61234572', 'OMT-106', 79, 83, 81, 83, 89, 86, 79, 93, 86, 78, 92, 85, 85, 0, 85, '2024', 'OCHENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 6),
(638, '61234572', 'DPW-107', 75, 83, 79, 85, 84, 85, 78, 92, 85, 83, 93, 88, 84, 0, 84, '2024', 'OCHENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 9),
(639, '61234573', 'MPI-101', 72, 73, 73, 68, 80, 74, 67, 81, 74, 70, 84, 77, 75, 0, 75, '2024', 'SETENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 2),
(640, '61234573', 'PROG-102', 68, 73, 71, 70, 75, 73, 66, 80, 73, 67, 75, 71, 72, 0, 72, '2024', 'SETENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 7),
(641, '61234573', 'INT-103', 75, 73, 74, 72, 81, 77, 75, 79, 77, 72, 76, 74, 76, 0, 76, '2024', 'SETENTA Y SEIS', 'Evaluación por porcentaje', 'APROBADO', 11),
(642, '61234573', 'HDC-104', 71, 73, 72, 74, 76, 75, 74, 78, 76, 69, 77, 73, 74, 0, 74, '2024', 'SETENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 6),
(643, '61234573', 'TSO-105', 67, 73, 70, 76, 82, 79, 73, 77, 75, 74, 78, 76, 75, 0, 75, '2024', 'SETENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 2),
(644, '61234573', 'OMT-106', 74, 73, 74, 69, 77, 73, 72, 76, 74, 71, 79, 75, 74, 0, 74, '2024', 'SETENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 6),
(645, '61234573', 'DPW-107', 70, 73, 72, 71, 83, 77, 71, 75, 73, 68, 80, 74, 74, 0, 74, '2024', 'SETENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 9),
(646, '61234574', 'MPI-101', 72, 79, 76, 79, 84, 82, 76, 80, 78, 79, 87, 83, 80, 0, 80, '2024', 'OCHENTA', 'Evaluación por porcentaje', 'APROBADO', 2),
(647, '61234574', 'PROG-102', 79, 79, 79, 81, 90, 86, 75, 79, 77, 76, 88, 82, 81, 0, 81, '2024', 'OCHENTA Y UNO', 'Evaluación por porcentaje', 'APROBADO', 7),
(648, '61234574', 'INT-103', 75, 79, 77, 74, 85, 80, 74, 78, 76, 73, 89, 81, 79, 0, 79, '2024', 'SETENTA Y NUEVE', 'Evaluación por porcentaje', 'APROBADO', 11),
(649, '61234574', 'HDC-104', 71, 79, 75, 76, 80, 78, 73, 89, 81, 78, 90, 84, 80, 0, 80, '2024', 'OCHENTA', 'Evaluación por porcentaje', 'APROBADO', 6),
(650, '61234574', 'TSO-105', 78, 79, 79, 78, 86, 82, 72, 88, 80, 75, 81, 78, 80, 0, 80, '2024', 'OCHENTA', 'Evaluación por porcentaje', 'APROBADO', 2),
(651, '61234574', 'OMT-106', 74, 79, 77, 80, 81, 81, 81, 87, 84, 80, 82, 81, 81, 0, 81, '2024', 'OCHENTA Y UNO', 'Evaluación por porcentaje', 'APROBADO', 6),
(652, '61234574', 'DPW-107', 81, 79, 80, 82, 87, 85, 80, 86, 83, 77, 83, 80, 82, 0, 82, '2024', 'OCHENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 9),
(653, '61234567', 'ADS-206', 76, 78, 77, 74, 81, 78, 78, 84, 81, 73, 83, 78, 79, 0, 79, '2025', 'SETENTA Y NUEVE', 'Evaluación por porcentaje', 'APROBADO', 4),
(654, '61234567', 'BDD-208', 72, 78, 75, 76, 87, 82, 77, 83, 80, 78, 84, 81, 80, 0, 80, '2025', 'OCHENTA', 'Evaluación por porcentaje', 'APROBADO', 10),
(655, '61234567', 'DPW-207', 79, 78, 79, 78, 82, 80, 76, 82, 79, 75, 85, 80, 80, 0, 80, '2025', 'OCHENTA', 'Evaluación por porcentaje', 'APROBADO', 1),
(656, '61234567', 'EDD-203', 75, 78, 77, 80, 88, 84, 75, 81, 78, 72, 86, 79, 80, 0, 80, '2025', 'OCHENTA', 'Evaluación por porcentaje', 'APROBADO', NULL),
(657, '61234567', 'EST-201', 71, 78, 75, 73, 83, 78, 74, 80, 77, 77, 87, 82, 78, 0, 78, '2025', 'SETENTA Y OCHO', 'Evaluación por porcentaje', 'APROBADO', 8),
(658, '61234567', 'PDM-205', 78, 78, 78, 75, 89, 82, 73, 79, 76, 74, 88, 81, 79, 0, 79, '2025', 'SETENTA Y NUEVE', 'Evaluación por porcentaje', 'APROBADO', 7),
(659, '61234567', 'PRG-202', 74, 78, 76, 77, 84, 81, 72, 78, 75, 79, 89, 84, 79, 0, 79, '2025', 'SETENTA Y NUEVE', 'Evaluación por porcentaje', 'APROBADO', 9),
(660, '61234567', 'RDC-204', 70, 78, 74, 79, 79, 79, 71, 77, 74, 76, 80, 78, 76, 0, 76, '2025', 'SETENTA Y SEIS', 'Evaluación por porcentaje', 'APROBADO', 8),
(661, '61234568', 'ADS-206', 72, 73, 73, 76, 80, 78, 75, 83, 79, 68, 76, 72, 76, 0, 76, '2025', 'SETENTA Y SEIS', 'Evaluación por porcentaje', 'APROBADO', 4),
(662, '61234568', 'BDD-208', 68, 73, 71, 69, 75, 72, 74, 82, 78, 73, 77, 75, 74, 0, 74, '2025', 'SETENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 10),
(663, '61234568', 'DPW-207', 75, 73, 74, 71, 81, 76, 73, 81, 77, 70, 78, 74, 75, 0, 75, '2025', 'SETENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 1),
(664, '61234568', 'EDD-203', 71, 73, 72, 73, 76, 75, 72, 80, 76, 67, 79, 73, 74, 0, 74, '2025', 'SETENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', NULL),
(665, '61234568', 'EST-201', 67, 73, 70, 75, 82, 79, 71, 79, 75, 72, 80, 76, 75, 0, 75, '2025', 'SETENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 8),
(666, '61234568', 'PDM-205', 74, 73, 74, 68, 77, 73, 70, 78, 74, 69, 81, 75, 74, 0, 74, '2025', 'SETENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 7),
(667, '61234568', 'PRG-202', 70, 73, 72, 70, 83, 77, 69, 77, 73, 74, 82, 78, 75, 0, 75, '2025', 'SETENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 9),
(668, '61234568', 'RDC-204', 66, 73, 70, 72, 78, 75, 68, 76, 72, 71, 83, 77, 74, 0, 74, '2025', 'SETENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 8),
(669, '61234569', 'ADS-206', 86, 86, 86, 87, 97, 92, 80, 88, 84, 81, 97, 89, 88, 0, 88, '2025', 'OCHENTA Y OCHO', 'Evaluación por porcentaje', 'APROBADO', 4),
(670, '61234569', 'BDD-208', 82, 86, 84, 89, 92, 91, 79, 87, 83, 86, 88, 87, 86, 0, 86, '2025', 'OCHENTA Y SEIS', 'Evaluación por porcentaje', 'APROBADO', 10),
(671, '61234569', 'DPW-207', 78, 86, 82, 82, 87, 85, 88, 86, 87, 83, 89, 86, 85, 0, 85, '2025', 'OCHENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 1),
(672, '61234569', 'EDD-203', 85, 86, 86, 84, 93, 89, 87, 85, 86, 80, 90, 85, 87, 0, 87, '2025', 'OCHENTA Y SIETE', 'Evaluación por porcentaje', 'APROBADO', NULL),
(673, '61234569', 'EST-201', 81, 86, 84, 86, 88, 87, 86, 96, 91, 85, 91, 88, 88, 0, 88, '2025', 'OCHENTA Y OCHO', 'Evaluación por porcentaje', 'APROBADO', 8),
(674, '61234569', 'PDM-205', 88, 86, 87, 88, 94, 91, 85, 95, 90, 82, 92, 87, 89, 0, 89, '2025', 'OCHENTA Y NUEVE', 'Evaluación por porcentaje', 'APROBADO', 7),
(675, '61234569', 'PRG-202', 84, 86, 85, 81, 89, 85, 84, 94, 89, 87, 93, 90, 87, 0, 87, '2025', 'OCHENTA Y SIETE', 'Evaluación por porcentaje', 'APROBADO', 9),
(676, '61234569', 'RDC-204', 80, 86, 83, 83, 95, 89, 83, 93, 88, 84, 94, 89, 87, 0, 87, '2025', 'OCHENTA Y SIETE', 'Evaluación por porcentaje', 'APROBADO', 8),
(677, '61234570', 'ADS-206', 72, 71, 72, 70, 75, 73, 67, 77, 72, 66, 80, 73, 73, 0, 73, '2025', 'SETENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 4),
(678, '61234570', 'BDD-208', 68, 71, 70, 72, 81, 77, 66, 76, 71, 71, 81, 76, 74, 0, 74, '2025', 'SETENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 10),
(679, '61234570', 'DPW-207', 64, 71, 68, 74, 76, 75, 65, 75, 70, 68, 82, 75, 72, 0, 72, '2025', 'SETENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 1),
(680, '61234570', 'EDD-203', 71, 71, 71, 67, 82, 75, 64, 74, 69, 65, 73, 69, 71, 0, 71, '2025', 'SETENTA Y UNO', 'Evaluación por porcentaje', 'APROBADO', NULL),
(681, '61234570', 'EST-201', 67, 71, 69, 69, 77, 73, 73, 73, 73, 70, 74, 72, 72, 0, 72, '2025', 'SETENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 8),
(682, '61234570', 'PDM-205', 63, 71, 67, 71, 72, 72, 72, 72, 72, 67, 75, 71, 71, 0, 71, '2025', 'SETENTA Y UNO', 'Evaluación por porcentaje', 'APROBADO', 7),
(683, '61234570', 'PRG-202', 70, 71, 71, 73, 78, 76, 71, 71, 71, 72, 76, 74, 73, 0, 73, '2025', 'SETENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 9),
(684, '61234570', 'RDC-204', 66, 71, 69, 66, 73, 70, 70, 70, 70, 69, 77, 73, 71, 0, 71, '2025', 'SETENTA Y UNO', 'Evaluación por porcentaje', 'APROBADO', 8),
(685, '61234571', 'ADS-206', 83, 81, 82, 78, 89, 84, 79, 91, 85, 76, 88, 82, 83, 0, 83, '2025', 'OCHENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 4),
(686, '61234571', 'BDD-208', 79, 81, 80, 80, 84, 82, 78, 90, 84, 81, 89, 85, 83, 0, 83, '2025', 'OCHENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 10),
(687, '61234571', 'DPW-207', 75, 81, 78, 82, 90, 86, 77, 89, 83, 78, 90, 84, 83, 0, 83, '2025', 'OCHENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 1),
(688, '61234571', 'EDD-203', 82, 81, 82, 84, 85, 85, 76, 88, 82, 75, 91, 83, 83, 0, 83, '2025', 'OCHENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', NULL),
(689, '61234571', 'EST-201', 78, 81, 80, 77, 91, 84, 75, 87, 81, 80, 92, 86, 83, 0, 83, '2025', 'OCHENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 8),
(690, '61234571', 'PDM-205', 74, 81, 78, 79, 86, 83, 74, 86, 80, 77, 83, 80, 80, 0, 80, '2025', 'OCHENTA', 'Evaluación por porcentaje', 'APROBADO', 7),
(691, '61234571', 'PRG-202', 81, 81, 81, 81, 92, 87, 83, 85, 84, 82, 84, 83, 84, 0, 84, '2025', 'OCHENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 9),
(692, '61234571', 'RDC-204', 77, 81, 79, 83, 87, 85, 82, 84, 83, 79, 85, 82, 82, 0, 82, '2025', 'OCHENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 8),
(693, '61234572', 'ADS-206', 75, 83, 79, 78, 84, 81, 83, 85, 84, 78, 88, 83, 82, 0, 82, '2025', 'OCHENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 4),
(694, '61234572', 'BDD-208', 82, 83, 83, 80, 90, 85, 82, 84, 83, 83, 89, 86, 84, 0, 84, '2025', 'OCHENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 10),
(695, '61234572', 'DPW-207', 78, 83, 81, 82, 85, 84, 81, 83, 82, 80, 90, 85, 83, 0, 83, '2025', 'OCHENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 1),
(696, '61234572', 'EDD-203', 85, 83, 84, 84, 91, 88, 80, 82, 81, 77, 91, 84, 84, 0, 84, '2025', 'OCHENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', NULL),
(697, '61234572', 'EST-201', 81, 83, 82, 86, 86, 86, 79, 93, 86, 82, 92, 87, 85, 0, 85, '2025', 'OCHENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 8),
(698, '61234572', 'PDM-205', 77, 83, 80, 79, 92, 86, 78, 92, 85, 79, 93, 86, 84, 0, 84, '2025', 'OCHENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 7),
(699, '61234572', 'PRG-202', 84, 83, 84, 81, 87, 84, 77, 91, 84, 84, 94, 89, 85, 0, 85, '2025', 'OCHENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 9),
(700, '61234572', 'RDC-204', 80, 83, 82, 83, 93, 88, 76, 90, 83, 81, 85, 83, 84, 0, 84, '2025', 'OCHENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 8),
(701, '61234573', 'ADS-206', 69, 76, 73, 78, 81, 80, 78, 82, 80, 71, 79, 75, 77, 0, 77, '2025', 'SETENTA Y SIETE', 'Evaluación por porcentaje', 'APROBADO', 4),
(702, '61234573', 'BDD-208', 76, 76, 76, 71, 87, 79, 77, 81, 79, 76, 80, 78, 78, 0, 78, '2025', 'SETENTA Y OCHO', 'Evaluación por porcentaje', 'APROBADO', 10),
(703, '61234573', 'DPW-207', 72, 76, 74, 73, 82, 78, 76, 80, 78, 73, 81, 77, 77, 0, 77, '2025', 'SETENTA Y SIETE', 'Evaluación por porcentaje', 'APROBADO', 1),
(704, '61234573', 'EDD-203', 68, 76, 72, 75, 77, 76, 75, 79, 77, 70, 82, 76, 75, 0, 75, '2025', 'SETENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', NULL),
(705, '61234573', 'EST-201', 75, 76, 76, 77, 83, 80, 74, 78, 76, 75, 83, 79, 78, 0, 78, '2025', 'SETENTA Y OCHO', 'Evaluación por porcentaje', 'APROBADO', 8),
(706, '61234573', 'PDM-205', 71, 76, 74, 79, 78, 79, 73, 77, 75, 72, 84, 78, 77, 0, 77, '2025', 'SETENTA Y SIETE', 'Evaluación por porcentaje', 'APROBADO', 7),
(707, '61234573', 'PRG-202', 78, 76, 77, 72, 84, 78, 72, 76, 74, 77, 85, 81, 78, 0, 78, '2025', 'SETENTA Y OCHO', 'Evaluación por porcentaje', 'APROBADO', 9),
(708, '61234573', 'RDC-204', 74, 76, 75, 74, 79, 77, 71, 75, 73, 74, 86, 80, 76, 0, 76, '2025', 'SETENTA Y SEIS', 'Evaluación por porcentaje', 'APROBADO', 8),
(709, '61234574', 'ADS-206', 75, 81, 78, 81, 90, 86, 75, 91, 83, 76, 92, 84, 83, 0, 83, '2025', 'OCHENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 4),
(710, '61234574', 'BDD-208', 82, 81, 82, 83, 85, 84, 74, 90, 82, 81, 83, 82, 83, 0, 83, '2025', 'OCHENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 10),
(711, '61234574', 'DPW-207', 78, 81, 80, 76, 91, 84, 83, 89, 86, 78, 84, 81, 83, 0, 83, '2025', 'OCHENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 1),
(712, '61234574', 'EDD-203', 74, 81, 78, 78, 86, 82, 82, 88, 85, 75, 85, 80, 81, 0, 81, '2025', 'OCHENTA Y UNO', 'Evaluación por porcentaje', 'APROBADO', NULL),
(713, '61234574', 'EST-201', 81, 81, 81, 80, 92, 86, 81, 87, 84, 80, 86, 83, 84, 0, 84, '2025', 'OCHENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 8),
(714, '61234574', 'PDM-205', 77, 81, 79, 82, 87, 85, 80, 86, 83, 77, 87, 82, 82, 0, 82, '2025', 'OCHENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 7),
(715, '61234574', 'PRG-202', 73, 81, 77, 84, 82, 83, 79, 85, 82, 82, 88, 85, 82, 0, 82, '2025', 'OCHENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 9),
(716, '61234574', 'RDC-204', 80, 81, 81, 77, 88, 83, 78, 84, 81, 79, 89, 84, 82, 0, 82, '2025', 'OCHENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 8),
(717, '62345671', 'ADS-306', 74, 79, 77, 76, 82, 79, 73, 80, 77, 75, 81, 78, 78, 0, 78, '2026', 'SETENTA Y OCHO', 'Evaluación por porcentaje', 'APROBADO', 4),
(718, '62345671', 'BDD-308', 72, 77, 75, 74, 80, 77, 71, 78, 75, 73, 79, 76, 76, 0, 76, '2026', 'SETENTA Y SEIS', 'Evaluación por porcentaje', 'APROBADO', 2),
(719, '62345671', 'DPW-302', 76, 81, 79, 78, 84, 81, 75, 82, 79, 77, 83, 80, 80, 0, 80, '2026', 'OCHENTA', 'Evaluación por porcentaje', 'APROBADO', 1),
(720, '62345671', 'EMP-301', 73, 78, 76, 75, 81, 78, 72, 79, 76, 74, 80, 77, 77, 0, 77, '2026', 'SETENTA Y SIETE', 'Evaluación por porcentaje', 'APROBADO', 6),
(721, '62345671', 'GMC-303', 71, 76, 74, 73, 79, 76, 70, 77, 74, 72, 78, 75, 75, 0, 75, '2026', 'SETENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 1),
(722, '62345671', 'PDM-307', 75, 80, 78, 77, 83, 80, 74, 81, 78, 76, 82, 79, 79, 0, 79, '2026', 'SETENTA Y NUEVE', 'Evaluación por porcentaje', 'APROBADO', 5),
(723, '62345671', 'RDC-304', 73, 78, 76, 75, 81, 78, 72, 79, 76, 74, 80, 77, 77, 0, 77, '2026', 'SETENTA Y SIETE', 'Evaluación por porcentaje', 'APROBADO', 3),
(724, '62345671', 'TMG-305', 74, 79, 77, 76, 82, 79, 73, 80, 77, 75, 81, 78, 78, 0, 78, '2026', 'SETENTA Y OCHO', 'Evaluación por porcentaje', 'APROBADO', 1),
(725, '62345672', 'ADS-306', 70, 75, 73, 68, 74, 71, 72, 78, 75, 69, 76, 73, 73, 0, 73, '2026', 'SETENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 4),
(726, '62345672', 'BDD-308', 68, 73, 71, 66, 72, 69, 70, 76, 73, 67, 74, 71, 71, 0, 71, '2026', 'SETENTA Y UNO', 'Evaluación por porcentaje', 'APROBADO', 2),
(727, '62345672', 'DPW-302', 72, 77, 75, 70, 76, 73, 74, 80, 77, 71, 78, 75, 75, 0, 75, '2026', 'SETENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 1),
(728, '62345672', 'EMP-301', 69, 74, 72, 67, 73, 70, 71, 77, 74, 68, 75, 72, 72, 0, 72, '2026', 'SETENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 6),
(729, '62345672', 'GMC-303', 67, 72, 70, 65, 71, 68, 69, 75, 72, 66, 73, 70, 70, 0, 70, '2026', 'SETENTA', 'Evaluación por porcentaje', 'APROBADO', 1),
(730, '62345672', 'PDM-307', 71, 76, 74, 69, 75, 72, 73, 79, 76, 70, 77, 74, 74, 0, 74, '2026', 'SETENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 5),
(731, '62345672', 'RDC-304', 69, 74, 72, 67, 73, 70, 71, 77, 74, 68, 75, 72, 72, 0, 72, '2026', 'SETENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 3),
(732, '62345672', 'TMG-305', 70, 75, 73, 68, 74, 71, 72, 78, 75, 69, 76, 73, 73, 0, 73, '2026', 'SETENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 1),
(733, '62345673', 'ADS-306', 72, 77, 75, 70, 76, 73, 74, 80, 77, 71, 78, 75, 75, 0, 75, '2026', 'SETENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 4),
(734, '62345673', 'BDD-308', 70, 75, 73, 68, 74, 71, 72, 78, 75, 69, 76, 73, 73, 0, 73, '2026', 'SETENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 2),
(735, '62345673', 'DPW-302', 74, 79, 77, 72, 78, 75, 76, 82, 79, 73, 80, 77, 77, 0, 77, '2026', 'SETENTA Y SIETE', 'Evaluación por porcentaje', 'APROBADO', 1),
(736, '62345673', 'EMP-301', 71, 76, 74, 69, 75, 72, 73, 79, 76, 70, 77, 74, 74, 0, 74, '2026', 'SETENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 6),
(737, '62345673', 'GMC-303', 69, 74, 72, 67, 73, 70, 71, 77, 74, 68, 75, 72, 72, 0, 72, '2026', 'SETENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 1),
(738, '62345673', 'PDM-307', 73, 78, 76, 71, 77, 74, 75, 81, 78, 72, 79, 76, 76, 0, 76, '2026', 'SETENTA Y SEIS', 'Evaluación por porcentaje', 'APROBADO', 5),
(739, '62345673', 'RDC-304', 71, 76, 74, 69, 75, 72, 73, 79, 76, 70, 77, 74, 74, 0, 74, '2026', 'SETENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 3),
(740, '62345673', 'TMG-305', 72, 77, 75, 70, 76, 73, 74, 80, 77, 71, 78, 75, 75, 0, 75, '2026', 'SETENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 1),
(813, '2736233', 'ADS-206', 65, 70, 68, 66, 72, 69, 64, 71, 68, 63, 73, 68, 68, 0, 68, '2026', 'SESENTA Y OCHO', 'Repetición 2do año', 'APROBADO', 4),
(814, '2736233', 'BDD-208', 63, 68, 66, 64, 70, 67, 62, 69, 66, 61, 71, 66, 66, 0, 66, '2026', 'SESENTA Y SEIS', 'Repetición 2do año', 'APROBADO', 10),
(815, '2736233', 'DPW-207', 67, 72, 70, 68, 74, 71, 66, 73, 70, 65, 75, 70, 70, 0, 70, '2026', 'SETENTA', 'Repetición 2do año', 'APROBADO', 1),
(816, '2736233', 'EDD-203', 64, 69, 67, 65, 71, 68, 63, 70, 67, 62, 72, 67, 67, 0, 67, '2026', 'SESENTA Y SIETE', 'Repetición 2do año', 'APROBADO', NULL),
(817, '2736233', 'EST-201', 62, 67, 65, 63, 69, 66, 61, 68, 65, 60, 70, 65, 65, 0, 65, '2026', 'SESENTA Y CINCO', 'Repetición 2do año', 'APROBADO', 8),
(818, '2736233', 'PDM-205', 66, 71, 69, 67, 73, 70, 65, 72, 69, 64, 74, 69, 69, 0, 69, '2026', 'SESENTA Y NUEVE', 'Repetición 2do año', 'APROBADO', 7),
(819, '2736233', 'PRG-202', 63, 68, 66, 64, 70, 67, 62, 69, 66, 61, 71, 66, 66, 0, 66, '2026', 'SESENTA Y SEIS', 'Repetición 2do año', 'APROBADO', 9),
(820, '2736233', 'RDC-204', 65, 70, 68, 66, 72, 69, 64, 71, 68, 63, 73, 68, 68, 0, 68, '2026', 'SESENTA Y OCHO', 'Repetición 2do año', 'APROBADO', 8),
(821, '7685675', 'ADS-206', 76, 82, 79, 74, 84, 79, 77, 85, 81, 76, 83, 80, 80, 0, 80, '2025', 'OCHENTA', 'Evaluación por porcentaje', 'APROBADO', 4),
(822, '7685675', 'BDD-208', 74, 80, 77, 72, 82, 77, 75, 83, 79, 74, 81, 78, 78, 0, 78, '2025', 'SETENTA Y OCHO', 'Evaluación por porcentaje', 'APROBADO', 10),
(823, '7685675', 'DPW-207', 78, 84, 81, 76, 86, 81, 79, 87, 83, 78, 85, 82, 82, 0, 82, '2025', 'OCHENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 1),
(824, '7685675', 'EDD-203', 72, 78, 75, 70, 80, 75, 73, 81, 77, 72, 79, 76, 76, 0, 76, '2025', 'SETENTA Y SEIS', 'Evaluación por porcentaje', 'APROBADO', NULL),
(825, '7685675', 'EST-201', 77, 83, 80, 75, 85, 80, 78, 86, 82, 77, 84, 81, 81, 0, 81, '2025', 'OCHENTA Y UNO', 'Evaluación por porcentaje', 'APROBADO', 8),
(826, '7685675', 'PDM-205', 75, 81, 78, 73, 83, 78, 76, 84, 80, 75, 82, 79, 79, 0, 79, '2025', 'SETENTA Y NUEVE', 'Evaluación por porcentaje', 'APROBADO', 7),
(827, '7685675', 'PRG-202', 79, 85, 82, 77, 87, 82, 80, 88, 84, 79, 86, 83, 83, 0, 83, '2025', 'OCHENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 9),
(828, '7685675', 'RDC-204', 73, 79, 76, 71, 81, 76, 74, 82, 78, 73, 80, 77, 77, 0, 77, '2025', 'SETENTA Y SIETE', 'Evaluación por porcentaje', 'APROBADO', 8),
(829, '12345678', 'ADS-206', 80, 85, 83, 78, 87, 83, 81, 88, 85, 80, 86, 83, 83, 0, 83, '2025', 'OCHENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 4),
(830, '12345678', 'BDD-208', 78, 83, 81, 76, 85, 81, 79, 86, 83, 78, 84, 81, 81, 0, 81, '2025', 'OCHENTA Y UNO', 'Evaluación por porcentaje', 'APROBADO', 10),
(831, '12345678', 'DPW-207', 82, 87, 85, 80, 89, 85, 83, 90, 87, 82, 88, 85, 85, 0, 85, '2025', 'OCHENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 1),
(832, '12345678', 'EDD-203', 76, 81, 79, 74, 83, 79, 77, 84, 81, 76, 82, 79, 79, 0, 79, '2025', 'SETENTA Y NUEVE', 'Evaluación por porcentaje', 'APROBADO', NULL),
(833, '12345678', 'EST-201', 81, 86, 84, 79, 88, 84, 82, 89, 86, 81, 87, 84, 84, 0, 84, '2025', 'OCHENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 8),
(834, '12345678', 'PDM-205', 79, 84, 82, 77, 86, 82, 80, 87, 84, 79, 85, 82, 82, 0, 82, '2025', 'OCHENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 7),
(835, '12345678', 'PRG-202', 83, 88, 86, 81, 90, 86, 84, 91, 88, 83, 89, 86, 86, 0, 86, '2025', 'OCHENTA Y SEIS', 'Evaluación por porcentaje', 'APROBADO', 9),
(836, '12345678', 'RDC-204', 77, 82, 80, 75, 84, 80, 78, 85, 82, 77, 83, 80, 80, 0, 80, '2025', 'OCHENTA', 'Evaluación por porcentaje', 'APROBADO', 8),
(837, '4780257', 'ADS-206', 70, 76, 73, 68, 78, 73, 71, 79, 75, 70, 77, 74, 74, 0, 74, '2025', 'SETENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 4),
(838, '4780257', 'BDD-208', 68, 74, 71, 66, 76, 71, 69, 77, 73, 68, 75, 72, 72, 0, 72, '2025', 'SETENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 10),
(839, '4780257', 'DPW-207', 72, 78, 75, 70, 80, 75, 73, 81, 77, 72, 79, 76, 76, 0, 76, '2025', 'SETENTA Y SEIS', 'Evaluación por porcentaje', 'APROBADO', 1),
(840, '4780257', 'EDD-203', 66, 72, 69, 64, 74, 69, 67, 75, 71, 66, 73, 70, 70, 0, 70, '2025', 'SETENTA', 'Evaluación por porcentaje', 'APROBADO', NULL),
(841, '4780257', 'EST-201', 71, 77, 74, 69, 79, 74, 72, 80, 76, 71, 78, 75, 75, 0, 75, '2025', 'SETENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 8),
(842, '4780257', 'PDM-205', 69, 75, 72, 67, 77, 72, 70, 78, 74, 69, 76, 73, 73, 0, 73, '2025', 'SETENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 7),
(843, '4780257', 'PRG-202', 73, 79, 76, 71, 81, 76, 74, 82, 78, 73, 80, 77, 77, 0, 77, '2025', 'SETENTA Y SIETE', 'Evaluación por porcentaje', 'APROBADO', 9),
(844, '4780257', 'RDC-204', 67, 73, 70, 65, 75, 70, 68, 76, 72, 67, 74, 71, 71, 0, 71, '2025', 'SETENTA Y UNO', 'Evaluación por porcentaje', 'APROBADO', 8),
(845, '2222222', 'ADS-206', 78, 83, 81, 76, 85, 81, 79, 86, 83, 78, 84, 81, 81, 0, 81, '2025', 'OCHENTA Y UNO', 'Evaluación por porcentaje', 'APROBADO', 4),
(846, '2222222', 'BDD-208', 76, 81, 79, 74, 83, 79, 77, 84, 81, 76, 82, 79, 79, 0, 79, '2025', 'SETENTA Y NUEVE', 'Evaluación por porcentaje', 'APROBADO', 10),
(847, '2222222', 'DPW-207', 80, 85, 83, 78, 87, 83, 81, 88, 85, 80, 86, 83, 83, 0, 83, '2025', 'OCHENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 1),
(848, '2222222', 'EDD-203', 74, 79, 77, 72, 81, 77, 75, 82, 79, 74, 80, 77, 77, 0, 77, '2025', 'SETENTA Y SIETE', 'Evaluación por porcentaje', 'APROBADO', NULL),
(849, '2222222', 'EST-201', 79, 84, 82, 77, 86, 82, 80, 87, 84, 79, 85, 82, 82, 0, 82, '2025', 'OCHENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 8),
(850, '2222222', 'PDM-205', 77, 82, 80, 75, 84, 80, 78, 85, 82, 77, 83, 80, 80, 0, 80, '2025', 'OCHENTA', 'Evaluación por porcentaje', 'APROBADO', 7),
(851, '2222222', 'PRG-202', 81, 86, 84, 79, 88, 84, 82, 89, 86, 81, 87, 84, 84, 0, 84, '2025', 'OCHENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 9),
(852, '2222222', 'RDC-204', 75, 80, 78, 73, 82, 78, 76, 83, 80, 75, 81, 78, 78, 0, 78, '2025', 'SETENTA Y OCHO', 'Evaluación por porcentaje', 'APROBADO', 8),
(853, '7685676', 'ADS-206', 72, 78, 75, 70, 80, 75, 73, 81, 77, 72, 79, 76, 76, 0, 76, '2025', 'SETENTA Y SEIS', 'Evaluación por porcentaje', 'APROBADO', 4),
(854, '7685676', 'BDD-208', 70, 76, 73, 68, 78, 73, 71, 79, 75, 70, 77, 74, 74, 0, 74, '2025', 'SETENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 10),
(855, '7685676', 'DPW-207', 74, 80, 77, 72, 82, 77, 75, 83, 79, 74, 81, 78, 78, 0, 78, '2025', 'SETENTA Y OCHO', 'Evaluación por porcentaje', 'APROBADO', 1),
(856, '7685676', 'EDD-203', 68, 74, 71, 66, 76, 71, 69, 77, 73, 68, 75, 72, 72, 0, 72, '2025', 'SETENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', NULL),
(857, '7685676', 'EST-201', 73, 79, 76, 71, 81, 76, 74, 82, 78, 73, 80, 77, 77, 0, 77, '2025', 'SETENTA Y SIETE', 'Evaluación por porcentaje', 'APROBADO', 8),
(858, '7685676', 'PDM-205', 71, 77, 74, 69, 79, 74, 72, 80, 76, 71, 78, 75, 75, 0, 75, '2025', 'SETENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 7),
(859, '7685676', 'PRG-202', 75, 81, 78, 73, 83, 78, 76, 84, 80, 75, 82, 79, 79, 0, 79, '2025', 'SETENTA Y NUEVE', 'Evaluación por porcentaje', 'APROBADO', 9),
(860, '7685676', 'RDC-204', 69, 75, 72, 67, 77, 72, 70, 78, 74, 69, 76, 73, 73, 0, 73, '2025', 'SETENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 8),
(861, '2736234', 'ADS-206', 79, 84, 82, 77, 86, 82, 80, 87, 84, 79, 85, 82, 82, 0, 82, '2025', 'OCHENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 4),
(862, '2736234', 'BDD-208', 77, 82, 80, 75, 84, 80, 78, 85, 82, 77, 83, 80, 80, 0, 80, '2025', 'OCHENTA', 'Evaluación por porcentaje', 'APROBADO', 10),
(863, '2736234', 'DPW-207', 81, 86, 84, 79, 88, 84, 82, 89, 86, 81, 87, 84, 84, 0, 84, '2025', 'OCHENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 1),
(864, '2736234', 'EDD-203', 75, 80, 78, 73, 82, 78, 76, 83, 80, 75, 81, 78, 78, 0, 78, '2025', 'SETENTA Y OCHO', 'Evaluación por porcentaje', 'APROBADO', NULL),
(865, '2736234', 'EST-201', 80, 85, 83, 78, 87, 83, 81, 88, 85, 80, 86, 83, 83, 0, 83, '2025', 'OCHENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 8),
(866, '2736234', 'PDM-205', 78, 83, 81, 76, 85, 81, 79, 86, 83, 78, 84, 81, 81, 0, 81, '2025', 'OCHENTA Y UNO', 'Evaluación por porcentaje', 'APROBADO', 7),
(867, '2736234', 'PRG-202', 82, 87, 85, 80, 89, 85, 83, 90, 87, 82, 88, 85, 85, 0, 85, '2025', 'OCHENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 9),
(868, '2736234', 'RDC-204', 76, 81, 79, 74, 83, 79, 77, 84, 81, 76, 82, 79, 79, 0, 79, '2025', 'SETENTA Y NUEVE', 'Evaluación por porcentaje', 'APROBADO', 8),
(869, '7685675', 'ADS-306', 80, 85, 83, 78, 86, 82, 79, 87, 83, 80, 87, 84, 83, 0, 83, '2026', 'OCHENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 4),
(870, '7685675', 'BDD-308', 78, 83, 81, 76, 84, 80, 77, 85, 81, 78, 85, 82, 81, 0, 81, '2026', 'OCHENTA Y UNO', 'Evaluación por porcentaje', 'APROBADO', 2),
(871, '7685675', 'DPW-302', 82, 87, 85, 80, 88, 84, 81, 89, 85, 82, 89, 86, 85, 0, 85, '2026', 'OCHENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 1),
(872, '7685675', 'EMP-301', 76, 81, 79, 74, 82, 78, 75, 83, 79, 76, 83, 80, 79, 0, 79, '2026', 'SETENTA Y NUEVE', 'Evaluación por porcentaje', 'APROBADO', 6),
(873, '7685675', 'GMC-303', 79, 84, 82, 77, 85, 81, 78, 86, 82, 79, 86, 83, 82, 0, 82, '2026', 'OCHENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 1),
(874, '7685675', 'PDM-307', 77, 82, 80, 75, 83, 79, 76, 84, 80, 77, 84, 81, 80, 0, 80, '2026', 'OCHENTA', 'Evaluación por porcentaje', 'APROBADO', 5),
(875, '7685675', 'RDC-304', 81, 86, 84, 79, 87, 83, 80, 88, 84, 81, 88, 85, 84, 0, 84, '2026', 'OCHENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 3),
(876, '7685675', 'TMG-305', 75, 80, 78, 73, 81, 77, 74, 82, 78, 75, 82, 79, 78, 0, 78, '2026', 'SETENTA Y OCHO', 'Evaluación por porcentaje', 'APROBADO', 1),
(877, '12345678', 'ADS-306', 83, 88, 86, 81, 89, 85, 82, 90, 86, 83, 89, 86, 86, 0, 86, '2026', 'OCHENTA Y SEIS', 'Evaluación por porcentaje', 'APROBADO', 4),
(878, '12345678', 'BDD-308', 81, 86, 84, 79, 87, 83, 80, 88, 84, 81, 87, 84, 84, 0, 84, '2026', 'OCHENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 2),
(879, '12345678', 'DPW-302', 85, 90, 88, 83, 91, 87, 84, 92, 88, 85, 91, 88, 88, 0, 88, '2026', 'OCHENTA Y OCHO', 'Evaluación por porcentaje', 'APROBADO', 1),
(880, '12345678', 'EMP-301', 79, 84, 82, 77, 85, 81, 78, 86, 82, 79, 85, 82, 82, 0, 82, '2026', 'OCHENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 6),
(881, '12345678', 'GMC-303', 82, 87, 85, 80, 88, 84, 81, 89, 85, 82, 88, 85, 85, 0, 85, '2026', 'OCHENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 1),
(882, '12345678', 'PDM-307', 80, 85, 83, 78, 86, 82, 79, 87, 83, 80, 86, 83, 83, 0, 83, '2026', 'OCHENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 5),
(883, '12345678', 'RDC-304', 84, 89, 87, 82, 90, 86, 83, 91, 87, 84, 90, 87, 87, 0, 87, '2026', 'OCHENTA Y SIETE', 'Evaluación por porcentaje', 'APROBADO', 3),
(884, '12345678', 'TMG-305', 78, 83, 81, 76, 84, 80, 77, 85, 81, 78, 84, 81, 81, 0, 81, '2026', 'OCHENTA Y UNO', 'Evaluación por porcentaje', 'APROBADO', 1),
(885, '4780257', 'ADS-306', 74, 79, 77, 72, 80, 76, 73, 81, 77, 74, 79, 77, 77, 0, 77, '2026', 'SETENTA Y SIETE', 'Evaluación por porcentaje', 'APROBADO', 4),
(886, '4780257', 'BDD-308', 72, 77, 75, 70, 78, 74, 71, 79, 75, 72, 77, 75, 75, 0, 75, '2026', 'SETENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 2),
(887, '4780257', 'DPW-302', 76, 81, 79, 74, 82, 78, 75, 83, 79, 76, 81, 79, 79, 0, 79, '2026', 'SETENTA Y NUEVE', 'Evaluación por porcentaje', 'APROBADO', 1),
(888, '4780257', 'EMP-301', 70, 75, 73, 68, 76, 72, 69, 77, 73, 70, 75, 73, 73, 0, 73, '2026', 'SETENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 6),
(889, '4780257', 'GMC-303', 73, 78, 76, 71, 79, 75, 72, 80, 76, 73, 78, 76, 76, 0, 76, '2026', 'SETENTA Y SEIS', 'Evaluación por porcentaje', 'APROBADO', 1),
(890, '4780257', 'PDM-307', 71, 76, 74, 69, 77, 73, 70, 78, 74, 71, 76, 74, 74, 0, 74, '2026', 'SETENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 5),
(891, '4780257', 'RDC-304', 75, 80, 78, 73, 81, 77, 74, 82, 78, 75, 80, 78, 78, 0, 78, '2026', 'SETENTA Y OCHO', 'Evaluación por porcentaje', 'APROBADO', 3),
(892, '4780257', 'TMG-305', 69, 74, 72, 67, 75, 71, 68, 76, 72, 69, 74, 72, 72, 0, 72, '2026', 'SETENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 1),
(893, '2222222', 'ADS-306', 82, 87, 85, 80, 88, 84, 81, 89, 85, 82, 88, 85, 85, 0, 85, '2026', 'OCHENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 4),
(894, '2222222', 'BDD-308', 80, 85, 83, 78, 86, 82, 79, 87, 83, 80, 86, 83, 83, 0, 83, '2026', 'OCHENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 2),
(895, '2222222', 'DPW-302', 84, 89, 87, 82, 90, 86, 83, 91, 87, 84, 90, 87, 87, 0, 87, '2026', 'OCHENTA Y SIETE', 'Evaluación por porcentaje', 'APROBADO', 1),
(896, '2222222', 'EMP-301', 78, 83, 81, 76, 84, 80, 77, 85, 81, 78, 84, 81, 81, 0, 81, '2026', 'OCHENTA Y UNO', 'Evaluación por porcentaje', 'APROBADO', 6),
(897, '2222222', 'GMC-303', 81, 86, 84, 79, 87, 83, 80, 88, 84, 81, 87, 84, 84, 0, 84, '2026', 'OCHENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 1),
(898, '2222222', 'PDM-307', 79, 84, 82, 77, 85, 81, 78, 86, 82, 79, 85, 82, 82, 0, 82, '2026', 'OCHENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 5),
(899, '2222222', 'RDC-304', 83, 88, 86, 81, 89, 85, 82, 90, 86, 83, 89, 86, 86, 0, 86, '2026', 'OCHENTA Y SEIS', 'Evaluación por porcentaje', 'APROBADO', 3),
(900, '2222222', 'TMG-305', 77, 82, 80, 75, 83, 79, 76, 84, 80, 77, 83, 80, 80, 0, 80, '2026', 'OCHENTA', 'Evaluación por porcentaje', 'APROBADO', 1),
(901, '7685676', 'ADS-306', 76, 81, 79, 74, 82, 78, 75, 83, 79, 76, 82, 79, 79, 0, 79, '2026', 'SETENTA Y NUEVE', 'Evaluación por porcentaje', 'APROBADO', 4),
(902, '7685676', 'BDD-308', 74, 79, 77, 72, 80, 76, 73, 81, 77, 74, 80, 77, 77, 0, 77, '2026', 'SETENTA Y SIETE', 'Evaluación por porcentaje', 'APROBADO', 2),
(903, '7685676', 'DPW-302', 78, 83, 81, 76, 84, 80, 77, 85, 81, 78, 84, 81, 81, 0, 81, '2026', 'OCHENTA Y UNO', 'Evaluación por porcentaje', 'APROBADO', 1),
(904, '7685676', 'EMP-301', 72, 77, 75, 70, 78, 74, 71, 79, 75, 72, 78, 75, 75, 0, 75, '2026', 'SETENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 6),
(905, '7685676', 'GMC-303', 75, 80, 78, 73, 81, 77, 74, 82, 78, 75, 81, 78, 78, 0, 78, '2026', 'SETENTA Y OCHO', 'Evaluación por porcentaje', 'APROBADO', 1),
(906, '7685676', 'PDM-307', 73, 78, 76, 71, 79, 75, 72, 80, 76, 73, 79, 76, 76, 0, 76, '2026', 'SETENTA Y SEIS', 'Evaluación por porcentaje', 'APROBADO', 5),
(907, '7685676', 'RDC-304', 77, 82, 80, 75, 83, 79, 76, 84, 80, 77, 83, 80, 80, 0, 80, '2026', 'OCHENTA', 'Evaluación por porcentaje', 'APROBADO', 3),
(908, '7685676', 'TMG-305', 71, 76, 74, 69, 77, 73, 70, 78, 74, 71, 77, 74, 74, 0, 74, '2026', 'SETENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 1),
(909, '2736234', 'ADS-306', 83, 88, 86, 81, 89, 85, 82, 90, 86, 83, 89, 86, 86, 0, 86, '2026', 'OCHENTA Y SEIS', 'Evaluación por porcentaje', 'APROBADO', 4),
(910, '2736234', 'BDD-308', 81, 86, 84, 79, 87, 83, 80, 88, 84, 81, 87, 84, 84, 0, 84, '2026', 'OCHENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 2),
(911, '2736234', 'DPW-302', 85, 90, 88, 83, 91, 87, 84, 92, 88, 85, 91, 88, 88, 0, 88, '2026', 'OCHENTA Y OCHO', 'Evaluación por porcentaje', 'APROBADO', 1),
(912, '2736234', 'EMP-301', 79, 84, 82, 77, 85, 81, 78, 86, 82, 79, 85, 82, 82, 0, 82, '2026', 'OCHENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 6),
(913, '2736234', 'GMC-303', 82, 87, 85, 80, 88, 84, 81, 89, 85, 82, 88, 85, 85, 0, 85, '2026', 'OCHENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 1),
(914, '2736234', 'PDM-307', 80, 85, 83, 78, 86, 82, 79, 87, 83, 80, 86, 83, 83, 0, 83, '2026', 'OCHENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 5),
(915, '2736234', 'RDC-304', 84, 89, 87, 82, 90, 86, 83, 91, 87, 84, 90, 87, 87, 0, 87, '2026', 'OCHENTA Y SIETE', 'Evaluación por porcentaje', 'APROBADO', 3),
(916, '2736234', 'TMG-305', 78, 83, 81, 76, 84, 80, 77, 85, 81, 78, 84, 81, 81, 0, 81, '2026', 'OCHENTA Y UNO', 'Evaluación por porcentaje', 'APROBADO', 1),
(917, '10203203', 'MPI-101', 68, 73, 71, 66, 75, 71, 67, 74, 71, 68, 72, 70, 71, 0, 71, '2025', 'SETENTA Y UNO', 'Repetición 1er año', 'APROBADO', 2),
(918, '10203203', 'PROG-102', 66, 71, 69, 64, 73, 69, 65, 72, 69, 66, 70, 68, 69, 0, 69, '2025', 'SESENTA Y NUEVE', 'Repetición 1er año', 'APROBADO', 7),
(919, '10203203', 'INT-103', 70, 75, 73, 68, 77, 73, 69, 76, 73, 70, 74, 72, 73, 0, 73, '2025', 'SETENTA Y TRES', 'Repetición 1er año', 'APROBADO', 11),
(920, '10203203', 'HDC-104', 64, 69, 67, 62, 71, 67, 63, 70, 67, 64, 68, 66, 67, 0, 67, '2025', 'SESENTA Y SIETE', 'Repetición 1er año', 'APROBADO', 6),
(921, '10203203', 'TSO-105', 67, 72, 70, 65, 74, 70, 66, 73, 70, 67, 71, 69, 70, 0, 70, '2025', 'SETENTA', 'Repetición 1er año', 'APROBADO', 2),
(922, '10203203', 'OMT-106', 69, 74, 72, 67, 76, 72, 68, 75, 72, 69, 73, 71, 72, 0, 72, '2025', 'SETENTA Y DOS', 'Repetición 1er año', 'APROBADO', 6),
(923, '10203203', 'DPW-107', 65, 70, 68, 63, 72, 68, 64, 71, 68, 65, 69, 67, 68, 0, 68, '2025', 'SESENTA Y OCHO', 'Repetición 1er año', 'APROBADO', 9),
(924, '10203203', 'ADS-206', 72, 77, 75, 70, 79, 75, 71, 78, 75, 72, 76, 74, 75, 0, 75, '2026', 'SETENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 4),
(925, '10203203', 'BDD-208', 70, 75, 73, 68, 77, 73, 69, 76, 73, 70, 74, 72, 73, 0, 73, '2026', 'SETENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 10),
(926, '10203203', 'DPW-207', 74, 79, 77, 72, 81, 77, 73, 80, 77, 74, 78, 76, 77, 0, 77, '2026', 'SETENTA Y SIETE', 'Evaluación por porcentaje', 'APROBADO', 1),
(927, '10203203', 'EDD-203', 68, 73, 71, 66, 75, 71, 67, 74, 71, 68, 72, 70, 71, 0, 71, '2026', 'SETENTA Y UNO', 'Evaluación por porcentaje', 'APROBADO', NULL),
(928, '10203203', 'EST-201', 73, 78, 76, 71, 80, 76, 72, 79, 76, 73, 77, 75, 76, 0, 76, '2026', 'SETENTA Y SEIS', 'Evaluación por porcentaje', 'APROBADO', 8),
(929, '10203203', 'PDM-205', 71, 76, 74, 69, 78, 74, 70, 77, 74, 71, 75, 73, 74, 0, 74, '2026', 'SETENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 7),
(930, '10203203', 'PRG-202', 75, 80, 78, 73, 82, 78, 74, 81, 78, 75, 79, 77, 78, 0, 78, '2026', 'SETENTA Y OCHO', 'Evaluación por porcentaje', 'APROBADO', 9),
(931, '10203203', 'RDC-204', 69, 74, 72, 67, 76, 72, 68, 75, 72, 69, 73, 71, 72, 0, 72, '2026', 'SETENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 8),
(932, '38283283', 'MPI-101', 69, 74, 72, 67, 76, 72, 68, 75, 72, 69, 73, 71, 72, 0, 72, '2025', 'SETENTA Y DOS', 'Repetición 1er año', 'APROBADO', 2),
(933, '38283283', 'PROG-102', 67, 72, 70, 65, 74, 70, 66, 73, 70, 67, 71, 69, 70, 0, 70, '2025', 'SETENTA', 'Repetición 1er año', 'APROBADO', 7),
(934, '38283283', 'INT-103', 71, 76, 74, 69, 78, 74, 70, 77, 74, 71, 75, 73, 74, 0, 74, '2025', 'SETENTA Y CUATRO', 'Repetición 1er año', 'APROBADO', 11),
(935, '38283283', 'HDC-104', 65, 70, 68, 63, 72, 68, 64, 71, 68, 65, 69, 67, 68, 0, 68, '2025', 'SESENTA Y OCHO', 'Repetición 1er año', 'APROBADO', 6),
(936, '38283283', 'TSO-105', 68, 73, 71, 66, 75, 71, 67, 74, 71, 68, 72, 70, 71, 0, 71, '2025', 'SETENTA Y UNO', 'Repetición 1er año', 'APROBADO', 2),
(937, '38283283', 'OMT-106', 70, 75, 73, 68, 77, 73, 69, 76, 73, 70, 74, 72, 73, 0, 73, '2025', 'SETENTA Y TRES', 'Repetición 1er año', 'APROBADO', 6),
(938, '38283283', 'DPW-107', 66, 71, 69, 64, 73, 69, 65, 72, 69, 66, 70, 68, 69, 0, 69, '2025', 'SESENTA Y NUEVE', 'Repetición 1er año', 'APROBADO', 9),
(939, '38283283', 'ADS-206', 73, 78, 76, 71, 80, 76, 72, 79, 76, 73, 77, 75, 76, 0, 76, '2026', 'SETENTA Y SEIS', 'Evaluación por porcentaje', 'APROBADO', 4),
(940, '38283283', 'BDD-208', 71, 76, 74, 69, 78, 74, 70, 77, 74, 71, 75, 73, 74, 0, 74, '2026', 'SETENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 10),
(941, '38283283', 'DPW-207', 75, 80, 78, 73, 82, 78, 74, 81, 78, 75, 79, 77, 78, 0, 78, '2026', 'SETENTA Y OCHO', 'Evaluación por porcentaje', 'APROBADO', 1),
(942, '38283283', 'EDD-203', 69, 74, 72, 67, 76, 72, 68, 75, 72, 69, 73, 71, 72, 0, 72, '2026', 'SETENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', NULL),
(943, '38283283', 'EST-201', 74, 79, 77, 72, 81, 77, 73, 80, 77, 74, 78, 76, 77, 0, 77, '2026', 'SETENTA Y SIETE', 'Evaluación por porcentaje', 'APROBADO', 8),
(944, '38283283', 'PDM-205', 72, 77, 75, 70, 79, 75, 71, 78, 75, 72, 76, 74, 75, 0, 75, '2026', 'SETENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 7),
(945, '38283283', 'PRG-202', 76, 81, 79, 74, 83, 79, 75, 82, 79, 76, 80, 78, 79, 0, 79, '2026', 'SETENTA Y NUEVE', 'Evaluación por porcentaje', 'APROBADO', 9),
(946, '38283283', 'RDC-204', 70, 75, 73, 68, 77, 73, 69, 76, 73, 70, 74, 72, 73, 0, 73, '2026', 'SETENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 8),
(947, '48574857', 'ADS-206', 74, 79, 77, 72, 81, 77, 73, 80, 77, 74, 78, 76, 77, 0, 77, '2026', 'SETENTA Y SIETE', 'Evaluación por porcentaje', 'APROBADO', 4),
(948, '48574857', 'BDD-208', 72, 77, 75, 70, 79, 75, 71, 78, 75, 72, 76, 74, 75, 0, 75, '2026', 'SETENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 10),
(949, '48574857', 'DPW-207', 76, 81, 79, 74, 83, 79, 75, 82, 79, 76, 80, 78, 79, 0, 79, '2026', 'SETENTA Y NUEVE', 'Evaluación por porcentaje', 'APROBADO', 1),
(950, '48574857', 'EDD-203', 70, 75, 73, 68, 77, 73, 69, 76, 73, 70, 74, 72, 73, 0, 73, '2026', 'SETENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', NULL),
(951, '48574857', 'EST-201', 75, 80, 78, 73, 82, 78, 74, 81, 78, 75, 79, 77, 78, 0, 78, '2026', 'SETENTA Y OCHO', 'Evaluación por porcentaje', 'APROBADO', 8),
(952, '48574857', 'PDM-205', 73, 78, 76, 71, 80, 76, 72, 79, 76, 73, 77, 75, 76, 0, 76, '2026', 'SETENTA Y SEIS', 'Evaluación por porcentaje', 'APROBADO', 7),
(953, '48574857', 'PRG-202', 77, 82, 80, 75, 84, 80, 76, 83, 80, 77, 81, 79, 80, 0, 80, '2026', 'OCHENTA', 'Evaluación por porcentaje', 'APROBADO', 9),
(954, '48574857', 'RDC-204', 71, 76, 74, 69, 78, 74, 70, 77, 74, 71, 75, 73, 74, 0, 74, '2026', 'SETENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 8),
(955, '4780223', 'ADS-206', 73, 78, 76, 71, 80, 76, 72, 79, 76, 73, 77, 75, 76, 0, 76, '2026', 'SETENTA Y SEIS', 'Evaluación por porcentaje', 'APROBADO', 4),
(956, '4780223', 'BDD-208', 71, 76, 74, 69, 78, 74, 70, 77, 74, 71, 75, 73, 74, 0, 74, '2026', 'SETENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 10),
(957, '4780223', 'DPW-207', 75, 80, 78, 73, 82, 78, 74, 81, 78, 75, 79, 77, 78, 0, 78, '2026', 'SETENTA Y OCHO', 'Evaluación por porcentaje', 'APROBADO', 1),
(958, '4780223', 'EDD-203', 69, 74, 72, 67, 76, 72, 68, 75, 72, 69, 73, 71, 72, 0, 72, '2026', 'SETENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', NULL),
(959, '4780223', 'EST-201', 74, 79, 77, 72, 81, 77, 73, 80, 77, 74, 78, 76, 77, 0, 77, '2026', 'SETENTA Y SIETE', 'Evaluación por porcentaje', 'APROBADO', 8),
(960, '4780223', 'PDM-205', 72, 77, 75, 70, 79, 75, 71, 78, 75, 72, 76, 74, 75, 0, 75, '2026', 'SETENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 7),
(961, '4780223', 'PRG-202', 76, 81, 79, 74, 83, 79, 75, 82, 79, 76, 80, 78, 79, 0, 79, '2026', 'SETENTA Y NUEVE', 'Evaluación por porcentaje', 'APROBADO', 9),
(962, '4780223', 'RDC-204', 70, 75, 73, 68, 77, 73, 69, 76, 73, 70, 74, 72, 73, 0, 73, '2026', 'SETENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 8),
(963, '46574343', 'ADS-206', 80, 85, 83, 78, 87, 83, 79, 86, 83, 80, 86, 83, 83, 0, 83, '2026', 'OCHENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 4),
(964, '46574343', 'BDD-208', 78, 83, 81, 76, 85, 81, 77, 84, 81, 78, 84, 81, 81, 0, 81, '2026', 'OCHENTA Y UNO', 'Evaluación por porcentaje', 'APROBADO', 10),
(965, '46574343', 'DPW-207', 82, 87, 85, 80, 89, 85, 81, 88, 85, 82, 88, 85, 85, 0, 85, '2026', 'OCHENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 1),
(966, '46574343', 'EDD-203', 76, 81, 79, 74, 83, 79, 75, 82, 79, 76, 82, 79, 79, 0, 79, '2026', 'SETENTA Y NUEVE', 'Evaluación por porcentaje', 'APROBADO', NULL),
(967, '46574343', 'EST-201', 81, 86, 84, 79, 88, 84, 80, 87, 84, 81, 87, 84, 84, 0, 84, '2026', 'OCHENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 8),
(968, '46574343', 'PDM-205', 79, 84, 82, 77, 86, 82, 78, 85, 82, 79, 85, 82, 82, 0, 82, '2026', 'OCHENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 7),
(969, '46574343', 'PRG-202', 83, 88, 86, 81, 90, 86, 82, 89, 86, 83, 89, 86, 86, 0, 86, '2026', 'OCHENTA Y SEIS', 'Evaluación por porcentaje', 'APROBADO', 9),
(970, '46574343', 'RDC-204', 77, 82, 80, 75, 84, 80, 76, 83, 80, 77, 83, 80, 80, 0, 80, '2026', 'OCHENTA', 'Evaluación por porcentaje', 'APROBADO', 8),
(971, '4780252', 'ADS-206', 74, 79, 77, 72, 81, 77, 73, 80, 77, 74, 78, 76, 77, 0, 77, '2026', 'SETENTA Y SIETE', 'Evaluación por porcentaje', 'APROBADO', 4),
(972, '4780252', 'BDD-208', 72, 77, 75, 70, 79, 75, 71, 78, 75, 72, 76, 74, 75, 0, 75, '2026', 'SETENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 10),
(973, '4780252', 'DPW-207', 76, 81, 79, 74, 83, 79, 75, 82, 79, 76, 80, 78, 79, 0, 79, '2026', 'SETENTA Y NUEVE', 'Evaluación por porcentaje', 'APROBADO', 1),
(974, '4780252', 'EDD-203', 70, 75, 73, 68, 77, 73, 69, 76, 73, 70, 74, 72, 73, 0, 73, '2026', 'SETENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', NULL),
(975, '4780252', 'EST-201', 75, 80, 78, 73, 82, 78, 74, 81, 78, 75, 79, 77, 78, 0, 78, '2026', 'SETENTA Y OCHO', 'Evaluación por porcentaje', 'APROBADO', 8),
(976, '4780252', 'PDM-205', 73, 78, 76, 71, 80, 76, 72, 79, 76, 73, 77, 75, 76, 0, 76, '2026', 'SETENTA Y SEIS', 'Evaluación por porcentaje', 'APROBADO', 7),
(977, '4780252', 'PRG-202', 77, 82, 80, 75, 84, 80, 76, 83, 80, 77, 81, 79, 80, 0, 80, '2026', 'OCHENTA', 'Evaluación por porcentaje', 'APROBADO', 9),
(978, '4780252', 'RDC-204', 71, 76, 74, 69, 78, 74, 70, 77, 74, 71, 75, 73, 74, 0, 74, '2026', 'SETENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 8),
(979, '47892832', 'ADS-206', 74, 79, 77, 72, 81, 77, 73, 80, 77, 74, 78, 76, 77, 0, 77, '2026', 'SETENTA Y SIETE', 'Evaluación por porcentaje', 'APROBADO', 4),
(980, '47892832', 'BDD-208', 72, 77, 75, 70, 79, 75, 71, 78, 75, 72, 76, 74, 75, 0, 75, '2026', 'SETENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 10),
(981, '47892832', 'DPW-207', 76, 81, 79, 74, 83, 79, 75, 82, 79, 76, 80, 78, 79, 0, 79, '2026', 'SETENTA Y NUEVE', 'Evaluación por porcentaje', 'APROBADO', 1),
(982, '47892832', 'EDD-203', 70, 75, 73, 68, 77, 73, 69, 76, 73, 70, 74, 72, 73, 0, 73, '2026', 'SETENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', NULL),
(983, '47892832', 'EST-201', 75, 80, 78, 73, 82, 78, 74, 81, 78, 75, 79, 77, 78, 0, 78, '2026', 'SETENTA Y OCHO', 'Evaluación por porcentaje', 'APROBADO', 8),
(984, '47892832', 'PDM-205', 73, 78, 76, 71, 80, 76, 72, 79, 76, 73, 77, 75, 76, 0, 76, '2026', 'SETENTA Y SEIS', 'Evaluación por porcentaje', 'APROBADO', 7),
(985, '47892832', 'PRG-202', 77, 82, 80, 75, 84, 80, 76, 83, 80, 77, 81, 79, 80, 0, 80, '2026', 'OCHENTA', 'Evaluación por porcentaje', 'APROBADO', 9),
(986, '47892832', 'RDC-204', 71, 76, 74, 69, 78, 74, 70, 77, 74, 71, 75, 73, 74, 0, 74, '2026', 'SETENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 8),
(987, '45645467', 'ADS-206', 80, 85, 83, 78, 87, 83, 79, 86, 83, 80, 86, 83, 83, 0, 83, '2026', 'OCHENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 4),
(988, '45645467', 'BDD-208', 78, 83, 81, 76, 85, 81, 77, 84, 81, 78, 84, 81, 81, 0, 81, '2026', 'OCHENTA Y UNO', 'Evaluación por porcentaje', 'APROBADO', 10),
(989, '45645467', 'DPW-207', 82, 87, 85, 80, 89, 85, 81, 88, 85, 82, 88, 85, 85, 0, 85, '2026', 'OCHENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 1),
(990, '45645467', 'EDD-203', 76, 81, 79, 74, 83, 79, 75, 82, 79, 76, 82, 79, 79, 0, 79, '2026', 'SETENTA Y NUEVE', 'Evaluación por porcentaje', 'APROBADO', NULL),
(991, '45645467', 'EST-201', 81, 86, 84, 79, 88, 84, 80, 87, 84, 81, 87, 84, 84, 0, 84, '2026', 'OCHENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 8),
(992, '45645467', 'PDM-205', 79, 84, 82, 77, 86, 82, 78, 85, 82, 79, 85, 82, 82, 0, 82, '2026', 'OCHENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 7),
(993, '45645467', 'PRG-202', 83, 88, 86, 81, 90, 86, 82, 89, 86, 83, 89, 86, 86, 0, 86, '2026', 'OCHENTA Y SEIS', 'Evaluación por porcentaje', 'APROBADO', 9),
(994, '45645467', 'RDC-204', 77, 82, 80, 75, 84, 80, 76, 83, 80, 77, 83, 80, 80, 0, 80, '2026', 'OCHENTA', 'Evaluación por porcentaje', 'APROBADO', 8),
(995, '190102033', 'ADS-206', 75, 80, 78, 73, 82, 78, 74, 81, 78, 75, 79, 77, 78, 0, 78, '2026', 'SETENTA Y OCHO', 'Evaluación por porcentaje', 'APROBADO', 4),
(996, '190102033', 'BDD-208', 73, 78, 76, 71, 80, 76, 72, 79, 76, 73, 77, 75, 76, 0, 76, '2026', 'SETENTA Y SEIS', 'Evaluación por porcentaje', 'APROBADO', 10),
(997, '190102033', 'DPW-207', 77, 82, 80, 75, 84, 80, 76, 83, 80, 77, 81, 79, 80, 0, 80, '2026', 'OCHENTA', 'Evaluación por porcentaje', 'APROBADO', 1),
(998, '190102033', 'EDD-203', 71, 76, 74, 69, 78, 74, 70, 77, 74, 71, 75, 73, 74, 0, 74, '2026', 'SETENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', NULL),
(999, '190102033', 'EST-201', 76, 81, 79, 74, 83, 79, 75, 82, 79, 76, 80, 78, 79, 0, 79, '2026', 'SETENTA Y NUEVE', 'Evaluación por porcentaje', 'APROBADO', 8),
(1000, '190102033', 'PDM-205', 74, 79, 77, 72, 81, 77, 73, 80, 77, 74, 78, 76, 77, 0, 77, '2026', 'SETENTA Y SIETE', 'Evaluación por porcentaje', 'APROBADO', 7),
(1001, '190102033', 'PRG-202', 78, 83, 81, 76, 85, 81, 77, 84, 81, 78, 82, 80, 81, 0, 81, '2026', 'OCHENTA Y UNO', 'Evaluación por porcentaje', 'APROBADO', 9),
(1002, '190102033', 'RDC-204', 72, 77, 75, 70, 79, 75, 71, 78, 75, 72, 76, 74, 75, 0, 75, '2026', 'SETENTA Y CINCO', 'Evaluación por porcentaje', 'APROBADO', 8),
(1003, '45345353', 'ADS-206', 78, 83, 81, 76, 85, 81, 77, 84, 81, 78, 84, 81, 81, 0, 81, '2026', 'OCHENTA Y UNO', 'Evaluación por porcentaje', 'APROBADO', 4),
(1004, '45345353', 'BDD-208', 76, 81, 79, 74, 83, 79, 75, 82, 79, 76, 82, 79, 79, 0, 79, '2026', 'SETENTA Y NUEVE', 'Evaluación por porcentaje', 'APROBADO', 10),
(1005, '45345353', 'DPW-207', 80, 85, 83, 78, 87, 83, 79, 86, 83, 80, 86, 83, 83, 0, 83, '2026', 'OCHENTA Y TRES', 'Evaluación por porcentaje', 'APROBADO', 1),
(1006, '45345353', 'EDD-203', 74, 79, 77, 72, 81, 77, 73, 80, 77, 74, 80, 77, 77, 0, 77, '2026', 'SETENTA Y SIETE', 'Evaluación por porcentaje', 'APROBADO', NULL),
(1007, '45345353', 'EST-201', 79, 84, 82, 77, 86, 82, 78, 85, 82, 79, 85, 82, 82, 0, 82, '2026', 'OCHENTA Y DOS', 'Evaluación por porcentaje', 'APROBADO', 8),
(1008, '45345353', 'PDM-205', 77, 82, 80, 75, 84, 80, 76, 83, 80, 77, 83, 80, 80, 0, 80, '2026', 'OCHENTA', 'Evaluación por porcentaje', 'APROBADO', 7),
(1009, '45345353', 'PRG-202', 81, 86, 84, 79, 88, 84, 80, 87, 84, 81, 87, 84, 84, 0, 84, '2026', 'OCHENTA Y CUATRO', 'Evaluación por porcentaje', 'APROBADO', 9),
(1010, '45345353', 'RDC-204', 75, 80, 78, 73, 82, 78, 74, 81, 78, 75, 81, 78, 78, 0, 78, '2026', 'SETENTA Y OCHO', 'Evaluación por porcentaje', 'APROBADO', 8),
(1011, '37473743', 'MPI-101', 65, 70, 68, 63, 72, 68, 64, 71, 68, 65, 69, 67, 68, 0, 68, '2026', 'SESENTA Y OCHO', 'Repetición 1er año', 'APROBADO', 2),
(1012, '37473743', 'PROG-102', 63, 68, 66, 61, 70, 66, 62, 69, 66, 63, 67, 65, 66, 0, 66, '2026', 'SESENTA Y SEIS', 'Repetición 1er año', 'APROBADO', 7),
(1013, '37473743', 'INT-103', 67, 72, 70, 65, 74, 70, 66, 73, 70, 67, 71, 69, 70, 0, 70, '2026', 'SETENTA', 'Repetición 1er año', 'APROBADO', 11);
INSERT INTO `historial` (`id`, `ci_est`, `cod_asig`, `nota_teorico1`, `nota_pract1`, `nota_primerbim`, `nota_teorico2`, `nota_pract2`, `nota_segundobim`, `nota_teorico3`, `nota_pract3`, `nota_tercerbim`, `nota_teorico4`, `nota_pract4`, `nota_cuartobim`, `nota_parcial`, `segundo_turno`, `TotalAnual`, `gestion`, `literal`, `observaciones`, `estado`, `id_docente`) VALUES
(1014, '37473743', 'HDC-104', 61, 66, 64, 59, 68, 64, 60, 67, 64, 61, 65, 63, 64, 0, 64, '2026', 'SESENTA Y CUATRO', 'Repetición 1er año', 'APROBADO', 6),
(1015, '37473743', 'TSO-105', 64, 69, 67, 62, 71, 67, 63, 70, 67, 64, 68, 66, 67, 0, 67, '2026', 'SESENTA Y SIETE', 'Repetición 1er año', 'APROBADO', 2),
(1016, '37473743', 'OMT-106', 66, 71, 69, 64, 73, 69, 65, 72, 69, 66, 70, 68, 69, 0, 69, '2026', 'SESENTA Y NUEVE', 'Repetición 1er año', 'APROBADO', 6),
(1017, '37473743', 'DPW-107', 62, 67, 65, 60, 69, 65, 61, 68, 65, 62, 66, 64, 65, 0, 65, '2026', 'SESENTA Y CINCO', 'Repetición 1er año', 'APROBADO', 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion`
--

CREATE TABLE `inscripcion` (
  `id` int(11) NOT NULL,
  `ci_est` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `cod_asig` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `id_sec` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `gestion` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `turno` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `grupo` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `tipo` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'Normal',
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `estado_final` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT 'EN PROCESO',
  `observaciones` text CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `inscripcion`
--

INSERT INTO `inscripcion` (`id`, `ci_est`, `cod_asig`, `id_sec`, `fecha`, `gestion`, `turno`, `grupo`, `tipo`, `activo`, `estado_final`, `observaciones`) VALUES
(1, '7685675', 'MPI-101', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(2, '7685675', 'PROG-102', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(3, '7685675', 'INT-103', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(4, '7685675', 'HDC-104', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(5, '7685675', 'TSO-105', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(6, '7685675', 'OMT-106', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(7, '7685675', 'DPW-107', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(8, '12345678', 'MPI-101', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(9, '12345678', 'PROG-102', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(10, '12345678', 'INT-103', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(11, '12345678', 'HDC-104', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(12, '12345678', 'TSO-105', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(13, '12345678', 'OMT-106', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(14, '12345678', 'DPW-107', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(15, '4780257', 'MPI-101', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(16, '4780257', 'PROG-102', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(17, '4780257', 'INT-103', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(18, '4780257', 'HDC-104', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(19, '4780257', 'TSO-105', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(20, '4780257', 'OMT-106', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(21, '4780257', 'DPW-107', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(29, '10203203', 'MPI-101', 1, '2024-06-01', '2024', 'TARDE', 'B', 'Regular', 1, 'EN PROCESO', NULL),
(30, '10203203', 'PROG-102', 1, '2024-06-01', '2024', 'TARDE', 'B', 'Regular', 1, 'EN PROCESO', NULL),
(31, '10203203', 'INT-103', 1, '2024-06-01', '2024', 'TARDE', 'B', 'Regular', 1, 'EN PROCESO', NULL),
(32, '10203203', 'HDC-104', 1, '2024-06-01', '2024', 'TARDE', 'B', 'Regular', 1, 'EN PROCESO', NULL),
(33, '10203203', 'TSO-105', 1, '2024-06-01', '2024', 'TARDE', 'B', 'Regular', 1, 'EN PROCESO', NULL),
(34, '10203203', 'OMT-106', 1, '2024-06-01', '2024', 'TARDE', 'B', 'Regular', 1, 'EN PROCESO', NULL),
(35, '10203203', 'DPW-107', 1, '2024-06-01', '2024', 'TARDE', 'B', 'Regular', 1, 'EN PROCESO', NULL),
(36, '10223203', 'MPI-101', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(37, '10223203', 'PROG-102', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(38, '10223203', 'INT-103', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(39, '10223203', 'HDC-104', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(40, '10223203', 'TSO-105', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(41, '10223203', 'OMT-106', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(42, '10223203', 'DPW-107', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(43, '2222222', 'MPI-101', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(44, '2222222', 'PROG-102', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(45, '2222222', 'INT-103', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(46, '2222222', 'HDC-104', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(47, '2222222', 'TSO-105', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(48, '2222222', 'OMT-106', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(49, '2222222', 'DPW-107', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(50, '38283283', 'MPI-101', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(51, '38283283', 'PROG-102', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(52, '38283283', 'INT-103', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(53, '38283283', 'HDC-104', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(54, '38283283', 'TSO-105', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(55, '38283283', 'OMT-106', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(56, '38283283', 'DPW-107', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(57, '7685676', 'MPI-101', 1, '2024-06-01', '2024', 'TARDE', 'B', 'Regular', 1, 'EN PROCESO', NULL),
(58, '7685676', 'PROG-102', 1, '2024-06-01', '2024', 'TARDE', 'B', 'Regular', 1, 'EN PROCESO', NULL),
(59, '7685676', 'INT-103', 1, '2024-06-01', '2024', 'TARDE', 'B', 'Regular', 1, 'EN PROCESO', NULL),
(60, '7685676', 'HDC-104', 1, '2024-06-01', '2024', 'TARDE', 'B', 'Regular', 1, 'EN PROCESO', NULL),
(61, '7685676', 'TSO-105', 1, '2024-06-01', '2024', 'TARDE', 'B', 'Regular', 1, 'EN PROCESO', NULL),
(62, '7685676', 'OMT-106', 1, '2024-06-01', '2024', 'TARDE', 'B', 'Regular', 1, 'EN PROCESO', NULL),
(63, '7685676', 'DPW-107', 1, '2024-06-01', '2024', 'TARDE', 'B', 'Regular', 1, 'EN PROCESO', NULL),
(64, '2736234', 'MPI-101', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(65, '2736234', 'PROG-102', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(66, '2736234', 'INT-103', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(67, '2736234', 'HDC-104', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(68, '2736234', 'TSO-105', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(69, '2736234', 'OMT-106', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(70, '2736234', 'DPW-107', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(71, '48574857', 'MPI-101', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(72, '48574857', 'PROG-102', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(73, '48574857', 'INT-103', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(74, '48574857', 'HDC-104', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(75, '48574857', 'TSO-105', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(76, '48574857', 'OMT-106', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(77, '48574857', 'DPW-107', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(78, '11239832', 'MPI-101', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(79, '11239832', 'PROG-102', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(80, '11239832', 'INT-103', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(81, '11239832', 'HDC-104', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(82, '11239832', 'TSO-105', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(83, '11239832', 'OMT-106', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(84, '11239832', 'DPW-107', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(85, '4780223', 'MPI-101', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(86, '4780223', 'PROG-102', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(87, '4780223', 'INT-103', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(88, '4780223', 'HDC-104', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(89, '4780223', 'TSO-105', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(90, '4780223', 'OMT-106', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(91, '4780223', 'DPW-107', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(92, '46574343', 'MPI-101', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(93, '46574343', 'PROG-102', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(94, '46574343', 'INT-103', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(95, '46574343', 'HDC-104', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(96, '46574343', 'TSO-105', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(97, '46574343', 'OMT-106', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(98, '46574343', 'DPW-107', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(99, '4780252', 'DPW-107', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(100, '4780252', 'HDC-104', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(101, '4780252', 'INT-103', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(102, '4780252', 'MPI-101', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(103, '4780252', 'OMT-106', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(104, '4780252', 'PROG-102', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(105, '4780252', 'TSO-105', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(106, '47892832', 'DPW-107', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(107, '47892832', 'HDC-104', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(108, '47892832', 'INT-103', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(109, '47892832', 'MPI-101', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(110, '47892832', 'OMT-106', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(111, '47892832', 'PROG-102', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(112, '47892832', 'TSO-105', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(113, '2736233', 'ADS-206', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(114, '2736233', 'BDD-208', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(115, '2736233', 'DPW-207', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(116, '2736233', 'EDD-203', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(117, '2736233', 'EST-201', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(118, '2736233', 'PDM-205', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(119, '2736233', 'PRG-202', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(120, '2736233', 'RDC-204', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(143, '45645467', 'DPW-107', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(144, '45645467', 'HDC-104', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(145, '45645467', 'INT-103', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(146, '45645467', 'MPI-101', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(147, '45645467', 'OMT-106', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(148, '45645467', 'PROG-102', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(149, '45645467', 'TSO-105', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(165, '37473743', 'DPW-107', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(166, '37473743', 'HDC-104', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(167, '37473743', 'INT-103', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(168, '37473743', 'MPI-101', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(169, '37473743', 'OMT-106', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(170, '37473743', 'PROG-102', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(171, '37473743', 'TSO-105', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(172, '190102033', 'DPW-107', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(173, '190102033', 'HDC-104', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(174, '190102033', 'INT-103', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(175, '190102033', 'MPI-101', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(176, '190102033', 'OMT-106', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(177, '190102033', 'PROG-102', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(178, '190102033', 'TSO-105', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(201, '45463464', 'ADS-206', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(202, '45463464', 'BDD-208', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(203, '45463464', 'DPW-207', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(204, '45463464', 'EDD-203', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(205, '45463464', 'EST-201', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(206, '45463464', 'PDM-205', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(207, '45463464', 'PRG-202', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(208, '45463464', 'RDC-204', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(223, '121232431', 'ADS-206', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(224, '121232431', 'BDD-208', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(225, '121232431', 'DPW-207', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(226, '121232431', 'EDD-203', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(227, '121232431', 'EST-201', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(228, '121232431', 'PDM-205', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(229, '121232431', 'PRG-202', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(230, '121232431', 'RDC-204', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(238, '45345353', 'DPW-107', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(239, '45345353', 'HDC-104', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(240, '45345353', 'INT-103', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(241, '45345353', 'MPI-101', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(242, '45345353', 'OMT-106', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(243, '45345353', 'PROG-102', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(244, '45345353', 'TSO-105', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(260, '61234567', 'ADS-306', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(261, '61234567', 'BDD-308', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(262, '61234567', 'DPW-302', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(263, '61234567', 'EMP-301', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(264, '61234567', 'GMC-303', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(265, '61234567', 'PDM-307', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(266, '61234567', 'RDC-304', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(267, '61234567', 'TMG-305', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(268, '61234568', 'ADS-306', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(269, '61234568', 'BDD-308', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(270, '61234568', 'DPW-302', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(271, '61234568', 'EMP-301', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(272, '61234568', 'GMC-303', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(273, '61234568', 'PDM-307', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(274, '61234568', 'RDC-304', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(275, '61234568', 'TMG-305', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(276, '61234569', 'ADS-306', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(277, '61234569', 'BDD-308', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(278, '61234569', 'DPW-302', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(279, '61234569', 'EMP-301', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(280, '61234569', 'GMC-303', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(281, '61234569', 'PDM-307', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(282, '61234569', 'RDC-304', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(283, '61234569', 'TMG-305', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(284, '61234570', 'ADS-306', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(285, '61234570', 'BDD-308', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(286, '61234570', 'DPW-302', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(287, '61234570', 'EMP-301', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(288, '61234570', 'GMC-303', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(289, '61234570', 'PDM-307', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(290, '61234570', 'RDC-304', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(291, '61234570', 'TMG-305', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(292, '61234571', 'ADS-306', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(293, '61234571', 'BDD-308', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(294, '61234571', 'DPW-302', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(295, '61234571', 'EMP-301', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(296, '61234571', 'GMC-303', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(297, '61234571', 'PDM-307', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(298, '61234571', 'RDC-304', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(299, '61234571', 'TMG-305', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(300, '61234572', 'ADS-306', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(301, '61234572', 'BDD-308', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(302, '61234572', 'DPW-302', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(303, '61234572', 'EMP-301', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(304, '61234572', 'GMC-303', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(305, '61234572', 'PDM-307', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(306, '61234572', 'RDC-304', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(307, '61234572', 'TMG-305', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(308, '61234573', 'ADS-306', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(309, '61234573', 'BDD-308', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(310, '61234573', 'DPW-302', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(311, '61234573', 'EMP-301', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(312, '61234573', 'GMC-303', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(313, '61234573', 'PDM-307', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(314, '61234573', 'RDC-304', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(315, '61234573', 'TMG-305', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(316, '61234574', 'ADS-306', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(317, '61234574', 'BDD-308', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(318, '61234574', 'DPW-302', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(319, '61234574', 'EMP-301', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(320, '61234574', 'GMC-303', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(321, '61234574', 'PDM-307', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(322, '61234574', 'RDC-304', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(323, '61234574', 'TMG-305', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'EN PROCESO', NULL),
(324, '62345671', 'ADS-206', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(325, '62345671', 'BDD-208', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(326, '62345671', 'DPW-207', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(327, '62345671', 'EDD-203', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(328, '62345671', 'EST-201', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(329, '62345671', 'PDM-205', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(330, '62345671', 'PRG-202', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(331, '62345671', 'RDC-204', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(332, '62345672', 'ADS-206', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(333, '62345672', 'BDD-208', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(334, '62345672', 'DPW-207', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(335, '62345672', 'EDD-203', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(336, '62345672', 'EST-201', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(337, '62345672', 'PDM-205', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(338, '62345672', 'PRG-202', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(339, '62345672', 'RDC-204', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(340, '62345673', 'ADS-206', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(341, '62345673', 'BDD-208', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(342, '62345673', 'DPW-207', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(343, '62345673', 'EDD-203', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(344, '62345673', 'EST-201', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(345, '62345673', 'PDM-205', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(346, '62345673', 'PRG-202', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(347, '62345673', 'RDC-204', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'BTH', 1, 'EN PROCESO', NULL),
(348, '2736233', 'MPI-101', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(349, '2736233', 'PROG-102', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(350, '2736233', 'INT-103', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(351, '2736233', 'HDC-104', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(352, '2736233', 'TSO-105', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(353, '2736233', 'OMT-106', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(354, '2736233', 'DPW-107', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(355, '45463464', 'MPI-101', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(356, '45463464', 'PROG-102', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(357, '45463464', 'INT-103', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(358, '45463464', 'HDC-104', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(359, '45463464', 'TSO-105', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(360, '45463464', 'OMT-106', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(361, '45463464', 'DPW-107', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(362, '121232431', 'MPI-101', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(363, '121232431', 'PROG-102', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(364, '121232431', 'INT-103', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(365, '121232431', 'HDC-104', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(366, '121232431', 'TSO-105', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(367, '121232431', 'OMT-106', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(368, '121232431', 'DPW-107', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(369, '62345671', 'MPI-101', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(370, '62345671', 'PROG-102', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(371, '62345671', 'INT-103', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(372, '62345671', 'HDC-104', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(373, '62345671', 'TSO-105', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(374, '62345671', 'OMT-106', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(375, '62345671', 'DPW-107', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(376, '62345672', 'MPI-101', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(377, '62345672', 'PROG-102', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(378, '62345672', 'INT-103', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(379, '62345672', 'HDC-104', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(380, '62345672', 'TSO-105', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(381, '62345672', 'OMT-106', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(382, '62345672', 'DPW-107', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(383, '62345673', 'MPI-101', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(384, '62345673', 'PROG-102', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(385, '62345673', 'INT-103', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(386, '62345673', 'HDC-104', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(387, '62345673', 'TSO-105', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(388, '62345673', 'OMT-106', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(389, '62345673', 'DPW-107', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'BTH', 1, 'CONVALIDADO', 'CONVALIDADO'),
(390, '61234567', 'MPI-101', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(391, '61234567', 'PROG-102', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(392, '61234567', 'INT-103', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(393, '61234567', 'HDC-104', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(394, '61234567', 'TSO-105', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(395, '61234567', 'OMT-106', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(396, '61234567', 'DPW-107', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(397, '61234568', 'MPI-101', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(398, '61234568', 'PROG-102', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(399, '61234568', 'INT-103', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(400, '61234568', 'HDC-104', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(401, '61234568', 'TSO-105', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(402, '61234568', 'OMT-106', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(403, '61234568', 'DPW-107', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(404, '61234569', 'MPI-101', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(405, '61234569', 'PROG-102', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(406, '61234569', 'INT-103', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(407, '61234569', 'HDC-104', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(408, '61234569', 'TSO-105', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(409, '61234569', 'OMT-106', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(410, '61234569', 'DPW-107', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(411, '61234570', 'MPI-101', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(412, '61234570', 'PROG-102', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(413, '61234570', 'INT-103', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(414, '61234570', 'HDC-104', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(415, '61234570', 'TSO-105', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(416, '61234570', 'OMT-106', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(417, '61234570', 'DPW-107', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(418, '61234571', 'MPI-101', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(419, '61234571', 'PROG-102', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(420, '61234571', 'INT-103', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(421, '61234571', 'HDC-104', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(422, '61234571', 'TSO-105', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(423, '61234571', 'OMT-106', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(424, '61234571', 'DPW-107', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(425, '61234572', 'MPI-101', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(426, '61234572', 'PROG-102', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(427, '61234572', 'INT-103', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(428, '61234572', 'HDC-104', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(429, '61234572', 'TSO-105', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(430, '61234572', 'OMT-106', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(431, '61234572', 'DPW-107', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(432, '61234573', 'MPI-101', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(433, '61234573', 'PROG-102', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(434, '61234573', 'INT-103', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(435, '61234573', 'HDC-104', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(436, '61234573', 'TSO-105', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(437, '61234573', 'OMT-106', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(438, '61234573', 'DPW-107', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(439, '61234574', 'MPI-101', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(440, '61234574', 'PROG-102', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(441, '61234574', 'INT-103', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(442, '61234574', 'HDC-104', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(443, '61234574', 'TSO-105', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(444, '61234574', 'OMT-106', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(445, '61234574', 'DPW-107', 1, '2024-06-01', '2024', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(446, '61234567', 'ADS-206', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(447, '61234567', 'BDD-208', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(448, '61234567', 'DPW-207', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(449, '61234567', 'EDD-203', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(450, '61234567', 'EST-201', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(451, '61234567', 'PDM-205', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(452, '61234567', 'PRG-202', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(453, '61234567', 'RDC-204', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(454, '61234568', 'ADS-206', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(455, '61234568', 'BDD-208', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(456, '61234568', 'DPW-207', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(457, '61234568', 'EDD-203', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(458, '61234568', 'EST-201', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(459, '61234568', 'PDM-205', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(460, '61234568', 'PRG-202', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(461, '61234568', 'RDC-204', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(462, '61234569', 'ADS-206', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(463, '61234569', 'BDD-208', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(464, '61234569', 'DPW-207', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(465, '61234569', 'EDD-203', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(466, '61234569', 'EST-201', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(467, '61234569', 'PDM-205', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(468, '61234569', 'PRG-202', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(469, '61234569', 'RDC-204', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(470, '61234570', 'ADS-206', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(471, '61234570', 'BDD-208', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(472, '61234570', 'DPW-207', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(473, '61234570', 'EDD-203', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(474, '61234570', 'EST-201', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(475, '61234570', 'PDM-205', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(476, '61234570', 'PRG-202', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(477, '61234570', 'RDC-204', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(478, '61234571', 'ADS-206', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(479, '61234571', 'BDD-208', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(480, '61234571', 'DPW-207', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(481, '61234571', 'EDD-203', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(482, '61234571', 'EST-201', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(483, '61234571', 'PDM-205', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(484, '61234571', 'PRG-202', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(485, '61234571', 'RDC-204', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(486, '61234572', 'ADS-206', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(487, '61234572', 'BDD-208', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(488, '61234572', 'DPW-207', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(489, '61234572', 'EDD-203', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(490, '61234572', 'EST-201', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(491, '61234572', 'PDM-205', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(492, '61234572', 'PRG-202', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(493, '61234572', 'RDC-204', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(494, '61234573', 'ADS-206', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(495, '61234573', 'BDD-208', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(496, '61234573', 'DPW-207', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(497, '61234573', 'EDD-203', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(498, '61234573', 'EST-201', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(499, '61234573', 'PDM-205', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(500, '61234573', 'PRG-202', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(501, '61234573', 'RDC-204', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(502, '61234574', 'ADS-206', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(503, '61234574', 'BDD-208', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(504, '61234574', 'DPW-207', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(505, '61234574', 'EDD-203', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(506, '61234574', 'EST-201', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(507, '61234574', 'PDM-205', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(508, '61234574', 'PRG-202', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(509, '61234574', 'RDC-204', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(510, '62345671', 'ADS-306', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'BTH', 1, 'APROBADO', NULL),
(511, '62345671', 'BDD-308', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'BTH', 1, 'APROBADO', NULL),
(512, '62345671', 'DPW-302', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'BTH', 1, 'APROBADO', NULL),
(513, '62345671', 'EMP-301', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'BTH', 1, 'APROBADO', NULL),
(514, '62345671', 'GMC-303', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'BTH', 1, 'APROBADO', NULL),
(515, '62345671', 'PDM-307', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'BTH', 1, 'APROBADO', NULL),
(516, '62345671', 'RDC-304', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'BTH', 1, 'APROBADO', NULL),
(517, '62345671', 'TMG-305', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'BTH', 1, 'APROBADO', NULL),
(518, '62345672', 'ADS-306', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'BTH', 1, 'APROBADO', NULL),
(519, '62345672', 'BDD-308', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'BTH', 1, 'APROBADO', NULL),
(520, '62345672', 'DPW-302', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'BTH', 1, 'APROBADO', NULL),
(521, '62345672', 'EMP-301', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'BTH', 1, 'APROBADO', NULL),
(522, '62345672', 'GMC-303', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'BTH', 1, 'APROBADO', NULL),
(523, '62345672', 'PDM-307', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'BTH', 1, 'APROBADO', NULL),
(524, '62345672', 'RDC-304', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'BTH', 1, 'APROBADO', NULL),
(525, '62345672', 'TMG-305', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'BTH', 1, 'APROBADO', NULL),
(526, '62345673', 'ADS-306', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'BTH', 1, 'APROBADO', NULL),
(527, '62345673', 'BDD-308', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'BTH', 1, 'APROBADO', NULL),
(528, '62345673', 'DPW-302', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'BTH', 1, 'APROBADO', NULL),
(529, '62345673', 'EMP-301', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'BTH', 1, 'APROBADO', NULL),
(530, '62345673', 'GMC-303', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'BTH', 1, 'APROBADO', NULL),
(531, '62345673', 'PDM-307', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'BTH', 1, 'APROBADO', NULL),
(532, '62345673', 'RDC-304', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'BTH', 1, 'APROBADO', NULL),
(533, '62345673', 'TMG-305', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'BTH', 1, 'APROBADO', NULL),
(558, '2736233', 'ADS-206', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'BTH', 1, 'APROBADO', 'REPITE 2DO AÑO'),
(559, '2736233', 'BDD-208', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'BTH', 1, 'APROBADO', 'REPITE 2DO AÑO'),
(560, '2736233', 'DPW-207', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'BTH', 1, 'APROBADO', 'REPITE 2DO AÑO'),
(561, '2736233', 'EDD-203', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'BTH', 1, 'APROBADO', 'REPITE 2DO AÑO'),
(562, '2736233', 'EST-201', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'BTH', 1, 'APROBADO', 'REPITE 2DO AÑO'),
(563, '2736233', 'PDM-205', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'BTH', 1, 'APROBADO', 'REPITE 2DO AÑO'),
(564, '2736233', 'PRG-202', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'BTH', 1, 'APROBADO', 'REPITE 2DO AÑO'),
(565, '2736233', 'RDC-204', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'BTH', 1, 'APROBADO', 'REPITE 2DO AÑO'),
(566, '7685675', 'ADS-206', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(567, '7685675', 'BDD-208', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(568, '7685675', 'DPW-207', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(569, '7685675', 'EDD-203', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(570, '7685675', 'EST-201', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(571, '7685675', 'PDM-205', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(572, '7685675', 'PRG-202', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(573, '7685675', 'RDC-204', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(574, '7685675', 'ADS-306', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(575, '7685675', 'BDD-308', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(576, '7685675', 'DPW-302', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(577, '7685675', 'EMP-301', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(578, '7685675', 'GMC-303', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(579, '7685675', 'PDM-307', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(580, '7685675', 'RDC-304', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(581, '7685675', 'TMG-305', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(582, '12345678', 'ADS-206', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(583, '12345678', 'BDD-208', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(584, '12345678', 'DPW-207', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(585, '12345678', 'EDD-203', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(586, '12345678', 'EST-201', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(587, '12345678', 'PDM-205', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(588, '12345678', 'PRG-202', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(589, '12345678', 'RDC-204', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(590, '12345678', 'ADS-306', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(591, '12345678', 'BDD-308', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(592, '12345678', 'DPW-302', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(593, '12345678', 'EMP-301', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(594, '12345678', 'GMC-303', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(595, '12345678', 'PDM-307', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(596, '12345678', 'RDC-304', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(597, '12345678', 'TMG-305', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(598, '4780257', 'ADS-206', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(599, '4780257', 'BDD-208', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(600, '4780257', 'DPW-207', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(601, '4780257', 'EDD-203', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(602, '4780257', 'EST-201', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(603, '4780257', 'PDM-205', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(604, '4780257', 'PRG-202', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(605, '4780257', 'RDC-204', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(606, '4780257', 'ADS-306', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(607, '4780257', 'BDD-308', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(608, '4780257', 'DPW-302', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(609, '4780257', 'EMP-301', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(610, '4780257', 'GMC-303', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(611, '4780257', 'PDM-307', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(612, '4780257', 'RDC-304', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(613, '4780257', 'TMG-305', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(614, '2222222', 'ADS-206', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(615, '2222222', 'BDD-208', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(616, '2222222', 'DPW-207', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(617, '2222222', 'EDD-203', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(618, '2222222', 'EST-201', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(619, '2222222', 'PDM-205', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(620, '2222222', 'PRG-202', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL);
INSERT INTO `inscripcion` (`id`, `ci_est`, `cod_asig`, `id_sec`, `fecha`, `gestion`, `turno`, `grupo`, `tipo`, `activo`, `estado_final`, `observaciones`) VALUES
(621, '2222222', 'RDC-204', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(622, '2222222', 'ADS-306', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(623, '2222222', 'BDD-308', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(624, '2222222', 'DPW-302', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(625, '2222222', 'EMP-301', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(626, '2222222', 'GMC-303', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(627, '2222222', 'PDM-307', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(628, '2222222', 'RDC-304', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(629, '2222222', 'TMG-305', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(630, '7685676', 'ADS-206', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(631, '7685676', 'BDD-208', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(632, '7685676', 'DPW-207', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(633, '7685676', 'EDD-203', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(634, '7685676', 'EST-201', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(635, '7685676', 'PDM-205', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(636, '7685676', 'PRG-202', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(637, '7685676', 'RDC-204', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(638, '7685676', 'ADS-306', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(639, '7685676', 'BDD-308', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(640, '7685676', 'DPW-302', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(641, '7685676', 'EMP-301', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(642, '7685676', 'GMC-303', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(643, '7685676', 'PDM-307', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(644, '7685676', 'RDC-304', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(645, '7685676', 'TMG-305', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(646, '2736234', 'ADS-206', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(647, '2736234', 'BDD-208', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(648, '2736234', 'DPW-207', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(649, '2736234', 'EDD-203', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(650, '2736234', 'EST-201', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(651, '2736234', 'PDM-205', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(652, '2736234', 'PRG-202', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(653, '2736234', 'RDC-204', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(654, '2736234', 'ADS-306', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(655, '2736234', 'BDD-308', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(656, '2736234', 'DPW-302', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(657, '2736234', 'EMP-301', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(658, '2736234', 'GMC-303', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(659, '2736234', 'PDM-307', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(660, '2736234', 'RDC-304', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(661, '2736234', 'TMG-305', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(662, '10203203', 'MPI-101', 1, '2025-06-01', '2025', 'TARDE', 'B', 'Regular', 1, 'APROBADO', 'REPITE 1ER AÑO'),
(663, '10203203', 'PROG-102', 1, '2025-06-01', '2025', 'TARDE', 'B', 'Regular', 1, 'APROBADO', 'REPITE 1ER AÑO'),
(664, '10203203', 'INT-103', 1, '2025-06-01', '2025', 'TARDE', 'B', 'Regular', 1, 'APROBADO', 'REPITE 1ER AÑO'),
(665, '10203203', 'HDC-104', 1, '2025-06-01', '2025', 'TARDE', 'B', 'Regular', 1, 'APROBADO', 'REPITE 1ER AÑO'),
(666, '10203203', 'TSO-105', 1, '2025-06-01', '2025', 'TARDE', 'B', 'Regular', 1, 'APROBADO', 'REPITE 1ER AÑO'),
(667, '10203203', 'OMT-106', 1, '2025-06-01', '2025', 'TARDE', 'B', 'Regular', 1, 'APROBADO', 'REPITE 1ER AÑO'),
(668, '10203203', 'DPW-107', 1, '2025-06-01', '2025', 'TARDE', 'B', 'Regular', 1, 'APROBADO', 'REPITE 1ER AÑO'),
(669, '10203203', 'ADS-206', 1, '2026-06-01', '2026', 'TARDE', 'B', 'Regular', 1, 'APROBADO', NULL),
(670, '10203203', 'BDD-208', 1, '2026-06-01', '2026', 'TARDE', 'B', 'Regular', 1, 'APROBADO', NULL),
(671, '10203203', 'DPW-207', 1, '2026-06-01', '2026', 'TARDE', 'B', 'Regular', 1, 'APROBADO', NULL),
(672, '10203203', 'EDD-203', 1, '2026-06-01', '2026', 'TARDE', 'B', 'Regular', 1, 'APROBADO', NULL),
(673, '10203203', 'EST-201', 1, '2026-06-01', '2026', 'TARDE', 'B', 'Regular', 1, 'APROBADO', NULL),
(674, '10203203', 'PDM-205', 1, '2026-06-01', '2026', 'TARDE', 'B', 'Regular', 1, 'APROBADO', NULL),
(675, '10203203', 'PRG-202', 1, '2026-06-01', '2026', 'TARDE', 'B', 'Regular', 1, 'APROBADO', NULL),
(676, '10203203', 'RDC-204', 1, '2026-06-01', '2026', 'TARDE', 'B', 'Regular', 1, 'APROBADO', NULL),
(677, '38283283', 'MPI-101', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', 'REPITE 1ER AÑO'),
(678, '38283283', 'PROG-102', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', 'REPITE 1ER AÑO'),
(679, '38283283', 'INT-103', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', 'REPITE 1ER AÑO'),
(680, '38283283', 'HDC-104', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', 'REPITE 1ER AÑO'),
(681, '38283283', 'TSO-105', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', 'REPITE 1ER AÑO'),
(682, '38283283', 'OMT-106', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', 'REPITE 1ER AÑO'),
(683, '38283283', 'DPW-107', 1, '2025-06-01', '2025', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', 'REPITE 1ER AÑO'),
(684, '38283283', 'ADS-206', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(685, '38283283', 'BDD-208', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(686, '38283283', 'DPW-207', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(687, '38283283', 'EDD-203', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(688, '38283283', 'EST-201', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(689, '38283283', 'PDM-205', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(690, '38283283', 'PRG-202', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(691, '38283283', 'RDC-204', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(692, '48574857', 'ADS-206', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(693, '48574857', 'BDD-208', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(694, '48574857', 'DPW-207', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(695, '48574857', 'EDD-203', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(696, '48574857', 'EST-201', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(697, '48574857', 'PDM-205', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(698, '48574857', 'PRG-202', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(699, '48574857', 'RDC-204', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(700, '4780223', 'ADS-206', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(701, '4780223', 'BDD-208', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(702, '4780223', 'DPW-207', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(703, '4780223', 'EDD-203', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(704, '4780223', 'EST-201', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(705, '4780223', 'PDM-205', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(706, '4780223', 'PRG-202', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(707, '4780223', 'RDC-204', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(708, '46574343', 'ADS-206', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(709, '46574343', 'BDD-208', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(710, '46574343', 'DPW-207', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(711, '46574343', 'EDD-203', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(712, '46574343', 'EST-201', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(713, '46574343', 'PDM-205', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(714, '46574343', 'PRG-202', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(715, '46574343', 'RDC-204', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(716, '4780252', 'ADS-206', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(717, '4780252', 'BDD-208', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(718, '4780252', 'DPW-207', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(719, '4780252', 'EDD-203', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(720, '4780252', 'EST-201', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(721, '4780252', 'PDM-205', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(722, '4780252', 'PRG-202', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(723, '4780252', 'RDC-204', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(724, '47892832', 'ADS-206', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(725, '47892832', 'BDD-208', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(726, '47892832', 'DPW-207', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(727, '47892832', 'EDD-203', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(728, '47892832', 'EST-201', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(729, '47892832', 'PDM-205', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(730, '47892832', 'PRG-202', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(731, '47892832', 'RDC-204', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(732, '45645467', 'ADS-206', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(733, '45645467', 'BDD-208', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(734, '45645467', 'DPW-207', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(735, '45645467', 'EDD-203', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(736, '45645467', 'EST-201', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(737, '45645467', 'PDM-205', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(738, '45645467', 'PRG-202', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(739, '45645467', 'RDC-204', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(740, '190102033', 'ADS-206', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(741, '190102033', 'BDD-208', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(742, '190102033', 'DPW-207', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(743, '190102033', 'EDD-203', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(744, '190102033', 'EST-201', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(745, '190102033', 'PDM-205', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(746, '190102033', 'PRG-202', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(747, '190102033', 'RDC-204', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(748, '45345353', 'ADS-206', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(749, '45345353', 'BDD-208', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(750, '45345353', 'DPW-207', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(751, '45345353', 'EDD-203', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(752, '45345353', 'EST-201', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(753, '45345353', 'PDM-205', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(754, '45345353', 'PRG-202', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(755, '45345353', 'RDC-204', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', NULL),
(756, '37473743', 'MPI-101', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', 'REPITE 1ER AÑO'),
(757, '37473743', 'PROG-102', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', 'REPITE 1ER AÑO'),
(758, '37473743', 'INT-103', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', 'REPITE 1ER AÑO'),
(759, '37473743', 'HDC-104', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', 'REPITE 1ER AÑO'),
(760, '37473743', 'TSO-105', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', 'REPITE 1ER AÑO'),
(761, '37473743', 'OMT-106', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', 'REPITE 1ER AÑO'),
(762, '37473743', 'DPW-107', 1, '2026-06-01', '2026', 'MAÑANA', 'A', 'Regular', 1, 'APROBADO', 'REPITE 1ER AÑO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prerequisito`
--

CREATE TABLE `prerequisito` (
  `id` int(11) NOT NULL,
  `cod_asig` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL COMMENT 'Asignatura que requiere un prerequisito',
  `cod_req` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL COMMENT 'Asignatura que funciona como prerequisito'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `prerequisito`
--

INSERT INTO `prerequisito` (`id`, `cod_asig`, `cod_req`) VALUES
(1, 'PRG-202', 'PROG-102'),
(2, 'DPW-207', 'DPW-107'),
(3, 'DPW-302', 'DPW-207'),
(4, 'RDC-304', 'RDC-204'),
(5, 'ADS-306', 'ADS-206'),
(6, 'PDM-307', 'PDM-205'),
(7, 'BDD-308', 'BDD-208');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `nombre`, `descripcion`, `activo`) VALUES
(1, 'ADMIN', 'Administrador del sistema con acceso total', 1),
(2, 'SECRETARIA', 'Secretaria académica, gestiona inscripciones', 1),
(3, 'ESTUDIANTE', 'Estudiante, consulta y gestión de sus materias', 1),
(4, 'DOCENTE', 'Docente, gestión de notas y materias asignadas', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `secretaria`
--

CREATE TABLE `secretaria` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `secretaria`
--

INSERT INTO `secretaria` (`id`, `nombre`, `id_usuario`, `activo`) VALUES
(1, 'SECRETARIA CENTRAL', 15, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `usuario` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `clave` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `id_rol` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `usuario`, `clave`, `id_rol`, `activo`) VALUES
(1, '12345678', '123456', 3, 1),
(2, '2222222', '123456', 3, 1),
(3, '7685675', '123456', 3, 1),
(4, '4780257', '123456', 3, 1),
(5, '2736233', '123456', 3, 1),
(6, '10203203', '123456', 3, 1),
(7, '10223203', '123456', 3, 0),
(8, '38283283', '123456', 3, 1),
(9, '7685676', '123456', 3, 1),
(10, '2736234', '123456', 3, 1),
(11, '48574857', '123456', 3, 1),
(12, '11239832', '123456', 3, 0),
(13, '4780223', '123456', 3, 1),
(14, '46574343', '123456', 3, 1),
(15, 'secretaria', '123456', 2, 1),
(16, 'admin', '123456', 1, 1),
(19, '4780252', '123456', 3, 1),
(20, '47892832', '123456', 3, 1),
(21, '45645467', '123456', 3, 1),
(22, '37473743', '123456', 3, 1),
(23, '190102033', '123456', 3, 1),
(24, '45463464', '123456', 3, 1),
(25, '121232431', '123456', 3, 1),
(26, '45345353', '123456', 3, 1),
(35, '5550001', '123456', 4, 1),
(36, '5550002', '123456', 4, 1),
(37, '5550003', '123456', 4, 1),
(38, '5550004', '123456', 4, 1),
(39, '5550005', '123456', 4, 1),
(40, '5550006', '123456', 4, 1),
(41, '5550007', '123456', 4, 1),
(42, '5550008', '123456', 4, 1),
(43, '5550009', '123456', 4, 1),
(44, '5550010', '123456', 4, 1),
(45, '5550011', '123456', 4, 1),
(46, '61234567', '123456', 3, 1),
(47, '61234568', '123456', 3, 1),
(48, '61234569', '123456', 3, 1),
(49, '61234570', '123456', 3, 1),
(50, '61234571', '123456', 3, 1),
(51, '61234572', '123456', 3, 1),
(52, '61234573', '123456', 3, 1),
(53, '61234574', '123456', 3, 1),
(54, '62345671', '123456', 3, 1),
(55, '62345672', '123456', 3, 1),
(56, '62345673', '123456', 3, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asignacion_docente`
--
ALTER TABLE `asignacion_docente`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_docente_materia` (`id_docente`,`cod_asig`),
  ADD KEY `fk_asigdoc_materia` (`cod_asig`);

--
-- Indices de la tabla `asignatura`
--
ALTER TABLE `asignatura`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `idx_asig_carrera` (`id_carrera`);

--
-- Indices de la tabla `carrera`
--
ALTER TABLE `carrera`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `docente`
--
ALTER TABLE `docente`
  ADD PRIMARY KEY (`id_docente`),
  ADD UNIQUE KEY `ci` (`ci`),
  ADD KEY `fk_doc_rol` (`id_rol`);

--
-- Indices de la tabla `documentos_est`
--
ALTER TABLE `documentos_est`
  ADD PRIMARY KEY (`id_documento`),
  ADD KEY `ci_est` (`ci_est`);

--
-- Indices de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD PRIMARY KEY (`ci`),
  ADD KEY `fk_est_carrera` (`id_carrera`),
  ADD KEY `fk_est_usuario` (`id_usuario`);

--
-- Indices de la tabla `historial`
--
ALTER TABLE `historial`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_estudiante_materia_gestion` (`ci_est`,`cod_asig`,`gestion`),
  ADD KEY `ci_est` (`ci_est`),
  ADD KEY `id_docente` (`id_docente`);

--
-- Indices de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_inscripcion_est_mat_gestion` (`ci_est`,`cod_asig`,`gestion`),
  ADD KEY `fk_ins_estudiante` (`ci_est`),
  ADD KEY `fk_ins_asignatura` (`cod_asig`),
  ADD KEY `fk_ins_secretaria` (`id_sec`);

--
-- Indices de la tabla `prerequisito`
--
ALTER TABLE `prerequisito`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_prereq_asig` (`cod_asig`),
  ADD KEY `fk_prereq_req` (`cod_req`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_rol_nombre` (`nombre`);

--
-- Indices de la tabla `secretaria`
--
ALTER TABLE `secretaria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sec_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD KEY `fk_usu_rol` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asignacion_docente`
--
ALTER TABLE `asignacion_docente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `docente`
--
ALTER TABLE `docente`
  MODIFY `id_docente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `documentos_est`
--
ALTER TABLE `documentos_est`
  MODIFY `id_documento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historial`
--
ALTER TABLE `historial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1018;

--
-- AUTO_INCREMENT de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=763;

--
-- AUTO_INCREMENT de la tabla `prerequisito`
--
ALTER TABLE `prerequisito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `secretaria`
--
ALTER TABLE `secretaria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignacion_docente`
--
ALTER TABLE `asignacion_docente`
  ADD CONSTRAINT `fk_asigdoc_docente` FOREIGN KEY (`id_docente`) REFERENCES `docente` (`id_docente`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_asigdoc_materia` FOREIGN KEY (`cod_asig`) REFERENCES `asignatura` (`codigo`) ON DELETE CASCADE;

--
-- Filtros para la tabla `asignatura`
--
ALTER TABLE `asignatura`
  ADD CONSTRAINT `fk_asig_carrera` FOREIGN KEY (`id_carrera`) REFERENCES `carrera` (`id`);

--
-- Filtros para la tabla `docente`
--
ALTER TABLE `docente`
  ADD CONSTRAINT `fk_doc_rol` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Filtros para la tabla `documentos_est`
--
ALTER TABLE `documentos_est`
  ADD CONSTRAINT `documentos_est_ibfk_1` FOREIGN KEY (`ci_est`) REFERENCES `estudiante` (`ci`);

--
-- Filtros para la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD CONSTRAINT `fk_est_carrera` FOREIGN KEY (`id_carrera`) REFERENCES `carrera` (`id`),
  ADD CONSTRAINT `fk_est_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `historial`
--
ALTER TABLE `historial`
  ADD CONSTRAINT `historial_ibfk_1` FOREIGN KEY (`ci_est`) REFERENCES `estudiante` (`ci`),
  ADD CONSTRAINT `historial_ibfk_2` FOREIGN KEY (`id_docente`) REFERENCES `docente` (`id_docente`);

--
-- Filtros para la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  ADD CONSTRAINT `fk_ins_asignatura` FOREIGN KEY (`cod_asig`) REFERENCES `asignatura` (`codigo`),
  ADD CONSTRAINT `fk_ins_estudiante` FOREIGN KEY (`ci_est`) REFERENCES `estudiante` (`ci`),
  ADD CONSTRAINT `fk_ins_secretaria` FOREIGN KEY (`id_sec`) REFERENCES `secretaria` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `prerequisito`
--
ALTER TABLE `prerequisito`
  ADD CONSTRAINT `fk_prereq_asig` FOREIGN KEY (`cod_asig`) REFERENCES `asignatura` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_prereq_req` FOREIGN KEY (`cod_req`) REFERENCES `asignatura` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usu_rol` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
