-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 13-11-2015 a las 03:41:34
-- Versión del servidor: 5.5.38
-- Versión de PHP: 5.4.4-14+deb7u12

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de datos: `uncsurveysdb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `columnaspreguntas`
--

CREATE TABLE IF NOT EXISTS `columnaspreguntas` (
  `idColumna` int(11) NOT NULL AUTO_INCREMENT,
  `idPregunta` int(11) NOT NULL,
  `Ponderacion` int(11) NOT NULL,
  `Texto` varchar(300) NOT NULL,
  PRIMARY KEY (`idColumna`),
  KEY `idPregunta` (`idPregunta`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `destinatariosnotificacion`
--

CREATE TABLE IF NOT EXISTS `destinatariosnotificacion` (
  `idNotificacion` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Leido` tinyint(1) NOT NULL DEFAULT '0',
  `FechaLeido` date DEFAULT NULL,
  PRIMARY KEY (`idNotificacion`,`idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuestas`
--

CREATE TABLE IF NOT EXISTS `encuestas` (
  `idEncuesta` int(11) NOT NULL AUTO_INCREMENT,
  `idTema` int(11) NOT NULL,
  `idTipoEncuesta` int(11) NOT NULL,
  `idEstado` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Titulo` varchar(250) NOT NULL,
  `Descripcion` text,
  `CodigoAcceso` varchar(100) DEFAULT NULL,
  `FechaCarga` date DEFAULT NULL,
  `FechaRecopilacion` date DEFAULT NULL,
  `FechaCierre` date DEFAULT NULL,
  `idUsuarioCierre` int(11) DEFAULT NULL,
  `FechaLimite` date DEFAULT NULL,
  `HoraLimite` time DEFAULT NULL,
  `CantMaxAccesos` int(11) DEFAULT '10000',
  `ClaveAcceso` varchar(100) DEFAULT NULL,
  `TieneClave` tinyint(1) DEFAULT '0',
  `MostrarResultados` tinyint(4) DEFAULT '1',
  `Proposito` text,
  `Poblacion` text,
  `CaractecisticasMuestra` text,
  `BloquearIP` tinyint(1) NOT NULL DEFAULT '1',
  `tieneIdentificadores` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idEncuesta`),
  KEY `idTema` (`idTema`,`idEstado`,`idUsuario`),
  KEY `idEstado` (`idEstado`),
  KEY `idUsuario` (`idUsuario`),
  KEY `idTipoEncuesta` (`idTipoEncuesta`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuestasgrupos`
--

CREATE TABLE IF NOT EXISTS `encuestasgrupos` (
  `idGrupo` int(11) NOT NULL,
  `idEncuesta` int(11) NOT NULL,
  PRIMARY KEY (`idGrupo`,`idEncuesta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `escalas`
--

CREATE TABLE IF NOT EXISTS `escalas` (
  `idEscala` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(50) NOT NULL,
  PRIMARY KEY (`idEscala`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `escalas`
--

INSERT INTO `escalas` (`idEscala`, `Descripcion`) VALUES
(1, 'Nominal'),
(2, 'Ordinal'),
(3, 'Intervalo'),
(4, 'Razón / Proporción');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE IF NOT EXISTS `estados` (
  `idEstado` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(50) NOT NULL,
  PRIMARY KEY (`idEstado`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`idEstado`, `Descripcion`) VALUES
(1, 'Diseño'),
(2, 'Recopilación'),
(3, 'Cerrada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadosrespuestas`
--

CREATE TABLE IF NOT EXISTS `estadosrespuestas` (
  `idEstado` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(20) NOT NULL,
  PRIMARY KEY (`idEstado`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `estadosrespuestas`
--

INSERT INTO `estadosrespuestas` (`idEstado`, `Descripcion`) VALUES
(1, 'Incompleta'),
(2, 'Completa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formatos`
--

CREATE TABLE IF NOT EXISTS `formatos` (
  `idFormato` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(50) NOT NULL,
  PRIMARY KEY (`idFormato`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `formatos`
--

INSERT INTO `formatos` (`idFormato`, `Descripcion`) VALUES
(1, 'Texto'),
(2, 'Numeros Enteros'),
(3, 'Decimal'),
(4, 'Fecha'),
(5, 'Correo Electrónico');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE IF NOT EXISTS `grupos` (
  `idGrupo` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) NOT NULL,
  `FechaCreacion` date NOT NULL,
  `idAdministrador` int(11) NOT NULL,
  `Descripcion` varchar(500) DEFAULT NULL,
  `Activo` tinyint(1) NOT NULL DEFAULT '1',
  `FechaBaja` date NOT NULL,
  PRIMARY KEY (`idGrupo`),
  KEY `idAdministrador` (`idAdministrador`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `identificadoresparticipantes`
--

CREATE TABLE IF NOT EXISTS `identificadoresparticipantes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idEncuesta` int(11) NOT NULL,
  `idPeriodo` int(11) NOT NULL,
  `Identificacion` varchar(100) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logscambios`
--

CREATE TABLE IF NOT EXISTS `logscambios` (
  `idLog` int(11) NOT NULL AUTO_INCREMENT,
  `FechaHora` datetime NOT NULL,
  `idOperacion` int(11) NOT NULL,
  `Observaciones` text,
  `Usuario` varchar(50) NOT NULL,
  PRIMARY KEY (`idLog`),
  KEY `Usuario` (`Usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE IF NOT EXISTS `notificaciones` (
  `idNotificacion` int(11) NOT NULL AUTO_INCREMENT,
  `FechaCarga` date NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Titulo` varchar(200) NOT NULL,
  `Mensaje` text NOT NULL,
  PRIMARY KEY (`idNotificacion`),
  KEY `idUsuario` (`idUsuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opcionespreguntas`
--

CREATE TABLE IF NOT EXISTS `opcionespreguntas` (
  `idOpcion` int(11) NOT NULL AUTO_INCREMENT,
  `idPregunta` int(11) NOT NULL,
  `Texto` varchar(250) NOT NULL,
  `Orden` int(11) DEFAULT NULL,
  `Texto2` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idOpcion`),
  KEY `idPregunta` (`idPregunta`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operaciones`
--

CREATE TABLE IF NOT EXISTS `operaciones` (
  `idOperacion` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(50) NOT NULL,
  PRIMARY KEY (`idOperacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paginasencuestas`
--

CREATE TABLE IF NOT EXISTS `paginasencuestas` (
  `idPagina` int(11) NOT NULL AUTO_INCREMENT,
  `idEncuesta` int(11) NOT NULL,
  `Titulo` varchar(300) NOT NULL,
  `NroPagina` int(11) NOT NULL,
  PRIMARY KEY (`idPagina`),
  KEY `idEncuesta` (`idEncuesta`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodosrecopilacion`
--

CREATE TABLE IF NOT EXISTS `periodosrecopilacion` (
  `idPeriodo` int(11) NOT NULL AUTO_INCREMENT,
  `idEncuesta` int(11) NOT NULL,
  `FechaInicio` date NOT NULL,
  `FechaFin` date DEFAULT NULL,
  `Activo` tinyint(1) NOT NULL DEFAULT '1',
  `Titulo` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`idPeriodo`),
  KEY `idEncuesta` (`idEncuesta`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Estructura de tabla para la tabla `preguntasencuestas`
--

CREATE TABLE IF NOT EXISTS `preguntasencuestas` (
  `idPregunta` int(11) NOT NULL AUTO_INCREMENT,
  `idPagina` int(11) NOT NULL,
  `idEncuesta` int(11) NOT NULL,
  `idTipoPregunta` int(11) NOT NULL,
  `RespuestaObligatoria` tinyint(1) NOT NULL DEFAULT '1',
  `Texto` varchar(500) NOT NULL,
  `NroPregunta` int(11) NOT NULL,
  `AgregarOtro` tinyint(1) NOT NULL DEFAULT '0',
  `idEscala` int(11) DEFAULT NULL,
  `ValorMinimo` varchar(20) DEFAULT NULL,
  `ValorMaximo` varchar(20) DEFAULT NULL,
  `idFormato` int(11) DEFAULT NULL,
  `incluirAnalisis` tinyint(1) NOT NULL DEFAULT '1',
  `Diferencial` int(11) DEFAULT NULL,
  `Interpretacion` text,
  PRIMARY KEY (`idPregunta`),
  KEY `idEncuesta` (`idEncuesta`),
  KEY `idPagina` (`idPagina`),
  KEY `idTipoPregunta` (`idTipoPregunta`),
  KEY `idEscala` (`idEscala`),
  KEY `idFormato` (`idFormato`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recolectores`
--

CREATE TABLE IF NOT EXISTS `recolectores` (
  `idRecolector` int(11) NOT NULL AUTO_INCREMENT,
  `idEncuesta` int(11) NOT NULL,
  `idPeriodo` int(11) NOT NULL,
  `Tipo` varchar(50) CHARACTER SET utf8 NOT NULL,
  `FechaCarga` date NOT NULL,
  `Codigo` varchar(50) CHARACTER SET utf8 NOT NULL,
  `Asunto` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `Mensaje` text CHARACTER SET utf8,
  PRIMARY KEY (`idRecolector`),
  KEY `idEncuesta` (`idEncuesta`),
  KEY `idPeriodo` (`idPeriodo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recolectoresemails`
--

CREATE TABLE IF NOT EXISTS `recolectoresemails` (
  `idRecolector` int(11) NOT NULL AUTO_INCREMENT,
  `idEncuesta` int(11) NOT NULL,
  `idPeriodo` int(11) NOT NULL,
  `Email` varchar(200) CHARACTER SET utf8 NOT NULL,
  `CodigoAccesso` varchar(100) NOT NULL,
  PRIMARY KEY (`idRecolector`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=38 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas`
--

CREATE TABLE IF NOT EXISTS `respuestas` (
  `idRespuesta` int(11) NOT NULL AUTO_INCREMENT,
  `idEncuesta` int(11) NOT NULL,
  `FechaHoraInicio` datetime NOT NULL,
  `FechaHoraFin` datetime DEFAULT NULL,
  `IP` varchar(20) CHARACTER SET utf8 NOT NULL,
  `idEstado` int(11) NOT NULL,
  `TipoRecolector` varchar(50) CHARACTER SET utf8 NOT NULL,
  `Codigo` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `Identificacion` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `idPeriodo` int(11) NOT NULL,
  PRIMARY KEY (`idRespuesta`),
  KEY `idEncuesta` (`idEncuesta`),
  KEY `idEstado` (`idEstado`),
  KEY `idPeriodo` (`idPeriodo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestaspreguntas`
--

CREATE TABLE IF NOT EXISTS `respuestaspreguntas` (
  `idRP` int(11) NOT NULL AUTO_INCREMENT,
  `idRespuesta` int(11) NOT NULL,
  `idPregunta` int(11) NOT NULL,
  `idOpcion` int(11) DEFAULT NULL,
  `idColumna` int(11) DEFAULT NULL,
  `RespuestaTexto` text CHARACTER SET utf8,
  `Otro/a` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `FechaHoraCarga` datetime NOT NULL,
  PRIMARY KEY (`idRP`),
  KEY `idRespuesta` (`idRespuesta`),
  KEY `idPregunta` (`idPregunta`),
  KEY `idOpcion` (`idOpcion`),
  KEY `idColumna` (`idColumna`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tagsbusqueda`
--

CREATE TABLE IF NOT EXISTS `tagsbusqueda` (
  `idtag` int(11) NOT NULL AUTO_INCREMENT,
  `Tag` varchar(50) NOT NULL,
  PRIMARY KEY (`idtag`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tagsencuesta`
--

CREATE TABLE IF NOT EXISTS `tagsencuesta` (
  `idEncuesta` int(11) NOT NULL,
  `idTag` int(11) NOT NULL,
  PRIMARY KEY (`idEncuesta`,`idTag`),
  KEY `idTag` (`idTag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temas`
--

CREATE TABLE IF NOT EXISTS `temas` (
  `idTema` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(250) NOT NULL,
  `Activo` tinyint(1) NOT NULL DEFAULT '1',
  `FechaBaja` date DEFAULT NULL,
  PRIMARY KEY (`idTema`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20;

--
-- Volcado de datos para la tabla `temas`
--

INSERT INTO `temas` (`idTema`, `Descripcion`, `Activo`, `FechaBaja`) VALUES
(1, 'Otro', 1, NULL),
(2, 'Salud', 1, NULL),
(3, 'Educación', 1, NULL),
(4, 'Comercio', 1, NULL),
(5, 'Marketing', 1, NULL),
(6, 'Política', 1, NULL),
(7, 'Actualidad', 1, NULL),
(8, 'Tecnología', 1, NULL),
(9, 'Comunicaciones', 1, NULL),
(10, 'Sociedad', 1, NULL),
(11, 'Ciencia', 1, NULL),
(12, 'Industria Específica', 1, NULL),
(13, 'Investigación de Mercado', 1, NULL),
(14, 'Recursos Humanos', 1, NULL),
(15, 'Eventos', 1, NULL),
(16, 'Informática', 1, NULL),
(17, 'Demografía', 1, NULL),
(18, 'Servicio al cliente', 1, NULL),
(19, 'Medicina', 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiposencuestas`
--

CREATE TABLE IF NOT EXISTS `tiposencuestas` (
  `idTipoEncuesta` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(100) NOT NULL,
  `Observaciones` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`idTipoEncuesta`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `tiposencuestas`
--

INSERT INTO `tiposencuestas` (`idTipoEncuesta`, `Descripcion`, `Observaciones`) VALUES
(1, 'Transversal', 'El estudio transversal se caracteriza por realizar una única medición y por el\r\nestudio de fenómenos estables en el tiempo.'),
(2, 'Tendencia', 'Los estudios de tendencias miden los mismos ítems en el tiempo pero los obtienen de diferentes muestras de la población en cada ocasión'),
(3, 'Panel', 'En los estudios de panel, un grupo de individuos se muestrea y se retiene, y los mismos individuos responden una serie de preguntas en el tiempo.'),
(4, 'Cohorte', 'Los cohortes son grupos de personas definidos. Los individuos pertenencientes\r\nal cohorte comparten algún evento o caracterástica en común.'),
(5, 'Cross-Lagged', 'Las encuestas cross-lagged miden una variable dependiente y una variable independiente en dos puntos en el tiempo y por lo tanto nos permiten sacar conclusiones acerca de la causalidad.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipospreguntas`
--

CREATE TABLE IF NOT EXISTS `tipospreguntas` (
  `idTipoPregunta` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(50) NOT NULL,
  `Elemento` varchar(50) NOT NULL,
  `Clasificacion` varchar(50) NOT NULL,
  `Activo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idTipoPregunta`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Volcado de datos para la tabla `tipospreguntas`
--

INSERT INTO `tipospreguntas` (`idTipoPregunta`, `Descripcion`, `Elemento`, `Clasificacion`, `Activo`) VALUES
(1, 'Opción Múltiple - Una Respuesta', 'radio', 'Cerrada', 1),
(2, 'Opción Múltiple - Muchas Respuestas', 'checkbox', 'Cerrada', 1),
(3, 'Escala Likert', 'radio', 'Cerrada', 1),
(4, 'Tabla de opciones - Una Respuesta por fila', 'radio', 'Cerrada', 1),
(6, 'Campo de Texto', 'text', 'Abierta', 1),
(8, 'Campo de Texto Tipo Comentario', 'textarea', 'Abierta', 1),
(10, 'Datos Demográficos', '', 'Abierta', 1),
(11, 'Escala de diferencial semántico', '', 'Cerrada', 1),
(12, 'Dicotómica', 'radio', 'Cerrada', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `Usuario` varchar(50) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Apellido` varchar(50) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Email` varchar(150) NOT NULL,
  `idPais` int(11) NOT NULL,
  `FechaNac` date NOT NULL,
  `FechaCarga` date NOT NULL,
  `Activo` tinyint(1) NOT NULL DEFAULT '1',
  `FechaBaja` date NOT NULL,
  PRIMARY KEY (`idUsuario`),
  UNIQUE KEY `Usuario` (`Usuario`),
  KEY `idPais` (`idPais`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuariosgrupos`
--

CREATE TABLE IF NOT EXISTS `usuariosgrupos` (
  `idGrupo` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `FechaCarga` date NOT NULL,
  `Activo` tinyint(1) NOT NULL DEFAULT '1',
  `FechaBaja` date DEFAULT NULL,
  UNIQUE KEY `idGrupo` (`idGrupo`,`idUsuario`),
  KEY `idUsuario` (`idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `columnaspreguntas`
--
ALTER TABLE `columnaspreguntas`
  ADD CONSTRAINT `columnaspreguntas_ibfk_1` FOREIGN KEY (`idPregunta`) REFERENCES `preguntasencuestas` (`idPregunta`);

--
-- Filtros para la tabla `encuestas`
--
ALTER TABLE `encuestas`
  ADD CONSTRAINT `encuestas_ibfk_1` FOREIGN KEY (`idTema`) REFERENCES `temas` (`idTema`),
  ADD CONSTRAINT `encuestas_ibfk_2` FOREIGN KEY (`idEstado`) REFERENCES `estados` (`idEstado`),
  ADD CONSTRAINT `encuestas_ibfk_3` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`),
  ADD CONSTRAINT `encuestas_ibfk_4` FOREIGN KEY (`idTipoEncuesta`) REFERENCES `tiposencuestas` (`idTipoEncuesta`);

--
-- Filtros para la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD CONSTRAINT `grupos_ibfk_1` FOREIGN KEY (`idAdministrador`) REFERENCES `usuarios` (`idUsuario`);

--
-- Filtros para la tabla `paginasencuestas`
--
ALTER TABLE `paginasencuestas`
  ADD CONSTRAINT `paginasencuestas_ibfk_1` FOREIGN KEY (`idEncuesta`) REFERENCES `encuestas` (`idEncuesta`);

--
-- Filtros para la tabla `periodosrecopilacion`
--
ALTER TABLE `periodosrecopilacion`
  ADD CONSTRAINT `periodosrecopilacion_ibfk_1` FOREIGN KEY (`idEncuesta`) REFERENCES `encuestas` (`idEncuesta`);

--
-- Filtros para la tabla `preguntasencuestas`
--
ALTER TABLE `preguntasencuestas`
  ADD CONSTRAINT `preguntasencuestas_ibfk_2` FOREIGN KEY (`idEncuesta`) REFERENCES `encuestas` (`idEncuesta`),
  ADD CONSTRAINT `preguntasencuestas_ibfk_3` FOREIGN KEY (`idPagina`) REFERENCES `paginasencuestas` (`idPagina`),
  ADD CONSTRAINT `preguntasencuestas_ibfk_4` FOREIGN KEY (`idTipoPregunta`) REFERENCES `tipospreguntas` (`idTipoPregunta`),
  ADD CONSTRAINT `preguntasencuestas_ibfk_5` FOREIGN KEY (`idEscala`) REFERENCES `escalas` (`idEscala`),
  ADD CONSTRAINT `preguntasencuestas_ibfk_6` FOREIGN KEY (`idFormato`) REFERENCES `formatos` (`idFormato`);

--
-- Filtros para la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD CONSTRAINT `respuestas_ibfk_1` FOREIGN KEY (`idEncuesta`) REFERENCES `encuestas` (`idEncuesta`),
  ADD CONSTRAINT `respuestas_ibfk_2` FOREIGN KEY (`idEstado`) REFERENCES `estadosrespuestas` (`idEstado`);

--
-- Filtros para la tabla `respuestaspreguntas`
--
ALTER TABLE `respuestaspreguntas`
  ADD CONSTRAINT `respuestaspreguntas_ibfk_2` FOREIGN KEY (`idPregunta`) REFERENCES `preguntasencuestas` (`idPregunta`),
  ADD CONSTRAINT `respuestaspreguntas_ibfk_3` FOREIGN KEY (`idOpcion`) REFERENCES `opcionespreguntas` (`idOpcion`),
  ADD CONSTRAINT `respuestaspreguntas_ibfk_4` FOREIGN KEY (`idColumna`) REFERENCES `columnaspreguntas` (`idColumna`),
  ADD CONSTRAINT `respuestaspreguntas_ibfk_5` FOREIGN KEY (`idRespuesta`) REFERENCES `respuestas` (`idRespuesta`);

--
-- Filtros para la tabla `usuariosgrupos`
--
ALTER TABLE `usuariosgrupos`
  ADD CONSTRAINT `usuariosgrupos_ibfk_1` FOREIGN KEY (`idGrupo`) REFERENCES `grupos` (`idGrupo`),
  ADD CONSTRAINT `usuariosgrupos_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
