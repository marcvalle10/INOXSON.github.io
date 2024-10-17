-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 16-10-2024 a las 01:32:17
-- Versión del servidor: 8.2.0
-- Versión de PHP: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `inoxson2`
--
CREATE DATABASE IF NOT EXISTS `inoxson2` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `inoxson2`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE IF NOT EXISTS `clientes` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `direccion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `requisitos_especificos` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `usuario_id` bigint DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `direccion`, `requisitos_especificos`, `usuario_id`) VALUES
(1, 'Empresa ABC', 'Calle Falsa 123, Ciudad X', 'Entrega antes del 30 de septiembre', 2),
(2, 'Juan Robles', 'Av. Siempre Viva 456, Ciudad Y', 'Pago a plazos', 3),
(3, 'María Pérez', 'Calle Luna 789, Ciudad Z', 'Requiere descuento por volumen', 4),
(5, 'Jose Pereira', 'Calle 654,HMO', 'Diseño Personalizado', 6),
(6, 'Ana Torres', 'Calle Río 303, Ciudad Z', 'Cotización urgente', 7),
(8, 'Pedro López', 'Calle Montaña 505, Ciudad Y', 'Entrega a domicilio', 9),
(10, 'Fernando Ruiz', 'Av. Secundaria 707, Ciudad X', 'Facturación electrónica requerida', 2),
(11, 'Alonso Pérez', 'Av. Chapultepec 123, Guadalajara, Jalisco', 'Mesa de acero inoxidable con acabados en espejo', 4),
(12, 'Nuevo Cliente', 'Calle Ejemplo 456, Ciudad ABC', 'Entrega express', 1),
(13, 'Francisco Quintana', 'Calle Morelos 56, Ciudad Obregon', 'Pago a meses sin intereses', 6);

--
-- Disparadores `clientes`
--
DROP TRIGGER IF EXISTS `after_cliente_insert`;
DELIMITER $$
CREATE TRIGGER `after_cliente_insert` AFTER INSERT ON `clientes` FOR EACH ROW BEGIN
  INSERT INTO registro_disparadores (nombre_disparador, accion)
  VALUES ('after_cliente_insert', 'Nuevo cliente insertado en la tabla clientes');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizaciones`
--

