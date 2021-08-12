-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-08-2021 a las 08:42:36
-- Versión del servidor: 5.7.32-log
-- Versión de PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sidiraunt`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actor`
--

CREATE TABLE `actor` (
  `codActor` int(11) NOT NULL,
  `apellidosYnombres` varchar(500) NOT NULL,
  `codUsuario` int(11) NOT NULL,
  `codTipoActor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `actor`
--

INSERT INTO `actor` (`codActor`, `apellidosYnombres`, `codUsuario`, `codTipoActor`) VALUES
(26045, 'CONSEJO UNIVERSITARIOO', 26061, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `analisis_examen`
--

CREATE TABLE `analisis_examen` (
  `codAnalisis` int(11) NOT NULL,
  `tasaIrregularidad` float DEFAULT NULL,
  `codExamen` int(11) NOT NULL,
  `tasaGI` float DEFAULT NULL,
  `tasaGP` float DEFAULT NULL,
  `tasaPE` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area`
--

CREATE TABLE `area` (
  `codArea` int(11) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `area` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `area`
--

INSERT INTO `area` (`codArea`, `descripcion`, `area`) VALUES
(1, 'CIENCIAS DE LA VIDA Y DE LA SALUD', 'A'),
(2, 'CIENCIAS BÁSICAS Y TECNOLÓGICAS', 'B'),
(3, 'CIENCIAS DE LA PERSONA', 'C'),
(4, 'CIENCIAS ECONÓMICAS', 'D');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrera`
--

CREATE TABLE `carrera` (
  `codCarrera` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `codAreaActual` char(1) NOT NULL,
  `codFacultad` int(11) NOT NULL,
  `abreviacionMayus` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `carrera`
--

INSERT INTO `carrera` (`codCarrera`, `nombre`, `codAreaActual`, `codFacultad`, `abreviacionMayus`) VALUES
(1, 'Ingenieria de Sistemas', '2', 7, 'IS'),
(2, 'Ciencias Biológicas', '1', 1, 'CCAS.BIOLOGICAS'),
(3, 'Enfermería', '1', 1, 'ENFERMERIA'),
(4, 'Farmacia y Bioquímica', '1', 1, 'FARMACIA y BBQQ.'),
(7, 'Medicina', '1', 1, 'MEDICINA'),
(8, 'Microbiología y Parasitologia', '1', 1, 'MICROBIOL.y PARAS.'),
(9, 'Estomatología', '1', 1, 'ESTOMATOLOGIA'),
(10, 'Biología pesquera', '1', 1, 'BIOLOGIA PESQUERA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrera_examen`
--

CREATE TABLE `carrera_examen` (
  `codCarreraExamen` int(11) NOT NULL,
  `cantidadVacantes` int(11) NOT NULL,
  `codExamen` int(11) NOT NULL,
  `codCarrera` int(11) NOT NULL,
  `puntajeMinimoPostulante` float NOT NULL,
  `puntajeMaximoPostulante` float NOT NULL,
  `puntajeMinimoPermitido` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `condicion_postulacion`
--

CREATE TABLE `condicion_postulacion` (
  `codCondicion` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `condicion_postulacion`
--

INSERT INTO `condicion_postulacion` (`codCondicion`, `nombre`) VALUES
(1, 'INGRESA'),
(2, 'ING. 2-OPC'),
(3, 'NO INGRESA'),
(4, 'AUSENTE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_examen`
--

CREATE TABLE `estado_examen` (
  `codEstado` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estado_examen`
--

INSERT INTO `estado_examen` (`codEstado`, `descripcion`) VALUES
(1, 'Creado'),
(3, 'Procesando'),
(4, 'Aprobado'),
(5, 'Cancelado'),
(6, 'Analizado'),
(7, 'Datos Insertados'),
(8, 'Archivos Cargados'),
(9, 'Archivos Preparados');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examen`
--

CREATE TABLE `examen` (
  `codExamen` int(11) NOT NULL,
  `año` int(11) NOT NULL,
  `fechaRendicion` date NOT NULL,
  `nroVacantes` int(11) DEFAULT NULL,
  `nroPostulantes` int(11) DEFAULT NULL,
  `asistentes` int(11) DEFAULT NULL,
  `ausentes` int(11) DEFAULT NULL,
  `codModalidad` int(11) NOT NULL,
  `codSede` int(11) NOT NULL,
  `codEstado` int(11) NOT NULL,
  `valoracionPositivaCON` float NOT NULL,
  `valoracionPositivaAPT` float NOT NULL,
  `valoracionNegativaCON` float NOT NULL,
  `valoracionNegativaAPT` float NOT NULL,
  `periodo` varchar(20) DEFAULT NULL,
  `codArea` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `examen`
--

INSERT INTO `examen` (`codExamen`, `año`, `fechaRendicion`, `nroVacantes`, `nroPostulantes`, `asistentes`, `ausentes`, `codModalidad`, `codSede`, `codEstado`, `valoracionPositivaCON`, `valoracionPositivaAPT`, `valoracionNegativaCON`, `valoracionNegativaAPT`, `periodo`, `codArea`) VALUES
(1, 2020, '2019-09-21', 53, 197, 197, 0, 1, 1, 9, 4.079, 4.07, -1.021, -1.019, '2020-I', 2),
(2, 2020, '2020-03-07', 53, 151, 151, 0, 1, 1, 9, 4.079, 4.07, -1.021, -1.019, '2020-II', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examen_postulante`
--

CREATE TABLE `examen_postulante` (
  `codExamenPostulante` int(11) NOT NULL,
  `orden` int(11) NOT NULL,
  `nroCarnet` varchar(10) NOT NULL,
  `codActor` int(11) NOT NULL,
  `puntajeAPT` float NOT NULL,
  `puntajeCON` float NOT NULL,
  `puntajeTotal` float NOT NULL,
  `puntajeMinimoPermitido` float NOT NULL,
  `codCarrera` int(11) NOT NULL,
  `codCondicion` int(11) NOT NULL,
  `respuestasJSON` varchar(1000) NOT NULL,
  `codExamen` int(11) NOT NULL,
  `nroCorrectas` int(11) NOT NULL,
  `nroIncorrectas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facultad`
--

CREATE TABLE `facultad` (
  `codFacultad` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `facultad`
--

INSERT INTO `facultad` (`codFacultad`, `nombre`) VALUES
(1, 'Facultad de Ciencias Biológicas'),
(2, 'Facultad de Farmacia y Bioquímica'),
(3, 'Facultad de Medicina'),
(4, 'Facultad de Estomatología'),
(5, 'Facultad de Enfermería'),
(6, 'Facultad de Ciencias Físicas y Matemáticas'),
(7, 'Facultad de Ingeniería'),
(8, 'Facultad de Ingeniería Química'),
(9, 'Facultad de Ciencias Sociales'),
(10, 'Facultad de Derecho y Ciencias Politicas'),
(11, 'Facultad de Ciencias Económicas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo_iguales`
--

CREATE TABLE `grupo_iguales` (
  `codGrupo` int(11) NOT NULL,
  `codAnalisis` int(11) NOT NULL,
  `puntajeAP` float NOT NULL,
  `puntajeCON` float NOT NULL,
  `puntajeTotal` float NOT NULL,
  `correctas` int(11) NOT NULL,
  `incorrectas` int(11) NOT NULL,
  `respuestasJSON` varchar(1000) NOT NULL,
  `vectorExamenPostulante` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo_patron`
--

CREATE TABLE `grupo_patron` (
  `codGrupoPatron` int(11) NOT NULL,
  `codAnalisis` int(11) NOT NULL,
  `nroIncorrectas` int(11) NOT NULL,
  `nroCorrectas` int(11) NOT NULL,
  `puntajeAdquirido` float NOT NULL,
  `respuestasCoincidentesJSON` varchar(1000) NOT NULL,
  `vectorExamenPostulante` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modalidad`
--

CREATE TABLE `modalidad` (
  `codModalidad` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `modalidad`
--

INSERT INTO `modalidad` (`codModalidad`, `nombre`) VALUES
(1, 'Ordinario'),
(2, 'Cepunt');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parametros`
--

CREATE TABLE `parametros` (
  `codParametro` int(11) NOT NULL,
  `campo` varchar(100) NOT NULL,
  `valor` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `parametros`
--

INSERT INTO `parametros` (`codParametro`, `campo`, `valor`) VALUES
(1, 'tasaToleranciaSubida', '0.8'),
(2, 'porcentajeUnificadorGI', '0.15'),
(3, 'porcentajeUnificadorGP', '0.25'),
(4, 'porcentajeUnificadPE', '0.2'),
(5, 'pesoTasaGI', '0.5'),
(6, 'pesoTasaGP', '0.2'),
(7, 'pesoTasaPE', '0.3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `postulantes_elevados`
--

CREATE TABLE `postulantes_elevados` (
  `codPostulanteElevado` int(11) NOT NULL,
  `porcentajeElevacion` char(18) NOT NULL,
  `puntajeDiferencia` float NOT NULL,
  `codExamenPostulanteAnterior` int(11) NOT NULL,
  `codAnalisis` int(11) NOT NULL,
  `codExamenPostulante` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta`
--

CREATE TABLE `pregunta` (
  `codPregunta` int(11) NOT NULL,
  `nroPregunta` int(11) NOT NULL,
  `enunciado` varchar(200) NOT NULL,
  `codExamen` int(11) NOT NULL,
  `respuestaCorrecta` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pregunta`
--

INSERT INTO `pregunta` (`codPregunta`, `nroPregunta`, `enunciado`, `codExamen`, `respuestaCorrecta`) VALUES
(8275, 1, 'ABC', 1, 'A'),
(8276, 2, 'ESTA ES LA PREGUNTA 2', 1, 'B'),
(8277, 3, 'ASD KADSK K AKS A3 3', 1, 'B'),
(8278, 4, 'ASKD KSA KDSA KK SAD4A', 1, 'B'),
(8279, 5, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA ', 1, 'B'),
(8280, 6, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8281, 7, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8282, 8, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8283, 9, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8284, 10, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'A'),
(8285, 11, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8286, 12, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8287, 13, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8288, 14, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8289, 15, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8290, 16, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8291, 17, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA 17', 1, 'B'),
(8292, 18, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8293, 19, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8294, 20, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'A'),
(8295, 21, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8296, 22, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8297, 23, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8298, 24, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8299, 25, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8300, 26, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8301, 27, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8302, 28, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8303, 29, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8304, 30, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8305, 31, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8306, 32, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA 32', 1, 'B'),
(8307, 33, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8308, 34, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8309, 35, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8310, 36, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8311, 37, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8312, 38, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8313, 39, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8314, 40, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8315, 41, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8316, 42, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8317, 43, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8318, 44, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8319, 45, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8320, 46, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8321, 47, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8322, 48, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8323, 49, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8324, 50, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8325, 51, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8326, 52, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8327, 53, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8328, 54, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8329, 55, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8330, 56, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8331, 57, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8332, 58, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA 58', 1, 'B'),
(8333, 59, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8334, 60, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8335, 61, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8336, 62, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8337, 63, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8338, 64, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8339, 65, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8340, 66, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8341, 67, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8342, 68, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8343, 69, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8344, 70, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8345, 71, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8346, 72, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8347, 73, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8348, 74, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8349, 75, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8350, 76, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8351, 77, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8352, 78, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8353, 79, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8354, 80, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8355, 81, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8356, 82, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8357, 83, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8358, 84, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8359, 85, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8360, 86, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8361, 87, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8362, 88, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8363, 89, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8364, 90, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8365, 91, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8366, 92, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8367, 93, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8368, 94, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8369, 95, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8370, 96, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8371, 97, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8372, 98, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8373, 99, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 1, 'B'),
(8374, 100, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LD100', 1, 'D'),
(8375, 1, 'ABC', 2, 'A'),
(8376, 2, 'ESTA ES LA PREGUNTA 2', 2, 'B'),
(8377, 3, 'ASD KADSK K AKS A3 3', 2, 'B'),
(8378, 4, 'ASKD KSA KDSA KK SAD4A', 2, 'B'),
(8379, 5, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8380, 6, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8381, 7, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8382, 8, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8383, 9, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8384, 10, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'A'),
(8385, 11, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8386, 12, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8387, 13, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8388, 14, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8389, 15, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8390, 16, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8391, 17, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA 17', 2, 'B'),
(8392, 18, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8393, 19, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8394, 20, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'A'),
(8395, 21, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8396, 22, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8397, 23, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8398, 24, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8399, 25, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8400, 26, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8401, 27, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8402, 28, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8403, 29, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8404, 30, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8405, 31, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8406, 32, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA 32', 2, 'B'),
(8407, 33, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8408, 34, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8409, 35, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8410, 36, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8411, 37, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8412, 38, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8413, 39, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8414, 40, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8415, 41, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8416, 42, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8417, 43, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8418, 44, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8419, 45, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8420, 46, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8421, 47, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8422, 48, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8423, 49, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8424, 50, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8425, 51, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8426, 52, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8427, 53, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8428, 54, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8429, 55, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8430, 56, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8431, 57, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8432, 58, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA 58', 2, 'B'),
(8433, 59, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8434, 60, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8435, 61, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8436, 62, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8437, 63, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8438, 64, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8439, 65, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8440, 66, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8441, 67, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8442, 68, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8443, 69, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8444, 70, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8445, 71, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8446, 72, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8447, 73, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8448, 74, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8449, 75, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8450, 76, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8451, 77, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8452, 78, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8453, 79, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8454, 80, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8455, 81, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8456, 82, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8457, 83, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8458, 84, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8459, 85, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8460, 86, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8461, 87, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8462, 88, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8463, 89, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8464, 90, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8465, 91, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8466, 92, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8467, 93, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8468, 94, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8469, 95, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8470, 96, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8471, 97, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8472, 98, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8473, 99, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LDSLA LDS ALD SAD', 2, 'B'),
(8474, 100, 'AASAS DDSA KSA KDSA KKSA KD AKDSKA KD A3 SAD LASL SALDSA LD100', 2, 'D');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sede`
--

CREATE TABLE `sede` (
  `codSede` int(11) NOT NULL,
  `nombre` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `sede`
--

INSERT INTO `sede` (`codSede`, `nombre`) VALUES
(4, 'Trujillo'),
(5, 'Huamachuco');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tasa`
--

CREATE TABLE `tasa` (
  `codTasa` int(11) NOT NULL,
  `valorMinimo` float NOT NULL,
  `valorMaximo` float NOT NULL,
  `valorTasa` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tasa`
--

INSERT INTO `tasa` (`codTasa`, `valorMinimo`, `valorMaximo`, `valorTasa`) VALUES
(1, 0, 50, 0.45),
(2, 50, 100, 0.5),
(7, 100, 150, 0.55),
(8, 150, 200, 0.6),
(9, 200, 250, 0.65),
(10, 250, 300, 0.7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_actor`
--

CREATE TABLE `tipo_actor` (
  `codTipoActor` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_actor`
--

INSERT INTO `tipo_actor` (`codTipoActor`, `nombre`) VALUES
(1, 'Postulante'),
(2, 'Consejo Universitario'),
(3, 'Dirección de Sistemas y Comunicaciones');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `codUsuario` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contraseña` varchar(200) DEFAULT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`codUsuario`, `usuario`, `contraseña`, `password`) VALUES
(26061, 'CONSEJO_UNIVERSITARIO', '', '$2y$10$wa00IMw4CNdUr1BihEkFMOeHmVV.ZGQ4jVaLSJUsfLe5swYZl3rMy'),
(29430, 'admin', NULL, '$2y$10$yC9YYQj/XkY0f7y8TjhkRuC72yl9BtgZzhmAaejQGUqEqHD.y9/bW');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actor`
--
ALTER TABLE `actor`
  ADD PRIMARY KEY (`codActor`);

--
-- Indices de la tabla `analisis_examen`
--
ALTER TABLE `analisis_examen`
  ADD PRIMARY KEY (`codAnalisis`);

--
-- Indices de la tabla `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`codArea`);

--
-- Indices de la tabla `carrera`
--
ALTER TABLE `carrera`
  ADD PRIMARY KEY (`codCarrera`);

--
-- Indices de la tabla `carrera_examen`
--
ALTER TABLE `carrera_examen`
  ADD PRIMARY KEY (`codCarreraExamen`);

--
-- Indices de la tabla `condicion_postulacion`
--
ALTER TABLE `condicion_postulacion`
  ADD PRIMARY KEY (`codCondicion`);

--
-- Indices de la tabla `estado_examen`
--
ALTER TABLE `estado_examen`
  ADD PRIMARY KEY (`codEstado`);

--
-- Indices de la tabla `examen`
--
ALTER TABLE `examen`
  ADD PRIMARY KEY (`codExamen`);

--
-- Indices de la tabla `examen_postulante`
--
ALTER TABLE `examen_postulante`
  ADD PRIMARY KEY (`codExamenPostulante`);

--
-- Indices de la tabla `facultad`
--
ALTER TABLE `facultad`
  ADD PRIMARY KEY (`codFacultad`);

--
-- Indices de la tabla `grupo_iguales`
--
ALTER TABLE `grupo_iguales`
  ADD PRIMARY KEY (`codGrupo`);

--
-- Indices de la tabla `grupo_patron`
--
ALTER TABLE `grupo_patron`
  ADD PRIMARY KEY (`codGrupoPatron`);

--
-- Indices de la tabla `modalidad`
--
ALTER TABLE `modalidad`
  ADD PRIMARY KEY (`codModalidad`);

--
-- Indices de la tabla `parametros`
--
ALTER TABLE `parametros`
  ADD PRIMARY KEY (`codParametro`);

--
-- Indices de la tabla `postulantes_elevados`
--
ALTER TABLE `postulantes_elevados`
  ADD PRIMARY KEY (`codPostulanteElevado`);

--
-- Indices de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD PRIMARY KEY (`codPregunta`);

--
-- Indices de la tabla `sede`
--
ALTER TABLE `sede`
  ADD PRIMARY KEY (`codSede`);

--
-- Indices de la tabla `tasa`
--
ALTER TABLE `tasa`
  ADD PRIMARY KEY (`codTasa`);

--
-- Indices de la tabla `tipo_actor`
--
ALTER TABLE `tipo_actor`
  ADD PRIMARY KEY (`codTipoActor`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`codUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actor`
--
ALTER TABLE `actor`
  MODIFY `codActor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30006;

--
-- AUTO_INCREMENT de la tabla `analisis_examen`
--
ALTER TABLE `analisis_examen`
  MODIFY `codAnalisis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT de la tabla `area`
--
ALTER TABLE `area`
  MODIFY `codArea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `carrera`
--
ALTER TABLE `carrera`
  MODIFY `codCarrera` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `carrera_examen`
--
ALTER TABLE `carrera_examen`
  MODIFY `codCarreraExamen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `condicion_postulacion`
--
ALTER TABLE `condicion_postulacion`
  MODIFY `codCondicion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `estado_examen`
--
ALTER TABLE `estado_examen`
  MODIFY `codEstado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `examen`
--
ALTER TABLE `examen`
  MODIFY `codExamen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `examen_postulante`
--
ALTER TABLE `examen_postulante`
  MODIFY `codExamenPostulante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31962;

--
-- AUTO_INCREMENT de la tabla `facultad`
--
ALTER TABLE `facultad`
  MODIFY `codFacultad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `grupo_iguales`
--
ALTER TABLE `grupo_iguales`
  MODIFY `codGrupo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `grupo_patron`
--
ALTER TABLE `grupo_patron`
  MODIFY `codGrupoPatron` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=785;

--
-- AUTO_INCREMENT de la tabla `modalidad`
--
ALTER TABLE `modalidad`
  MODIFY `codModalidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `parametros`
--
ALTER TABLE `parametros`
  MODIFY `codParametro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `postulantes_elevados`
--
ALTER TABLE `postulantes_elevados`
  MODIFY `codPostulanteElevado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  MODIFY `codPregunta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8475;

--
-- AUTO_INCREMENT de la tabla `sede`
--
ALTER TABLE `sede`
  MODIFY `codSede` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tasa`
--
ALTER TABLE `tasa`
  MODIFY `codTasa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tipo_actor`
--
ALTER TABLE `tipo_actor`
  MODIFY `codTipoActor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `codUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30022;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
