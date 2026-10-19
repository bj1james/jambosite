-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-03-2026 a las 06:46:55
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `jambo_site`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `about_bullets`
--

CREATE TABLE `about_bullets` (
  `id` int(11) NOT NULL,
  `text` varchar(255) NOT NULL,
  `position` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `about_bullets`
--

INSERT INTO `about_bullets` (`id`, `text`, `position`, `created_at`, `updated_at`) VALUES
(1, 'Soluciones personalizadas', 1, '2026-03-02 09:45:10', '2026-03-03 04:43:03'),
(3, 'Compromiso tecnológico', 2, '2026-03-02 09:45:31', '2026-03-03 04:43:40'),
(5, 'Soporte profesional', 3, '2026-03-02 09:46:06', '2026-03-03 04:43:46'),
(6, 'Visión empresarial', 4, '2026-03-03 04:44:10', '2026-03-03 04:44:10'),
(7, 'Eficiencia operativa', 5, '2026-03-03 04:44:29', '2026-03-03 04:44:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `is_saved` tinyint(1) NOT NULL DEFAULT 0,
  `read_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `first_name`, `last_name`, `email`, `phone`, `message`, `is_read`, `is_saved`, `read_at`, `created_at`) VALUES
(1, 'BOB JAMES', 'DAVILA REYES', 'jamesdare@gmail.com', '920599473', 'DVSSDVER DFBQAEBQA REGRG FD F BE', 0, 1, NULL, '2026-03-02 06:25:15'),
(2, 'WE', 'weew', 'ew@GMAIL.COM', '952585642', 'hbababeragds', 0, 1, NULL, '2026-03-02 06:28:56'),
(3, 'BOB JAMES', 'fgarg eghqretvbr', 'apoetra59@gmail.com', '920599473', 'fwefgverghebvgergbtgbafbtarthbaervbarba', 0, 1, NULL, '2026-03-02 07:32:08'),
(4, 'sarah abigail', 'bogado gonzales', 'princesita@hotmail.com', '', '', 0, 1, NULL, '2026-03-03 00:01:42'),
(5, 'WEjaj', 'fwcs', 'jamesdare@gmail.com', '920599473', 'wevebq4tgb fbqartr r rw wrwywthetyjse neeuesdghrhe jeuyjedy4sgnsdjrssgh e u nwsthye eueh u wg hymrt tyesrynw y wy wywy e  6wtyh nsf etyuth', 0, 1, NULL, '2026-03-03 03:15:04'),
(6, 'qrgqerg', 'regerg', 'apoetra59@gmail.com', '920599473', 'gergerg', 0, 0, NULL, '2026-03-03 04:13:33'),
(7, 'BOB JAMES', 'rger', 'ew@GMAIL.COM', '920599473', 'gegwbeyn', 1, 0, '2026-03-02 23:28:43', '2026-03-03 04:13:42'),
(8, 'WErgheg', 'rgeg', 'apoetra59@gmail.com', '', 'hwrth', 0, 0, NULL, '2026-03-03 04:13:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `home_slides`
--

CREATE TABLE `home_slides` (
  `id` int(11) NOT NULL,
  `image_url` varchar(500) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `caption` varchar(500) DEFAULT NULL,
  `position` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `home_slides`
--

INSERT INTO `home_slides` (`id`, `image_url`, `title`, `caption`, `position`, `created_at`, `updated_at`) VALUES
(2, 'public/uploads/2026/03/depositphotos_59096337-stock-photo-computer-system-health-concept_69a669a8f0b238.62929667.jpg', '', '', 2, '2026-03-02 05:10:50', '2026-03-03 04:55:04'),
(4, 'public/uploads/20260302_062824_c971331fe412.png', 'JAMBO', 'always', 1, '2026-03-02 05:28:24', '2026-03-02 05:28:24'),
(5, 'public/uploads/2026/03/desarrollo-web_69a669bd3bb596.25805441.png', '', '', 3, '2026-03-02 05:28:57', '2026-03-03 04:55:25'),
(6, 'public/uploads/2026/03/cap_redes_y_comunicaciones_2_69a66a22a9bcc5.26567040.jpg', '', '', 4, '2026-03-03 04:57:06', '2026-03-03 04:57:15'),
(7, 'public/uploads/2026/03/tipo-camaras-seguridad_69a66a7a6eeb16.82113328.jpg', '', '', 5, '2026-03-03 04:58:34', '2026-03-03 04:58:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `slug` varchar(64) NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` mediumtext DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pages`
--

INSERT INTO `pages` (`id`, `slug`, `title`, `content`, `updated_at`) VALUES
(1, 'sobre', 'JAMBO', 'Esta orientado al crecimiento empresarial. Nos dedicamos a integrar infraestructura, seguridad e innovación digital para que las organizaciones operen con mayor eficiencia, estabilidad y visión de futuro. Más que ofrecer servicios aislados, trabajamos como un aliado estratégico que entiende el negocio de cada cliente y desarrolla soluciones adaptadas a sus necesidades reales.\r\n\r\nImpulsamos la continuidad operativa mediante una infraestructura sólida, protegemos los activos críticos con soluciones de seguridad confiables y promovemos la modernización a través de herramientas digitales y automatización de procesos. Nuestro enfoque combina orden, estrategia y tecnología para generar resultados sostenibles.\r\n\r\nEn esencia, JAMBO existe para ayudar a los emprendedores y empresas a evolucionar con seguridad, eficiencia y proyección.', '2026-03-03 04:53:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `page_slides`
--

CREATE TABLE `page_slides` (
  `id` int(11) NOT NULL,
  `page_slug` varchar(64) NOT NULL,
  `image_url` varchar(500) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `caption` varchar(500) DEFAULT NULL,
  `position` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `page_slides`
--

INSERT INTO `page_slides` (`id`, `page_slug`, `image_url`, `title`, `caption`, `position`, `created_at`, `updated_at`) VALUES
(1, 'sobre', 'public/uploads/2026/03/ChatGPT_Image_2_mar_2026_10_55_38_p_m__69a664c1c5dcd4.52009523.png', 'ESTRUCTURA DE NEGOCIO', 'Compromiso y experiencia', 1, '2026-03-02 04:42:26', '2026-03-03 04:34:09'),
(2, 'sobre', 'public/uploads/2026/03/ChatGPT_Image_2_mar_2026_11_15_37_p_m__69a664a33d0d91.91714988.png', 'INFRAESTRUCTURA DE TECNOLOGIA', '', 2, '2026-03-02 06:16:43', '2026-03-03 04:33:39'),
(3, 'sobre', 'public/uploads/2026/03/ChatGPT_Image_2_mar_2026_11_19_35_p_m__69a664e2d17784.63419688.png', 'SERVICIO DE VIDEO SEGURIDAD', '', 3, '2026-03-02 06:16:55', '2026-03-03 04:34:42'),
(4, 'sobre', 'public/uploads/2026/03/ChatGPT_Image_2_mar_2026_11_37_46_p_m__69a665bdb37a55.63920252.png', '', '', 4, '2026-03-02 06:17:14', '2026-03-03 04:38:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `slug` varchar(220) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `content` mediumtext DEFAULT NULL,
  `image_url` varchar(500) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `services`
--

INSERT INTO `services` (`id`, `title`, `slug`, `excerpt`, `content`, `image_url`, `created_at`, `updated_at`) VALUES
(1, 'INSTALACION DE CAMARA DE VIGILANCIA', 'instalacion-de-camara-de-seguridad', '🔐 Protege lo que más importa con JAMBO', 'En JAMBO entendemos que la seguridad no es un gasto, es una inversión estratégica. Por eso ofrecemos instalación profesional de cámaras de seguridad, diseñada para brindar monitoreo confiable, control total y tranquilidad permanente.\r\n\r\nImplementamos sistemas modernos de videovigilancia adaptados a tu empresa, comercio o propiedad, con asesoría personalizada y tecnología de alta calidad. Nuestro equipo se encarga de todo el proceso: evaluación, instalación y configuración, garantizando un funcionamiento óptimo desde el primer día.\r\n\r\n📹 Supervisión en tiempo real\r\n🛡 Protección de activos\r\n📲 Acceso remoto desde tus dispositivos\r\n⚙ Instalación técnica profesional\r\n\r\nCon JAMBO, tu seguridad está en manos expertas.\r\n\r\nContáctanos y fortalece la protección de tu negocio hoy mismo.', 'public/uploads/2026/03/Instalar_camaras_69a66cf7df50e9.25111533.jpg', '2026-03-01 20:23:00', '2026-03-03 05:09:11'),
(2, 'REPARACION DE EQUIPOS DE COMPUTO', 'reparacion-de-equipos-de-computo', '💻 Recupera el rendimiento de tus equipos con JAMBO', 'En JAMBO sabemos que cada minuto sin funcionar es una oportunidad perdida. Por eso ofrecemos reparación profesional de equipos de cómputo, enfocada en devolver estabilidad, velocidad y eficiencia a tus herramientas de trabajo.\r\n\r\nDiagnosticamos con precisión, solucionamos fallas de hardware y software, realizamos mantenimiento preventivo y optimizamos el rendimiento para que tus equipos trabajen al máximo nivel. Atendemos computadoras, laptops y estaciones de trabajo con enfoque técnico y responsabilidad.\r\n\r\n🔧 Diagnóstico especializado\r\n⚙ Reparación y reemplazo de componentes\r\n🧹 Mantenimiento preventivo y correctivo\r\n🚀 Optimización y mejora de rendimiento\r\n\r\nCon JAMBO, tu tecnología vuelve a ser una ventaja, no un problema.\r\n\r\nContáctanos y dale nueva vida a tus equipos.', 'public/uploads/2026/03/tecnicos-en-mantenimiento-de-computadores-ID-01_69a66ed212afe4.94517183.webp', '2026-03-01 20:23:00', '2026-03-03 05:17:06'),
(3, 'DISEÑO WEB PARA TU NEGOCIO', 'diseno-web-para-tu-negocio', '🌐 Impulsa tu negocio al mundo digital con JAMBO', 'En JAMBO transformamos ideas en plataformas digitales funcionales y estratégicas. Diseñamos páginas web profesionales que no solo se ven bien, sino que trabajan para tu negocio, generan confianza y potencian tus ventas.\r\n\r\nDesarrollamos soluciones digitales adaptadas a cada etapa de crecimiento: desde páginas para emprendimientos hasta sistemas empresariales personalizados. Creamos herramientas que organizan, optimizan y fortalecen tu operación.\r\n\r\n💻 Diseño web profesional para negocios y emprendedores\r\n📦 Sistemas de inventario personalizados\r\n📊 CRM para gestión y seguimiento de clientes\r\n⚙ Plataformas funcionales, modernas y escalables\r\n\r\nNuestro enfoque combina diseño, tecnología y estrategia para convertir tu presencia digital en una ventaja competitiva real.\r\n\r\nCon JAMBO, tu negocio no solo está en internet… está preparado para crecer.', 'public/uploads/2026/03/diseno-paginas-web-pymes_69a66fd8f30c59.54201011.png', '2026-03-01 20:23:00', '2026-03-03 05:22:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `key` varchar(64) NOT NULL,
  `value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`) VALUES
(1, 'site_name', 'JAMBO'),
(2, 'logo_url', 'public/uploads/2026/03/cirjambo_69a65c36b0d327.92006699.png'),
(3, 'brand_primary', '#504e4e'),
(4, 'brand_accent', '#6596d7'),
(21, 'home_title', 'JAMBO'),
(22, 'home_subtitle', 'Soluciones Tecnológicas Inteligentes para Empresas Exigentes'),
(49, 'sobre_bullet1', ''),
(50, 'sobre_bullet2', ''),
(51, 'sobre_bullet3', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(64) NOT NULL,
  `display_name` varchar(120) NOT NULL,
  `email` varchar(160) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','editor') NOT NULL DEFAULT 'editor',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `last_login_at` datetime DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `display_name`, `email`, `password`, `role`, `is_active`, `last_login_at`, `password_hash`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Administrador', 'admin@local', 'admin', 'admin', 1, '2026-03-02 23:51:51', '$2y$10$HdIIlbw/ZyU1QrtxHQHNQOB9M4n2KI5m.xUOBKxg7k.WTY2wP9C.W', '2026-03-01 20:23:00', '2026-03-03 04:51:51');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `about_bullets`
--
ALTER TABLE `about_bullets`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `home_slides`
--
ALTER TABLE `home_slides`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indices de la tabla `page_slides`
--
ALTER TABLE `page_slides`
  ADD PRIMARY KEY (`id`),
  ADD KEY `page_slug` (`page_slug`);

--
-- Indices de la tabla `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indices de la tabla `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key` (`key`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `about_bullets`
--
ALTER TABLE `about_bullets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `home_slides`
--
ALTER TABLE `home_slides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `page_slides`
--
ALTER TABLE `page_slides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
