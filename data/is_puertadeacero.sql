-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-03-2019 a las 05:04:45
-- Versión del servidor: 10.1.19-MariaDB
-- Versión de PHP: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `is_puertadeacero`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `casas`
--

CREATE TABLE `casas` (
  `id` int(11) NOT NULL,
  `dueno` varchar(45) NOT NULL,
  `adeudo` decimal(10,2) NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `casas`
--

INSERT INTO `casas` (`id`, `dueno`, `adeudo`, `usuario_id`) VALUES
(3, 'PEPE CHUGA', '200.00', 1),
(4, 'CROSTY', '500.00', 2),
(5, 'JOSE ANTONIO', '900.00', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `folio` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `casa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`folio`, `fecha`, `monto`, `usuario_id`, `casa_id`) VALUES
(1, '2018-10-31 17:38:20', '200.00', 1, 3),
(2, '2018-10-31 09:18:16', '100.00', 1, 3),
(3, '2018-10-31 17:52:32', '100.00', 1, 4),
(4, '2018-10-31 18:01:48', '50.00', 1, 4),
(5, '2018-10-31 18:05:45', '50.00', 1, 4),
(6, '2018-10-31 18:09:39', '300.00', 1, 4),
(7, '2019-02-22 06:36:10', '123.00', 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombres` varchar(45) NOT NULL,
  `ape_paterno` varchar(45) NOT NULL,
  `ape_materno` varchar(45) NOT NULL,
  `telefono` varchar(45) NOT NULL,
  `correo` varchar(45) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `tipo` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombres`, `ape_paterno`, `ape_materno`, `telefono`, `correo`, `contrasena`, `tipo`) VALUES
(1, 'Luis Alberto', 'García', 'Rodríguez', '333222111', 'luis@gmail.com', '$2y$10$/6h8MyfzKmah8/sAncWe3.xU.5r9DXCjK9qLG4XQ8fzpO3kzFvZCu', 'Administrador'),
(2, 'Carlos Ernestos', 'Ávila', 'Gómez', '222333555', 'carlos@correo.com', '$2y$10$V6KfQipzRw80ojYfgQKjz.nw1/wz31.gAXgdVQ8djzzUK/L/O1jYK', 'Empleado'),
(3, 'Saul', 'Uni', 'Uni', '555555', 'saul@correo.com', '$2y$10$pK9RIs7kjt65Sb0YtVJK.eCfy9bLTewdzJCris6aQDcvxV3DM7KqS', 'Administrador');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `casas`
--
ALTER TABLE `casas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`folio`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `casa_id` (`casa_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `casas`
--
ALTER TABLE `casas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `folio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `casas`
--
ALTER TABLE `casas`
  ADD CONSTRAINT `casas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pagos_ibfk_2` FOREIGN KEY (`casa_id`) REFERENCES `casas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
