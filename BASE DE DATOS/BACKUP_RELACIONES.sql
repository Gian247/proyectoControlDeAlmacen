-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 26-01-2023 a las 10:55:05
-- Versión del servidor: 8.0.32-0buntu0.22.04.1
-- Versión de PHP: 8.0.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `lvc_pos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int NOT NULL,
  `categoria` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `categoria`) VALUES
(1, 'LIMPIEZA'),
(2, 'UTILES ESCOLARES'),
(3, 'UTILITARIOS'),
(4, 'OTROS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE `perfil` (
  `id_perfil` int NOT NULL,
  `perfil` varchar(30) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`id_perfil`, `perfil`) VALUES
(1, 'ADMINISTRADOR'),
(2, 'ADMINISTRATIVO'),
(3, 'LOGISTICA'),
(4, 'ADMINISTRACION LOGISTICA'),
(5, 'MANTENIMIENTO'),
(6, 'DOCENTE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int NOT NULL,
  `id_categoria` int NOT NULL,
  `codigo_producto` varchar(12) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` varchar(40) COLLATE utf8mb4_general_ci NOT NULL,
  `stock` int NOT NULL,
  `costo_unitario` float NOT NULL,
  `costo_total` float NOT NULL,
  `id_proveedor` int NOT NULL,
  `salidas` int NOT NULL,
  `fecha_ingreso` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `id_proveedor` int NOT NULL,
  `nombre_proveedor` varchar(60) COLLATE utf8mb4_general_ci NOT NULL,
  `rubro` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `contacto` varchar(90) COLLATE utf8mb4_general_ci NOT NULL,
  `telefono` varchar(12) COLLATE utf8mb4_general_ci NOT NULL,
  `ruc` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `correo` varchar(75) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salidas`
--

CREATE TABLE `salidas` (
  `id_salida` int NOT NULL,
  `codigo_salida` int NOT NULL,
  `id_solicitante` int NOT NULL,
  `id_usuario` int NOT NULL,
  `productos` text COLLATE utf8mb4_general_ci NOT NULL,
  `total_valor_salida` float NOT NULL,
  `fecha_salida` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitante`
--

CREATE TABLE `solicitante` (
  `id_solicitante` int NOT NULL,
  `nombres` varchar(60) COLLATE utf8mb4_general_ci NOT NULL,
  `apellidos` varchar(60) COLLATE utf8mb4_general_ci NOT NULL,
  `documento` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `solicitudes` int NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ultima_solicitud` datetime DEFAULT NULL,
  `correo` varchar(75) COLLATE utf8mb4_general_ci NOT NULL,
  `id_perfil` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int NOT NULL,
  `nombres` varchar(60) COLLATE utf8mb4_general_ci NOT NULL,
  `apellidos` varchar(60) COLLATE utf8mb4_general_ci NOT NULL,
  `user` varchar(60) COLLATE utf8mb4_general_ci NOT NULL,
  `contra` varchar(60) COLLATE utf8mb4_general_ci NOT NULL,
  `id_perfil` int NOT NULL,
  `foto` text COLLATE utf8mb4_general_ci NOT NULL,
  `estado` int DEFAULT '0',
  `ultimo_login` datetime DEFAULT CURRENT_TIMESTAMP,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `correo` varchar(75) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombres`, `apellidos`, `user`, `contra`, `id_perfil`, `foto`, `estado`, `ultimo_login`, `fecha_creacion`, `correo`) VALUES
(1, 'GIANFRANCO GABRIEL ', 'FLORES PACHECO', 'ADMIN', 'ADMIN', 1, '', 1, '2023-01-26 10:53:47', '2023-01-25 18:50:18', ''),
(2, 'MATIAS', 'FLORES PACHECO', 'MATIAS', 'MATIAS', 2, '', 0, '2023-01-25 15:48:47', '2023-01-25 20:48:47', ''),
(3, 'GIULIANA', 'CUBA FLORES', 'GIULIANA', 'GIULIANA', 3, 'vistas/img/usuarios/GIULIANA/716.jpg', 0, '2023-01-25 16:42:33', '2023-01-25 21:42:33', ''),
(4, 'Juan Fernanco', 'CUBA FLORES', 'dsds', '1234', 4, 'vistas/img/usuarios/dsds/944.jpg', 0, '2023-01-25 16:43:32', '2023-01-25 21:43:32', ''),
(5, 'JULIO ', 'LOPEZ PERES', 'JULIO', 'JULIO', 5, 'vistas/img/usuarios/JULIO/790.jpg', 0, '2023-01-26 08:27:42', '2023-01-26 13:27:42', ''),
(6, 'GEANCARLO', 'FLORES JUAREZ', 'GEANCARLO', 'GEANCARLO', 2, 'vistas/img/usuarios/GEANCARLO/987.jpg', 0, '2023-01-26 09:04:22', '2023-01-26 14:04:22', ''),
(7, 'CARLOS ', 'AGUILAR PERES', 'CARLOS', 'CARLOS', 1, 'vistas/img/usuarios/CARLOS/659.jpg', 0, '2023-01-26 09:32:43', '2023-01-26 14:32:43', ''),
(8, 'Gladys ', 'Jananpa Pacheco', 'GLADYS', 'GLADYS', 3, 'vistas/img/usuarios/GLADYS/631.jpg', 0, '2023-01-26 09:35:43', '2023-01-26 14:35:43', '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`id_perfil`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `salidas`
--
ALTER TABLE `salidas`
  ADD PRIMARY KEY (`id_salida`);

--
-- Indices de la tabla `solicitante`
--
ALTER TABLE `solicitante`
  ADD PRIMARY KEY (`id_solicitante`),
  ADD KEY `id_perfil` (`id_perfil`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `id_perfil` (`id_perfil`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `perfil`
--
ALTER TABLE `perfil`
  MODIFY `id_perfil` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id_proveedor` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `salidas`
--
ALTER TABLE `salidas`
  MODIFY `id_salida` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `solicitante`
--
ALTER TABLE `solicitante`
  MODIFY `id_solicitante` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `solicitante`
--
ALTER TABLE `solicitante`
  ADD CONSTRAINT `solicitante_ibfk_1` FOREIGN KEY (`id_perfil`) REFERENCES `perfil` (`id_perfil`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_perfil`) REFERENCES `perfil` (`id_perfil`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