DROP TABLE IF EXISTS `cotizaciones`;
CREATE TABLE IF NOT EXISTS `cotizaciones` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `cliente_id` bigint DEFAULT NULL,
  `usuario_id` bigint DEFAULT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `monto` decimal(10,2) NOT NULL,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `cliente_id` (`cliente_id`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cotizaciones`
--

INSERT INTO `cotizaciones` (`id`, `cliente_id`, `usuario_id`, `descripcion`, `monto`, `fecha`) VALUES
(1, 1, 2, 'Cotización de muebles para oficina', 50000.00, '2024-09-01 17:30:00'),
(2, 2, 3, 'Cotización de estantes de acero', 30000.00, '2024-09-02 18:00:00'),
(3, 3, 4, 'Cotización de mesas de trabajo', 20000.00, '2024-09-03 16:45:00'),
(5, 5, 6, 'Cotización de muebles de cocina', 80000.00, '2024-09-05 19:00:00'),
(6, 6, 7, 'Cotización de gabinetes industriales', 45000.00, '2024-09-06 21:30:00'),
(8, 8, 9, 'Cotización de mesas plegables', 17000.00, '2024-09-08 20:45:00'),
(10, 10, 2, 'Cotización de vitrinas de acero', 55000.00, '2024-09-10 22:00:00');

--
-- Disparadores `cotizaciones`
--
DROP TRIGGER IF EXISTS `after_cotizacion_insert`;
DELIMITER $$
CREATE TRIGGER `after_cotizacion_insert` AFTER INSERT ON `cotizaciones` FOR EACH ROW BEGIN
  INSERT INTO registro_disparadores (nombre_disparador, accion)
  VALUES ('after_cotizacion_insert', CONCAT('Nueva cotización creada: ', NEW.descripcion, ' por un monto de ', NEW.monto));
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `after_cotizacion_update`;
DELIMITER $$
CREATE TRIGGER `after_cotizacion_update` AFTER UPDATE ON `cotizaciones` FOR EACH ROW BEGIN
  INSERT INTO registro_disparadores (nombre_disparador, accion)
  VALUES ('after_cotizacion_update', CONCAT('Cotización actualizada: ID ', OLD.id, ', nuevo monto: ', NEW.monto));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

DROP TABLE IF EXISTS `facturas`;
CREATE TABLE IF NOT EXISTS `facturas` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `cliente_id` bigint DEFAULT NULL,
  `usuario_id` bigint DEFAULT NULL,
  `fecha_emision` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `monto` decimal(10,2) NOT NULL,
  `metodo_pago` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cliente_id` (`cliente_id`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `facturas`
--

INSERT INTO `facturas` (`id`, `cliente_id`, `usuario_id`, `fecha_emision`, `monto`, `metodo_pago`) VALUES
(1, 1, 2, '2024-09-01 17:45:00', 50000.00, 'Transferencia bancaria'),
(2, 2, 3, '2024-09-02 18:15:00', 30000.00, 'Tarjeta de crédito'),
(3, 3, 4, '2024-09-03 17:00:00', 20000.00, 'Efectivo'),
(5, 5, 6, '2024-09-05 19:15:00', 80000.00, 'Transferencia bancaria'),
(6, 6, 7, '2024-09-06 21:45:00', 45000.00, 'Tarjeta de crédito'),
(8, 8, 9, '2024-09-08 21:00:00', 17000.00, 'PayPal'),
(10, 10, 2, '2024-09-10 22:15:00', 50000.00, 'Tarjeta de crédito');

--
-- Disparadores `facturas`
--
DROP TRIGGER IF EXISTS `after_factura_delete`;
DELIMITER $$
CREATE TRIGGER `after_factura_delete` AFTER DELETE ON `facturas` FOR EACH ROW BEGIN
  INSERT INTO registro_disparadores (nombre_disparador, accion)
  VALUES ('after_factura_delete', CONCAT('Factura eliminada: ID ', OLD.id, ', monto: ', OLD.monto));
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `after_factura_insert`;
DELIMITER $$
CREATE TRIGGER `after_factura_insert` AFTER INSERT ON `facturas` FOR EACH ROW BEGIN
  INSERT INTO registro_disparadores (nombre_disparador, accion)
  VALUES ('after_factura_insert', CONCAT('Nueva factura emitida para el cliente ID: ', NEW.cliente_id, ' por un monto de ', NEW.monto, ' usando ', NEW.metodo_pago));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_disparadores`
--

DROP TABLE IF EXISTS `registro_disparadores`;
CREATE TABLE IF NOT EXISTS `registro_disparadores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre_disparador` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `accion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `registro_disparadores`
--

INSERT INTO `registro_disparadores` (`id`, `nombre_disparador`, `accion`, `fecha`) VALUES
(1, 'after_cliente_insert', 'Nuevo cliente insertado en la tabla clientes', '2024-09-26 21:10:00'),
(2, 'after_cliente_insert', 'Nuevo cliente insertado en la tabla clientes', '2024-09-26 21:15:16'),
(3, 'after_cliente_insert', 'Nuevo cliente insertado en la tabla clientes', '2024-09-26 21:49:06'),
(4, 'after_cliente_insert', 'Nuevo cliente insertado en la tabla clientes', '2024-10-10 17:48:27'),
(5, 'after_factura_insert', 'Nueva factura emitida para el cliente ID: 14 por un monto de 20000.00 usando Transferencia bancaria', '2024-10-10 19:33:14'),
(6, 'after_factura_insert', 'Nueva factura emitida para el cliente ID: 15 por un monto de 10000.00 usando Transferencia bancaria', '2024-10-10 19:33:55'),
(7, 'after_cotizacion_insert', 'Nueva cotización creada: Cotización asador para exterior por un monto de 15000.00', '2024-10-10 20:22:23'),
(8, 'after_cotizacion_insert', 'Nueva cotización creada: Cotización asador para exterior por un monto de 10000.00', '2024-10-10 20:26:55'),
(9, 'after_cliente_insert', 'Nuevo cliente insertado en la tabla clientes', '2024-10-10 20:41:43'),
(10, 'after_transaccion_update', 'Transacción actualizada: ID 1, nuevo monto 50000.00', '2024-10-14 08:13:41'),
(11, 'after_transaccion_update', 'Transacción actualizada: ID 1, nuevo monto 50000.00', '2024-10-14 08:14:03'),
(12, 'after_transaccion_update', 'Transacción actualizada: ID 3, nuevo monto 25000.00', '2024-10-14 08:15:03'),
(13, 'after_transaccion_update', 'Transacción actualizada: ID 3, nuevo monto 25000.00', '2024-10-14 08:17:55'),
(14, 'after_cotizacion_update', 'Cotización actualizada: ID 11, nuevo monto: 15000.00', '2024-10-14 08:23:33'),
(15, 'after_cotizacion_update', 'Cotización actualizada: ID 5, nuevo monto: 8000.00', '2024-10-14 08:23:56'),
(16, 'after_cotizacion_update', 'Cotización actualizada: ID 11, nuevo monto: 17000.00', '2024-10-14 08:24:23'),
(17, 'after_cotizacion_update', 'Cotización actualizada: ID 5, nuevo monto: 80000.00', '2024-10-14 08:24:54'),
(18, 'after_factura_delete', 'Factura eliminada: ID 12, monto: 20000.00', '2024-10-14 08:28:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`) VALUES
(1, 'Administrador'),
(2, 'Vendedor'),
(3, 'Diseñador'),
(4, 'Contador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sesiones`
--

DROP TABLE IF EXISTS `sesiones`;
CREATE TABLE IF NOT EXISTS `sesiones` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `usuario_id` bigint NOT NULL,
  `fecha_inicio` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_fin` timestamp NULL DEFAULT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sesiones`
--

INSERT INTO `sesiones` (`id`, `usuario_id`, `fecha_inicio`, `fecha_fin`, `token`) VALUES
(1, 2, '2024-09-01 16:00:00', '2024-09-02 00:00:00', 'token_12345'),
(2, 3, '2024-09-02 16:00:00', '2024-09-03 00:00:00', 'token_12346'),
(3, 4, '2024-09-03 16:00:00', '2024-09-04 00:00:00', 'token_12347'),
(5, 6, '2024-09-05 16:00:00', '2024-09-06 00:00:00', 'token_12349'),
(6, 7, '2024-09-06 16:00:00', '2024-09-07 00:00:00', 'token_12350'),
(7, 8, '2024-09-07 16:00:00', '2024-09-08 00:00:00', 'token_12351'),
(8, 9, '2024-09-08 16:00:00', '2024-09-09 00:00:00', 'token_12352'),
(9, 10, '2024-09-09 16:00:00', '2024-09-10 00:00:00', 'token_12353'),
(10, 2, '2024-09-10 16:00:00', '2024-09-11 00:00:00', 'token_12354');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transacciones_financieras`
--

DROP TABLE IF EXISTS `transacciones_financieras`;
CREATE TABLE IF NOT EXISTS `transacciones_financieras` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `cliente_id` bigint DEFAULT NULL,
  `usuario_id` bigint DEFAULT NULL,
  `tipo_transaccion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `cliente_id` (`cliente_id`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `transacciones_financieras`
--

INSERT INTO `transacciones_financieras` (`id`, `cliente_id`, `usuario_id`, `tipo_transaccion`, `monto`, `fecha`) VALUES
(1, 1, 9, 'Venta', 50000.00, '2024-09-01 17:45:00'),
(2, 2, 3, 'Venta', 30000.00, '2024-09-02 18:15:00'),
(3, 3, 4, 'Venta', 25000.00, '2024-09-03 17:00:00'),
(5, 5, 6, 'Venta', 80000.00, '2024-09-05 19:15:00'),
(6, 6, 7, 'Venta', 45000.00, '2024-09-06 21:45:00'),
(8, 8, 9, 'Venta', 17000.00, '2024-09-08 21:00:00');

--
-- Disparadores `transacciones_financieras`
--
DROP TRIGGER IF EXISTS `after_transaccion_insert`;
DELIMITER $$
CREATE TRIGGER `after_transaccion_insert` AFTER INSERT ON `transacciones_financieras` FOR EACH ROW BEGIN
  INSERT INTO registro_disparadores (nombre_disparador, accion)
  VALUES ('after_transaccion_insert', CONCAT('Nueva transacción registrada: tipo ', NEW.tipo_transaccion, ', monto ', NEW.monto));
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `after_transaccion_update`;
DELIMITER $$
CREATE TRIGGER `after_transaccion_update` AFTER UPDATE ON `transacciones_financieras` FOR EACH ROW BEGIN
  INSERT INTO registro_disparadores (nombre_disparador, accion)
  VALUES ('after_transaccion_update', CONCAT('Transacción actualizada: ID ', OLD.id, ', nuevo monto ', NEW.monto));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `rol_id` bigint DEFAULT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `rol_id` (`rol_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `rol_id`, `username`, `password_hash`, `email`) VALUES
(1, 1, 'admin', '$2y$10$Rj7Bb6zQJa9oPJL5uv5YuuxyIeigXfrD.iTDie5R0XOflk4gg0HNK', 'admin@inoxson.com'),
(2, 2, 'juan_perez', '$2y$10$0BlkIB1tKSHVLNWp9nZmFOY3YnTOjrKU1mktkw1bC8q9M6RqIJQ2W', 'juan@inoxson.com'),
(3, 3, 'maria_lopez', '$2y$10$9jmD4ALYaPRfR10Ib0Ac6.30VJB.7nIJCFekVGcHOWnagp/BtCRVq', 'maria@inoxson.com'),
(4, 2, 'carlos_sanchez', '$2y$10$rlKrL8Wty0l.GPTsU4jXHulk3dfdvVmQ6li.ZVGaGcU.EnZPSNS0a', 'carlos@inoxson.com'),
(6, 3, 'laura_martinez', '$2y$10$6Hyal7l180NJBUgmPNCOqOQODsXfd43x1SF4JTo2DxPIQwXd1ipXG', 'laura@inoxson.com'),
(7, 2, 'luis_gomez', '$2y$10$3XTT5xZ35dn6VhuozpwHIO42avRC1nnRtGwxjJzLJU5K0tDBag/V.', 'luis@inoxson.com'),
(8, 4, 'fernando_ramos', '$2y$10$Ua9XQKn7bz5I6o6lJJdxLuu87ucvC3FbDfsNTZoNWsdtS7x5ns/a6', 'fernando@inoxson.com'),
(9, 2, 'sofia_diaz', '$2y$10$RAYeeS1Xfwhx6bYxbsI4meKqW9Yy04KiGkHyNT7dlngOBf2A7my3y', 'sofia@inoxson.com'),
(10, 4, 'pablo_ortega', '$2y$10$rWGsS2bsFpp2WLmVxq.aRuk0wIR3zNeE9ySo17y4Kk4TGtf356k8e', 'pablo@inoxson.com'),
(11, 2, 'vercini69@gmail.com', '$2y$10$LoC9sto9oNpEGru1uc6rienYstmlcT9tQPBWwfkXrmkTa9Yrw0b2m', 'vercini69@gmail.com'),
(12, 1, 'Marcos vallejo', '$2y$10$nM/k71kDCDHbmu1698QkMOg5PdWYsUHgrbVWvj1kk8hd8su2wLszC', 'marcosvalle546@gmail.com'),
(13, 1, 'Alexis vercini', '$2y$10$4ouGYDKHnzX1WKLZ.rbYvOsvWb5L4N7F9/w44q0ATmtkPONRfHcdW', 'vercini29@gmail.com');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `fk_clientes_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  ADD CONSTRAINT `fk_cliente_cotizaciones` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_cliente_id` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `fk_usuario_cotizaciones` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD CONSTRAINT `fk_cliente_facturas` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_usuario_facturas` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sesiones`
--
ALTER TABLE `sesiones`
  ADD CONSTRAINT `fk_sesiones_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `transacciones_financieras`
--
ALTER TABLE `transacciones_financieras`
  ADD CONSTRAINT `fk_cliente_transacciones` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_usuario_transacciones` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_roles` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
