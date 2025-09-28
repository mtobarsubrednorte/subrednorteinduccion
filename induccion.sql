-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-09-2025 a las 01:57:51
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
-- Base de datos: `induccion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_09_27_000000_create_profile_table', 1),
(2, '2025_09_27_000001_create_users_table', 1),
(3, '2025_09_27_003113_create_sessions_table', 1),
(4, '2025_09_27_004016_create_cache_table', 1),
(5, '2025_09_27_012559_create_modulos_table', 1),
(6, '2025_09_27_021903_create_recursos_table', 1),
(7, '2025_09_27_021954_create_preguntas_table', 1),
(8, '2025_09_27_183555_add_original_name_to_recursos_table', 1),
(9, '2025_09_27_205329_create_modulo_user_table', 2),
(10, '2025_09_27_225916_create_steps_table', 3),
(11, '2025_09_27_232911_create_step_user_table', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos`
--

CREATE TABLE `modulos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `duration` int(11) NOT NULL,
  `genilay_recursos_link1` text DEFAULT NULL,
  `genilay_recursos_link2` text DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `modulos`
--

INSERT INTO `modulos` (`id`, `title`, `description`, `duration`, `genilay_recursos_link1`, `genilay_recursos_link2`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 'Bienvenida', 'Esta es la descripcion de la presentacion geniallyu', 20, 'https://static.genially.com/resources/loader-default-rebranding.mp4', 'https://view.genially.com/static/embed/embed.js', NULL, '2025-09-28 01:32:52', '2025-09-28 01:32:52'),
(2, 'Salud física', 'Explora los contenidos interactivos para comprender la importancia del cuidado físico en tu bienestar.', 20, 'https://view.genially.com/6893e9fda1dcf302e7411d14', 'https://view.genially.com/static/embed/embed.js', NULL, '2025-09-28 01:39:47', '2025-09-28 01:39:47'),
(3, 'Modulo 3 en espera', 'En espera de desarrollo', 5, NULL, NULL, NULL, '2025-09-28 02:04:19', '2025-09-28 02:04:19'),
(5, 'Aplicativo GitApps', 'Completa los pasos en orden. Cada paso se desbloquea solo cuando completas el anterior.', 45, NULL, NULL, NULL, '2025-09-28 03:32:56', '2025-09-28 03:32:56'),
(7, 'bdf', 'bdf', 40, NULL, NULL, NULL, '2025-09-28 04:12:08', '2025-09-28 04:12:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo_user`
--

CREATE TABLE `modulo_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `modulo_id` bigint(20) UNSIGNED NOT NULL,
  `calificacion` int(11) DEFAULT NULL,
  `aprobado` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `modulo_user`
--

INSERT INTO `modulo_user` (`id`, `user_id`, `modulo_id`, `calificacion`, `aprobado`, `created_at`, `updated_at`) VALUES
(2, 2, 1, 10, 1, '2025-09-28 02:08:33', '2025-09-28 02:08:33'),
(3, 2, 2, 10, 1, '2025-09-28 02:08:49', '2025-09-28 02:08:49'),
(4, 2, 3, 10, 1, '2025-09-28 03:35:24', '2025-09-28 03:35:24'),
(5, 2, 5, 10, 1, '2025-09-28 04:12:24', '2025-09-28 04:12:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE `preguntas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `modulo_id` bigint(20) UNSIGNED NOT NULL,
  `pregunta` varchar(255) NOT NULL,
  `opciones` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`opciones`)),
  `respuestas_correctas` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`respuestas_correctas`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `preguntas`
--

