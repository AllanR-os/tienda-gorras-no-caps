-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-02-2026 a las 19:36:00
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `login_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `added_at`) VALUES
(1134, 1, 7, 1, '2026-02-24 17:23:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `category`) VALUES
(1, 'Primo Hat Blue/White', 550.00, 'https://getyourhooey.com/cdn/shop/files/2546T-BLWH_400x.jpg?v=1736799580', 'destacados'),
(2, 'O-Classic Hat Navy', 550.00, 'https://getyourhooey.com/cdn/shop/files/2509T-NV_400x.jpg?v=1736796603', 'destacados'),
(3, 'OG Hooey Hat White', 550.00, 'https://getyourhooey.com/cdn/shop/files/2560T-WH_400x.jpg?v=1739290339', 'destacados'),
(4, 'Zenith Hat Tan/White', 550.00, 'https://getyourhooey.com/cdn/shop/files/2524T-TNWH_400x.jpg?v=1736796941', 'destacados'),
(5, 'Local Hooey Hat Tan', 550.00, 'https://getyourhooey.com/cdn/shop/files/2599T-TN_400x.jpg?v=1736377862', 'destacados'),
(6, 'OG Hooey Hat Black/White', 550.00, 'https://getyourhooey.com/cdn/shop/files/2562T-BK_400x.jpg?v=1736376056', 'Edicion Especial'),
(7, 'Local Hooey Hat Navy', 550.00, 'https://getyourhooey.com/cdn/shop/files/2509T-NV_400x.jpg?v=1736796603', 'Edicion Especial'),
(8, 'Cowboy Golf BLACK', 550.00, 'https://getyourhooey.com/cdn/shop/files/HPR25-01-D_634f32a1-79ac-4974-8d8e-98b5fbb24711_600x.jpg?v=1736882997', 'Cowboy Golf'),
(9, 'Cowboy Golf Hat White', 550.00, 'https://getyourhooey.com/cdn/shop/files/HPR25-22-A_400x.jpg?v=1736525233', 'Cowboy Golf'),
(10, 'Cowboy Golf Hat Navy', 550.00, 'https://getyourhooey.com/cdn/shop/files/HPR25-17-C_400x.jpg?v=1736204744', 'Cowboy Golf'),
(11, 'Cowboy Golf Hat Maroon', 550.00, 'https://getyourhooey.com/cdn/shop/files/HPR25-25-C_400x.jpg?v=1736202814', 'Cowboy Golf'),
(12, 'Dallas Cowboys Hat Navy', 550.00, 'https://getyourhooey.com/cdn/shop/files/7324T-NVGYH_400x.jpg?v=1728077088', 'Colaboraciones'),
(13, 'Hooey Dallas', 550.00, 'https://getyourhooey.com/cdn/shop/files/7320T-NVWH-1_400x.jpg?v=1721327830', 'Colaboraciones'),
(14, 'Dallas Cowboys Hat White', 550.00, 'https://getyourhooey.com/cdn/shop/files/7267T-WH-02_400x.jpg?v=1687189277', 'Colaboraciones'),
(15, 'Dallas Cowboys Flexfit Hat', 550.00, 'https://getyourhooey.com/cdn/shop/files/7294GY-02_400x.jpg?v=1687887221', 'Colaboraciones'),
(16, 'Dallas Cowboys Hat Tan', 550.00, 'https://getyourhooey.com/cdn/shop/files/7325T-TN_400x.jpg?v=1720474401', 'Colaboraciones'),
(17, 'Fishing Patch Cap', 550.00, 'https://cdn.shopify.com/s/files/1/0357/2432/9005/files/ST0193_Off_Wht_Tan_Green_2_large.jpg?v=1713469540', 'Edicion Especial'),
(18, 'Stetson Trucker Cap', 550.00, 'https://stetson.com/cdn/shop/files/ST0266_Olive_2.jpg?v=1722282175&width=1100', 'Edicion Especial'),
(19, 'Landscape Trucker Hat', 550.00, 'https://cdn.shopify.com/s/files/1/0357/2432/9005/files/ST0333_Off_White_Brown_2_large.jpg?v=1741147558', 'Edicion Especial'),
(20, 'Gorra PRI', 550.00, 'https://http2.mlstatic.com/D_NQ_NP_803129-MLM75795852180_042024-O.webp', 'Edicion Especial'),
(21, 'Skull Trucker Hat', 550.00, 'https://stetson.com/cdn/shop/files/ST0323_OFF-WHITE_BLACK_1.jpg?v=1740162860&width=1100', 'Edicion Especial');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` enum('cliente','admin') DEFAULT 'cliente',
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `user_name`, `email`, `password`, `role`, `date`) VALUES
(1, 'allan04', 'ortizallan97@.com', '$2y$10$D67.HOI.emJLQ6xJ4eJ0M.ZFHRY/8A1Act1A.I3kkete6id84k8/K', 'admin', '2026-02-24 02:04:30'),
(2, 'josechuy', 'josechuy@gmail.com', '$2y$10$So9arOWm8C5j6wLbA8UVPeQGg5YLiOrone3FSnTmtDM9dnqrH/q1S', 'cliente', '2025-03-27 03:28:08'),
(3, 'PEPE', 'SHI@GMAL.COM', '$2y$10$8j3ICpY9cXlztigt/SaEzut79nFLidS42WUBRHP3lUBdN9plIEO8.', 'cliente', '2025-03-27 19:19:09'),
(4, 'admin', 'admin@desertcaps.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', '2026-02-24 01:55:05');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_cart_item` (`user_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1135;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
