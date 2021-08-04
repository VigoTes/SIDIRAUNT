-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-08-2021 a las 23:31:35
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
(26045, 'CONSEJO UNIVERSITARIO', 26061, 2);

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

--
-- Volcado de datos para la tabla `carrera_examen`
--

INSERT INTO `carrera_examen` (`codCarreraExamen`, `cantidadVacantes`, `codExamen`, `codCarrera`, `puntajeMinimoPostulante`, `puntajeMaximoPostulante`, `puntajeMinimoPermitido`) VALUES
(1, 10, 1, 1, 120, 200, 100),
(2, 11, 2, 1, 130, 220, 100);

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
(8, 'Archivos Cargados');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examen`
--

CREATE TABLE `examen` (
  `codExamen` int(11) NOT NULL,
  `año` int(11) NOT NULL,
  `fechaRendicion` date NOT NULL,
  `nroVacantes` int(11) NOT NULL,
  `nroPostulantes` int(11) NOT NULL,
  `asistentes` int(11) DEFAULT NULL,
  `ausentes` int(11) DEFAULT NULL,
  `codModalidad` int(11) NOT NULL,
  `codSede` int(11) NOT NULL,
  `codEstado` int(11) NOT NULL,
  `valoracionPositivaCON` float NOT NULL,
  `valoracionPositivaAPT` float NOT NULL,
  `valoracionNegativaCON` float NOT NULL,
  `valoracionNegativaAPT` float NOT NULL,
  `periodo` varchar(20) NOT NULL,
  `codArea` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `examen`
--

INSERT INTO `examen` (`codExamen`, `año`, `fechaRendicion`, `nroVacantes`, `nroPostulantes`, `asistentes`, `ausentes`, `codModalidad`, `codSede`, `codEstado`, `valoracionPositivaCON`, `valoracionPositivaAPT`, `valoracionNegativaCON`, `valoracionNegativaAPT`, `periodo`, `codArea`) VALUES
(1, 2021, '2021-01-28', 53, 151, 151, 0, 1, 1, 8, 4.079, 4.07, -1.021, -1.019, '2021-I', 2),
(2, 2021, '2021-07-28', 53, 151, 151, 0, 1, 1, 8, 215, 152, 21, 21, '2021-II', 2);

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sede`
--

CREATE TABLE `sede` (
  `codSede` int(11) NOT NULL,
  `nombre` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(2, 'Consejo Universitario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `codUsuario` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contraseña` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`codUsuario`, `usuario`, `contraseña`, `password`) VALUES
(26061, 'CONSEJO', '', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

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
  MODIFY `codActor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27858;

--
-- AUTO_INCREMENT de la tabla `analisis_examen`
--
ALTER TABLE `analisis_examen`
  MODIFY `codAnalisis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

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
  MODIFY `codCarreraExamen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `condicion_postulacion`
--
ALTER TABLE `condicion_postulacion`
  MODIFY `codCondicion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `estado_examen`
--
ALTER TABLE `estado_examen`
  MODIFY `codEstado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `examen`
--
ALTER TABLE `examen`
  MODIFY `codExamen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `examen_postulante`
--
ALTER TABLE `examen_postulante`
  MODIFY `codExamenPostulante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29060;

--
-- AUTO_INCREMENT de la tabla `facultad`
--
ALTER TABLE `facultad`
  MODIFY `codFacultad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `grupo_iguales`
--
ALTER TABLE `grupo_iguales`
  MODIFY `codGrupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=270;

--
-- AUTO_INCREMENT de la tabla `grupo_patron`
--
ALTER TABLE `grupo_patron`
  MODIFY `codGrupoPatron` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=711;

--
-- AUTO_INCREMENT de la tabla `modalidad`
--
ALTER TABLE `modalidad`
  MODIFY `codModalidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `parametros`
--
ALTER TABLE `parametros`
  MODIFY `codParametro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `postulantes_elevados`
--
ALTER TABLE `postulantes_elevados`
  MODIFY `codPostulanteElevado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  MODIFY `codPregunta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5175;

--
-- AUTO_INCREMENT de la tabla `sede`
--
ALTER TABLE `sede`
  MODIFY `codSede` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tasa`
--
ALTER TABLE `tasa`
  MODIFY `codTasa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `tipo_actor`
--
ALTER TABLE `tipo_actor`
  MODIFY `codTipoActor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `codUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27874;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