INSERT INTO `preguntas` (`id`, `modulo_id`, `pregunta`, `opciones`, `respuestas_correctas`, `created_at`, `updated_at`) VALUES
(1, 1, 'Preguntas por seccion', '[\"a correcta\",\"b\",\"c\",\"d\"]', '[\"0\"]', '2025-09-28 01:32:52', '2025-09-28 01:32:52'),
(2, 1, 'pregunta 2', '[\"a\",\"b correcta\",\"c\",\"d\"]', '[\"1\"]', '2025-09-28 01:32:52', '2025-09-28 01:32:52'),
(3, 2, 'Pregunta 1', '[\"a correcta\",\"b\",\"c\"]', '[\"0\"]', '2025-09-28 01:39:47', '2025-09-28 01:39:47'),
(4, 2, 'Pregunta 2', '[\"a\",\"b\",\"c correcta\"]', '[\"2\"]', '2025-09-28 01:39:47', '2025-09-28 01:39:47'),
(6, 5, 'como ingresar', '[\"Pregunta 1\",\"a\",\"b correcta\",\"c\",\"d\"]', '[\"2\"]', '2025-09-28 03:32:56', '2025-09-28 03:32:56'),
(7, 5, 'pregunta 2', '[\"a correcta\",\"b\",\"c\",\"d\"]', '[\"0\"]', '2025-09-28 03:32:56', '2025-09-28 03:32:56'),
(8, 5, 'pregunta 3', '[\"a\",\"b correcta\",\"c\",\"d\"]', '[\"1\"]', '2025-09-28 03:32:56', '2025-09-28 03:32:56'),
(9, 3, 'pregunta  1', '[\"Pregunta 1\",\"a\",\"b correcta\",\"c\",\"d\"]', '[\"2\"]', NULL, NULL),
(10, 7, 'fwefwf', '[\"a correcta\",\"b\",\"c\"]', '[\"0\"]', '2025-09-28 04:12:08', '2025-09-28 04:12:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profiles`
--

CREATE TABLE `profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `profiles`
--

INSERT INTO `profiles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Gestor', '2025-09-28 01:28:21', '2025-09-28 01:28:21'),
(2, 'Psicólogo', '2025-09-28 01:28:21', '2025-09-28 01:28:21'),
(3, 'Psicólogo Clínico', '2025-09-28 01:28:21', '2025-09-28 01:28:21'),
(4, 'Médico', '2025-09-28 01:28:21', '2025-09-28 01:28:21'),
(5, 'Enfermero', '2025-09-28 01:28:21', '2025-09-28 01:28:21'),
(6, 'Nutricionista', '2025-09-28 01:28:21', '2025-09-28 01:28:21'),
(7, 'Ingeniero', '2025-09-28 01:28:21', '2025-09-28 01:28:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recursos`
--

CREATE TABLE `recursos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `modulo_id` bigint(20) UNSIGNED NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `original_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `recursos`
--

INSERT INTO `recursos` (`id`, `modulo_id`, `file_path`, `file_type`, `created_at`, `updated_at`, `original_name`) VALUES
(1, 1, 'recursos/CRgGTOgYobIl035Z0IBvDKje4sXGWVDuXK57xSyD.pdf', 'pdf', '2025-09-28 01:32:52', '2025-09-28 01:32:52', NULL),
(2, 1, 'recursos/eQEmI4CpMHEt3BZ8tkSWVpWo4nnlTHO0yhCksul2.docx', 'docx', '2025-09-28 01:32:52', '2025-09-28 01:32:52', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('BFj5TYuv45lJDWbWhQ5t18zos5SdHomEoAa6xYgF', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiaURvN3RSeUtZMkVBZTdBUVJLQ3Z3cmFtalgzZFZoNlM1S1JkeDNaZiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6NDoiYXV0aCI7YToxOntzOjIxOiJwYXNzd29yZF9jb25maXJtZWRfYXQiO2k6MTc1OTAwNDk0NTt9fQ==', 1759014728),
('UxGx85PeE0KNNpPbDlbC0RYqWxwg6kWLjaPO3eUb', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoidGJJU1NRU3VOUFJYRmN1M2pjOWt1WWZXa1I3aTRaMmJreHZ1cVZvZiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL21vZHVsZXMvbW9kdWxlMSI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM3OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvbW9kdWxlcy9tb2R1bGU0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1759017150);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `steps`
--

CREATE TABLE `steps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `modulo_id` bigint(20) UNSIGNED NOT NULL,
  `text` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `type` enum('image','video','text') DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `steps`
--

INSERT INTO `steps` (`id`, `modulo_id`, `text`, `icon`, `type`, `file`, `created_at`, `updated_at`) VALUES
(1, 7, 'Ingresa al sistema GTAPS con tu usuario correspondiente', 'fa-right-to-bracket', 'image', 'images/gitapps/INICIO_DE_SESION.png', '2025-09-28 04:12:08', '2025-09-28 04:12:08'),
(2, 7, 'Verifica el estado del predio: debe estar en \"Efectivo', 'fa-building', 'video', 'videos/predios.mp4', NULL, NULL),
(3, 7, 'Revisa la caracterización previa y evita duplicidades en ADRES', 'fa-magnifying-glass', 'video', 'videos/predios.mp4', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `step_user`
--

CREATE TABLE `step_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `step_id` bigint(20) UNSIGNED NOT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `step_user`
--

INSERT INTO `step_user` (`id`, `user_id`, `step_id`, `completed_at`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '2025-09-28 04:42:13', '2025-09-28 04:42:13', '2025-09-28 04:42:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subred` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `document_type` varchar(255) DEFAULT NULL,
  `document_number` varchar(255) DEFAULT NULL,
  `gender` enum('Masculino','Femenino','Otro') DEFAULT NULL,
  `profile_id` bigint(20) UNSIGNED DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `subred`, `name`, `email`, `password`, `is_active`, `role`, `document_type`, `document_number`, `gender`, `profile_id`, `phone`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'NORTE', 'Gabriel Monhabell', 'monhabell@gmail.com', '$2y$12$Iu02GAB4X24JZQus72trQ.Hi1aTcRZ0vLgEdJDfnuIX1llObaryJ2', 1, 'admin', 'CC', '1000693246', 'Masculino', 1, NULL, NULL, NULL, '2025-09-28 01:28:50', '2025-09-28 01:28:50'),
(2, 'NORTE', 'Usuario Prueba', 'usuario_prueba@gmail.com', '$2y$12$bXibLfkuHS8vHcnsgaZpQODozo4SR6yWFarbQeW.H9ipDffQ0phxW', 1, 'user', 'CC', '123456789', 'Masculino', 2, NULL, NULL, NULL, '2025-09-28 01:29:34', '2025-09-28 01:29:34');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `modulos`
--
ALTER TABLE `modulos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `modulos_parent_id_foreign` (`parent_id`);

--
-- Indices de la tabla `modulo_user`
--
ALTER TABLE `modulo_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `modulo_user_user_id_modulo_id_unique` (`user_id`,`modulo_id`),
  ADD KEY `modulo_user_modulo_id_foreign` (`modulo_id`);

--
-- Indices de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `preguntas_modulo_id_foreign` (`modulo_id`);

--
-- Indices de la tabla `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `recursos`
--
ALTER TABLE `recursos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recursos_modulo_id_foreign` (`modulo_id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `steps`
--
ALTER TABLE `steps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `steps_modulo_id_foreign` (`modulo_id`);

--
-- Indices de la tabla `step_user`
--
ALTER TABLE `step_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `step_user_user_id_step_id_unique` (`user_id`,`step_id`),
  ADD KEY `step_user_step_id_foreign` (`step_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_profile_id_foreign` (`profile_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `modulos`
--
ALTER TABLE `modulos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `modulo_user`
--
ALTER TABLE `modulo_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `recursos`
--
ALTER TABLE `recursos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `steps`
--
ALTER TABLE `steps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `step_user`
--
ALTER TABLE `step_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `modulos`
--
ALTER TABLE `modulos`
  ADD CONSTRAINT `modulos_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `modulos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `modulo_user`
--
ALTER TABLE `modulo_user`
  ADD CONSTRAINT `modulo_user_modulo_id_foreign` FOREIGN KEY (`modulo_id`) REFERENCES `modulos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `modulo_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD CONSTRAINT `preguntas_modulo_id_foreign` FOREIGN KEY (`modulo_id`) REFERENCES `modulos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `recursos`
--
ALTER TABLE `recursos`
  ADD CONSTRAINT `recursos_modulo_id_foreign` FOREIGN KEY (`modulo_id`) REFERENCES `modulos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `steps`
--
ALTER TABLE `steps`
  ADD CONSTRAINT `steps_modulo_id_foreign` FOREIGN KEY (`modulo_id`) REFERENCES `modulos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `step_user`
--
ALTER TABLE `step_user`
  ADD CONSTRAINT `step_user_step_id_foreign` FOREIGN KEY (`step_id`) REFERENCES `steps` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `step_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_profile_id_foreign` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
